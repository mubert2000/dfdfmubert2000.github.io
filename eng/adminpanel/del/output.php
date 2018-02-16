<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 4.11.2008 г.

-> Файл удаления заявки на вывод средств
*/

include "../../cfg.php";
include "../../ini.php";

if ($status == 1) {
	if ($_GET['id']) {
		//$sql = 'DELETE FROM output WHERE `id` = '.$_GET['id'].' LIMIT 1';
		$sql = "UPDATE output SET status = 3 WHERE id = ".$_GET['id']." LIMIT 1";
		if (mysql_query($sql)) {
			echo "<html><head><script>alert('Отказ выполнен!'); top.location.href='../adminstation.php?a=edit';</script></head></html>";
		} else {
			echo "<html><head><script>alert('Не удаётся удалить запись!'); top.location.href='../adminstation.php?a=edit';</script></head></html>";
		}
	} else {
		echo "<html><head><script>alert('Не указана запись!'); top.location.href='../adminstation.php?a=edit';</script></head></html>";
	}
}
?>