<?php
include "../cfg.php";include "../ini.php";$cusers		= mysql_num_rows(mysql_query("SELECT id FROM users")) + cfgSET('fakeusers');$cwm		= mysql_num_rows(mysql_query("SELECT id FROM users WHERE pm_balance != 0 OR lr_balance != 0")) + cfgSET('fakeactiveusers');$money	= cfgSET('fakewithdraws');$query	= "SELECT sum FROM output WHERE status = 2";$result	= mysql_query($query);while($row = mysql_fetch_array($result)) {	$money = $money + $row['sum'];}$depmoney	= cfgSET('fakedeposits');$query	= "SELECT sum FROM deposits WHERE status = 0";$result	= mysql_query($query);while($row = mysql_fetch_array($result)) {	$depmoney = $depmoney + $row['sum'];}

// ������ ������� ����� ---------------------------------------------------------------------------
mysql_query("TRUNCATE TABLE `captcha`");$dategraph = "\'".date("d-m-y H:i:s", time())."\'";$graph1 = mysql_query('SELECT * FROM graph ORDER BY date DESC LIMIT 1');$graph = mysql_fetch_array($graph1);$graphres = '{ y: '.$dategraph.', a: '.sprintf("%01.2f", $depmoney).', b: '.sprintf("%01.2f", $money).', c: '.$cusers.' },';mysql_query("INSERT INTO `graph` (`date`, `graphres`) VALUES ('".time()."', '".$graphres."')");
?>