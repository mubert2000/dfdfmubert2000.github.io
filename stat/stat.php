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
<p align="right">Show:  <a href="?sort=1">Accrual %</a> | <a href="?sort=2">Opening of deposit</a> | <a href="?sort=3">Account funding</a> | <a href="?sort=4">Withdrawal</a> | <a href="?sort=5">The authorization</a></p>
<?php
	if($_GET['sort'] == 2) {
		include "depo.php";
	} elseif($_GET['sort'] == 3) {
		include "enter.php";
	} elseif($_GET['sort'] == 4) {
		include "out.php";
	} elseif($_GET['sort'] == 5) {
		include "auth.php";
	} else {
		include "percent.php";
	}

} else {
	print "<p class=\"er\">To access this page, you need to log in!</p>";
}
?>