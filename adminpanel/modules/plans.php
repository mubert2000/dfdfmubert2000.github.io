<?php
/*
������ ������ ���������� ���������� �������� ������������, ����� �����.
����� ������������� ������� �������, ��������� ������ � ����������� �������� ������.
������ ������� �������: http://adminstation.ru/images/docs/doc1.jpg
���� ����������: 04.10.2012 �.

-> �������� �������� ������
*/
defined('ACCESS') or die();

$view = intval($_GET['status']);
if(($view == 0 || $view == 1) && $_GET['act']) {
	mysql_query("UPDATE plans SET status = ".intval($_GET['status'])." WHERE id = ".intval($_GET['id'])." LIMIT 1");
}

if($_GET['action'] == "add") {

	$name			= htmlspecialchars($_POST['name'], ENT_QUOTES, '');
	$minsum			= sprintf("%01.2f", $_POST['minsum']);
	$maxsum			= sprintf("%01.2f", $_POST['maxsum']);
	$percent		= sprintf("%01.2f", $_POST['percent']);
	$bonusdeposit	= sprintf("%01.2f", $_POST['bonusdeposit']);
	$bonusbalance	= sprintf("%01.2f", $_POST['bonusbalance']);
	$period			= intval($_POST['period']);
	$days			= intval($_POST['days']);
	$back			= intval($_POST['back']);
	$weekend		= intval($_POST['weekend']);
	$close			= intval($_POST['close']);
	$close_percent	= sprintf("%01.2f", $_POST['close_percent']);

	if($name && $minsum && $percent && $days) {
		mysql_query("INSERT INTO `plans` (`name`, `minsum`, `maxsum`, `percent`, `period`, `days`, `back`, `bonusdeposit`, `bonusbalance`, `weekend`, `close`, `close_percent`) VALUES ('".$name."', ".$minsum.", ".$maxsum.", ".$percent.", ".$period.", ".$days.", ".$back.", ".$bonusdeposit.", ".$bonusbalance.", ".$weekend.", ".$close.", ".$close_percent.")");
		print '<p class="erok">�������� ���� ������</p>';
	} else {
		print '<p class="er">��������� ��� ����</p>';
	}

}

?>
<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<FIELDSET style="border: solid #666666 1px; margin-bottom: 20px;">
<LEGEND><b>����������� �������� �����</b></LEGEND>

<table width="100%" align="center">
<?php
$result	= mysql_query("SELECT * FROM plans ORDER BY id ASC");
while($row = mysql_fetch_array($result)) {

print "<tr>
	<td><b>".$row['name']."</b><br />����� ������: $".$row['minsum']." - $".$row['maxsum']." ��� ".$row['percent']."% � ";
	if($row['period'] == 1) { print "����"; } elseif($row['period'] == 2) { print "������"; } elseif($row['period'] == 3) { print "�����"; } else { print "���"; }
print ", ������ ".$row['days'];
	if($row['period'] == 4) { print " �����"; } elseif($row['period'] == 1) { print " ����"; } elseif($row['period'] == 2) { print " ������"; } elseif($row['period'] == 3) { print " �������"; }
print "</td>";

	if($row['status'] == 1) {
		print "	<td width=\"20\"><a href=\"?a=plans&id=".$row['id']."&status=0&act=cp\"><img src=\"images/no_view.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"�� ����� / ��������\" /></a></td>";
	} else {
		print "<td width=\"20\"><a href=\"?a=plans&id=".$row['id']."&status=1&act=cp\"><img src=\"images/view.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"������� / ���������\" /></a></td>";
	}
	
	print "
	<td width=\"20\"><a href=\"?a=plan_edit&id=".$row['id']."\"><img src=\"images/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"�������������\" /></a></td><td width=\"20\"><a style=\"cursor:hand\" onclick=\"if(confirm('�� ������������� ������ ������� ������ �������� ����?')) top.location.href='del/plans.php?id=".$row['id']."';\"><img src=\"images/delite.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"�������\" /></a></td></tr>
<tr>
	<td colspan=\"4\" height=\"1\" bgcolor=\"#cccccc\"></td>
</tr>";
}
?>
</table>
</FIELDSET>

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

<FIELDSET style="border: solid #666666 1px;">
<LEGEND><b>�������� �������� ������</b></LEGEND>
<form action="?a=plans&action=add" method="post">
<table width="650" bgcolor="#eeeeee" align="center" border="0" style="border: solid #cccccc 1px;">
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>��������:</td>
		<td align="right"><input style="width: 400px;" type="text" name="name" size="80" maxlength="100" value="" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="�������� ��������� ����� ��������. ���������� ������ �������� �������� �� ���������� �����." /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font>����������� ����� ������:</td>
		<td align="right"><input style="width: 400px;" type="text" name="minsum" size="80" maxlength="10" value="0.1" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="����������� ����� ������ ��� ������� ��������� �����" /></td>
	</tr>
	<tr>
		<td>������������ ����� ������:</td>
		<td align="right"><input style="width: 400px;" type="text" name="maxsum" size="80" maxlength="10" value="0" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������������ ����� ������ ��� ������� ��������� �����. ��� ��������� ���� (0), ����� ������ �� ����������" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font>�������:</td>
		<td align="right"><input style="width: 302px;" type="text" name="percent" size="80" maxlength="5" value="" /><select name="period" id="period" onChange="checkPeriod();">
			<option value="4">� ���</option>
			<option value="1" selected>� ����</option>
			<option value="2">� ������</option>
			<option value="3">� �����</option>
		</select></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="�������, ������� ����� ����������� �� ������ � ��������� ��������������." /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font>���� (<span id="srok">����</span>):</td>
		<td align="right"><input style="width: 400px;" type="text" name="days" size="80" maxlength="10" value="" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� � ������� �������� ����� ����������� �������� �� ��������. ����������� ���-�� ���������� (������: ���� �� ������� ���������� ��������� � �����, �� � ������ ���� ����������� ���-�� �����, �� ���������� ������� ����� ����������� ��������.)" /></td>
	</tr>
	<tr>
		<td>����� � ����� �������� (%):</td>
		<td align="right"><input style="width: 400px;" type="text" name="bonusdeposit" size="80" maxlength="10" value="0.00" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������ ����� ��������� ��������� ��� �������� �������� ����� � ���� ��������. (������: �� ������� ����� 10%, ������ ��������� ������� �� ����� 100$, ����� ���� �������� ����� ����� 110$)" /></td>
	</tr>
	<tr>
		<td>����� �� ������ �� ����� �������� (%):</td>
		<td align="right"><input style="width: 400px;" type="text" name="bonusbalance" size="80" maxlength="10" value="0.00" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������ ����� ��������� ��������� ����� �� ������ ������������ ��� �������� ��������, ������� �� ������ ����� �������, ��� ������� � ��� ���� �������." /></td>
	</tr>
	<tr>
		<td align="right"><input class="check" type="checkbox" name="weekend" value="1" /></td>
		<td><b>�� ��������� � ��������</b></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� ������ ����� ��������, �� �������� �� ����� ����������� �� �������� � ������������." /></td>
	</tr>
	<tr>
		<td align="right"><input class="check" type="checkbox" id="back" name="back" value="1" onclick="ShowCloseDepo()" /></td>
		<td><b>������� ������ ������ �����</b></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� ������ ����� ��������, �� � ����� ����� �������� ������������ ����� ���������� ���� �������� �� ������. �����, ������ ������� ��������� ��� �������� ���� ��������." /></td>
	</tr>
</table>
<div id="closedep" style="display:none">
<table width="650" bgcolor="#eeeeee" align="center" border="0" style="border: solid #cccccc 1px;">
	<tr>
		<td width="50%" align="right"><input class="check" type="checkbox" name="close" value="1" /></td>
		<td><b>�������� ����������� ���������� ��������</b></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� ������ ����� ��������, ����� ������������ ������ �������� ������� ���� ������� � ������� �������� ��� ������� � ������ �������." /></td>
	</tr>
	<tr>
		<td>������� �� ����� ��������:</td>
		<td><input style="width: 400px;" type="text" name="close_percent" size="80" maxlength="10" value="0.00" /></td>
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