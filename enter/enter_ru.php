<?php
defined('ACCESS') or die();
if ($login) {

	if($_GET['pay'] == "no") {
		print '<p class="er">Не удалось пополнить баланс</p>';
	}

	if($_GET['conf']) {

		print '<p class="erok">Ваша заявка отправлена администраторам на проверку</p>';

		$conf		= intval($_GET['conf']);
		$purse		= addslashes(htmlspecialchars($_POST["purse"], ENT_QUOTES, ''));

		mysql_query("UPDATE enter SET status = 1, purse = '".$purse."' WHERE id = ".$conf." LIMIT 1");

	} elseif ($_GET['action'] == 'save') {
		$sum	= sprintf ("%01.2f", str_replace(',', '.', $_POST['sum']));
		$ps		= intval($_POST['ps']);

		if ($sum <= 0) {
			print '<p class="er">Введите корректную сумму (от $1 до $10 000)!</p>';
		} elseif ($sum < 1 || $sum > 10000) {
			print '<p class="er">За один раз разрешено выводить от $1 до $10 000!</p>';
		} elseif($ps < 1) {
			print '<p class="er">Укажите платежную систему!</p>';
		} else {

				// Форма пополнения
					if($ps == 1) {

					// PM

					$sql = 'INSERT INTO enter (sum, date, login, paysys, service) VALUES ('.$sum.', '.time().', "'.$login.'", "PerfectMoney", "bal")';
					mysql_query($sql);
					$lid = mysql_insert_id();

					if(cfgSET('cfgSSL') == "on") {
						$http = "https";
					} else {
						$http = "http";
					}

					print '<FIELDSET style="padding-top: 15px; margin-bottom: 10px;">
					<LEGEND><b>Подтверждение платежа</b></LEGEND>
					<form action="https://perfectmoney.is/api/step1.asp" method="POST">
					<input type="hidden" name="PAYEE_ACCOUNT" value="'.$cfgPerfect.'">
					<input type="hidden" name="PAYEE_NAME" value="'.$cfgPAYEE_NAME.'">
					<input type="hidden" name="PAYMENT_ID" value="'.$lid.'">
					<input type="hidden" name="PAYMENT_AMOUNT" value="'.$sum.'">
					<input type="hidden" name="PAYMENT_UNITS" value="USD">
					<input type="hidden" name="STATUS_URL" value="'.$http.'://'.$cfgURL.'/pmresult.php">
					<input type="hidden" name="PAYMENT_URL" value="'.$http.'://'.$cfgURL.'/deposit/?pay=yes">
					<input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="NOPAYMENT_URL" value="'.$http.'://'.$cfgURL.'/enter/?pay=no">
					<input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="BAGGAGE_FIELDS" value="">
					<input type="hidden" name="SUGGESTED_MEMO" value="'.$cfgURL.'">
					<center>
					Вы переводите <strong>'.$sum.'</strong> USD на счёт <strong>'.$cfgPerfect.'</strong> PerfectMoney<br />Пополнение баланса в проекте '.$cfgURL.'<br />
					<p align="center"><input style="width: 205px; margin: 15px 0 0 0" class="subm" name="PAYMENT_METHOD" type="submit" value=" Пополнить баланс " /></p>
					</center>
					</form>
					</FIELDSET>';

					} else {


					$get_ps	= mysql_query("SELECT * FROM paysystems WHERE id = ".intval($ps)." LIMIT 1");
					$rowps	= mysql_fetch_array($get_ps);

					$sum2 = sprintf("%01.2f", $sum * $rowps['percent']);

					$sql = 'INSERT INTO enter (sum, date, login, paysys, service) VALUES ('.$sum.', '.time().', "'.$login.'", "'.$rowps['name'].'", "bal")';

						if(mysql_query($sql)) {

						$m_orderid = mysql_insert_id();

							if($rowps['name'] == "PAYEER.com") {

								$desc = base64_encode($cfgURL);

								$cu = 'USD';

								$cid	= cfgSET('cfgPEsid');
								$m_key	= cfgSET('cfgPEkey');

								$arHash = array(
									$cid,
									$m_orderid,
									$sum,
									$cu,
									$desc,
									$m_key
								);

								$sign = strtoupper(hash('sha256', implode(":", $arHash)));

								print '<FIELDSET style="padding-top: 15px; margin-bottom: 10px;">
								<LEGEND><b>Подтверждение платежа</b></LEGEND>
								<form method="GET" action="//payeer.com/api/merchant/m.php" accept-charset="utf-8">
								<input type="hidden" name="m_shop" value="'.$cid.'">
								<input type="hidden" name="m_orderid" value="'.$m_orderid.'">
								<input type="hidden" name="m_amount" value="'.$sum.'">
								<input type="hidden" name="m_curr" value="USD">
								<input type="hidden" name="m_desc" value="'.$desc.'">
								<input type="hidden" name="m_sign" value="'.$sign.'">

								<center>
								Вы переводите <strong>'.$sum.'</strong> USD<br />Пополнение баланса в проекте '.$cfgURL.'<br /><br />
								<p align="center"><input class="subm" type="submit" name="m_process" value="Пополнить баланс" /></p>
								</center>
								</form>
								</FIELDSET>';

							} else {

								print '<FIELDSET style="padding-top: 15px; margin-bottom: 10px;">
								<LEGEND><b>Подтверждение платежа</b></LEGEND>
								<form method="POST" action="?conf='.$m_orderid.'">
								<center>Вам необходимо перевести <b>'.$sum2.'</b> '.$rowps['abr'].' на счет <b>'.$rowps['purse'].'</b> в примечании к платежу, укажите ваш логин: <b>'.$login.'</b>.  После оплаты, укажите ваш номер счета, с которого вы совершили платеж в форме ниже и нажмите кнопку подтверждения платежа.

								<input type="text" name="purse" size="20" />
								<br /><br />
								<p align="center"><input class="subm" type="submit" value="Я совершил платеж" /></p>
								</center>
								</form>
								</FIELDSET>';
							}

						} else {
							print '<p class="er">Не удаётся отправить заявку!</p>';
						}

				
				
					}
		}
	} else {
	?>
<table style="margin: 0px 180px;" align="center">
	<form action="?action=save" method="post">
	<tr><td><b>Сумма ввода</b>: </td><td align="right"><input style="width: 180px;" type='text' name='sum' value='' size="30" maxlength="7" /></td></tr>
	<tr><td><b>Платежная система</b>: </td><td align="right">
	<select style="width: 203px; margin: 0px 0px;" name="ps">
		<?php
			if($cfgPerfect) {
				print '<option value="1">PerfectMoney</option>';
			}
			if(cfgSET('cfgPEsid') && cfgSET('cfgPEkey')) {
				print '<option value="2">PAYEER.com</option>';
			}

			$result	= mysql_query("SELECT * FROM `paysystems` WHERE id > 2 ORDER BY id ASC");
			while($row = mysql_fetch_array($result)) {
				print '<option value="'.$row['id'].'">'.$row['name'].'</option> ';
			}
		?>
	</select></td></tr>
	<tr><td></td><td align="right"><input class="subm" style="width: 180px; margin: 5px 0 0 0" type='submit' name='submit' value=' Пополнить баланс ' /></td></tr>
	</form>
	</table><br><br>
<center><b><span style="font-size: 20px">История ввода средств:</span></b></center><br> 
<?php


	$page	= intval($_GET['page']);
	$query	= "SELECT * FROM `enter` WHERE login = '".$login."'";
	$result	= mysql_query($query);
	$themes = mysql_num_rows($result);
	$total	= intval(($themes - 1) / $num) + 1;

	if(empty($page) or $page < 0) $page = 1;
	if($page > $total) $page = $total;
	$start = $page * $num - $num;
	$result = mysql_query($query." ORDER BY id DESC LIMIT ".$start.", ".$num);

	if(!$themes) {
		print "<p class=\"er\">Вы не подавали заявок на пополнение баланса!</p>";
	} else {

		print "<table width=\"100%\"><tr bgcolor=\"#dddddd\" align=\"center\"><td style=\"padding: 3px;\"><b>#</b></td><td width=\"100\"><b>Дата</b></td><td><b>Сумма</b></td><td><b>Счет</b></td><td><b>Система</b></td><td><b>Статус</b></td></tr>";

		$i = 1;
		$s = 0;
		while ($row = mysql_fetch_array($result)) {

		if($i % 2) { $bg = ""; } else { $bg = " bgcolor=\"#eeeeee\""; }

		print "<tr".$bg." align=\"center\">
		<td style=\"padding: 3px;\">".$row['id']."</td>
		<td>".date("d.m.Y H:i", $row['date'])."</td>
		<td>$".$row['sum']."</td>
		<td><b>".$row['purse']."</b></td>
		<td>".$row['paysys']."</td>
		<td>";

		if($row['status'] == 0) {
			print '<span class="tool"><img src="/images/proc_ico.png" width="16" height="16" alt="В процессе" /><span class="tip">Заявка создана, но пока не подтверждена оплата с вашей стороны</span></span>';
		} elseif($row['status'] == 1) {
			print '<span class="tool"><img src="/images/wait_ico.png" width="16" height="16" alt="Ожидание" /><span class="tip">Заявка находится на рассмотрении и обработке.</span></span>';
		} elseif($row['status'] == 2) {
			print '<span class="tool"><img src="/images/yes_ico.png" width="16" height="16" alt="Выполнена" /><span class="tip">Заявка выполнена!</span></span>';
		} else {
			print '<span class="tool"><img src="/images/no_ico.png" width="16" height="16" alt="Отклонена" /><span class="tip">Заявка отклонена.</span></span>';
		}

		print "</td>

		</tr>";

			$i++;
			$s = $s + $row['sum'];
		}

		print "<tr bgcolor=\"#dddddd\" height=\"3\"><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><td></td><td align=\"right\"><b>Итого:</b></td><td align=\"center\"><b>$".$s."</b></td><td></td><td></td><td></td></tr></table>";

	}

	if ($page) {
		if($page != 1) { $pervpage = "<a href=\"?page=". ($page - 1) ."\">««</a>"; }
		if($page != $total) { $nextpage = " <a href=\"?page=". ($page + 1) ."\">»»</a>"; }
		if($page - 2 > 0) { $page2left = " <a href=\"?page=". ($page - 2) ."\">". ($page - 2) ."</a> "; }
		if($page - 1 > 0) { $page1left = " <a href=\"?page=". ($page - 1) ."\">". ($page - 1) ."</a> "; }
		if($page + 2 <= $total) { $page2right = " <a href=\"?page=". ($page + 2) ."\">". ($page + 2) ."</a> "; }
		if($page + 1 <= $total) { $page1right = " <a href=\"?page=". ($page + 1) ."\">". ($page + 1) ."</a> "; }
	}
	print "<div class=\"pages\"><b>Страницы:  </b>".$pervpage.$page2left.$page1left." <b>".$page."</b> ".$page1right.$page2right.$nextpage."</div>";

	}

} else {
	print "<p class=\"er\">Вы должны авторизироваться для доступа к этой странице!</p>";
}

?>