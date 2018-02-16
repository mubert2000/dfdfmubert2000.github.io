<?php

if($er) {

	print '<div class="er" style="text-align: left; padding-left: 15px; margin-bottom: 25px;">

	<strong>Не удается войти.</strong><br />

	Пожалуйста, проверьте правильность написания <b>логина</b> и <b>пароля</b>.

	<ul>

		<li>Возможно, нажата клавиша CAPS-LOCK?</li>

		<li>Может быть, у вас включена неправильная <b>раскладка</b>? (русская или английская)</li>

		<li>Попробуйте набрать свой пароль в текстовом редакторе и <b>скопировать</b> в графу «Пароль»</li>

	</ul>

	Если вы всё внимательно проверили, но войти всё равно не удается, вы можете <b><a href="/reminder/">нажать сюда</a></b>.</div>';

} else {

	print '<center><p class="warn">Введите ваш логин и пароль в данной форме!</p></center>';

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