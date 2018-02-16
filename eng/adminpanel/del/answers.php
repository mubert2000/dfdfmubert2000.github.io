<?php
include "../../cfg.php";
include "../../ini.php";

if ($status == 1) {
	if ($_GET['id']) {

		$get_inf = mysql_query("SELECT part FROM answers WHERE id = ".intval($_GET['id'])." LIMIT 1");
		$row = mysql_fetch_array($get_inf);
			$part	= $row['part'];

		$sql = 'DELETE FROM answers WHERE `id` = '.intval($_GET['id']).' LIMIT 1';
		if (mysql_query($sql)) {
			print "<html><head><script>alert('Запись удалена!'); top.location.href='/answers/';</script></head></html>";
			if($part) {
				mysql_query("UPDATE answers SET comments = comments - 1 WHERE id = ".$part." LIMIT 1");
			}
		} else {
			print "<html><head><script>alert('Не удаётся удалить запись!'); top.location.href='/answers/';</script></head></html>";
		}
	} else {
		print "<html><head><script>alert('Не указан комментарий!'); top.location.href='/answers/';</script></head></html>";
	}
}
?>