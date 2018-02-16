<?php
	$page = 'help';
	$file = 'help.php';
	$idpg = 11;
	include '../cfg.php';
	include '../ini.php';
	if($lng == "ru") {
		include "../template_ru.php";
	} else {
		include "../template.php";
	}
?>