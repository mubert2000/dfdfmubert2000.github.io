<?php

if($er) {

	print '<div class="er" style="text-align: left; padding-left: 15px; margin-bottom: 25px;">

	<strong>�� ������� �����.</strong><br />

	����������, ��������� ������������ ��������� <b>������</b> � <b>������</b>.

	<ul>

		<li>��������, ������ ������� CAPS-LOCK?</li>

		<li>����� ����, � ��� �������� ������������ <b>���������</b>? (������� ��� ����������)</li>

		<li>���������� ������� ���� ������ � ��������� ��������� � <b>�����������</b> � ����� ��������</li>

	</ul>

	���� �� �� ����������� ���������, �� ����� �� ����� �� �������, �� ������ <b><a href="/reminder/">������ ����</a></b>.</div>';

} else {

	print '<center><p class="warn">������� ��� ����� � ������ � ������ �����!</p></center>';

}

?>


<table align="left" border=0>
<form action="?action=send" method=post>
	<tr>
		<td><strong>Login</strong>: </td>
	</tr>
	<tr>
		<td><input style="width: 243px;" type="text" name="ulogin" size="30" maxlength="30" /></td>
	</tr>
	<tr>
		<td><strong>E-mail</strong>: </td>
	</tr>
	<tr>
		<td><input style="width: 243px;" type="text" name="email" size="45" maxlength="30" /></td>
	</tr>
	<tr>
		<td>
			<table align="center" cellpadding="0" cellspacing="1" border="0">
				<tr>

					<td><br></td></tr><tr>
					<td align="center"><input  class="subm"style="width: 245px; "  type="submit" value=" Supmit " /></td>
				</tr>
			</table>
		</td>
	</tr>
</form>
</table>