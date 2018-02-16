<?php
defined('ACCESS') or die();
if ($login) {

	if($_GET['pay'] == "no") {
		print '<p class="er">Unable to top-up</p>';
	}

	if($_GET['conf']) {

		print '<p class="erok">Your request is sent to the administrator for review</p>';

		$conf		= intval($_GET['conf']);
		$purse		= addslashes(htmlspecialchars($_POST["purse"], ENT_QUOTES, ''));

		mysql_query("UPDATE enter SET status = 1, purse = '".$purse."' WHERE id = ".$conf." LIMIT 1");

	} elseif ($_GET['action'] == 'save') {
		$sum	= sprintf ("%01.2f", str_replace(',', '.', $_POST['sum']));
		$ps		= intval($_POST['ps']);

		if ($sum <= 0) {
			print '<p class="er">Enter the correct amount ($0.10 - $10 000)!</p>';
		} elseif ($sum < 0.10 || $sum > 10000) {
			print '<p class="er">At a time is allowed to output $0.10 - $10 000!</p>';
		} elseif($ps < 1) {
			print '<p class="er">Enter the payment system!</p>';
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

					print '<FIELDSET style="border: solid #666666 1px; padding-top: 15px; margin-bottom: 10px;">
					<LEGEND><b>Confirmation of payment</b></LEGEND>
					<form action="https://perfectmoney.com/api/step1.asp" method="POST">
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
					You transfer the <strong> '.$sum.' </strong> USD to account <strong>'.$cfgPerfect.'</strong> PerfectMoney<br />Recharge in the project '.$cfgURL.'<br />
					<p align="center"><input class="subm" name="PAYMENT_METHOD" type="submit" value=" Payment confirm " /></p>
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

								print '<FIELDSET style="border: solid #666666 1px; padding-top: 15px; margin-bottom: 10px;">
								<LEGEND><b>Confirmation of payment</b></LEGEND>
								<form method="GET" action="//payeer.com/api/merchant/m.php" accept-charset="utf-8">
								<input type="hidden" name="m_shop" value="'.$cid.'">
								<input type="hidden" name="m_orderid" value="'.$m_orderid.'">
								<input type="hidden" name="m_amount" value="'.$sum.'">
								<input type="hidden" name="m_curr" value="USD">
								<input type="hidden" name="m_desc" value="'.$desc.'">
								<input type="hidden" name="m_sign" value="'.$sign.'">

								<center>
								You need to to transfer <strong>'.$sum.'</strong> USD<br /><br />
								<p align="center"><input class="subm" type="submit" name="m_process" value="send" /></p>
								</center>
								</form>
								</FIELDSET>';

							} else {

								print '<FIELDSET style="border: solid #666666 1px; padding-top: 15px; margin-bottom: 10px;">
								<LEGEND><b>Confirmation of payment</b></LEGEND>
								<form method="POST" action="?conf='.$m_orderid.'">
								<center>You need to to transfer <b> '.$sum2.'</b> '.$rowps['abr'].' at the expense of <b> '.$rowps['purse'].' </b> in a note to the payment, enter your login: <b> '.$login.' </b>. After payment, enter your account number from which you made a payment in the form below and click the confirmation of payment.

								<input type="text" name="purse" size="20" />
								<br /><br />
								<p align="center"><input class="subm" type="submit" value="I made a payment" /></p>
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
	<table align="center">
	<form action="?action=save" method="post">
	<tr><td><b>Amount</b>: </td><td align="right"><input style="width: 180px;" type='text' name='sum' value='' size="30" maxlength="7" /></td></tr>
	<tr><td><b>Payment System</b>: </td><td align="right">
	<select style="width: 180px; margin-right: 0px;" name="ps">
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
	<tr><td></td><td align="right"><input class="subm" type='submit' name='submit' value=' Fill up balance ' /></td></tr>
	</form>
	</table><hr />

<h3>History completions:</h3>
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
		print "<p class=\"er\">You have not filed applications for top-ups!</p>";
	} else {

		print "<table width=\"100%\"><tr bgcolor=\"#dddddd\" align=\"center\"><td style=\"padding: 3px;\"><b>#</b></td><td width=\"100\"><b>Date</b></td><td><b>Amount</b></td><td><b>Account</b></td><td><b>System</b></td><td><b>Status</b></td></tr>";

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
			print '<span class="tool"><img src="/images/proc_ico.png" width="16" height="16" alt="during" /><span class="tip">The application is created, but not yet confirmed payment from your side</span></span>';
		} elseif($row['status'] == 1) {
			print '<span class="tool"><img src="/images/wait_ico.png" width="16" height="16" alt="expectation" /><span class="tip">The application is under consideration and treatment.</span></span>';
		} elseif($row['status'] == 2) {
			print '<span class="tool"><img src="/images/yes_ico.png" width="16" height="16" alt="performed" /><span class="tip">application is made!</span></span>';
		} else {
			print '<span class="tool"><img src="/images/no_ico.png" width="16" height="16" alt="rejected" /><span class="tip">application rejected.</span></span>';
		}

		print "</td>

		</tr>";

			$i++;
			$s = $s + $row['sum'];
		}

		print "<tr bgcolor=\"#dddddd\" height=\"3\"><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><td></td><td align=\"right\"><b>Total:</b></td><td align=\"center\"><b>$".$s."</b></td><td></td><td></td><td></td></tr></table>";

	}

	if ($page) {
		if($page != 1) { $pervpage = "<a href=\"?page=". ($page - 1) ."\">««</a>"; }
		if($page != $total) { $nextpage = " <a href=\"?page=".$total."\">»»</a>"; }
		if($page - 2 > 0) { $page2left = " <a href=\"?page=". ($page - 2) ."\">". ($page - 2) ."</a> "; }
		if($page - 1 > 0) { $page1left = " <a href=\"?page=". ($page - 1) ."\">". ($page - 1) ."</a> "; }
		if($page + 2 <= $total) { $page2right = " <a href=\"?page=". ($page + 2) ."\">". ($page + 2) ."</a> "; }
		if($page + 1 <= $total) { $page1right = " <a href=\"?page=". ($page + 1) ."\">". ($page + 1) ."</a> "; }
	}
	print "<div class=\"pages\"><b>Pages:  </b>".$pervpage.$page2left.$page1left." <b>".$page."</b> ".$page1right.$page2right.$nextpage."</div>";

	}

} else {
	print "<p class=\"er\">You must login to access this page!</p>";
}

?>