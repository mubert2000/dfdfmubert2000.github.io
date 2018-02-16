<?php
	$page = 'outputs';
	$file = 'outputs.php';
	$idpg = 300;
	include '../cfg.php';
	include '../ini.php';
	$title = "Выплаты";
	if($lng == "ru") {
		include "../template_ru.php";
	} else {
		include "../template.php";
	}
?>