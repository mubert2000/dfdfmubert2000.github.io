<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 14.10.2007 г. - Модернизирован 18.04.2009 г.

-> Файл инсталляции модулей на сайт
*/
defined('ACCESS') or die();
if($status != 1) { exit(); }
$action	= $_GET['action'];
$page	= $_GET['page'];

if($action == "go") {
	$zip	= $_FILES['zip']['name'];
	$FILE_EXTENSIONS = substr(strrchr($zip,"."),1);
	$old_umask = umask(0);

	if(!$zip) {
		print "<p class=\"er\">Вы не указали файл для загрузки!</p>";
	} elseif($FILE_EXTENSIONS != "zip" && $FILE_EXTENSIONS != "ZIP") {
		print "<p class=\"er\">Формат файла не поддерживается! Только ZIP-архив</p>";
	} elseif(!mkdir("installs/".$page, "0".$chmod)) {
		print "<p class=\"er\">Невозможно создать директорию для инсталляции! Необходимо дать права на запись папке: adminpanel/installs/</p>";
	} elseif(!copy($_FILES['zip']['tmp_name'], 'installs/'.$page.'/'.$page.'.zip')) {
		print "<p class=\"er\">Невозможно скопировать ZIP-архив! Необходимо дать права на запись папке: adminpanel/installs/".$page."/</p>";
		rmdir("installs/".$page);
	} else {
		require_once('installs/pclzip.lib.php');
		$archive	= new PclZip('installs/'.$page.'/'.$page.'.zip');
		$list		= $archive->extract(PCLZIP_OPT_PATH, "installs/".$page."/");

		if($list == 0) {
			print "<p class=\"er\">Невозможно разархивировать архив!</p>";
			rmdir("installs/".$page);
			unlink("installs/".$page."/".$page.".zip");
		} else {
			umask($old_umask);
			unlink("installs/".$page."/".$page.".zip");
			print "<p class=\"erok\">Модуль установлен!</p>";
		}

	}
}
?>
<form action="?a=install&page=<?php print intval($_GET[page]); ?>&action=go" method="post" enctype="multipart/form-data">
<FIELDSET style="border: solid #666666 1px; padding: 10px;">
<LEGEND><b>Установка модуля:</b></LEGEND>
<table width="100%" border="0">
	<tr>
		<td width="60"><strong>Файл:</strong></td>
		<td><input type="file" name="zip" style="width: 610px;" size="76" /></td>
		<td><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Сохранить!" /></td>
	</tr>
</table>
</FIELDSET>
</form>
<?php
if(file_exists("installs/".$page."/install.php")) {
	include "installs/".$page."/install.php";
}

if($action == "go_del") {
$password		= $_POST['password'];
	if(!$password) {
		print "<p class=\"er\">Введите пароль!</p>";
	} elseif(as_md5($key, $password) != $user_pass) {
		print "<p class=\"er\">Пароль введён не верно!</p>";
	} elseif(!file_exists("uninstalls/".$page.".php")) {
		print "<p class=\"er\">Не найден файл деинсталляции!</p>";
	} else {
		include "uninstalls/".$page.".php";
	}
}
?>
<form action="?a=install&page=<?php print intval($_GET[page]); ?>&action=go_del" method="post">
<FIELDSET style="border: solid #666666 1px; padding: 10px;">
<LEGEND><b style="color: red;">Удаление модуля:</b></LEGEND>
<table width="100%" border="0">
	<tr>
		<td width="60"><strong>Пароль:</strong></td>
		<td><input class="inp" style="background-color: #ffffff; width: 610px;" type="password" name="password" size="90" /></td>
		<td><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Удалить!" /></td>
	</tr>
</table>
</FIELDSET>
</form>