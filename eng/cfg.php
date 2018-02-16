<?php

/*

Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.

Любое использование данного скрипта, разрешено только с письменного согласия автора.

Скрипт защищён законом: http://adminstation.ru/images/docs/doc1.jpg

Дата разработки: 14.10.2007 г.

#

# Контакты: ICQ: 451699555; E-mail: rem-x@i.ua; URL: www.adminstation.ru

#

-> Конфигурационный файл программы AdminStation

*/



Error_Reporting(0);



	$hostname				= "localhost";					// Хост

	$mysql_login			= "veritasdonum1_a";						// Логин к БД

	$mysql_password			= "Defender1974";							// Пароль к БД

	$database				= "veritasdonum1_a";						// База данных

	$num					= 10;							// Кол-во выводов на страницу

	$cfgURL					= "veritas-donum.com";						// URL ресурса

	$chmod					= "755";						// Права папкам на запись



// Данные лицензии. Следующие переменные после установки скрипта НЕ МЕНЯТЬ!



  $licID				= 743;										// ID лицензионной копии

  $key					= "0W40-0N6E-W0HT-7863";					// Лицензионный ключ

  $mdhash				= "434dc8a33d7f9c85eb44fdf778619802";		// MD5 hash



// Соединение с БД

if (!($conn = mysql_connect($hostname, $mysql_login , $mysql_password))) {

	include "includes/errors/db.php";

	exit();

} else {

	if (!(mysql_select_db($database, $conn))) {

		include "includes/errors/db.php";

		exit();

	}

}

// Конец соединения с БД

mysql_query("SET NAMES 'cp1251'");



set_magic_quotes_runtime(0);

@set_time_limit(0);

@ini_set('max_execution_time',0);

@ini_set('output_buffering',0);

$safe_mode = @ini_get('safe_mode');

$version = "1.24";



if(version_compare(phpversion(), '4.1.0') == -1) {

 $_POST   = &$HTTP_POST_VARS;

 $_GET    = &$HTTP_GET_VARS;

 $_SERVER = &$HTTP_SERVER_VARS;

}



if (@get_magic_quotes_gpc()) {

	foreach ($_POST as $k=>$v) {

		$_POST[$k] = stripslashes($v);

	}

	foreach ($_SERVER as $k=>$v) {

		$_SERVER[$k] = stripslashes($v);

	}

}



define('ACCESS', true);

?>