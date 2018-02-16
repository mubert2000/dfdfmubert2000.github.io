<?php
defined('ACCESS') or die();
if($_GET['action'] == "edit") {

	$fakeusers			= intval($_POST['fakeusers']);
	$fakeactiveusers	= intval($_POST['fakeactiveusers']);
	$fakeonline			= intval($_POST['fakeonline']);
	$fakedeposits		= sprintf("%01.2f", $_POST['fakedeposits']);
	$fakewithdraws		= sprintf("%01.2f", $_POST['fakewithdraws']);

	mysql_query('UPDATE `settings` SET `data` = "'.$fakeusers.'" WHERE cfgname = "fakeusers" LIMIT 1');
	mysql_query('UPDATE `settings` SET `data` = "'.$fakeactiveusers.'" WHERE cfgname = "fakeactiveusers" LIMIT 1');
	mysql_query('UPDATE `settings` SET `data` = "'.$fakeonline.'" WHERE cfgname = "fakeonline" LIMIT 1');
	mysql_query('UPDATE `settings` SET `data` = "'.$fakedeposits.'" WHERE cfgname = "fakedeposits" LIMIT 1');
	mysql_query('UPDATE `settings` SET `data` = "'.$fakewithdraws.'" WHERE cfgname = "fakewithdraws" LIMIT 1');

	print '<p class="erok">Данные сохранены!</p>';

}

?>
<FIELDSET style="border: solid #666666 1px; padding: 10px;">
<LEGEND><b>Накрутка статистики *:</b></LEGEND>
<form action="?a=fake&action=edit" method="post">
<table align="center" width="612" border="0" cellpadding="3" cellspacing="0" style="border: solid #cccccc 1px;">
<tr bgcolor="#dddddd">
	<td><b>Добавить фейковых пользователей</b>:</td>
	<td align="right"><input style="width: 280px;" type="text" name="fakeusers" size="70" maxlength="30" value="<?php print cfgSET('fakeusers'); ?>" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Добавить активных пользователей</b>:</td>
	<td align="right"><input style="width: 280px;" type="text" name="fakeactiveusers" size="70" maxlength="30" value="<?php print cfgSET('fakeactiveusers'); ?>" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Добавить пользователей онлайн</b>:</td>
	<td align="right"><input style="width: 280px;" type="text" name="fakeonline" size="70" maxlength="30" value="<?php print cfgSET('fakeonline'); ?>" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Добавить к сумме депозитов</b>:</td>
	<td align="right"><input style="width: 280px;" type="text" name="fakedeposits" size="70" maxlength="30" value="<?php print cfgSET('fakedeposits'); ?>" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Добавить/отнять сумму вывода</b> **:</td>
	<td align="right"><input style="width: 280px;" type="text" name="fakewithdraws" size="70" maxlength="30" value="<?php print cfgSET('fakewithdraws'); ?>" /></td>
</tr>

</table>
<table align="center" width="624" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Сохранить!" /></td>
	</tr>
</table>
</form>
</FIELDSET>
<p>* Данные цифры будут суммированы с реальными показателями</p>
<p>* Вы можете как добавить к сумме вывода средств, так и уменьшить её. Для уменьшения суммы, укажите перед цифрой символ "-" (минус)</p>