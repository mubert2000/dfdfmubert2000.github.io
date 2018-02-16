<?php
defined('ACCESS') or die();
print $body;
	
if($login) {

	if(cfgSET('cfgTrans') == "off") {
		print '<p class="er">Данный раздел отключен администратором</p>';	
	} else {

		if($_GET['action'] == "yes") { 

			$name		= as_html($_POST['name']);
			$sum		= sprintf("%01.2f", str_replace(',', '.', $_POST['sum']));
			$percent	= intval($_POST['percent']);

			if(!$name) {
				print '<p class="er">Укажите логин или e-mail получателя платежа</p>';
			} elseif(!$sum) {
				print '<p class="er">Укажите сумму перевода</p>';
			} elseif($sum < 0.01) {
				print '<p class="er">Сумма перевода должна быть больше 0.01$</p>';
			} elseif(!mysql_num_rows(mysql_query("SELECT login, mail FROM users WHERE login = '".$name."' OR mail = '".$name."'"))) {
				print '<p class="er">Получатель не найден!</p>';
			} else {

				if(cfgSET('cfgTransPercent') > 0 && $percent == 2) {
					$sum_in		= sprintf("%01.2f", $sum - $sum / 100 * cfgSET('cfgTransPercent'));
					$sum_out	= $sum;
				} elseif(cfgSET('cfgTransPercent') > 0 && $percent == 3) {
					$sum_in		= sprintf("%01.2f", $sum - $sum / 100 * cfgSET('cfgTransPercent') / 2);
					$sum_out	= sprintf("%01.2f", $sum + $sum / 100 * cfgSET('cfgTransPercent') / 2);
				} else {
					$sum_in		= $sum;
					$sum_out	= sprintf("%01.2f", $sum + $sum / 100 * cfgSET('cfgTransPercent'));
				}

				if($balance < $sum_out) {
					print '<p class="er">У вас недостаточно средств на счету</p>';
				} else {

					$get_user_info	= mysql_query("SELECT login, mail FROM users WHERE login = '".$name."' OR mail = '".$name."' LIMIT 1");
					$row			= mysql_fetch_array($get_user_info);

					mysql_query('UPDATE users SET pm_balance = pm_balance + '.$sum_in.' WHERE login = "'.$row['login'].'" LIMIT 1');
					mysql_query('UPDATE users SET pm_balance = pm_balance - '.$sum_out.' WHERE login = "'.$login.'" LIMIT 1');

					mysql_query('INSERT INTO `transfer` (`sum`, `date`, `to`, `from`) VALUES ('.$sum.', '.time().', "'.$row['login'].'", "'.$login.'")');

					$mail	= $row['mail'];

					$headers = "From: ".$adminmail."\n";
					$headers .= "Reply-to: ".$adminmail."\n";
					$headers .= "X-Sender: < http://".$cfgURL." >\n";
					$headers .= "Content-Type: text/html; charset=windows-1251\n";

					$subject	= "Вам поступил денежный перевод";
					$msg		= "Здравствуйте! Вам поступил денежный перевод в сумме ".$sum_in."$ от пользователя ".$login;

					mail($mail, $subject, $msg, $headers);

					print '<p class="erok">Перевод успешно выполнен</p>';
				}

			}

		}

?>
	<table align="center">
	<form action="?action=yes" method="post">
	<tr><td><b>Логин или e-mail получателя</b>: </td><td align="right"><input style="width: 180px;" type='text' name='name' value='' size="30" maxlength="30" /></td></tr>
	<tr><td><b>Сумма перевода *</b>: </td><td align="right"><input style="width: 180px;" type='text' name='sum' value='' size="30" maxlength="7" /></td></tr>
<?php if(cfgSET('cfgTransPercent') > 0) { ?>
	<tr><td><b>Комиссию оплачивает</b>: </td><td align="right">
	<select style="width: 180px; margin-right: 0px;" name="percent">
		<option value="1">Я</option> 
		<option value="2">Получатель</option>
		<option value="3">Пополам</option>
	</select></td></tr>
<?php } ?>
	<tr><td></td><td align="right"><input class="subm" type='submit' name='submit' value=' Совершить перевод ' /></td></tr>
	</form>
	</table><hr />
	* Комиссия системы за перевод <b><?php print cfgSET('cfgTransPercent'); ?>%</b>

<h3>История переводов:</h3>
<?php


	$page	= intval($_GET['page']);
	$query	= "SELECT * FROM `transfer` WHERE `to` = '".$login."' OR `from` = '".$login."'";
	$result	= mysql_query($query);
	$themes = mysql_num_rows($result);
	$total	= intval(($themes - 1) / $num) + 1;

	if(empty($page) or $page < 0) $page = 1;
	if($page > $total) $page = $total;
	$start = $page * $num - $num;
	$result = mysql_query($query." ORDER BY id DESC LIMIT ".$start.", ".$num);

	if(!$themes) {
		print "<p class=\"er\">У вас еще не было переводов!</p>";
	} else {

		print "<table width=\"100%\"><tr bgcolor=\"#dddddd\" align=\"center\"><td style=\"padding: 3px;\"><b>#</b></td><td width=\"100\"><b>Дата</b></td><td><b>Сумма</b></td><td><b>Получатель</b></td><td><b>Отправитель</b></td><td><b>Статус</b></td></tr>";

		$i = 1;
		$s = 0;
		while ($row = mysql_fetch_array($result)) {

		if($i % 2) { $bg = ""; } else { $bg = " bgcolor=\"#eeeeee\""; }

		print "<tr".$bg." align=\"center\">
		<td style=\"padding: 3px;\">".$row['id']."</td>
		<td>".date("d.m.Y H:i", $row['date'])."</td>
		<td>$".$row['sum']."</td>
		<td><b>".$row['to']."</b></td>
		<td>".$row['from']."</td>
		<td>";

		if($row['to'] == $login) {
			print '<span class="tool"><img src="/images/to_ico.png" width="16" height="16" alt="Получено" /><span class="tip">Полученный перевод</span></span>';
		} else {
			print '<span class="tool"><img src="/images/from_ico.png" width="16" height="16" alt="Отправлено" /><span class="tip">Отправленный перевод</span></span>';
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
		if($page != 1) { $pervpage = "<a href=\"?page=1\">««</a>"; }
		if($page != $total) { $nextpage = " <a href=\"?page=".$total."\">»»</a>"; }
		if($page - 2 > 0) { $page2left = " <a href=\"?page=". ($page - 2) ."\">". ($page - 2) ."</a> "; }
		if($page - 1 > 0) { $page1left = " <a href=\"?page=". ($page - 1) ."\">". ($page - 1) ."</a> "; }
		if($page + 2 <= $total) { $page2right = " <a href=\"?page=". ($page + 2) ."\">". ($page + 2) ."</a> "; }
		if($page + 1 <= $total) { $page1right = " <a href=\"?page=". ($page + 1) ."\">". ($page + 1) ."</a> "; }
	}
	print "<div class=\"pages\"><b>Страницы:  </b>".$pervpage.$page2left.$page1left." [<b>".$page."</b>] ".$page1right.$page2right.$nextpage."</div>";

	}

} else {
	print '<p class="er">Для доступа к данной странице вам необходимо авторизироваться!</p>';
}
?>