<?php
defined('ACCESS') or die();
if ($login) {

	$sql	= 'SELECT `pe`, `pm`, `pm_balance`, `ref`, `login` FROM `users` WHERE `id` = '.$user_id.' LIMIT 1';
	$rs		= mysql_query($sql);
	$r		= mysql_fetch_array($rs);

	if($_GET['cancel']) {
			$sql2	= 'SELECT * FROM `output` WHERE `id` = '.intval($_GET['cancel']).' AND status = 0 AND login = "'.$login.'" LIMIT 1';
			$rs2	= mysql_query($sql2);
			$r2		= mysql_fetch_array($rs2);

			if($r2['sum']) {

				if($cfgPercentOut) {
					$sum = sprintf("%01.2f", $r2['sum'] + ($r2['sum'] / (100 - $cfgPercentOut) * $cfgPercentOut));
				} else {
					$sum = $r2['sum'];
				}

				mysql_query('UPDATE `users` SET pm_balance = pm_balance + '.$sum.' WHERE id = '.$user_id.' LIMIT 1');
				mysql_query('UPDATE `output` SET status = 6 WHERE id = '.intval($_GET['cancel']).' LIMIT 1');
				print '<p class="erok">Заявка отменена, средства возвращены на баланс</p>';
			} else {
				print '<p class="er">Невозможно отменить заявку</p>';
			}
	}

	if ($_GET['action'] == 'save') {
		$sum	= sprintf ("%01.2f", str_replace(',', '.', $_POST['sum']));
		$ps		= intval($_POST['ps']);
		$purse	= htmlspecialchars($_POST['purse'], ENT_QUOTES, '');

		if(!$purse) {
			$purse = $r['pm'];
		}

		if ($sum <= 0) {
			print '<p class="er">Введите корректную сумму (от $'.$cfgMinOut.' до $'.cfgSET('cfgMaxOut').')!</p>';
		} elseif ($sum < $cfgMinOut || $sum > cfgSET('cfgMaxOut')) {
			print '<p class="er">За один раз разрешено выводить от $'.$cfgMinOut.' до $'.cfgSET('cfgMaxOut').'!</p>';
		} elseif ($r['pm_balance'] < $sum) {
			print '<p class="er">У Вас нет столько денег на счету!</p>';
		} elseif(cfgSET('cfgCountOut') != 0 && cfgSET('cfgCountOut') <= mysql_num_rows(mysql_query("SELECT * FROM output WHERE login = '".$login."' AND (status = 2 OR status = 0)"))) {
			print '<p class="er">Вы на сегодня исчерпали свой лимит заявок на вывод средств. Попробуйте пожалуйста завтра.</p>';	
		} elseif($ps < 1) {
			print '<p class="er">Укажите платежную систему! Номер счета укажите в вашем профиле.</p>';
		} elseif(!$purse) {
			print '<p class="er">Укажите номер счета</p>';
		} else {

			$minus = $sum;

			if($cfgPercentOut) {
				$sum = sprintf("%01.2f", $sum - $sum / 100 * $cfgPercentOut);
			}

			$sql	= 'UPDATE `users` SET pm_balance = pm_balance - '.$minus.' WHERE id = '.$user_id.' LIMIT 1';
			mysql_query($sql);

			if(($cfgAutoPay == "on" && $ps == 1) || (cfgSET('cfgAutoPayPE') == "on" && $ps == 2)) { 
				$st	= 2; 
			} else { 
				$st = 0; 

				$text = "<p>Здравствуйте! В <a href=\"http://".$cfgURL."\">вашем проекте</a> подана заявка на вывод средств. Обработайте её пожалуйста.</p>";

				$subject	= "Заявка на вывод средств";
				$headers 	= "From: ".$adminmail."\n";
				$headers 	.= "Reply-to: ".$adminmail."\n";
				$headers 	.= "X-Sender: < http://".$cfgURL." >\n";
				$headers 	.= "Content-Type: text/html; charset=windows-1251\n";

				mail($adminmail,$subject,$text,$headers);
			}

			if($ps == 1) { $purse = $r['pm']; }
			if($ps == 2) { $purse = $r['pe']; }

			$sql = 'INSERT INTO `output` (`sum`, `date`, `login`, `paysys`, `purse`, `status`) VALUES("'.$sum.'", "'.time().'", "'.$login.'", '.$ps.', "'.$purse.'", '.$st.')';

			if (mysql_query($sql)) {

					$lid = mysql_insert_id();

					// АВТОВЫПЛАТЫ
						if($ps == 1 && $cfgAutoPay == "on") {
							$f = fopen('https://perfectmoney.com/acct/confirm.asp?AccountID='.$cfgPMID.'&PassPhrase='.$cfgPMpass.'&Payer_Account='.$cfgPerfect.'&Payee_Account='.$purse.'&Amount='.$sum.'&PAY_IN=1&PAYMENT_ID='.$lid.'&Memo='.$cfgURL, 'rb');

							if($f===false){
								mysql_query('UPDATE `users` SET pm_balance = pm_balance + '.$minus.' WHERE id = '.$user_id.' LIMIT 1');
								mysql_query('UPDATE `output` SET status = 6 WHERE id = '.$lid.' LIMIT 1');

								print '<p class="er">Временно недоступен API PerfectMoney. Попробуйте пожалуйста позже.</p>';
							} else {
								// getting data
								$out=array(); $out="";
								while(!feof($f)) $out.=fgets($f);

								fclose($f);

								// searching for hidden fields
								if(!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $out, $result, PREG_SET_ORDER)){

									mysql_query('UPDATE `users` SET pm_balance = pm_balance + '.$minus.' WHERE id = '.$user_id.' LIMIT 1');
									mysql_query('UPDATE `output` SET status = 6 WHERE id = '.$lid.' LIMIT 1');

									print '<p class="er">PerfectMoney не дал разрешения на выполнение данной операции</p>';

								}
							}

						} elseif($ps == 2 && cfgSET('cfgAutoPayPE') == "on") {

							require_once('../includes/cpayeer.php');
							$accountNumber	= cfgSET('cfgPEAcc');
							$apiId			= cfgSET('cfgPEidAPI');
							$apiKey			= cfgSET('cfgPEapiKey');
							$payeer = new CPayeer($accountNumber, $apiId, $apiKey);
							if ($payeer->isAuth()) {
								$arTransfer = $payeer->transfer(array(
								'curIn' => 'USD',	// счет списания 
								'sum' => $sum,		// Сумма получения 
								'curOut' => 'USD',	// валюта получения  
								'to' => $purse,		// Получатель
								'comment' => 'API '.$r['login'].' '.$cfgURL,
							));

								if(!empty($arTransfer["historyId"])) {
									print "<p class=\"erok\">Перевод №".$arTransfer["historyId"]." успешно завершен</p>";
								} else {
									mysql_query('UPDATE `output` SET status = 0 WHERE id = '.$lid.' LIMIT 1');
									print '<p class=\"er\">ОШИБКА! Заявка будет выполнена в ручном режиме</p>';		
								}
							} else {
								mysql_query('UPDATE `output` SET status = 0 WHERE id = '.$lid.' LIMIT 1');
								print "<p class=\"er\">Ошибка авторизации в API Payeer. Заявка будет выполнена в ручном режиме.</p>";
							}

						}

					print '<p class="erok">Ваша заявка отправлена в обработку!</p>';

			} else {
				print '<p class="er">Не удаётся отправить заявку на снятие денег!</p>';
			}
		}
	}
	?>
<script language="JavaScript">
<!--
	function CheBal() {

		document.getElementById("sum").value = "<?php print $r['pm_balance']; ?>"

		if(document.getElementById('ps').value == 1) {
			document.getElementById("purse").value = '<?php print $r['pm']; ?>';
			document.getElementById("purse").disabled = true;
		} else if(document.getElementById('ps').value == 2) {
			document.getElementById("purse").value = '<?php print $r['pe']; ?>';
			document.getElementById("purse").disabled = true;
		} else {
			document.getElementById("purse").value = '';
			document.getElementById("purse").disabled = false;
		}
	}
//-->
</script>


	<table  style="margin: 0px 180px;" align="center">
	<form action="?action=save" method="post">
	<tr><td><b>Сумма вывода</b>: </td><td align="right"><input id="sum" style="width: 200px;" type='text' name='sum' value='<?php print $r['pm_balance']; ?>' size="30" maxlength="7" /></td></tr>
	<tr><td><b>Платежная система</b>: </td><td align="right"><select style="width: 221px; margin: 0px 0px;" name="ps">
<?php
if($r['pm']) {
	print '<option value="1">PerfectMoney</option>';
}

$result	= mysql_query("SELECT * FROM `paysystems` WHERE id != 1 ORDER BY id ASC");
while($row = mysql_fetch_array($result)) {
	print '<option value="'.$row['id'].'">'.$row['name'].'</option> ';
}
?>
	</select></td></tr>
	<tr><td><b>Номер счета:</b> </td><td align="right"><input  style="width: 200px;" type='text' id="purse" name='purse' value='' size="30" maxlength="30" /></td></tr>
	<tr><td></td><td align="right"><input style="width: 200px; margin: 5px 0 0 0" class="subm" type='submit' name='submit' value=' Подать заявку ' /></td></tr>
	</form>
	</table>

<script language="JavaScript">
<!--
	CheBal();
//-->
</script><br><br>
<center><b><span style="font-size: 20px">История вывода средств:</span></b></center><br>
<?php


	$page	= intval($_GET['page']);
	$query	= "SELECT * FROM `output` WHERE login = '".$login."'";
	$result	= mysql_query($query);
	$themes = mysql_num_rows($result);
	$total	= intval(($themes - 1) / $num) + 1;

	if(empty($page) or $page < 0) $page = 1;
	if($page > $total) $page = $total;
	$start = $page * $num - $num;
	$result = mysql_query($query." ORDER BY id DESC LIMIT ".$start.", ".$num);

	if(!$themes) {
		print "<p class=\"er\">Вы не подавали заявок на вывод!</p>";
	} else {

		print "<table width=\"100%\"><tr bgcolor=\"#dddddd\" align=\"center\"><td style=\"padding: 3px;\"><b>#</b></td><td width=\"100\"><b>Дата</b></td><td><b>Сумма</b></td><td><b>Счет</b></td><td><b>Система</b></td><td><b>Статус</b></td></tr>";

		$i = 1;
		$s = 0;
		while ($row = mysql_fetch_array($result)) {

		if($i % 2) { $bg = ""; } else { $bg = " bgcolor=\"#eeeeee\""; }

		$get_ps	= mysql_query("SELECT name FROM paysystems WHERE id = ".intval($row['paysys'])." LIMIT 1");
		$rowps	= mysql_fetch_array($get_ps);

		print "<tr".$bg." align=\"center\">
		<td style=\"padding: 3px;\">".$row['id']."</td>
		<td>".date("d.m.Y H:i", $row['date'])."</td>
		<td>$".$row['sum']."</td>
		<td><b>".$row['purse']."</b></td>
		<td>".$rowps['name']."</td>
		<td>";

		if($row['status'] == 0) {
			print '<span class="tool"><img src="/images/wait_ico.png" width="16" height="16" alt="Ожидание" /><span class="tip">Заявка находится на рассмотрении и обработке.</span></span> <span class="tool"><a href="?cancel='.$row['id'].'"><img src="/images/cancel_btn.png" width="16" height="16" border="0" alt="Отменить" /></a><span class="tip">Отменить заявку</span></span>';
		} elseif($row['status'] == 2) {
			print '<span class="tool"><img src="/images/yes_ico.png" width="16" height="16" alt="Обработана" /><span class="tip">Заявка выполнена!</span></span>';
		} elseif($row['status'] == 6) {
			print '<span class="tool"><img src="/images/cancel_ico.png" width="16" height="16" alt="Отменена" /><span class="tip">Заявка отменена - средства возвращены на баланс!</span></span>';
		} else {
			print '<span class="tool"><img src="/images/no_ico.png" width="16" height="16" alt="Удалена" /><span class="tip">Заявка отклонена администратором.</span></span>';
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
} else {
	print "<p class=\"er\">Вы должны авторизироваться для доступа к этой странице!</p>";
}
?>