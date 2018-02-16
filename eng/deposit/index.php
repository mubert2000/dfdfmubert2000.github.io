<?php

	$page = 'deposit';

	$file = 'deposit.php';

	$idpg = 13;

	include '../cfg.php';

	include '../ini.php';

	if($lng == "ru") {

		include "../template_lk.php";

	} else {

		include "../template.php";

	}

?>