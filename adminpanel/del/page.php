<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 4.11.2008 г.

-> Файл удаления страницы
*/

include "../../cfg.php";
include "../../ini.php";
if($status == 1) {
	$f = $_GET['f'];
	if(!$f) {
		print "<html><head><script language=\"javascript\">alert('Вы не указали какую страницу необходимо удалить'); top.location.href='../adminstation.php?a=pages';</script></head></html>";
	} else {
		unlink("../../".$f."/".$f.".php");
		unlink("../../".$f."/".$f."_ru.php");
		unlink("../../".$f."/index.php");
		rmdir("../../".$f);
		mysql_query("DELETE FROM pages WHERE path = '".$f."' LIMIT 1");
		print "<html><head><script language=\"javascript\">alert('Страница удалена!'); top.location.href='../adminstation.php?a=pages';</script></head></html>";
	}
} else {
	include "../../includes/errors/404.php";
}
?>