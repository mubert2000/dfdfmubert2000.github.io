<?php
	$page = 'top';
	$file = 'top.php';
	$idpg = 19;
	include '../cfg.php';
	include '../ini.php';
	if($lng == "ru") {
		include "../template_ru.php";
	} else {
		include "../template.php";
	}
?>