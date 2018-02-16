<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 14.10.2007 г.

-> Файл удаления новостей
*/
include "../../cfg.php";
include "../../ini.php";
if($status == 1) {
	$id = intval($_GET['id']);
	mysql_query("DELETE FROM news WHERE id = ".$id." LIMIT 1");
	print "<script>alert('Новость удалена!'); location.href='/news/'</script>";
}
?>