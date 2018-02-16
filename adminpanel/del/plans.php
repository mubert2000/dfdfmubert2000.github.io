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
	if (mysql_num_rows(mysql_query('SELECT `id` FROM plans WHERE id = '.$id))) {
		if (mysql_query("DELETE FROM plans WHERE id = ".$id." LIMIT 1")) {
			print "<script>alert('Тарифный план удалён!'); location.href='../adminstation.php?a=plans'</script>";
		} else {
			print "<script>alert('Не удаётся удалить тарифный план!'); location.href='../adminstation.php?a=plans'</script>";
		}
	} else {
		print "<script>alert('Нет такого тарифного плана!'); location.href='../adminstation.php?a=plans'</script>";
	}
}
?>