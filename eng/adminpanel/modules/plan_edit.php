<?php
/*
������ ������ ���������� ���������� �������� ������������, ����� �����.
����� ������������� ������� �������, ��������� ������ � ����������� �������� ������.
������ ������� �������: http://adminstation.ru/images/docs/doc1.jpg
���� ����������: 4.11.2008 �.

-> ���� �������������� ������
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

	print "<p class=\"erok\">����� ������ ���������!</p>";

	} else {
		print '<p class="er">��������� ��� ����</p>';
	}
}

$get_terif = mysql_query("SELECT * FROM plans WHERE id = ".intval($_GET['id'])." LIMIT 1");
$row = mysql_fetch_array($get_terif);
?>
<script language="JavaScript">
<!--
	function checkPeriod() {
		if(document.getElementById('period').value == '4') {
			document.getElementById("srok").innerHTML = "�����"
		} else if(document.getElementById('period').value == '1') {
			document.getElementById("srok").innerHTML = "����"
		} else if(document.getElementById('period').value == '2') {
			document.getElementById("srok").innerHTML = "������"
		} else if(document.getElementById('period').value == '3') {
			document.getElementById("srok").innerHTML = "�������"
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
<LEGEND><b>�������������� ��������� �����</b></LEGEND>
<form action="?a=plan_edit&action=edit&id=<?php print intval($_GET['id']); ?>" method="post">
<table width="650" bgcolor="#eeeeee" align="center" border="0" style="border: solid #cccccc 1px;">
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>��������:</td>
		<td align="right"><input style="width: 400px;" type="text" name="name" size="80" maxlength="100" value="<?php print $row['name']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="�������� ��������� ����� ��������. ���������� ������ �������� �������� �� ���������� �����." /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font>����������� ����� ������:</td>
		<td align="right"><input style="width: 400px;" type="text" name="minsum" size="80" maxlength="10" value="<?php print $row['minsum']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="����������� ����� ������ ��� ������� ��������� �����" /></td>
	</tr>
	<tr>
		<td>������������ ����� ������:</td>
		<td align="right"><input style="width: 400px;" type="text" name="maxsum" size="80" maxlength="10" value="<?php print $row['maxsum']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������������ ����� ������ ��� ������� ��������� �����. ��� ��������� ���� (0), ����� ������ �� ����������" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font>�������:</td>
		<td align="right"><input style="width: 302px;" type="text" name="percent" size="80" maxlength="5" value="<?php print $row['percent']; ?>" /><select name="period" id="period" onChange="checkPeriod();"><option value="4"<?php if($row['period'] == 4) { print " selected"; } ?>>� ���</option><option value="1"<?php if($row['period'] == 1) { print " selected"; } ?>>� ����</option><option value="2"<?php if($row['period'] == 2) { print " selected"; } ?>>� ������</option><option value="3"<?php if($row['period'] == 3) { print " selected"; } ?>>� �����</option></select></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="�������, ������� ����� ����������� �� ������ � ��������� ��������������." /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font>���� (<span id="srok"><?php if($row['period'] == 4) { print "�����"; } elseif($row['period'] == 1) { print "����"; } elseif($row['period'] == 2) { print "������"; } elseif($row['period'] == 3) { print "�������"; } ?></span>):</td>
		<td align="right"><input style="width: 400px;" type="text" name="days" size="80" maxlength="10" value="<?php print $row['days']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� � ������� �������� ����� ����������� �������� �� ��������. ����������� ���-�� ���������� (������: ���� �� ������� ���������� ��������� � �����, �� � ������ ���� ����������� ���-�� �����, �� ���������� ������� ����� ����������� ��������.)" /></td>
	</tr>
	<tr>
		<td>����� � ����� �������� (%):</td>
		<td align="right"><input style="width: 400px;" type="text" name="bonusdeposit" size="80" maxlength="10" value="<?php print $row['bonusdeposit']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������ ����� ��������� ��������� ��� �������� �������� ����� � ���� ��������. (������: �� ������� ����� 10%, ������ ��������� ������� �� ����� 100$, ����� ���� �������� ����� ����� 110$)" /></td>
	</tr>
	<tr>
		<td>����� �� ������ �� ����� �������� (%):</td>
		<td align="right"><input style="width: 400px;" type="text" name="bonusbalance" size="80" maxlength="10" value="<?php print $row['bonusbalance']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������ ����� ��������� ��������� ����� �� ������ ������������ ��� �������� ��������, ������� �� ������ ����� �������, ��� ������� � ��� ���� �������." /></td>
	</tr>
	<tr>
		<td align="right"><input class="check" type="checkbox" name="weekend" value="1"<?php if($row['weekend']) { print " checked"; } ?> /></td>
		<td><b>�� ��������� � ��������</b></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� ������ ����� ��������, �� �������� �� ����� ����������� �� �������� � ������������." /></td>
	</tr>
	<tr>
		<td align="right"><input class="check" type="checkbox" name="back" id="back" onclick="ShowCloseDepo()" value="1"<?php if($row['back']) { print " checked"; } ?> /></td>
		<td><b>������� ������ ������ �����</b></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� ������ ����� ��������, �� � ����� ����� �������� ������������ ����� ���������� ���� �������� �� ������. �����, ������ ������� ��������� ��� �������� ���� ��������." /></td>
	</tr>
</table>

<div id="closedep"<?php if(!$row['back']) { print ' style="display:none"'; } ?>>
<table width="650" bgcolor="#eeeeee" align="center" border="0" style="border: solid #cccccc 1px;">
	<tr>
		<td width="50%" align="right"><input class="check" type="checkbox" name="close" value="1"<?php if($row['close']) { print " checked"; } ?> /></td>
		<td><b>�������� ����������� ���������� ��������</b></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� ������ ����� ��������, ����� ������������ ������ �������� ������� ���� ������� � ������� �������� ��� ������� � ������ �������." /></td>
	</tr>
	<tr>
		<td>������� �� ����� ��������:</td>
		<td><input style="width: 400px;" type="text" name="close_percent" size="80" maxlength="10" value="<?php print $row['close_percent']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="��� ��������� �������� ������ �� ������ ������� �������, ������� ����� ������������� �� ����� �������� � ������ �������." /></td>
	</tr>
</table>
</div>

<table align="center" width="660" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="���������!" /></td>
	</tr>
</table>
</form>
</FIELDSET>