<?php
include "../../cfg.php";
include "../../ini.php";
defined('ACCESS') or die();
if($status == 1) {

	$file = fopen("http://adminstation.ru/ip.php", "r");

	if($file) {

	$file = fread($file, 50);

	print "<p class=\"erok\">".$file."</p>";

	} else {
		print "ddd";
	}

}
?>