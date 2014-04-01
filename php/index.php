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

		// Rename photos with the new name
		if ($pass) {
			$start = __dir__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
			$old = DIRECTORY_SEPARATOR . ucfirst($old_data['last']) . ', ' . ucfirst($old_data['first']) . '.jpg';
			$new = DIRECTORY_SEPARATOR . ucfirst($data['last']) . ', ' . ucfirst($data['first']) . '.jpg';
			$pass = rename( $start . 'img' . $old, $start . 'img' . $new );
		}
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
	if ($result) die(header('Location: index.php#profile')); // lose post request
	array_push($app->status, 'profile-error');
}