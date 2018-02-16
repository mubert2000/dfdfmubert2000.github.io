<?php

	$page = 'profile';

	$file = 'profile.php';

	$idpg = 5;

	include '../cfg.php';

	include '../ini.php';

	if($lng == "ru") {

		include "../template_lk.php";

	} else {

		include "../template.php";

	}

?>