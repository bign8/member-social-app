<?php

$pass = true;
$data = false;

if (!isset($_REQUEST['action'])) $_REQUEST['action'] = false;
switch ($_REQUEST['action']) {
	case 'search':
		$db   = new PDO('sqlite:db.sqlite3');
		// $sth  = $db->query("SELECT userID,first,last,company,title,city,state,bio FROM participants;");
		$sth  = $db->prepare("SELECT * FROM participants p LEFT JOIN (SELECT * FROM note WHERE srcID=?) n ON p.accountno = n.destID;");
		$sth->execute( array('B0091656878&C`G)9Tod') );
		$data = $sth->fetchAll(PDO::FETCH_ASSOC);
		break;
	case 'note':

		break;
	default: $pass = false;
}

// Determine proper return data
if ( $pass ) {
	if ( !is_bool($data) ) echo ")]}',\n";
	echo json_encode( $data, JSON_PRETTY_PRINT );
} else {
	header( 'HTTP/ 405 Method Not Allowed' );
	echo 'Your Kung-Fu is not strong.';
}
