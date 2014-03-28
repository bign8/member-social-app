<?php

ob_start("ob_gzhandler"); // gzip if possible

// For Debug
error_reporting(E_ALL);
ini_set('display_errors', '1');

/**
* Class Definition: Handles the generic processes for ELA-APP
*/
class Search_ELA {
	function __construct() {
		$this->db   = new PDO('sqlite:db.sqlite3');
		$this->data = json_decode(file_get_contents("php://input"));
	}

	public function search() {
		// $sth  = $db->query("SELECT userID,first,last,company,title,city,state,bio FROM participants;");
		$sth  = $this->db->prepare("SELECT * FROM participants p LEFT JOIN (SELECT * FROM note WHERE srcID=?) n ON p.accountno = n.destID;");
		$sth->execute( array('B0091656878&C`G)9Tod') );
		return $sth->fetchAll( PDO::FETCH_ASSOC );
	}

	public function note() {

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

// var err = function () {
// 	var that = this;
// 	this.obj = $('.e'), this.win = $(window);
// 	this.win.resize(function() { that.update() }).resize();
// 	this.animateMe();
// };
// err.prototype.update = function () {
// 	this.h = this.win.height() - this.obj.outerHeight();
// 	this.w = this.win.width() - this.obj.outerWidth();
// };
// err.prototype.animateMe = function() {
// 	var that = this;
// 	this.obj.animate({ top: Math.random() * this.h >> 0, left: Math.random() * this.w >> 0 }, 1500, function() { that.animateMe(); });
// };
// $(document).ready(function () { new err(); });

__halt_compiler() ?>
<title>ERROR</title>
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>var e=function(){var t=this;this.o=$(".e"),this.b=$(window);this.b.resize(function(){t.u()}).resize();this.a()};e.prototype.u=function(){this.h=this.b.height()-this.o.outerHeight();this.w=this.b.width()-this.o.outerWidth()};e.prototype.a=function(){var e=this;this.o.animate({top:Math.random()*this.h>>0,left:Math.random()*this.w>>0},1500,function(){e.a()})};$(document).ready(function(){new e})</script>
<div class="e" style="position:fixed;padding:15px;margin:5px;text-align:center;background-color:#f2dede;border:1px solid #ebccd1;color:#a94442;border-radius:4px;white-space:nowrap;">Your Kung-Fu<br/>is not strong!</div>