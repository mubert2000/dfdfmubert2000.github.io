<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 14.10.2007 г.

-> Файл авторизации пользователя
*/

include "../cfg.php";
include "../ini.php";

$login		 = htmlspecialchars(substr($_POST['login'],0,20), ENT_QUOTES, '');
$password	 = as_md5($key, $_POST['pass']);
$cookies	 = intval($_POST['cookies']);

if(!$login || !$password || $login == "Login") {
	$error = 1;
} else {
	$get_pass = mysql_query("SELECT `id`, `login`, `pass` FROM `users` WHERE login = '".$login."' LIMIT 1");
	$row = mysql_fetch_array($get_pass);
		$id		= $row['id'];
		$login		= $row['login'];
		$user_password	= $row['pass'];

	if($user_password != $password) {
		$error = 2;
	} else {

		$_SESSION['user'] = $login;

		if($cookies) {
			$hash = as_md5($key, $user_password.$key.$login);
			setcookie("adminstation1", $id, time() + 604800, "/");
			setcookie("adminstation2", $hash, time() + 604800, "/");
		}

		$ip		= getip();
		$time	= time();

		mysql_query("UPDATE users SET 	ip = '".$ip."', go_time = ".$time." WHERE login = '".$login."' LIMIT 1");
		mysql_query("INSERT INTO logip (user_id, ip, date) VALUES (".$id.", '".$ip."', ".$time.")");

	}
}

if(!$error) {
	print "<html><head><script language=\"javascript\">top.location.href='adminstation.php';</script></head><body><a href=\"adminstation.php\"><b>Enter</b></a></body></html>";
} else {
	print "<html><head><script language=\"javascript\">top.location.href='index.php?error=".$error."';</script></head></html>";
}
?>