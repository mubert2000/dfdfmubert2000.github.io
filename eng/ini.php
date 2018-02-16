<?php
/**
 *
 * @ IonCube v8 Decoder By DoraemonPT
 *
 * @ Version  : 1,0,0,3
 * @ Author   : DoraemonPT
 * @ Release on : 15-10-2013
 * @ Website  : http://easytoyou.eu
 *
 **/

function cfgSET($cieiddedfb) {
	$dhebhcfeae = mysql_fetch_array( mysql_query( 'SELECT * FROM `settings` WHERE cfgname = \'' . $cieiddedfb . '\' LIMIT 1' ) );
	
	return $dhebhcfeae['data'];
}

function as_html($cjcfggidhc) {
	$cjcfggidhc = htmlspecialchars( $cjcfggidhc, ENT_QUOTES, '' );
	
	return $cjcfggidhc;
}

function getip() {
	if (getenv( 'HTTP_CLIENT_IP' )) {
		$cfgdicbjdd = getenv( 'HTTP_CLIENT_IP' );
		
	}
	else {
		if (getenv( 'HTTP_X_FORWARDED_FOR' )) {
			$cfgdicbjdd = getenv( 'HTTP_X_FORWARDED_FOR' );
			
		}
		else {
			$cfgdicbjdd = getenv( 'REMOTE_ADDR' );
			
		}
	}

	$cfgdicbjdd = htmlspecialchars( substr( $cfgdicbjdd, 0, 15 ), ENT_QUOTES, '' );
	
	return $cfgdicbjdd;
}

function as_md5($dcidgfffj, $chbjifbfgj) {
	$chbjifbfgj = md5( $dcidgfffj . md5( 'Z&' . $dcidgfffj . 'x_V' . htmlspecialchars( $chbjifbfgj, ENT_QUOTES, '' ) ) );
	
	return $chbjifbfgj;
}




if (!( defined( 'ACCESS' ))) {
	exit(  );
	(bool)true;
}

session_start(  );
$login = $_SESSION['user'];

$sid = htmlspecialchars( substr( session_id(  ), 0, 32 ), ENT_QUOTES, '' );

$key2 = 'Z201OlC1985';

$adminmail = cfgSET( 'adminmail' );


$cfgPerfect = cfgSET( 'cfgPerfect' );

$cfgPAYEE_NAME = cfgSET( 'cfgPAYEE_NAME' );

$ALTERNATE_HASH = cfgSET( 'ALTERNATE_PHRASE_HASH' );

$cfgAutoPay = cfgSET( 'cfgAutoPay' );

$cfgPMID = cfgSET( 'cfgPMID' );

$cfgPMpass = cfgSET( 'cfgPMpass' );

$cfgMinOut = cfgSET( 'cfgMinOut' );

$cfgPercentOut = cfgSET( 'cfgPercentOut' );

$ref = htmlspecialchars( $_GET['ref'], ENT_QUOTES, '' );

if ($ref) {
	setcookie( 'referal', $ref, time(  ) + 2592000, '/' );
}


$referal = htmlspecialchars( $_COOKIE['referal'], ENT_QUOTES, '' );

if (mysql_num_rows( mysql_query( 'SELECT * FROM `blacklist_ip` WHERE ip = \'' . getip(  ) . '\' LIMIT 1' ) )) {
	include( 'includes/errors/banip.php' );
	exit(  );
}


if (( $_GET['lang'] == 'ru' || $_GET['lang'] == 'en' )) {
	setcookie( 'lng', htmlspecialchars( $_GET['lang'], ENT_QUOTES, '' ), time(  ) + 2592000, '/' );
	
	$lng = htmlspecialchars( $_GET['lang'], ENT_QUOTES, '' );
}
else {
	if (( $_COOKIE['lng'] == 'ru' || $_COOKIE['lng'] == 'en' )) {
		
		$lng = htmlspecialchars( $_COOKIE['lng'], ENT_QUOTES, '' );
	}
	else {
		$get_lang = mysql_fetch_array( mysql_query( 'SELECT `data` FROM `settings` WHERE id = 13 LIMIT 1' ) );
		
		
		$lng = $get_lang['data'];
	}
}


if (!$login) {
	if ($_COOKIE['adminstation1']) {
		$get_user = mysql_query( 'SELECT login, pass, mail FROM users WHERE id = ' . intval( $_COOKIE['adminstation1'] ) . ' LIMIT 1' );
		
		$row = mysql_fetch_array( $get_user );
		
		
		$login = $row['login'];
		
		$pass = $row['pass'];
		
		$mail = $row['mail'];
		
		$user_pass = as_md5( $key, $pass . $key . $login );

		if ($_COOKIE['adminstation2'] == $user_pass) {
			$_SESSION['user'] = $login;
		}
		else {
			$login = '';
		}
	}
}


if ($login) {
	$get_user_info = mysql_query( 'SELECT * FROM users WHERE login = \'' . $login . '\' LIMIT 1' );
	
	$row = mysql_fetch_array( $get_user_info );
	
	
	$user_id = $row['id'];
	
	$login = $row['login'];
	
	$user_pass = $row['pass'];
	
	$user_mail = $row['mail'];
	
	$status = $row['status'];
	
	$pmbalance = $row['pm_balance'];
	
	$upm = $row['pm'];
	
	$uref = $row['ref'];
	
	$balance = $pmbalance;
	mysql_query( 'UPDATE users SET go_time = ' . time(  ) . ', ip = \'' . getip(  ) . '\' WHERE id = ' . $user_id . ' LIMIT 1' );

	if ($status == 3) {
		include( 'includes/errors/banlogin.php' );
		exit(  );
	}
} else {
	$user_id = 0;
	$login = '';
	$user_pass = '';
	$user_mail = '';
}


if (!$idpg) {
	$idpg = 1;
}

if ($lng == 'ru') {
	$get_page_info = mysql_query( 'SELECT title, keywords, description, body, part FROM pages WHERE id = ' . intval( $idpg ) . ' LIMIT 1' );
	
	$row = mysql_fetch_array( $get_page_info );
	
	
	$title = $row['title'];
	
	$keywords = $row['keywords'];
	
	$description = $row['description'];
	
	$body = stripslashes( $row['body'] );
	
	$part_page = $row['part'];

	if (( $page == 'news' && $_GET['id'] )) {
		$get_news_info = mysql_query( 'SELECT subject, keywords, description, msg, date FROM news WHERE id = ' . intval( $_GET['id'] ) . ' LIMIT 1' );
		
		
		$row = mysql_fetch_array( $get_news_info );
		
		$title = $row['subject'];
		
		$keywords = $row['keywords'];
		
		$description = $row['description'];
		
		$news_text = $row['msg'];
		
		$news_date = $row['date'];
	}
}
else {
	$get_page_info = mysql_query( 'SELECT title_en, keywords_en, description_en, body_en, part FROM pages WHERE id = ' . intval( $idpg ) . ' LIMIT 1' );
	
	$row = mysql_fetch_array( $get_page_info );
	
	
	$title = $row['title_en'];
	
	$keywords = $row['keywords_en'];
	
	$description = $row['description_en'];
	
	$body = stripslashes( $row['body_en'] );
	
	$part_page = $row['part'];

	if (( $page == 'news' && $_GET['id'] )) {
		$get_news_info = mysql_query( 'SELECT subject_en, keywords_en, description_en, msg_en, date FROM news WHERE id = ' . intval( $_GET['id'] ) . ' LIMIT 1' );
		
		$row = mysql_fetch_array( $get_news_info );
		
		
		$title = $row['subject_en'];
		
		$keywords = $row['keywords_en'];
		
		$description = $row['description_en'];
		
		$news_text = $row['msg_en'];
		
		$news_date = $row['date'];
	}
}


$url = $_SERVER['SERVER_NAME'];

$url = str_replace( 'www.', '', $url );

$url = str_replace( 'http://', '', $url );

$url = str_replace( 'https://', '', $url );



if (( cfgSET( 'autopercent' ) == 'on' && cfgSET( 'datestart' ) < time(  ) )) {
	$result = mysql_query( 'SELECT * FROM `deposits` WHERE nextdate <= ' . time(  ) );
	
	

	if ($row = mysql_fetch_array( $result )) {
		
		$result2 = mysql_query( 'SELECT * FROM plans WHERE id = ' . $row['plan'] . ' LIMIT 1' );
		
		$row2 = mysql_fetch_array( $result2 );

		if ($row['reinvest']) {
			
			$p = sprintf( '%01.2f', $row['sum'] / 100 * $row2['percent'] );
			
			$re = sprintf( '%01.2f', $p / 100 * $row['reinvest'] );
			$p = $p - $re;
			mysql_query( 'UPDATE `deposits` SET sum = sum + ' . $re . ' WHERE id = ' . $row['id'] . ' LIMIT 1' );
		}
		else {
			
			$p = sprintf( '%01.2f', $row['sum'] / 100 * $row2['percent'] );
		}

		mysql_query( 'UPDATE users SET pm_balance = pm_balance + ' . $p . ' WHERE id = ' . $row['user_id'] . ' LIMIT 1' );
		mysql_query( 'INSERT INTO stat (user_id, date, plan, sum, paysys) VALUES (' . $row['user_id'] . ', ' . $row['nextdate'] . ', ' . $row['plan'] . ', ' . $p . ', ' . $row['paysys'] . ')' );

		if ($row2['days'] <= intval( $row['count'] + 1 )) {
			if ($row2['back'] == 1) {
				mysql_query( 'UPDATE users SET pm_balance = pm_balance + ' . $row['sum'] . ' WHERE id = ' . $row['user_id'] . ' LIMIT 1' );
				mysql_query( 'DELETE FROM deposits WHERE id = ' . $row['id'] . ' LIMIT 1' );
			}

			mysql_query( 'DELETE FROM deposits WHERE id = ' . $row['id'] . ' LIMIT 1' );
		}


		if (( date( 'w' ) == 5 && $row2['weekend'] == 1 )) {
			$plus = 173953;
		}
		else {
			$plus = 1153;
		}


		if ($row2['period'] == 1) {
			$nextdate = $row['nextdate'] + 86400 + $plus;
		} elseif ($row2['period'] == 2) {
				$nextdate = $row['nextdate'] + 604800 + $plus;
			} elseif ($row2['period'] == 3) {
					$nextdate = $row['nextdate'] + 2592000 + $plus;
				} elseif ($row2['period'] == 4) {
						$nextdate = $row['nextdate'] + 3600;
					}
				
			
		

		mysql_query( 'UPDATE deposits SET count = count + 1, lastdate = ' . $row['nextdate'] . ', nextdate = ' . $nextdate . ' WHERE id = ' . $row['id'] . ' LIMIT 1' );
	}
}

?>
