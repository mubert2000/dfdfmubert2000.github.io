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
			echo '<p class="er">You must enter the E-mail!</p>';
		} else {
			if ($pass_1 != $pass_2) {
				echo '<p class="er">Password and confirm password do not match!</p>';
			} else {
				if (!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is", $email)) {
					print '<p class="er">Enter a valid e-mail!</p>';
				} elseif (strlen($pm) != 8 && $pm) {
					print '<p class="er">Please enter a valid PM account!</p>';
				} elseif ($pm[0] != 'U' && $pm) {
					print '<p class="er">Please enter a valid PM account!</p>';
				} elseif(mysql_num_rows(mysql_query("SELECT pm FROM users WHERE pm = '".$pm."' AND id != ".$user_id)) && $pm) {
					print "<p class=\"er\">This PM is already in the database!</p>";
				} elseif(mysql_num_rows(mysql_query("SELECT mail FROM users WHERE mail = '".$email."' AND id != ".$user_id))) {
					print "<p class=\"er\">This e-mail is already in the database!</p>";
				} else {
					$sql = 'UPDATE users SET ';
					if($pass_1) { $sql .= 'pass = "'.as_md5($key, $pass_1).'", '; }

					$sql .= 'mail = "'.$email.'", icq = "'.$icq.'", pm = "'.$pm.'", pe = "'.$pe.'", skype = "'.$skype.'" WHERE id = '.$user_id.' LIMIT 1';
					if (mysql_query($sql)) {
						print '<p class="erok">The data has been successfully updated!</p>';
					} else {
						print '<p class="er">I can not change the data!</p>';
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
<table align="left" width="350" border="0" cellpadding="2" cellspacing="1">
	<tr>
		<td>Password: </td>
		<td align="right"><input type='password' name='pass_1' size="30" /></td>
	</tr>
	<tr>
		<td>Confirm password: </td>
		<td align="right"><input type='password' name='pass_2' size="30" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font> E-mail:</td>
		<td align="right"><input type='text' name='email' value='<?php print $a['mail']; ?>' size="30" maxlength="30" /></td>
	</tr>
	<tr>
		<td>Skype:</td>
		<td align="right"><input type='text' name='skype' value='<?php print $a['skype']; ?>' size="30" maxlength="50" /></td>
	</tr>
	<tr>
		<td>ICQ UIN:</td>
		<td align="right"><input type='text' name='icq' value='<?php print $a['icq']; ?>' size="30" maxlength="20" /></td>
	</tr>
<?php
if($cfgPerfect) {	
?>
	<tr>
		<td>PerfectMoney: </td>
		<td align="right"><input type='text' name='pm' value='<?php print $a['pm']; ?>' size="30" maxlength="8" <?php if($a['pm']) { print 'disabled'; } ?> /></td>
	</tr>
<?php
}
if(cfgSET('cfgPEsid') && cfgSET('cfgPEkey')) {	
?>
	<tr>
		<td>PAYEER.com</td><td align="right"><input type="text" name="pe" value="<?php print $a['pe']; ?>" size="30" maxlength="50" <?php if($a['pe']) { print 'disabled'; } ?>  /></td>
	</tr>
<?php
}
?>
</table>
<div align="center" style="padding-top: 10px;"><input class="subm" type="submit" name="submit" value=" Save " /></div>
</form>
<?php
} else {
	print "<p class=\"er\">You must login to access this page!</p>";
}
?>