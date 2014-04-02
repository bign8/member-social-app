<?php
require_once(__dir__ . DIRECTORY_SEPARATOR . 'secure_pass.php');

/**
* ELA Main class
*/
class ELA {
	public $status;
	protected $db;

	function __construct() {
		$this->db = new PDO('sqlite:' . __dir__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db.sqlite3');
		$this->status = array();
	}

	public function login( $email, $password ) {
		$sth  = $this->db->prepare("SELECT * FROM user WHERE email=?;");
		$pass = $sth->execute(array( $email ));
		$user = $sth->fetch( PDO::FETCH_ASSOC );
		$pass = $pass ? validate_password( $password, $user['pass'] ) : false ;

		if ($pass) {
			unset($user['pass']);
			$_SESSION['user'] = $user;
		}
		return $pass;
	}
	public function logout() {
		unset( $_SESSION['user'] );
	}

	public function save_profile( $data ) {
		$user = $this->db->prepare("SELECT accountno, first, last, company, title, city, state, bio, gradYear, email FROM user WHERE accountno=?;");
		$pass = $user->execute(array( $_SESSION['user']['accountno'] ));
		$old_data = $user->fetch( PDO::FETCH_ASSOC );

		// Upload photos
		if ($pass) {
			$start = __dir__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
			$old = DIRECTORY_SEPARATOR . ucfirst($old_data['last']) . ', ' . ucfirst($old_data['first']) . '.jpg';
			$new = DIRECTORY_SEPARATOR . ucfirst($data['last']) . ', ' . ucfirst($data['first']) . '.jpg';
			if (
				isset($_FILES['image']) && !$_FILES['image']['error']
			) $pass = $this->process_image( $_FILES['image'], $start, $old );
		}

		// Rename photos with the new name
		if ($pass) $pass = rename( $start . 'img' . $old, $start . 'img' . $new );
		if ($pass) $pass = rename( $start . 'img-full' . $old, $start . 'img-full' . $new );
		if ($pass) $pass = rename( $start . 'img-orig' . $old, $start . 'img-orig' . $new );

		// Update settings
		if ($pass) {
			$sth = $this->db->prepare("UPDATE user SET first=?, last=?, title=?, company=?, city=?, state=?, bio=? WHERE accountno=?;");
			$pass = $sth->execute(array( $data['first'], $data['last'], $data['title'], $data['company'], $data['city'], $data['state'], $data['bio'], $_SESSION['user']['accountno'] ));
		}
		
		// Re-assign session data
		if ($pass) {
			$user->execute(array( $_SESSION['user']['accountno'] ));
			$_SESSION['user'] = $user->fetch( PDO::FETCH_ASSOC );
		}

		// Email profile change to UA...

		return $pass;
	}
	private function process_image( $image, $base, $name ) {
		// Verify image is of proper type
		$pass = ($image["type"] == "image/gif") || 
			($image["type"] == "image/jpeg")    || 
			($image["type"] == "image/jpg")     || 
			($image["type"] == "image/pjpeg")   || 
			($image["type"] == "image/x-png")   || 
			($image["type"] == "image/png");
		if (!$pass) array_push($this->status, 'image-type-error');

		// Upload new file
		if (file_exists($base . 'img-orig' . $name)) unlink($base . 'img-orig' . $name); // delete image
		if ($pass) $pass = move_uploaded_file($image['tmp_name'], $base . 'img-orig' . $name);

		// Get Image Data
		if ($pass) {
			list($width, $height, $mime) = getimagesize($base . 'img-orig' . $name);
			switch ($mime) {
				case IMAGETYPE_GIF:  $source = imagecreatefromgif( $base . 'img-orig' . $name); break;
				case IMAGETYPE_PNG:  $source = imagecreatefrompng( $base . 'img-orig' . $name); break;
				case IMAGETYPE_JPEG: $source = imagecreatefromjpeg($base . 'img-orig' . $name); break;
				default: $pass = false;
			}
		}

		// Resize + store images for web
		if ($pass) $pass = $this->resize_crop_save($source, $base . 'img-full' . $name, 200);
		if ($pass) $pass = $this->resize_crop_save($source, $base . 'img' . $name, 100);
		return $pass;
	}
	private function resize_crop_save( $source, $dest, $height ) {
		// Init variables
		$src_width = imagesx($source);
		$src_height = imagesy($source);
		$width = ($height / $src_height) * $src_width; // Scale Factor

		// Prepare crop (square image if in landscape)
		$src_x = 0;
		if ($width > $height) {
			$src_x = floor( ($src_width - $src_height) / 2 );
			$src_width = $src_height;
			$width = $height;
		}

		// Resize + crop
		$img = imagecreatetruecolor($width, $height);
		imagecopyresampled($img, $source, 0, 0, $src_x, 0, $width, $height, $src_width, $src_height);

		// Save
		if (file_exists($dest)) unlink($dest); // delete dest if exists
		$pass = imagejpeg($img, $dest);

		// Cleanup
		imagedestroy($img);
		return $pass;
	}

	public function clean_files() {
		// set_time_limit(0);
		// echo '<pre>';
		// $base = __dir__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
		// $source = array_diff(scandir($base . 'img-orig'), array('..', '.'));

		// foreach ($source as $key => $image) {
		// 	$resource =    imagecreatefromjpeg($base . 'img-orig' . DIRECTORY_SEPARATOR . $image);
		// 	$this->resize_crop_save($resource, $base . 'img-full' . DIRECTORY_SEPARATOR . $image, 200);
		// 	$this->resize_crop_save($resource, $base . 'img'      . DIRECTORY_SEPARATOR . $image, 100);
		// 	echo $key . "\n";
		// 	imagedestroy($resource);
		// }
	}

	public function my_conference_info() {
		$sth = $this->db->prepare("SELECT * FROM (SELECT * FROM attendee WHERE userID=?) a LEFT JOIN event e ON a.eventID=e.eventID LEFT JOIN year y ON a.yearID=y.yearID ORDER BY y.year DESC;");
		$sth->execute(array( $_SESSION['user']['accountno'] ));
		return $sth->fetchAll( PDO::FETCH_ASSOC );
	}
}

// if (isset($_REQUEST['cron'])) (new ELA())->clean_files();