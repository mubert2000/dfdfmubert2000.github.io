<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 14.10.2007 г.

-> Смена пароля
*/
defined('ACCESS') or die();
$action = $_GET['action'];
if($action == "change") {
	$password		= $_POST['password'];
	$new_pass		= $_POST['new_pass'];
	$re_new_pass	= $_POST['re_new_pass'];

	if(!$password || !$new_pass || !$re_new_pass) {
		print "<p class=\"er\">Заполните все поля!</p>";
	}
	elseif($new_pass != $re_new_pass) {
		print "<p class=\"er\"> Введённые новые пароли не совпадают!</p>";
	}
	elseif($user_pass != as_md5($key, $password)) {
		print "<p class=\"er\"> Действующий пароль введён не верно!</p>";
	} else {
		$md_pass = as_md5($key, $new_pass);
		mysql_query("UPDATE users SET pass = '".$md_pass."' WHERE id = ".$user_id." LIMIT 1");
		print "<p class=\"erok\"><b>Изменения сохранены!</p>";
	}

}
?>
<form method="post" action="?a=change_pass&action=change">
<center><FIELDSET style="width: 300px; padding: 10px;" align="center">
<LEGEND><b>Смена пароля</b></LEGEND>
	<table align="center" border="0">
		<tr>
			<td>Действующий пароль:</td>
		</tr>
		<tr>
			<td><input class="input" type="password" name="password" size="30" /></td>
		</tr>
		<tr>
			<td>Новый пароль:</td>
		</tr>
		<tr>
			<td><input class="input" type="password" name="new_pass" size="30" /></td>
		</tr>
		<tr>
			<td>Новый пароль <small>[повторно]</small>:</td>
		</tr>
		<tr>
			<td><input class="input" type="password" name="re_new_pass" size="30" /></td>
		</tr>
		<tr>
			<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Сохранить!" /></td>
		</tr>
	</table>
</FIELDSET></center>
</form>