<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 14.10.2007 г.
*/
defined('ACCESS') or die();
?>
<table class="tbl">
	<tr>
		<th width="40"><b>ID</b></th>
  		<th><b>Логин</b></th>
		<th width="100"><b>Баланс</b></th>
		<th width="100"><b>Реферальские</b></th>
		<th width="100"><b>Регистрация</b></th>
		<th width="110"><b>EDIT</b></th>
	</tr>
<?php
function users_list($query) {

	$result = mysql_query($query);
	$themes = mysql_num_rows($result);

	if (!$themes) {
		print '<tr><td colspan="6" align="center"><font color="#ffffff"><b>Пользователей нет.</b></font></td></tr>';
	} else {
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result)) {

		print "<tr>
		<td>".$row['id']."</td>
		<td align=\"left\"><a href=\"mailto:".$row['mail']."\"><b>".$row['login']."</b></a></td>
		<td>".$row['pm_balance']."</td>
		<td>".$row['reftop']."</td>
		<td>".date("d.m.y H:i", $row['reg_time'])."</td>";

		print '<td><nobr><a href="?a=edit_user&id='.$row[id].'"><img src="images/edit_ico.png" width="16" height="16" border="0" alt="Редактировать"></a> <a href="?a=referals&id='.$row[id].'"><img src="images/partners.png" width="16" height="16" border="0" alt="Привлечённые рефералы"></a> <a href="?a=logip&id='.$row[id].'"><img src="images/ip.png" width="16" height="16" border="0" alt="Лог IP"></a></nobr></td></tr>';

		}
	}
	print "</table>";
}

$sql = "SELECT * FROM users ORDER BY reftop DESC LIMIT 100";
users_list($sql);
?>