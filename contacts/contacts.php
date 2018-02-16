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
		$code		= htmlspecialchars(str_replace("'","",substr($_POST['code'],0,5)), ENT_QUOTES, '');

		    if(!$name) {
				print "<p class=\"er\">Please enter your name!</p>";
		}
		elseif(!$mail) {
				print "<p class=\"er\">Please enter your e-mail!</p>";
		}
		elseif(!$subj) {
				print "<p class=\"er\">Please enter the subject of your message!</p>";
		}
		elseif(!$textform) {
				print "<p class=\"er\">Please enter your message!</p>";
		}
		elseif(!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is",$mail)) {
				print "<p class=\"er\">Please enter your e-mail validly!</p>";
		} elseif(!mysql_num_rows(mysql_query("SELECT * FROM captcha WHERE sid = '".$sid."' AND ip = '".getip()."' AND code = '".$code."'"))) {
			print "<p class=\"er\">Not entered the correct code!</b></font></center></p>";
		} else {

			$headers = "From: ".$mail."\n";
			$headers .= "Reply-to: ".$mail."\n";
			$headers .= "X-Sender: < http://".$cfgURL." >\n";
			$headers .= "Content-Type: text/html; charset=windows-1251\n";

			$textform = $textform;

			$send = mail($adminmail,$subj,$textform,$headers);

			if(!$send) {
				print "<p class=\"er\">Error mail server! Sorry for any inconvenience.</p>";
			} else {

				print "<p class=\"erok\">Your message is sent!</p>";

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
<table width="400" align="center" cellpadding="1" cellspacing="1" border="0" style="margin-top: 15px;">
	<tr>
		<td><font color="red"><b>!</b></font> Your name:</td>
	</tr>
	<tr>
		<td><input style="width: 400px;" type="text" name="name" size="50" maxlength="50" value="<?php if(!$name) { print $login; } else { print $name; } ?>" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font> Your e-mail:</td>
	</tr>
	<tr>
		<td><input style="width: 400px;" type="text" name="mail" size="50" maxlength="50" value="<?php if(!$mail) { print $user_mail; } else { print $mail; } ?>" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font> Subject:</td>
	</tr>
	<tr>
		<td><input style="width: 400px;" type="text" name="subj" size="50" maxlength="100" value="<?php print $subj; ?>" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font> Message:</td>
	</tr>
	<tr>
		<td><textarea style="width: 400px; margin-left: 0px;" name="textform" cols="40" rows="8"><?php print $textform; ?></textarea></td>
	</tr>
	<tr>
		<td>
			<table align="right" cellpadding="1" cellspacing="1" border="0">
				<tr>
					<td><a href="javascript:void(0);" onclick="this.parentNode.getElementsByTagName('img')[0].src = '/captcha.php?'+Math.random(); return false;"><img src="/captcha.php" width="70" height="25" border="0" alt="Captcha" title="Enter the code shown in the picture" /></a></td>
					<td><input style="width: 111px; height: 25px; font-size: 16px; font-weight: bold;" type="text" name="code" size="17" maxlength="5" /></td>
					<td><input class="subm" style="height: 25px;"  type="submit" value=" Send! " /></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</center>
</form>