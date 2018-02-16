<?php

	$page = 'lk';

	$file = 'lk.php';

	$idpg = 150;

	include '../cfg.php';

	include '../ini.php';

	if($lng == "ru") {

		include "../template_lk.php";

	} else {

		include "../template.php";

	}

?>