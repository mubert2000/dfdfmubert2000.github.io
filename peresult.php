<?php
include "cfg.php";
include "ini.php";

$cid	= cfgSET('cfgPEsid');
$m_key	= cfgSET('cfgPEkey');

if(isset($_POST["m_operation_id"]) && isset($_POST["m_sign"])) {

	$arHash = array($_POST['m_operation_id'],
			$_POST['m_operation_ps'],
			$_POST['m_operation_date'],
			$_POST['m_operation_pay_date'],
			$_POST['m_shop'],
			$_POST['m_orderid'],
			$_POST['m_amount'],
			$_POST['m_curr'],
			$_POST['m_desc'],
			$_POST['m_status'],
			$m_key);

	$sign_hash = strtoupper(hash('sha256', implode(":", $arHash)));

	if($_POST["m_sign"] == $sign_hash && $_POST['m_status'] == "success" && $_POST['m_orderid'] && $_POST['m_desc']) {

			$get_info	= mysql_query("SELECT * FROM enter WHERE id = ".intval($_POST['m_orderid'])." AND status != 2 LIMIT 1");
			$row		= mysql_fetch_array($get_info);

			$date = date("d.m.Y");

			if($row['sum']) {
				mysql_query('UPDATE users SET pm_balance = pm_balance + '.$row['sum'].' WHERE login = "'.$row['login'].'" LIMIT 1');
				mysql_query("UPDATE enter SET status = 2, purse = 'PAYEER' WHERE id = ".intval($_POST['m_orderid'])." LIMIT 1");
			}

		echo $_POST['m_orderid']."|success";
		exit();

	} else {
		echo $_POST['m_orderid']."|error";
	}
}
?>