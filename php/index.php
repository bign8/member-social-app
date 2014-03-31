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
	protected $db;

	function __construct() {
		$this->db = new PDO('sqlite:db.sqlite3');
	}

	public function login() {
		$sth  = $this->db->prepare("SELECT * FROM participants WHERE email=?;");
		$pass = $sth->execute(array( $_POST['user'] ));
		$user = $sth->fetch( PDO::FETCH_ASSOC );
		$pass = $pass ? validate_password( $_POST['pass'], $user['pass'] ) : false ;

		if ($pass) {
			unset($user['pass']);
			$_SESSION['user'] = $user;
			die(header('Location: index.php')); // lose post request
		} else {
			// show login error
		}
	}
	public function logout() {
		unset( $_SESSION['user'] );
		die(header('Location: index.php')); // lose query string
	}
}

$app = new ELA();
if (isset($_POST['login'])) {
	$app->login();
} elseif (isset($_GET['logout'])) {
	$app->logout();
}