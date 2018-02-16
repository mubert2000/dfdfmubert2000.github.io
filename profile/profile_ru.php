<?php
defined('ACCESS') or die();
if ($login) {
	if ($_GET['action'] == 'save') {
		$get_user_info = mysql_query("SELECT pe FROM users WHERE id = ".$user_id." LIMIT 1");
		$row = mysql_fetch_array($get_user_info);
		 $upe		= $row['pe'];

		$pass_1 = $_POST['pass_1'];
		$pass_2 = $_POST['pass_2'];
		$email	= addslashes(htmlspecialchars($_POST['email'], ENT_QUOTES, ''));
		$icq	= addslashes(htmlspecialchars($_POST['icq'], ENT_QUOTES, ''));
		$pm		= addslashes(htmlspecialchars($_POST['pm'], ENT_QUOTES, ''));
		$pe		= addslashes(htmlspecialchars($_POST['pe'], ENT_QUOTES, ''));
		$skype	= addslashes(htmlspecialchars($_POST['skype'], ENT_QUOTES, ''));

		if($upm) { $pm = $upm; } 
		if($upe) { $pe = $upe; } 

		if (!$email) {
			echo '<p class="er">Следует ввести E-mail!</p>';
		} else {
			if ($pass_1 != $pass_2) {
				echo '<p class="er">Пароль и подтверждение не совпадают!</p>';
			} else {
				if (!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is", $email)) {
					print '<p class="er">Введите правильно e-mail!</p>';
				} elseif (strlen($pm) != 8 && $pm) {
					print '<p class="er">Введите корректный PM кошелёк!</p>';
				} elseif ($pm[0] != 'U' && $pm) {
					print '<p class="er">Введите корректный PM кошелёк!</p>';
				} elseif(mysql_num_rows(mysql_query("SELECT pm FROM users WHERE pm = '".$pm."' AND id != ".$user_id)) && $pm) {
					print "<p class=\"er\">Такой PM уже есть в базе!</p>";
				} elseif(mysql_num_rows(mysql_query("SELECT mail FROM users WHERE mail = '".$email."' AND id != ".$user_id))) {
					print "<p class=\"er\">Такой e-mail уже есть в базе!</p>";
				} else {
					$sql = 'UPDATE users SET ';
					if($pass_1) { $sql .= 'pass = "'.as_md5($key, $pass_1).'", '; }

					$sql .= 'mail = "'.$email.'", icq = "'.$icq.'", pm = "'.$pm.'", pe = "'.$pe.'", skype = "'.$skype.'" WHERE id = '.$user_id.' LIMIT 1';
					if (mysql_query($sql)) {
						print '<p class="erok">Данные были успешно обновлены!</p>';
					} else {
						print '<p class="er">Не удаётся изменить данные!</p>';
					}
			}
		}
	}
}

$sql	= 'SELECT * FROM users WHERE login = "'.$login.'" LIMIT 1';
$rs		= mysql_query($sql);
$a		= mysql_fetch_array($rs);
?>
<form action="?action=save" method="post">
<table align="left" width="100%" border="0" cellpadding="2" cellspacing="1">
	<tr>
		<td style="padding-right: 10px"; align="right" width="20%" >Пароль: </td>
		<td align="left" width="20%"><input type='password' name='pass_1' size="30" /></td>
	</tr>
	<tr>
		<td style="padding-right: 10px"; align="right" width="20%" >Подтверждение: </td>
		<td align="left" width="20%"><input type='password' name='pass_2' size="30" /></td>
	</tr>
	<tr>
		<td style="padding-right: 10px"; align="right" width="20%" ><font color="red"><b>!</b></font> E-mail:</td>
		<td align="left" width="20%"><input type='text' name='email' value='<?php print $a['mail']; ?>' size="30" maxlength="30" /></td>
	</tr>
	<tr>
		<td style="padding-right: 10px"; align="right" width="20%" >Skype:</td>
		<td align="left" width="20%"><input type='text' name='skype' value='<?php print $a['skype']; ?>' size="30" maxlength="50" /></td>
	</tr>
	<tr>
		<td style="padding-right: 10px"; align="right" width="20%" >ICQ UIN:</td>
		<td align="left" width="20%"><input type='text' name='icq' value='<?php print $a['icq']; ?>' size="30" maxlength="20" /></td>
	</tr>
<?php
if($cfgPerfect) {	
?>
	<tr>
		<td style="padding-right: 10px"; align="right" width="20%" >PerfectMoney: </td>
		<td align="left" width="20%"><input type='text' name='pm' value='<?php print $a['pm']; ?>' size="30" maxlength="8" <?php if($a['pm']) { print 'disabled'; } ?> /></td>
	</tr>
<?php
}
if(cfgSET('cfgPEsid') && cfgSET('cfgPEkey')) {	
?>
	<tr>
		<td style="padding-right: 10px"; align="right" width="20%" >PAYEER.com</td><td align="left" width="20%"><input type="text" name="pe" value="<?php print $a['pe']; ?>" size="30" maxlength="50" <?php if($a['pe']) { print 'disabled'; } ?>  /></td>
	</tr>
<?php
}
?>
</table>
<div align="left" style="padding-top: 10px;"><input class="subm" type="submit" name="submit" value=" Сохранить " /></div>
</form>
<?php
} else {
	print "<p class=\"er\">Вы должны авторизироваться для доступа к этой странице!</p>";
}
?>