<?php
require_once(__dir__ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'index.php');

/**
* Class Definition: Handles the generic processes for ELA-APP
*/
class Search_ELA extends ELA {
	function __construct() {
		parent::__construct();
		$this->data = json_decode(file_get_contents("php://input"));
		$this->user = (object) $_SESSION['user'];
	}

	public function search() {
		// $sth  = $db->query("SELECT userID,first,last,company,title,city,state,bio FROM participants;");
		$sth  = $this->db->prepare("SELECT * FROM user p LEFT JOIN (SELECT * FROM note WHERE srcID=?) n ON p.accountno = n.destID;");
		$sth->execute( array( $this->user->accountno ) );
		return $sth->fetchAll( PDO::FETCH_ASSOC );
	}

	public function note() {
		$pass = false;
		if ( is_null($this->data->noteID) ) {
			$sth = $this->db->prepare("INSERT INTO note (srcID, destID, note, \"when\") VALUES (?,?,?,CURRENT_TIMESTAMP);");
			$pass = $sth->execute(array( $this->user->accountno, $this->data->accountno, $this->data->note ));
			$this->data->noteID = $this->db->lastInsertId();
		} else {
			$sth = $this->db->prepare("UPDATE note SET note=?, \"when\"=CURRENT_TIMESTAMP WHERE noteID=?;");
			$pass = $sth->execute(array( $this->data->note, $this->data->noteID ));
		}
		if (!$pass) header('HTTP/ 409 Conflict');
		return $pass ? $this->data : $this->db->errorInfo();
	}
}

/**
* Interface Definition: Handles the generic processes for ELA-APP
*/
$data = false;

if (isset($_REQUEST['action'])) switch ($_REQUEST['action']) {
	case 'search': $data = (new Search_ELA())->search(); break;
	case 'note':   $data = (new Search_ELA())->note();   break;
}

// Determine proper return data
if ( $data ) echo ")]}',\n" . json_encode( $data, JSON_PRETTY_PRINT );
else {
	header( 'HTTP/ 405 Method Not Allowed' );
	$fp = fopen(__FILE__, 'r');
	fseek($fp, __COMPILER_HALT_OFFSET__);
	echo stream_get_contents($fp);
}

__halt_compiler() ?>
<title>ERROR</title>
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<div class="e" style="position:fixed;padding:15px;margin:5px;text-align:center;background-color:#f2dede;border:1px solid #ebccd1;color:#a94442;border-radius:4px;white-space:nowrap;">Your Kung-Fu<br/>is not strong!</div>
<script>var e=function(){var t=this;this.o=$(".e"),this.b=$(window);this.b.resize(function(){t.u()}).resize();this.a()};e.prototype.u=function(){this.h=this.b.height()-this.o.outerHeight();this.w=this.b.width()-this.o.outerWidth()};e.prototype.a=function(){var e=this;this.o.animate({top:Math.random()*this.h>>0,left:Math.random()*this.w>>0},1500,function(){e.a()})};(function(){new e})();</script>