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
		$sth  = $this->db->prepare("SELECT * FROM participants WHERE email=?;");
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
}

$app = new ELA();
if (isset($_POST['login'])) {
	$result = $app->login( $_POST['user'], $_POST['pass'] );
	if ($result) die(header('Location: index.php')); // lose post request
	array_push($app->status, 'login-error');
} elseif (isset($_GET['logout'])) {
	$app->logout();
	die(header('Location: index.php')); // lose query string
}