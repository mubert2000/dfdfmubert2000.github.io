<?php
if($er) {
	print '<div class="er" style="text-align: left; padding-left: 15px; margin-bottom: 25px;">
	<strong>Unable to enter. </strong> <br /> 
	Please check your spelling <b> login </b> and <b> password </b>. 
	<ul> 
	<li> Perhaps pressed CAPS-LOCK? </li> 
	<li> Maybe you have enabled the wrong <b> layout </b>? (Russian or English) </li> 
	<li> Try typing your password in a text editor and copy in the column "Password"</li> 
	</ul> 
	If you are carefully checked, but still log fails, you can <b> <a href="/reminder/"> click here </a> </b>.</div>';
} else {
	print '<p class="warn">Enter your username and password in this form!</p>';
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