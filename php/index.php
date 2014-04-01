<?php

session_start();
ob_start("ob_gzhandler"); // gzip if possible

// For Debug
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once(__dir__ . DIRECTORY_SEPARATOR . 'secure_pass.php');

/**
* ELA Main class
*/
class ELA {
	public $status;
	protected $db;

	function __construct() {
		$this->db = new PDO('sqlite:db.sqlite3');
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
			if (isset($_FILES['image'])) $pass = $this->process_image( $_FILES['image'], $start, $old );
		}

		// Rename photos with the new name
		if ($pass) $pass = rename( $start . 'img' . $old, $start . 'img' . $new );
		if ($pass) $pass = rename( $start . 'img-full' . $old, $start . 'img-full' . $new );

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

		// Email profile change...

		return $pass;
	}

	private function process_image( $image, $base, $name ) {

		if (file_exists($base . 'img-orig' . $name)) /* TODO: delete image */ echo 'image exists';

		$pass = ($image["type"] == "image/gif") || 
			($image["type"] == "image/jpeg")    || 
			($image["type"] == "image/jpg")     || 
			($image["type"] == "image/pjpeg")   || 
			($image["type"] == "image/x-png")   || 
			($image["type"] == "image/png");

		if (!$pass) array_push($this->status, 'image-type-error');

		if ($pass) $pass = move_uploaded_file($image['tmp_name'], $base . 'img-orig' . $name);

		// Get Image Data
		list($width, $height) = getimagesize($base . 'img-orig' . $name);
		$source = imagecreatefromjpeg($base . 'img-orig' . $name); // TODO: this will have to change based on png and gif

		// Resize for `img-full` (200px tall)
		if ($pass && $height > 200) {
			$new_200_width = (200 / $height) * $width;
			$new_200 = imagecreatetruecolor($new_200_width, 200);
			imagecopyresized($new_200, $source, 0, 0, 0, 0, $new_200_width, 200, $width, $height);

			if ($new_200_width > 200) {
				// TODO: crop out sides (centered)
			}

			$pass = imagejpeg($new_200, $base . 'img-full' . $name); // TODO: delete file if exists
			imagedestroy($new_200);
		}

		// Resize for `img` (100px tall)
		if ($pass && $height > 100) {
			$new_100_width = (100 / $height) * $width;
			$new_100 = imagecreatetruecolor($new_100_width, 100);
			imagecopyresized($new_100, $source, 0, 0, 0, 0, $new_100_width, 100, $width, $height);

			if ($new_100_width > 100) {
				// TODO: crop out sides (centered)
			}

			$pass = imagejpeg($new_200, $base . 'img' . $name); // TODO: delete file if exists
			imagedestroy($new_100);
		}
		imagedestroy($source);

		return $pass;
	}
}

$app = new ELA();
if (isset($_POST['login'])) {
	$result = $app->login( $_POST['user'], $_POST['pass'] );
	if ($result) die(header('Location: index.php')); // lose post request
	array_push($app->status, 'login-error');
} elseif (isset($_GET['logout'])) {
	$app->logout();
	die(header('Location: index.php')); // lose query string
} elseif (isset($_POST['profile'])) {
	$result = $app->save_profile( $_POST );
	// if ($result) die(header('Location: index.php#profile')); // lose post request
	array_push($app->status, 'profile-error');
}