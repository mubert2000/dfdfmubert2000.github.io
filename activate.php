<?php
include "cfg.php";
include "ini.php";

$m = htmlspecialchars($_GET['m'], ENT_QUOTES, '');
$h = htmlspecialchars($_GET['h'], ENT_QUOTES, '');

if(!$m || !$h) {
	print '<script language="JavaScript">
	<!--
		alert(\'Error link\');
		top.location.href=\'/\';
	//-->
	</script>';
} else {

	$query	= "SELECT `login`, `mail` FROM `users` WHERE mail = '".$m."' LIMIT 1";
	$result	= mysql_query($query);
	$row	= mysql_fetch_array($result);

	if(!$row['mail']) {
		print '<script language="JavaScript">
		<!--
			alert(\'No mail\');
			top.location.href=\'/\';
		//-->
		</script>';
	} elseif($h != as_md5($key, $row['login'].$row['mail'])) {
		print '<script language="JavaScript">
		<!--
			alert(\'Error activate link\');
			top.location.href=\'/\';
		//-->
		</script>';
	} else {

		mysql_query('UPDATE users SET active = 0 WHERE mail = "'.$row['mail'].'" LIMIT 1');

		print '<script language="JavaScript">
		<!--
			alert(\'Ok!\');
			top.location.href=\'/login/\';
		//-->
		</script>';

	}

}
?>