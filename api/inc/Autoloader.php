<?php

spl_autoload_register(function($classname) {

	// This was a filename, don't bother
	if (false !== strpos($classname, '.')) exit;

	// Build appropriate include path
	$path = array(__DIR__, $classname . '.php');
	if (preg_match('/[a-zA-Z]+Controller$/', $classname)) {
		array_splice($path, 1, 0, 'controllers');
	} elseif (preg_match('/[a-zA-Z]+Model$/', $classname)) {
		array_splice($path, 1, 0, 'models');
	} elseif (preg_match('/[a-zA-Z]+View$/', $classname)) {
		array_splice($path, 1, 0, 'views');
	}

	// Include file as desired
	$path = implode( DIRECTORY_SEPARATOR, $path );
	if (file_exists($path)) {
		include $path;
		return true;
	}
});

