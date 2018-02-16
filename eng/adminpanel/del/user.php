<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 14.10.2007 г.

-> Удаление пользователя с базы
*/
include "../../cfg.php";
include "../../ini.php";
if($status == 1) {
	$id = intval($_GET['id']);
	mysql_query("DELETE FROM users WHERE id = ".$id." LIMIT 1");

	print "<html><head><script language=\"javascript\">alert('Пользователь удалён!'); location.href='../adminstation.php?a=users&page=".$_GET['page']."'</script></head></html>";
} else {
	print "<html><head><script language=\"javascript\">alert('У Вас нет прав на выполнение данной операции!'); location.href='../adminstation.php?a=users&page=".$_GET['page']."'</script></head></html>";
}
?>