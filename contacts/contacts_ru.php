<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Дата разработки: 12.10.2007 г.

-> Файл обработчика формы и последующей отсылки данных на e-mail (контактная форма)
*/
defined('ACCESS') or die();
print $body;
$action = htmlspecialchars(str_replace("'","",substr($_GET['action'],0,6)));

	if($action == "submit") {
		$name		= htmlspecialchars(str_replace("'","",substr($_POST['name'],0,50)), ENT_QUOTES, '');
		$mail		= htmlspecialchars(str_replace("'","",substr($_POST['mail'],0,50)), ENT_QUOTES, '');
		$subj		= htmlspecialchars(str_replace("'","",substr($_POST['subj'],0,100)), ENT_QUOTES, '');
		$textform	= htmlspecialchars(str_replace("'","",substr($_POST['textform'],0,10240)), ENT_QUOTES, '');


		    if(!$name) {
				print "<p class=\"er\">Введите пожалуйста Ваше имя!</p>";
		}
		elseif(!$mail) {
				print "<p class=\"er\">Введите пожалуйста Ваш e-mail!</p>";
		}
		elseif(!$subj) {
				print "<p class=\"er\">Введите пожалуйста тему Вашего сообщения!</p>";
		}
		elseif(!$textform) {
				print "<p class=\"er\">Введите пожалуйста текст Вашего сообщения!</p>";
		}
		elseif(!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is",$mail)) {
				print "<p class=\"er\">Введите пожалуйста Ваш e-mail валидно!</p>";

		} else {

			$headers = "From: ".$mail."\n";
			$headers .= "Reply-to: ".$mail."\n";
			$headers .= "X-Sender: < http://".$cfgURL." >\n";
			$headers .= "Content-Type: text/html; charset=windows-1251\n";

			$textform = "Здравствуйте, ".$name."!<br />Вы писали нам, указав e-mail: ".$mail.", как контактный следующее:<p> >".$textform."</p>";

			$send = mail($adminmail,$subj,$textform,$headers);

			if(!$send) {
				print "<p class=\"er\">Ошибка почтового сервера!<br />Приносим извинения за предоставленные неудобства.</p>";
			} else {

				print "<p class=\"erok\">Ваше сообщение отправлено!</p>";

				$name		= "";
				$mail		= "";
				$subj		= "";
				$textform	= "";
			}
		}
	}
?>
<form action="?action=submit" method="post">
<center>
<table width="400" align="left" cellpadding="1" cellspacing="1" border="0" style="margin-top: 15px;">
	<tr>
		<td>Ваше логин:</td>
	</tr>
	<tr>
		<td><input style="width: 400px;" type="text" name="name" size="50" maxlength="50" value="<?php if(!$name) { print $login; } else { print $name; } ?>" /></td>
	</tr>
	<tr>
		<td> Ваш e-mail:</td>
	</tr>
	<tr>
		<td><input style="width: 400px;" type="text" name="mail" size="50" maxlength="50" value="<?php if(!$mail) { print $user_mail; } else { print $mail; } ?>" /></td>
	</tr>
	<tr>
		<td> Тема сообщения:</td>
	</tr>
	<tr>
		<td><input style="width: 400px;" type="text" name="subj" size="50" maxlength="100" value="<?php print $subj; ?>" /></td>
	</tr>
	<tr>
		<td> Текст сообщения:</td>
	</tr>
	<tr>
		<td><textarea style="width: 400px; margin-left: 0px;" name="textform" cols="40" rows="8"><?php print $textform; ?></textarea></td>
	</tr>
	<tr>
		<td>
			<table align="right" cellpadding="1" cellspacing="1" border="0">
				<tr>

					<td><input class="subm" "  type="submit" value=" Отправить! " /></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</center>
</form>