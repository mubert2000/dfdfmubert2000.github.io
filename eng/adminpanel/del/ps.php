<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 4.11.2008 г.

-> Файл удаления сайтов веб-мастеров
*/

include '../../cfg.php';
include '../../ini.php';

if($status == 1) {
$id = intval($_GET['id']);
	if (mysql_num_rows(mysql_query('SELECT `id` FROM paysystems WHERE id = '.$id))) {
		if (mysql_query("DELETE FROM paysystems WHERE id = ".$id." LIMIT 1")) {
			print "<script>alert('Платежная система удалена!'); location.href='../adminstation.php?a=paysystems'</script>";
		} else {
			print "<script>alert('Не удаётся удалить платежную систему!'); location.href='../adminstation.php?a=paysystems'</script>";
		}
	} else {
		print "<script>alert('Нет такой платежной системы!'); location.href='../adminstation.php?a=paysystems'</script>";
	}
}
?>