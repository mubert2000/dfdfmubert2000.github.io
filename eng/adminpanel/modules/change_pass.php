<?php
/*
������ ������ ���������� ���������� �������� ������������, ����� �����.
����� ������������� ������� �������, ��������� ������ � ����������� �������� ������.
������ ������� �������: http://adminstation.ru/images/docs/doc1.jpg
���� ����������: 14.10.2007 �.

-> ����� ������
*/
defined('ACCESS') or die();
$action = $_GET['action'];
if($action == "change") {
	$password		= $_POST['password'];
	$new_pass		= $_POST['new_pass'];
	$re_new_pass	= $_POST['re_new_pass'];

	if(!$password || !$new_pass || !$re_new_pass) {
		print "<p class=\"er\">��������� ��� ����!</p>";
	}
	elseif($new_pass != $re_new_pass) {
		print "<p class=\"er\"> �������� ����� ������ �� ���������!</p>";
	}
	elseif($user_pass != as_md5($key, $password)) {
		print "<p class=\"er\"> ����������� ������ ����� �� �����!</p>";
	} else {
		$md_pass = as_md5($key, $new_pass);
		mysql_query("UPDATE users SET pass = '".$md_pass."' WHERE id = ".$user_id." LIMIT 1");
		print "<p class=\"erok\"><b>��������� ���������!</p>";
	}

}
?>
<form method="post" action="?a=change_pass&action=change">
<center><FIELDSET style="width: 300px; padding: 10px;" align="center">
<LEGEND><b>����� ������</b></LEGEND>
	<table align="center" border="0">
		<tr>
			<td>����������� ������:</td>
		</tr>
		<tr>
			<td><input class="input" type="password" name="password" size="30" /></td>
		</tr>
		<tr>
			<td>����� ������:</td>
		</tr>
		<tr>
			<td><input class="input" type="password" name="new_pass" size="30" /></td>
		</tr>
		<tr>
			<td>����� ������ <small>[��������]</small>:</td>
		</tr>
		<tr>
			<td><input class="input" type="password" name="re_new_pass" size="30" /></td>
		</tr>
		<tr>
			<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="���������!" /></td>
		</tr>
	</table>
</FIELDSET></center>
</form>