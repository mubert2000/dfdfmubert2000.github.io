<?php
defined('ACCESS') or die();

if($login) {

if($_GET['act'] == "open") {

	$plan	= intval($_POST['plan']);
	$sum	= sprintf("%01.2f", $_POST['sum']);
	$reinv	= sprintf("%01.2f", $_POST['reinv']);
	$paysys	= intval($_POST['paysys']);
	if($plan && $sum) {

	$result	= mysql_query("SELECT * FROM plans WHERE id = ".$plan." LIMIT 1");
	$row	= mysql_fetch_array($result);

		if(!$row['id']) {
			print '<p class="er">Choose a tariff plan</p>';
		} elseif($sum < $row['minsum'] || ($sum > $row['maxsum'] && $row['maxsum'] != 0)) {
			print '<p class="er">The amount does not match the rate plan</p>';
		} elseif($sum > $pmbalance) {
			print '<p class="er">You have insufficient funds in the account, we recommend <a href="/enter/"> refill </ a> it.</p>';
		} elseif($reinv < 0 && $reinv > 100) {
			print '<p class="er">Percentage of reinvestment delivery has to be from 0 to 100</p>';
		} else {

			if($row['bonusdeposit']) {
				$depo	= sprintf("%01.2f", $sum + $sum / 100 * $row['bonusdeposit']);
			} else {
				$depo = $sum;
			}

			if(cfgSET('datestart') <= time()) {
				$lastdate	= time();
				$weekend	= $row['weekend'];
				$day		= date("w");

				if($day == 0 && $weekend == 1) {
					$nad = intval((24 - date("H")) * 3600);
				} elseif($day == 6 && $weekend == 1) {
					$nad = intval((24 - date("H")) * 3600 + 86400);
				} else {
					$nad = 0;
				}

				if($row['period'] == 1) {
					$nextdate = $lastdate + 86400 + $nad;
				} elseif($row['period'] == 2) {
					$nextdate = $lastdate + 604800 + $nad;
				} elseif($row['period'] == 3) {
					$nextdate = $lastdate + 2592000 + $nad;
				} elseif($row['period'] == 4) {
					$nextdate = $lastdate + 3600 + $nad;
				}
			} else {
				$lastdate = time();
				if($row['period'] == 1) {
					$nextdate = cfgSET('datestart') + 86400;
				} elseif($row['period'] == 2) {
					$nextdate = cfgSET('datestart') + 604800;
				} elseif($row['period'] == 3) {
					$nextdate = cfgSET('datestart') + 2592000;
				} elseif($row['period'] == 4) {
					$nextdate = cfgSET('datestart') + 3600;
				}
			}

			$sql = "INSERT INTO `deposits` (username, user_id, date, plan, sum, paysys, lastdate, nextdate, reinvest) VALUES ('".$login."', ".$user_id.", ".time().", ".$plan.", ".$depo.", ".$paysys.", ".$lastdate.", ".$nextdate.", ".$reinv.")";
			mysql_query($sql);

			mysql_query('UPDATE users SET pm_balance = pm_balance - '.$sum.' WHERE id = '.$user_id.' LIMIT 1');


			// Начисляем бонус

			if($row['bonusbalance']) {
				$bonus	= sprintf("%01.2f", $sum / 100 * $row['bonusbalance']);
					mysql_query('UPDATE users SET pm_balance = pm_balance + '.$bonus.' WHERE id = '.$user_id.' LIMIT 1');
			}

			// Начисляем нашим "любимым" рефералам
			if($uref) {

				// Подсчитываем кол-во уровней
				$countlvl = mysql_num_rows(mysql_query("SELECT * FROM reflevels"));

				if($countlvl) {
					$i		= 0;
					$uid	= $user_id;
					$query	= "SELECT * FROM reflevels ORDER BY id ASC";
					$result	= mysql_query($query);
					while($row = mysql_fetch_array($result)) {
						if($i < $countlvl) {
							$lvlperc = $row['sum'];		// Процент уровня
							$ps		 = sprintf("%01.2f", $sum / 100 * $lvlperc); // Сумма рефских

							if($uref) {

								// Смотрим есть ли индивидуальный процент у данного реферала
								$get_refp	= mysql_query("SELECT ref_percent FROM users WHERE id = ".intval($uref)." LIMIT 1");
								$rowrefp	= mysql_fetch_array($get_refp);
								$urefp		= $rowrefp['ref_percent'];

								if($i == 0 && $urefp) {
									$ps = sprintf("%01.2f", $sum / 100 * $urefp); // Сумма рефских
								}

								mysql_query('UPDATE users SET pm_balance = pm_balance + '.$ps.', reftop = reftop + '.$ps.' WHERE id = '.$uref.' LIMIT 1');

								mysql_query('UPDATE users SET ref_money = ref_money + '.$ps.' WHERE id = '.$uid.' LIMIT 1');
								
								// Получаем данные следующего пользователя

								$get_ref	= mysql_query("SELECT id, ref FROM users WHERE id = ".intval($uref)." LIMIT 1");
								$rowref		= mysql_fetch_array($get_ref);
								$uref		= $rowref['ref'];
								$uid		= $rowref['id'];

							}

						}
						$i++;
					}
				}

			}
			// Закончили с рефералами

			print '<p class="erok">Deposit is open! <a href="/deposits/">deposits to top »</a></p>';
		}

	} else {
		print '<p class="er">Select a data plan, the payment system and enter the amount of the deposit</p>';
	}
	
}


?>
<form method="post" action="?act=open">
<table width="100%" align="center">
<?php
$result	= mysql_query("SELECT * FROM plans WHERE status = 0 ORDER BY id ASC");
while($row = mysql_fetch_array($result)) {

print "<tr>
	<td><label><input style=\"float: left;\" type=\"radio\" name=\"plan\" value=\"".$row['id']."\" checked /> <div style=\"padding: 4px; background-color: #eeeeee;\"><b>".$row['name']."</b></div>";
		print "<div style=\"padding-left: 22px;\">Min - Max investment: $".$row['minsum']." - $".$row['maxsum'].". <b>".$row['percent']."%</b>";
		if($row['period'] == 4) { print " per hour"; } elseif($row['period'] == 1) { print " daily"; } elseif($row['period'] == 2) { print " per week"; } elseif($row['period'] == 3) { print " per month"; }
		print ", for ".$row['days'];
		if($row['period'] == 4) { print " hours"; } elseif($row['period'] == 1) { print " days"; } elseif($row['period'] == 2) { print " weeks"; } elseif($row['period'] == 3) { print " months"; }
		print "</div></label></td>
</tr>
<tr>
	<td height=\"1\" bgcolor=\"#cccccc\"></td>
</tr>
<tr>
	<td height=\"15\"></td>
</tr>";

}
?>
</table>
<div style="margin-top: 15px;"></div>

<table width="100%">
<tr>
	<td align="right">Amount ($): </td>
	<td width="205"><input style="width: 198px;" type="text" name="sum" value="<?php print $pmbalance; ?>" /></td>
</tr>
<?php
if(cfgSET('cfgReInv') == "on") {
	print '<tr>
	<td align="right">Reinvestment (%): </td>
	<td width="205"><input style="width: 198px;" type="text" name="reinv" value="0" /></td>
	</tr>';	
}
?>
<tr>
	<td></td>
	<td><input style="width: 198px;" class="subm" type="submit" value=" Open deposit " /></td>
</tr>
</table>
</form>
<?php 
} else {
	print "<p class=\"er\">To access this page you need to login</p>";
	include "../login/login.php";
}
?>