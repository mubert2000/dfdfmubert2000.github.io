<?php
	$page = 'about';
	$file = 'about.php';
	$idpg = 16;
	include '../cfg.php';
	include '../ini.php';
	if($lng == "ru") {
		include "../template_ru.php";
	} else {
		include "../template.php";
	}
?>