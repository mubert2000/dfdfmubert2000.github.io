<?php

	$page = 'contacts';

	$file = 'contacts.php';

	$idpg = 9;

	include '../cfg.php';

	include '../ini.php';

	if($lng == "ru") {

		include "../template_reg.php";

	} else {

		include "../template.php";

	}

?>