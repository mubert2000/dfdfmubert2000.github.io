<?php
defined('ACCESS') or die();
if($status != 1) { exit(); }

if($_GET['action'] == "add") {

	$name			= htmlspecialchars($_POST['name'], ENT_QUOTES, '');
	$purse			= htmlspecialchars($_POST['purse'], ENT_QUOTES, '');
	$abr			= htmlspecialchars($_POST['abr'], ENT_QUOTES, '');
	$percent		= sprintf("%01.2f", $_POST['percent']);
	$comment		= htmlspecialchars($_POST['comment'], ENT_QUOTES, '');

	if($name && $purse && $abr && $percent) {
		mysql_query("INSERT INTO `paysystems` (`name`, `purse`, `abr`, `percent`, `comment`) VALUES ('".$name."', '".$purse."', '".$abr."', ".$percent.", '".$comment."')");
		print '<p class="erok">Платежная система '.$name.' добавлена!</p>';
	} else {
		print '<p class="er">Заполните все поля</p>';
	}

}
?>

<FIELDSET style="border: solid #666666 1px; margin-bottom: 20px;">
<LEGEND><b>Платежные системы</b></LEGEND>

<table width="100%" align="center">
<tr>
	<td style="color: #999999;"><b>PerfectMoney</b> [USD]<br />Курс: 1:1</td>
	<td width="20"><img src="images/no_edit.gif" width="20" height="20" border="0" alt="Редактировать" /></td>
	<td width="20"><img src="images/no_delite.gif" width="20" height="20" border="0" alt="Удалить" /></td></tr>
<tr>
	<td colspan="3" height="1" bgcolor="#cccccc"></td>
</tr>
<tr>
	<td style="color: #999999;"><b>PAYEER.com</b> [USD]<br />Курс: 1:1</td>
	<td width="20"><img src="images/no_edit.gif" width="20" height="20" border="0" alt="Редактировать" /></td>
	<td width="20"><img src="images/no_delite.gif" width="20" height="20" border="0" alt="Удалить" /></td></tr>
<tr>
	<td colspan="3" height="1" bgcolor="#cccccc"></td>
</tr>
<?php
$result	= mysql_query("SELECT * FROM `paysystems` WHERE id > 2 ORDER BY id ASC");
while($row = mysql_fetch_array($result)) {

print "<tr>
	<td><b>".$row['name']."</b> [".$row['abr']."]<br />Курс: 1:".$row['percent']."</td>
	<td width=\"20\"><a href=\"?a=ps_edit&id=".$row['id']."\"><img src=\"images/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать\" /></a></td><td width=\"20\"><a onclick=\"if(confirm('Вы действительно хотите удалить данную платежную систему?')) top.location.href='del/ps.php?id=".$row['id']."';\"><img style=\"cursor: pointer;\" src=\"images/delite.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить\" /></a></td></tr>
<tr>
	<td colspan=\"3\" height=\"1\" bgcolor=\"#cccccc\"></td>
</tr>";
}
?>
</table>
</FIELDSET>

<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<FIELDSET style="border: solid #666666 1px;">
<LEGEND><b>Создание тарифных планов</b></LEGEND>
<form action="?a=paysystems&action=add" method="post">
<table width="650" bgcolor="#eeeeee" align="center" border="0" style="border: solid #cccccc 1px;">
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>Название:</td>
		<td align="right"><input style="width: 400px;" type="text" name="name" size="80" maxlength="20" value="" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Название платежной системы (до 20 символов)" /></td>
	</tr>
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>Номер счета:</td>
		<td align="right"><input style="width: 400px;" type="text" name="purse" size="80" maxlength="50" value="" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Ваш номер счета в данной платежной системе, куда пользователи будут переводить средства." /></td>
	</tr>
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>Аббревиатура:</td>
		<td align="right"><input style="width: 400px;" type="text" name="abr" size="80" maxlength="10" value="" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Короткое название денежных знаков платежной системы, или валюты (Например: Доллары в системе WebMoney = WMZ, или QIWI = руб.)" /></td>
	</tr>
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>Курс:</td>
		<td align="right"><input style="width: 400px;" type="text" name="percent" size="80" maxlength="50" value="1" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Курс на который будет умножаться/делиться сумма ввода/вывода (Например: если платежная система работает в рублях, вам необходимо указать курс, по которому будет считаться рубль к доллару)" /></td>
	</tr>
	<tr>
		<td width="50%">Комментарий:</td>
		<td align="right"><input style="width: 400px;" type="text" name="comment" size="80" maxlength="250" value="" /></td>
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