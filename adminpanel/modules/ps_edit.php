<?php
/*
������ ������ ���������� ���������� �������� ������������, ����� �����.
����� ������������� ������� �������, ��������� ������ � ����������� �������� ������.
������ ������� �������: http://adminstation.ru/images/docs/doc1.jpg
���� ����������: 4.11.2008 �.

-> ���� ��������������
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
		print "<p class=\"erok\">����� ������ ���������!</p>";

	} else {
		print '<p class="er">��������� ��� ����</p>';
	}
}

$get_terif = mysql_query("SELECT * FROM paysystems WHERE id = ".intval($_GET['id'])." LIMIT 1");
$row = mysql_fetch_array($get_terif);
?>
<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<FIELDSET style="border: solid #666666 1px;">
<LEGEND><b>�������������� ��������� �������</b></LEGEND>
<form action="?a=ps_edit&action=edit&id=<?php print intval($_GET['id']); ?>" method="post">
<table width="650" bgcolor="#eeeeee" align="center" border="0" style="border: solid #cccccc 1px;">
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>��������:</td>
		<td align="right"><input style="width: 400px;" type="text" name="name" size="80" maxlength="20" value="<?php print $row['name']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="�������� ��������� ������� (�� 20 ��������)" /></td>
	</tr>
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>����� �����:</td>
		<td align="right"><input style="width: 400px;" type="text" name="purse" size="80" maxlength="50" value="<?php print $row['purse']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="��� ����� ����� � ������ ��������� �������, ���� ������������ ����� ���������� ��������." /></td>
	</tr>
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>������������:</td>
		<td align="right"><input style="width: 400px;" type="text" name="abr" size="80" maxlength="10" value="<?php print $row['abr']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="�������� �������� �������� ������ ��������� �������, ��� ������ (��������: ������� � ������� WebMoney = WMZ, ��� QIWI = ���.)" /></td>
	</tr>
	<tr>
		<td width="50%"><font color="red"><b>!</b></font>����:</td>
		<td align="right"><input style="width: 400px;" type="text" name="percent" size="80" maxlength="50" value="<?php print $row['percent']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� �� ������� ����� ����������/�������� ����� �����/������ (��������: ���� ��������� ������� �������� � ������, ��� ���������� ������� ����, �� �������� ����� ��������� ����� � �������)" /></td>
	</tr>
	<tr>
		<td width="50%">�����������:</td>
		<td align="right"><input style="width: 400px;" type="text" name="comment" size="80" maxlength="250" value="<?php print $row['comment']; ?>" /></td>
		<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="����� �� ������ ������ ����������� �� 250 �������� (��������: �� ������ ������� ������� ���������� �����). ������ ����������� ����� ������� ������������ ��� ���������� �������." /></td>
	</tr>
</table>
<table align="center" width="660" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="���������!" /></td>
	</tr>
</table>
</form>
</FIELDSET>