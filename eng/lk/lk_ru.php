			<?php
defined('ACCESS') or die();



if($login) {
			$sql8	= 'SELECT * FROM users WHERE login = "'.$login.'" LIMIT 1';
$rs8		= mysql_query($sql8);
$a8		= mysql_fetch_array($rs8);
$alldep = 0.00;
$allout = 0.00;
$resultd	= mysql_query("SELECT * FROM deposits WHERE user_id = ".$user_id." ORDER BY id ASC");
while($rowd = mysql_fetch_array($resultd)) {
	$alldep = $alldep + $rowd['sum'];
	}
	$resulto	= mysql_query("SELECT * FROM `output` WHERE `login` = '".$login."' AND status = '2' ORDER BY id ASC");
while($rowo = mysql_fetch_array($resulto)) {
	$allout = $allout + $rowo['sum'];
	}
	$resultol	= mysql_query("SELECT `date`,`sum` FROM `output` WHERE `login` = '".$login."' AND status = '2' ORDER BY id DESC LIMIT 1");
	if(mysql_num_rows($resultol)) {
$rowol = mysql_fetch_array($resultol);
$outl = date("d-m-Y H:i:s", $rowol['date']).',на сумму: '.sprintf ("%01.2f", str_replace(',', '.', $rowol['sum'])).' USD';
} else {
$outl = 'Нет Выплат!';
}
$resulten	= mysql_query("SELECT `sum`,`paysys` FROM `enter` WHERE `login` = '".$login."' AND status = '2' ORDER BY id DESC LIMIT 1");
	if(mysql_num_rows($resulten)) {
$rowen = mysql_fetch_array($resulten);
$ent = sprintf ("%01.2f", str_replace(',', '.', $rowen['sum'])).' USD - '.$rowen['paysys'];
} else {
$ent = 'Нет Пополнений!';
}
?>
			
			<h1>Ваш Личный Кабинет:</h1><br>
			<table class="history" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr>
					<td>Ваш Логин:</td>
					<td><span><?php print $login;?></span></td>
				</tr>
				<tr>
					<td>Дата Регистрации:</td>
					<td><span><?php print date("d-m-Y", $a8['reg_time']);?></span></td>
				</tr>
				<tr>
					<td>Последний Вход:</td>
					<td><span><?php print date("d-m-Y H:i:s", $a8['go_time']);?></span></td>
				</tr>
			</tbody></table>
			
			<br><br>
			<h2>Статистика по финансам:</h2><br>
			<table class="history" width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
					<td valign="top">Общий баланс:</td>
					<td><span><b><?php print sprintf ("%01.2f", str_replace(',', '.', ($a8['lr_balance'] + $a8['pm_balance'])));?></b> USD</span></td>
				</tr>
				<tbody><tr>
					<td valign="top"><small>Баланс Payeer:</small></td>
					<td><small><span><b><?php print sprintf ("%01.2f", str_replace(',', '.', $a8['lr_balance']));?></b> USD</span></small></td>
				</tr>
				<tr>
					<td valign="top"><small>Баланс PerfectMoney:</small></td>
					<td><small><span><b><?php print sprintf ("%01.2f", str_replace(',', '.', $a8['pm_balance']));?></b> USD</span></small></td>
				</tr>
				
				<tr>
					<td>Последнее Пополнение:</td>
					<td><span><b>
						<?php print $ent;?>					</b></span></td>
				</tr>
				<tr>
					<td>Последняя Выплата:</td>
					<td><span><b>
													<small><?php print $outl;?></small>
											</b></span></td>
				</tr>
				<tr>
					<td>Всего Выплачено:</td>
					<td><span><b><?php print sprintf ("%01.2f", str_replace(',', '.', $allout));?> USD</b></span></td>
				</tr>
				<tr>
					<td>Активных Депозитов:</td>
					<td><span><b><?php print sprintf ("%01.2f", str_replace(',', '.', $alldep));?> USD</b></span></td>
				</tr>
			</tbody></table>
			<?php } else {
	print "<p class=\"er\">Для доступа к данной странице вам необходимо авторизироваться</p>";
	include "../login/login_ru.php";
}
?>