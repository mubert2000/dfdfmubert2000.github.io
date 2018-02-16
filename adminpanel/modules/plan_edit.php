<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 4.11.2008 г.

-> Файл редактирования тарифа
*/
defined('ACCESS') or die();
if($_GET['action'] == "edit") {

	$name			= htmlspecialchars($_POST['name'], ENT_QUOTES, '');
	$minsum			= sprintf("%01.2f", $_POST['minsum']);
	$maxsum			= sprintf("%01.2f", $_POST['maxsum']);
	$percent		= sprintf("%01.2f", $_POST['percent']);
	$period			= intval($_POST['period']);
	$days			= intval($_POST['days']);
	$back			= intval($_POST['back']);
	$bonusdeposit	= sprintf("%01.2f", $_POST['bonusdeposit']);
	$bonusbalance	= sprintf("%01.2f", $_POST['bonusbalance']);
	$weekend		= intval($_POST['weekend']);
	$close			= intval($_POST['close']);
	$close_percent	= sprintf("%01.2f", $_POST['close_percent']);

	if($name && $minsum && $percent && $days) {

	mysql_query("UPDATE plans SET close = ".$close.", close_percent = ".$close_percent.", back = ".$back.", name = '".$name."', minsum = ".$minsum.", maxsum = ".$maxsum.", percent = ".$percent.", period = ".$period.", days = ".$days.", bonusdeposit = ".$bonusdeposit.", bonusbalance = ".$bonusbalance.", weekend = ".$weekend." WHERE id = ".intval($_GET['id'])." LIMIT 1");

	print "<p class=\"erok\">Новые данные сохранены!</p>";

	} else {
		print '<p class="er">Заполните все поля</p>';
	}
}

$get_terif = mysql_query("SELECT * FROM plans WHERE id = ".intval($_GET['id'])." LIMIT 1");
$row = mysql_fetch_array($get_terif);
?>
<script language="JavaScript">
<!--
	function checkPeriod() {
		if(document.getElementById('period').value == '4') {
			document.getElementById("srok").innerHTML = "часов"
		} else if(document.getElementById('period').value == '1') {
			document.getElementById("srok").innerHTML = "дней"
		} else if(document.getElementById('period').value == '2') {
			document.getElementById("srok").innerHTML = "недель"
		} else if(document.getElementById('period').value == '3') {
			document.getElementById("srok").innerHTML = "месяцев"
		}
	}

	function ShowCloseDepo() {
		back		= document.getElementById('back');
		closedep	= document.getElementById('closedep');
		if(back.checked) {
			closedep.style.display = "block";
		} else {
			closedep.style.display = "none";
		}
	}
//-->
</script>
<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<FIELDSET style="border: solid #666666 1px;">
<LEGEND><b>Редактирование тарифного плана</b></LEGEND>
<form action="?a=plan_edit&action=edit&id=<?php print intval($_GET['id']); ?>" method="post">
<table width="650" bgcolor="#eeeeee" align="center" border="0" style="border: solid #cccccc 1px;">
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>Название:</td>
		<td align="right"><input style="width: 400px;" type="text" name="name" size="80" maxlength="100" value="<?php print $row['name']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Название тарифного плана депозита. Желательно давать короткие названия на английском языке." /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font>Минимальная сумма вклада:</td>
		<td align="right"><input style="width: 400px;" type="text" name="minsum" size="80" maxlength="10" value="<?php print $row['minsum']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Минимальная сумма вклада для данного тарифного плана" /></td>
	</tr>
	<tr>
		<td>Максимальная сумма вклада:</td>
		<td align="right"><input style="width: 400px;" type="text" name="maxsum" size="80" maxlength="10" value="<?php print $row['maxsum']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Максимальная сумма вклада для данного тарифного плана. При установке нуля (0), сумма вклада не ограничена" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font>Процент:</td>
		<td align="right"><input style="width: 302px;" type="text" name="percent" size="80" maxlength="5" value="<?php print $row['percent']; ?>" /><select name="period" id="period" onChange="checkPeriod();"><option value="4"<?php if($row['period'] == 4) { print " selected"; } ?>>В час</option><option value="1"<?php if($row['period'] == 1) { print " selected"; } ?>>В день</option><option value="2"<?php if($row['period'] == 2) { print " selected"; } ?>>В неделю</option><option value="3"<?php if($row['period'] == 3) { print " selected"; } ?>>В месяц</option></select></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Процент, который будет начисляться на баланс с указанной переодичностью." /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font>Срок (<span id="srok"><?php if($row['period'] == 4) { print "часов"; } elseif($row['period'] == 1) { print "дней"; } elseif($row['period'] == 2) { print "недель"; } elseif($row['period'] == 3) { print "месяцев"; } ?></span>):</td>
		<td align="right"><input style="width: 400px;" type="text" name="days" size="80" maxlength="10" value="<?php print $row['days']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Срок в течении которого будут начисляться проценты от депозита. Указывается кол-во начислений (Пример: если вы указали начисление процентов в часах, то в данном поле указывается кол-во часов, на протяжении которых быдут начисляться проценты.)" /></td>
	</tr>
	<tr>
		<td>Бонус к сумме депозита (%):</td>
		<td align="right"><input style="width: 400px;" type="text" name="bonusdeposit" size="80" maxlength="10" value="<?php print $row['bonusdeposit']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Данная опция позволяет начислять при открытии депозита бонус к телу депозита. (Пример: Вы указали бонус 10%, клиент открывает депозит на сумму 100$, итого тело депозита будет равно 110$)" /></td>
	</tr>
	<tr>
		<td>Бонус на баланс от суммы депозита (%):</td>
		<td align="right"><input style="width: 400px;" type="text" name="bonusbalance" size="80" maxlength="10" value="<?php print $row['bonusbalance']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Данная опция позволяет добавлять бонус на баланс пользователя при открытии депозита, который он сможет сразу вывести, или вложить в еще один депозит." /></td>
	</tr>
	<tr>
		<td align="right"><input class="check" type="checkbox" name="weekend" value="1"<?php if($row['weekend']) { print " checked"; } ?> /></td>
		<td><b>Не начислять в выходные</b></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Если данная опция включена, то проценты не будут начисляться по субботам и воскресеньям." /></td>
	</tr>
	<tr>
		<td align="right"><input class="check" type="checkbox" name="back" id="back" onclick="ShowCloseDepo()" value="1"<?php if($row['back']) { print " checked"; } ?> /></td>
		<td><b>Возврат вклада вконце срока</b></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Если данная опция включена, то в конце срока депозита пользователю будет возвращено тело депозита на баланс. Иначе, просто депозит закроется без возврата тела депозита." /></td>
	</tr>
</table>

<div id="closedep"<?php if(!$row['back']) { print ' style="display:none"'; } ?>>
<table width="650" bgcolor="#eeeeee" align="center" border="0" style="border: solid #cccccc 1px;">
	<tr>
		<td width="50%" align="right"><input class="check" type="checkbox" name="close" value="1"<?php if($row['close']) { print " checked"; } ?> /></td>
		<td><b>Включить возможность досрочного закрытия</b></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Если данная опция включена, тогда пользователь сможет досрочно закрыть свой депозит и вывести средства или вложить в другой депозит." /></td>
	</tr>
	<tr>
		<td>Процент от суммы депозита:</td>
		<td><input style="width: 400px;" type="text" name="close_percent" size="80" maxlength="10" value="<?php print $row['close_percent']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="При досрочном закрытии вклада вы можете указать процент, который будет высчитываться от суммы депозита в пользу системы." /></td>
	</tr>
</table>
</div>

<table align="center" width="660" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Сохранить!" /></td>
	</tr>
</table>
</form>
</FIELDSET>