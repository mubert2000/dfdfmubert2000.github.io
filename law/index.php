<?php
	$page = 'law';
	$file = 'law.php';
	$idpg = 10;
	include '../cfg.php';
	include '../ini.php';
	if($lng == "ru") {
		include "../template_ru.php";
	} else {
		include "../template.php";
	}
?>