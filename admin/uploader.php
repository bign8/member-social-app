<?php

// Configuration
$upload_name = implode( DIRECTORY_SEPARATOR, array(__DIR__, '..', 'data', 'admin', 'upload-data.csv') );

// Uploader class (uses content after __hault_compiler)
class UPLOADER {
	const field_name = 'file';

	function __construct($upload_name) {
		session_start();
		$this->upload_name = $upload_name;
	}

	private function upload($msg = 'Upload new data') {
		$fp = fopen(__FILE__, 'r');
		fseek($fp, __COMPILER_HALT_OFFSET__);
		$data = stream_get_contents($fp);
		$_SESSION['hash'] = uniqid();
		$data = str_replace('{{MSG}}', $msg, $data);
		die( str_replace('{{HASH_VALUE}}', $_SESSION['hash'], $data) );
	}

	public function execute() {
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

			if (!move_uploaded_file( $_FILES[ $this::field_name ]['tmp_name'], $this->upload_name ))
				throw new RuntimeException('Failed to move uploaded file');

		} catch (RuntimeException $e) {
			$this->upload( $e->getMessage() );
		}
	}
}

/* Upload CSV Data
$uploader = new UPLOADER( $upload_name );
$uploader->execute();
// */

// Processor class (requires $upload_name's file)
class PROCESSOR {
	function __construct($upload_name = null) {
		$this->upload_name = $upload_name;
		$this->db = new PDO('sqlite:..' . DIRECTORY_SEPARATOR . 'db.sqlite3');
		$this->db->exec("set names utf8");
		if ( ($this->handle = fopen($upload_name, 'r')) === FALSE ) die('cannot open stream');
	}

	public function process() {
		$col_to_db_map = $this->processTitles();
		print_r($col_to_db_map);
		print_r($this->titles);

		// Setup queries
		$uGetSTH = $this->db->prepare("SELECT accountno FROM user WHERE accountno=?;");
		$uAddSTH = $this->db->prepare("INSERT INTO user (first,last,company,title,city,state,bio,gradyear,phone,email,user,pass,accountno) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);");
		$uModSTH = $this->db->prepare("UPDATE \"user\" SET first=?,last=?,company=?,title=?,city=?,state=?,bio=?,gradyear=?,phone=?,email=?,\"user\"=?,pass=? WHERE accountno=?;");
		$eGetSTH = $this->db->prepare("SELECT eventID FROM event WHERE name=? AND programYearID=?;");
		$eAddSTH = $this->db->prepare("INSERT INTO event (name, programYearID) VALUES (?,?);");

		$aGetSTH = $this->db->prepare("SELECT attendeeID FROM attendee WHERE userID=?,eventID=?,yearID=?;"); // WHAT IF EVENT CHANGES???
		$aAddSTH = $this->db->prepare("INSERT INTO attendee (userID, eventID, yearID) vALUES (?,?,?);");

		// process rows
		while (($data = fgetcsv($this->handle, 1000, ",")) !== FALSE) {
			$data = array_map('trim', $data);

			// Insert user
			$user_data = array(
				$data[ $this->titles['first'] ],
				$data[ $this->titles['last'] ],
				$data[ $this->titles['company'] ],
				$data[ $this->titles['title'] ],
				$data[ $this->titles['city'] ],
				$data[ $this->titles['state'] ],
				iconv("SHIFT_JIS", "UTF-8", $data[ $this->titles['bio'] ]), // microsoft :( http://i-tools.org/charset
				'???', // $data[ $this->titles['gradyear'] ], // no grad-year yet
				$data[ $this->titles['phone1'] ],
				$data[ $this->titles['contsupref'] ], // email
				$data[ $this->titles['username'] ],
				$data[ $this->titles['password'] ], // encrypt this please!!!!
				$data[ $this->titles['accountno'] ]
			);
			if (
				!$uGetSTH->execute(array( $data[ $this->titles['accountno'] ] )) ||
				$uGetSTH->fetchColumn() === FALSE
			) {
				$uAddSTH->execute( $user_data );
			} else {
				$uModSTH->execute( $user_data );
			}

			// Add events  and attendees for each user
			foreach ($col_to_db_map as $key => $value) {
				echo $data[ $key ] . ' ' . print_r($value, true);

				// Should we insert event?
				switch ( strtolower($data[$key]) ) { // just check if key has numbers (ie: year)
					case 'deferred':
					case 'undecided':
					case 'none':
					case '': echo 'Skipped inserting event "' . $data[$key] . '"'; break;

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

				
				
				// TODO: process attendee with aGetSTH and aAddSTH (WHAT IF EVENT CHANGES???)
			}
		}

		// Final cleanup
		fclose($this->handle);
	}

	// Deal with titles and insert programYear and year entries as necessary
	private function processTitles() {
		$titles = fgetcsv($this->handle);
		$this->titles = array_flip(array_map('strtolower', $titles));

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
}

//* Process CSV Data
$processor = new PROCESSOR( $upload_name );
$processor->process();
// */

__halt_compiler() ?>
<html>
	<body>
		<h3>{{MSG}}</h3>
		<form action="uploader.php" method="post" enctype="multipart/form-data">
			<label for="file">Filename:</label>
			<input type="file" name="file" id="file">
			<input type="hidden" name="hash" value="{{HASH_VALUE}}">
			<input type="submit" name="submit" value="Upload">
		</form>
		<p>Full description of CSV format and required columns</p>
	</body>
</html>