<?php

require_once('admin.class.php');
$admin->requiresAdmin();

// Uploader class (uses content after __hault_compiler)
class UPLOADER {
	const field_name = 'file';

	private function upload($msg = 'Upload new data') {
		$fp = fopen(__FILE__, 'r');
		fseek($fp, __COMPILER_HALT_OFFSET__);
		$data = stream_get_contents($fp);
		$_SESSION['hash'] = uniqid();
		$data = str_replace('{{MSG}}', $msg, $data);

		$admin = new Admin();
		include('tpl' . DIRECTORY_SEPARATOR . 'header.tpl.html');
		echo str_replace('{{HASH_VALUE}}', $_SESSION['hash'], $data);
		include('tpl' . DIRECTORY_SEPARATOR . 'footer.tpl.html');
		die();
	}

	public function execute() {
		$ret = null;
		if (!isset($_REQUEST['submit'])) $this->upload();

		// Verify and upload file
		try {
			if ( 
				$_REQUEST['hash'] != $_SESSION['hash'] || 
				!isset($_FILES[ $this::field_name ]['error']) || 
				is_array($_FILES[ $this::field_name ]['error'])
			) throw new RuntimeException('Invalid parameters');

			// Check $_FILES[ $fieldName ]['error'] value.
			switch ($_FILES[ $this::field_name ]['error']) {
				case UPLOAD_ERR_OK: break;
				case UPLOAD_ERR_NO_FILE: throw new RuntimeException('No file sent');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE: throw new RuntimeException('Exceeded filesize limit');
				default: throw new RuntimeException('Unknown errors');
			}

			if ($_FILES[ $this::field_name ]['size'] > 1000000)
				throw new RuntimeException('Exceeded filesize limit');

			$ret = $_FILES[ $this::field_name ]['tmp_name'];
		} catch (RuntimeException $e) {
			$this->upload( $e->getMessage() );
		}
		return $ret;
	}
}

//* Upload CSV Data
$uploader = new UPLOADER();
$upload_name = $uploader->execute();
// */

// Processor class (requires $upload_name's file)
class PROCESSOR {
	function __construct($upload_name = null) {
		$this->upload_name = $upload_name;
		$this->db = new PDO('sqlite:..' . DIRECTORY_SEPARATOR . 'db.sqlite3');
		if ( ($this->handle = fopen($upload_name, 'r')) === FALSE ) die('cannot open stream');
	}

	public function process() {
		$col_to_db_map = $this->processTitles();

		// Setup queries
		$uGetSTH = $this->db->prepare("SELECT accountno FROM user WHERE accountno=?;");
		$uAddSTH = $this->db->prepare("INSERT INTO user (first,last,company,title,city,state,bio,gradyear,phone,email,\"user\",img,guide,accountno,pass) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
		$uModSTH = $this->db->prepare("UPDATE \"user\" SET first=?,last=?,company=?,title=?,city=?,state=?,bio=?,gradyear=?,phone=?,email=?,\"user\"=?,img=?,guide=? WHERE accountno=?;");
		$eGetSTH = $this->db->prepare("SELECT eventID FROM event WHERE name=? AND programYearID=?;");
		$eAddSTH = $this->db->prepare("INSERT INTO event (name, programYearID) VALUES (?,?);");

		$aGetSTH = $this->db->prepare("SELECT attendeeID FROM attendee WHERE userID=? AND yearID=?;");
		$aAddSTH = $this->db->prepare("INSERT INTO attendee (userID, eventID, yearID) vALUES (?,?,?);");
		$aModSTH = $this->db->prepare("UPDATE attendee SET eventID=? WHERE attendeeID=?;");


		// process rows
		$notified = array();

		while (($data = fgetcsv($this->handle, 1000, ",")) !== FALSE) {
			$data = array_map('trim', $data);
			
			// Clean data for importing
			$titles = $this->titles;
			$map = function () use ($data, $titles) {
				$arr = func_get_args();
				$cb = function ($value) use ($data, $titles) {
					$ele = $data[ $titles[$value] ];
					return @iconv(mb_detect_encoding($ele, mb_detect_order(), true), "UTF-8", $ele);
				};
				return array_map($cb, $arr);
			};
			$user_data = $map('first','last','company','title','city','state','bio','program','phone1','contsupref','username','photo link','guide','accountno');
			
			if (
				!$uGetSTH->execute(array( $data[ $this->titles['accountno'] ] )) ||
				$uGetSTH->fetchColumn() === FALSE
			) {
				array_push($user_data, create_hash($data[ $this->titles['password'] ]));
				$uAddSTH->execute( $user_data );
			} else {
				$uModSTH->execute( $user_data );
			}

			// Add events and attendees for each user
			foreach ($col_to_db_map as $key => $value) {
				// echo $data[ $key ] . ' ' . print_r($value, true);

				// Should we insert event?
				$eventID = false;
				switch ( strtolower($data[$key]) ) { // just check if key has numbers (ie: year)
					case 'deferred':
					case 'none':
					case '': 
						if (!in_array($data[$key], $notified)) {
							array_push($notified, $data[$key]);
							echo 'Skipped insert event "' . $data[$key] . '"<br/>' . "\r\n";
						}
						break;

					case 'undecided': $eventID = null; break;

					default:
						// Insert event if not already there
						$event_data = array( $data[$key], $value['pyID'] );
						$eGetSTH->execute( $event_data );
						$eventID = $eGetSTH->fetchColumn();
						if ( $eventID === FALSE ) {
							$eAddSTH->execute( $event_data );
							$eventID = $this->db->lastInsertId();
						}
				}

				// If we should do some sort of attendee add
				if ($eventID !== false) {
					$aGetSTH->execute(array( $data[ $this->titles['accountno'] ], $value['yrID'] ));
					$attendeeID = $aGetSTH->fetchColumn();
					if ($attendeeID) {
						$aModSTH->execute(array( $eventID, $attendeeID )); // update attendee if it exists
					} else {
						$aAddSTH->execute(array( $data[ $this->titles['accountno'] ], $eventID, $value['yrID'] )); // insert attendee
					}
				}
			}
		}

		// Final cleanup
		fclose($this->handle);
	}

	// Deal with titles and insert programYear and year entries as necessary
	private function processTitles() {
		$titles = fgetcsv($this->handle);
		$this->titles = array_flip(array_map('strtolower', $titles));
		$this->validateTitles();

		// Process program years
		$title_pattern = "/^event ([0-9]{2}-[0-9]{2})$/i";
		$event_titles = preg_grep($title_pattern, $titles); // Parse for matching titles
		$event_titles = preg_replace($title_pattern, "$1", $event_titles); // cleanup

		// Insert and store ID's for Program Year
		$programYearIDs = array();
		$getSTH = $this->db->prepare("SELECT programYearID FROM programYear WHERE programYear=?;");
		$addSTH = $this->db->prepare("INSERT INTO programYear (programYear) VALUES (?);");

		foreach ($event_titles as $key => $value) {
			$temp_arr = array( $value );

			$getSTH->execute( $temp_arr );
			$programYearID = $getSTH->fetchColumn();
			if ($programYearID === FALSE) {
				$addSTH->execute( $temp_arr );
				$programYearID = $this->db->lastInsertId();
			}
			$programYearIDs[$value] = array(
				'dbID' => $programYearID,
				'colID' => $key
			);
		}

		// Figure out Which Year each program year is / insert and store
		sort($event_titles); // sorting values
		$yearIDs = array();
		$getSTH = $this->db->prepare("SELECT yearID FROM year WHERE programYearID=? AND year=?;");
		$addSTH = $this->db->prepare("INSERT INTO year (programYearID, year) VALUES (?,?);");
		foreach ($event_titles as $key => $value) {
			$temp_arr = array( $programYearIDs[$value]['dbID'], $key+1 );

			$getSTH->execute( $temp_arr );
			$yearID = $getSTH->fetchColumn();
			if ($yearID === FALSE) {
				$addSTH->execute( $temp_arr );
				$yearID = $this->db->lastInsertId();
			}
			$yearIDs[ $programYearIDs[$value]['colID'] ] = array(
				'pyID' => $programYearIDs[$value]['dbID'],
				'yrID' => $yearID,
				'year' => $value
			);
		}
		return $yearIDs;
	}

	// Ensure we have the required titles
	private function validateTitles() {
		echo '<p>Column titles as the script sees them.</p><pre>';
		$titles = array_flip($this->titles);
		print_r($titles);
		echo '</pre>';

		$event_titles = preg_grep("/^event ([0-9]{2}-[0-9]{2})$/i", $titles); // Parse for matching titles
		
		if ( sizeof($event_titles) < 1 ) die("No event titles matching the pattern /^event ([0-9]{2}-[0-9]{2})$/i.");
		if ( !in_array('accountno', $titles) ) die("No accountno title.");
		if ( !in_array('first', $titles) ) die("No first title.");
		if ( !in_array('last', $titles) ) die("No last title.");
		if ( !in_array('company', $titles) ) die("No company title.");
		if ( !in_array('title', $titles) ) die("No title title.");
		if ( !in_array('title', $titles) ) die("No title title.");
		if ( !in_array('city', $titles) ) die("No city title.");
		if ( !in_array('state', $titles) ) die("No state title.");
		if ( !in_array('bio', $titles) ) die("No bio title.");
		if ( !in_array('program', $titles) ) die("No program title.");
		if ( !in_array('guide', $titles) ) die("No guide title.");
		if ( !in_array('phone1', $titles) ) die("No phone1 title.");
		if ( !in_array('contsupref', $titles) ) die("No contsupref title.");
		if ( !in_array('username', $titles) ) die("No username title.");
		if ( !in_array('password', $titles) ) die("No password title.");
	}
}

//* Process CSV Data
$processor = new PROCESSOR( $upload_name );
$processor->process();
// */

__halt_compiler() ?>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<h3>{{MSG}}</h3>
		<form action="uploader.php" method="post" enctype="multipart/form-data" class="form-horizontal">
			<div class="form-group">
				<label for="file">Filename:</label>
				<input type="file" name="file" id="file" class="form-control">
			</div>
			<input type="hidden" name="hash" value="{{HASH_VALUE}}">
			<input type="submit" name="submit" value="Upload">
			<br/><br/><br/><br/><br/>
		</form>
	</div>
</div>

<div class="well">
	<p>
		Below is a full list of columns that <strong>NEED</strong> to be in the CSV
		<ul>
			<li>
				<code>accountno</code> A unique identifier for each user (should stay the same year to year)
			</li>
			<li>
				<code>first</code> First name of the participant
			</li>
			<li>
				<code>last</code> Last name of the participant
			</li>
			<li>
				<code>company</code> The company of the participant
			</li>
			<li>
				<code>title</code> The job title of the participant
			</li>
			<li>
				<code>city</code> The address city of the participant
			</li>
			<li>
				<code>state</code> The address state of the participant
			</li>
			<li>
				<code>bio</code> The biography of the participant
			</li>
			<li>
				<code>program</code> The graduation year of the participant
			</li>
			<li>
				<code>guide</code> The participant's guide
			</li>
			<li>
				<code>phone1</code> The phone number of the participant
			</li>
			<li>
				<code>contsupref</code> The email number of the participant
			</li>
			<li>
				<code>username</code> The username of the participant
			</li>
			<li>
				<code>password</code> The password of the participant (unencrypted)
			</li>
			<li>
				<code>photo link</code> The name of the photo of the user.  Located in <code>http://upstreamacademy.com/apps/...</code>
			</li>
			<li>
				<code>event 14-15</code> At least one event (usually 3) that presents the year span in <code>[0-9]{2}-[0-9]{2}</code> format
			</li>
		</ul>
		<i>* Note: the case of the titles does not matter (ie: <u>FIRST</u>, <u>FiRsT</u>, and <u>first</u> are the same)</i>
	</p>
</div>
