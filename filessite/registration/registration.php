<?php
print $body;
defined('ACCESS') or die();
if($_GET['action'] == "save") {
		$ulogin	= htmlspecialchars($_POST['ulogin'], ENT_QUOTES, '');
		$pass	= $_POST['pass'];
		$repass	= $_POST['repass'];
		$email	= htmlspecialchars($_POST['email'], ENT_QUOTES, '');
		$code	= htmlspecialchars($_POST["code"], ENT_QUOTES, '');
		$skype	= htmlspecialchars($_POST["skype"], ENT_QUOTES, '');
		$pm		= htmlspecialchars($_POST["pm"], ENT_QUOTES, '');
		$pe		= htmlspecialchars($_POST["pe"], ENT_QUOTES, '');
		$yes	= intval($_POST['yes']);

		if(!$ulogin || !$pass || !$repass || !$email || !$yes) {
			$error = "<p class=\"er\">Fill out all required fields</p>";
		} elseif(strlen($ulogin) > 20 || strlen($ulogin) < 3) {
			$error = "<p class=\"er\">Username must be between 3 and 20 characters</p>";
		} elseif($pass != $repass) {
			$error = "<p class=\"er\">Passwords do not match</p>";
		} elseif(strlen($email) > 30) {
			$error = "<p class=\"er\">E-mail should contain up to 30 characters</p>";
		} elseif(!mysql_num_rows(mysql_query("SELECT * FROM captcha WHERE sid = '".$sid."' AND ip = '".getip()."' AND code = '".$code."'"))) {
			$error = "<p class=\"er\">The code entered from the picture does not match!</p>";
		} elseif(!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is", $email)) {
			$error = "<p class=\"er\">Enter validate e-mail</p>";
		} elseif(mysql_num_rows(mysql_query("SELECT login FROM users WHERE login = '".$ulogin."'"))) {
			$error = "<p class=\"er\">This username is already in the database! Please select a different</p>";
		} elseif(mysql_num_rows(mysql_query("SELECT mail FROM users WHERE mail = '".$email."'"))) {
			$error = "<p class=\"er\">This e-mail is already in the database!</p>";
		} else {
			$time	 = time();
			$ip		 = getip();
			$pass	 = as_md5($key, $pass);

			if($referal) { 
				$get_user_info	= mysql_query("SELECT * FROM users WHERE login = '".$referal."' LIMIT 1");
				$row			= mysql_fetch_array($get_user_info);
				$ref_id			= intval($row['id']);
			} else { 
				$ref_id = 0; 
			}

			if(cfgSET('cfgMailConf') == "on") {
				$active		= 1;
				$actlink	= "You activate link: http://".$cfgURL."/activate.php?m=".$email."&h=".as_md5($key, $ulogin.$email);
			} else {
				$active		= 0;
				$actlink	= "";
			}
			$sql = "INSERT INTO users (login, pass, mail, go_time, ip, reg_time, ref, pm, active, skype, pe) VALUES ('".$ulogin."', '".$pass."', '".$email."', ".$time.", '".$ip."', ".$time.", ".$ref_id.", '".$pm."', ".$active.", '".$skype."', '".$pe."')";
			mysql_query($sql);

			$subject = "Congratulations on your successful registration";

			$headers = "From: ".$adminmail."\n";
			$headers .= "Reply-to: ".$adminmail."\n";
			$headers .= "X-Sender: < http://".$cfgURL." >\n";
			$headers .= "Content-Type: text/html; charset=windows-1251\n";

			$text = "Hello <b>".$ulogin."!</b><br />Congratulations on your successful registration to the service <a href=\"http://".$cfgURL."/\" target=\"_blank\">http://".$cfgURL."</a><br />Your Login: <b>".$ulogin."</b><br />Your password: <b>".$repass."</b><br />".$actlink."<br /><br />Sincerely, the administration of the project ".$cfgURL;

			mail($email, $subject, $text, $headers);

			$ulogin	= "";
			$pass	= "";
			$repass	= "";
			$email	= "";
			$skype	= "";
			$pm		= "";
			$pe		= "";

			$error = 1;
		}
}

if($error == 1) {

	print "<p class=\"erok\">Congratulations! You registered. Please Sign In.</p>";
	include "../login/login.php";

} else {
	print $error;
?>
<center>
<form action="?action=save" method="post">
<table align="left" width="400" border="0" cellpadding="3" cellspacing="1">
	<tr>
		<td><font color="red"><b>!</b></font> Username:</td>
		<td align="center"><input style="width: 200px;" type="text" name="ulogin" value="<?php print $ulogin; ?>" size="30" maxlength="30" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font> Password:</td><td align="center"><input style="width: 200px;" type="password" name="pass" size="30" maxlength="20" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font> Confirm password:</td><td align="center"><input style="width: 200px;" type="password" name="repass" size="30" maxlength="20" /></td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font> E-mail:</td><td align="center"><input style="width: 200px;" type="text" name="email" value="<?php print $email; ?>" size="30" maxlength="30" /></td>
	</tr>
	<tr>
		<td>Skype:</td>
		<td align="center"><input style="width: 200px;" type="text" name="skype" value="<?php print $skype; ?>" size="30" maxlength="50" /></td>
	</tr>
<?php
if($cfgPerfect) {	
?>
	<tr>
		<td>PerfectMoney: </td><td align="center"><input style="width: 200px;" type="text" name="pm" value="<?php print $pm; ?>" size="30" maxlength="10" /></td>
	</tr>
<?php
}
if(cfgSET('cfgPEsid') && cfgSET('cfgPEkey')) {	
?>
	<tr>
		<td>PAYEER.com</td><td align="center"><input style="width: 200px;" type="text" name="pe" value="<?php print $pe; ?>" size="30" maxlength="50" /></td>
	</tr>
<?php
}
?>
	<tr>
		<td align="right"><a href="javascript:void(0);" onclick="this.parentNode.getElementsByTagName('img')[0].src = '/captcha.php?'+Math.random(); return false;"><img src="/captcha.php" width="70" height="25" border="0" alt="Captcha" title="Enter the code shown in the picture" /></a></td><td align="center"><input style="width: 200px; height: 25px; font-size: 16px; font-weight: bold;" type="text" name="code" size="17" maxlength="5" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><font color="red"><b>!</b></font> <label><input class="check" type="checkbox" name="yes" value="1" /> <b>I agree with <a href="/law/" target="_blank">the rules</a> of the system.</b></label></td>
	</tr>
</table>
</center>
<div align="center" style="padding-top: 10px; padding-bottom: 15px;"><input class="subm" type="submit" name="submit" value=" Register " /></div>
</form>
<?php

	if($referal) {
		print '<center>Your Upline: '.$referal.'</center>';
	}

} 
?>