<?php
	$page = 'news';
	$file = 'news.php';
	$idpg = 8;
	include '../cfg.php';
	include '../ini.php';
	if($lng == "ru") {
		include "../template_ru.php";
	} else {
		include "../template.php";
	}
?>