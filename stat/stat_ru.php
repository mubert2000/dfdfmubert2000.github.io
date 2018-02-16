<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защищён законом: http://adminstation.ru/images/docs/doc1.jpg
#
# Контакты: ICQ: 451699555; E-mail: support@adminstation.ru; URL: www.adminstation.ru
#
*/
defined('ACCESS') or die();

if($login) {
?>
<p align="left">
	Показать:  <a href="?sort=1">Начисление %</a> | <a href="?sort=2">Открытие депозитов</a> | <a href="?sort=3">Пополнение счета</a> | <a href="?sort=4">Вывод</a> | <a href="?sort=5">Авторизации</a>
</p>
<?php
	if($_GET['sort'] == 2) {
		include "depo_ru.php";
	} elseif($_GET['sort'] == 3) {
		include "enter_ru.php";
	} elseif($_GET['sort'] == 4) {
		include "out_ru.php";
	} elseif($_GET['sort'] == 5) {
		include "auth_ru.php";
	} else {
		include "percent_ru.php";
	}

} else {
	print "<p class=\"er\">Для доступа к данной странице, вам необходимо авторизироваться!</p>";
}
?>