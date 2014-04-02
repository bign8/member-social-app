<?php

session_start();
ob_start("ob_gzhandler"); // gzip if possible

// For Debug
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once(__dir__ . DIRECTORY_SEPARATOR . 'ela.php');

$app = new ELA();
switch ( isset($_REQUEST['action']) ? $_REQUEST['action'] : 'none' ) {
	case 'login':
		$result = $app->login( $_POST['user'], $_POST['pass'] );
		if ($result) die(header('Location: index.php#')); // lose post request
		array_push($app->status, 'login-error');
		break;

	case 'logout':
		$app->logout();
		die(header('Location: index.php')); // lose query string
		break;

	case 'profile':
		$result = $app->save_profile( $_POST );
		if ($result) die(header('Location: index.php#profile')); // lose post request
		array_push($app->status, 'profile-error');
		break;
}
