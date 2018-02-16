<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 4.11.2008 г.

-> Файл редактирования
*/
defined('ACCESS') or die();
if($_GET['action'] == "edit") {

	$name			= htmlspecialchars($_POST['name'], ENT_QUOTES, '');
	$purse			= htmlspecialchars($_POST['purse'], ENT_QUOTES, '');
	$abr			= htmlspecialchars($_POST['abr'], ENT_QUOTES, '');
	$percent		= sprintf("%01.2f", $_POST['percent']);
	$comment		= htmlspecialchars($_POST['comment'], ENT_QUOTES, '');

	if($name && $purse && $percent && $abr) {

		mysql_query("UPDATE paysystems SET name = '".$name."', purse = '".$purse."', abr = '".$abr."', percent = ".$percent.", comment = '".$comment."' WHERE id = ".intval($_GET['id'])." LIMIT 1");
		print "<p class=\"erok\">Новые данные сохранены!</p>";

	} else {
		print '<p class="er">Заполните все поля</p>';
	}
}

$get_terif = mysql_query("SELECT * FROM paysystems WHERE id = ".intval($_GET['id'])." LIMIT 1");
$row = mysql_fetch_array($get_terif);
?>
<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<FIELDSET style="border: solid #666666 1px;">
<LEGEND><b>Редактирование платежной системы</b></LEGEND>
<form action="?a=ps_edit&action=edit&id=<?php print intval($_GET['id']); ?>" method="post">
<table width="650" bgcolor="#eeeeee" align="center" border="0" style="border: solid #cccccc 1px;">
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>Название:</td>
		<td align="right"><input style="width: 400px;" type="text" name="name" size="80" maxlength="20" value="<?php print $row['name']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Название платежной системы (до 20 символов)" /></td>
	</tr>
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>Номер счета:</td>
		<td align="right"><input style="width: 400px;" type="text" name="purse" size="80" maxlength="50" value="<?php print $row['purse']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Ваш номер счета в данной платежной системе, куда пользователи будут переводить средства." /></td>
	</tr>
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>Аббревиатура:</td>
		<td align="right"><input style="width: 400px;" type="text" name="abr" size="80" maxlength="10" value="<?php print $row['abr']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Короткое название денежных знаков платежной системы, или валюты (Например: Доллары в системе WebMoney = WMZ, или QIWI = руб.)" /></td>
	</tr>
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>Курс:</td>
		<td align="right"><input style="width: 400px;" type="text" name="percent" size="80" maxlength="50" value="<?php print $row['percent']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Курс на который будет умножаться/делиться сумма ввода/вывода (Например: если платежная система работает в рублях, вам необходимо указать курс, по которому будет считаться рубль к доллару)" /></td>
	</tr>
	<tr>
		<td width="50%">Комментарий:</td>
		<td align="right"><input style="width: 400px;" type="text" name="comment" size="80" maxlength="250" value="<?php print $row['comment']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Здесь вы можете ввести комментарий до 250 символов (например: вы можете указать порядок пополнения счета). Данный комментарий будет выведен пользователю при пополнении баланса." /></td>
	</tr>
</table>
<table align="center" width="660" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Сохранить!" /></td>
	</tr>
</table>
</form>
</FIELDSET>