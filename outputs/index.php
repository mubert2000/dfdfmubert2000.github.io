<?php
	$page = 'outputs';
	$file = 'outputs.php';
	$idpg = 300;
	include '../cfg.php';
	include '../ini.php';
	$title = "�������";
	if($lng == "ru") {
		include "../template_ru.php";
	} else {
		include "../template.php";
	}
?>