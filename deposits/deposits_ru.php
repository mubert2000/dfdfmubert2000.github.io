<?php
defined('ACCESS') or die();
if($login) {

	if($_GET['close']) {

		$result	= mysql_query("SELECT * FROM deposits WHERE id = ".intval($_GET['close'])." AND user_id = ".$user_id." AND status = 0 LIMIT 1");
		$row	= mysql_fetch_array($result);

		$result2	= mysql_query("SELECT * FROM plans WHERE id = ".$row['plan']." LIMIT 1");
		$row2		= mysql_fetch_array($result2);

		if(!$row['id'] || !$row2['id']) {
			print '<p class="er">Произошла ошибка при закрытии депозита</p>';
		} elseif($row2['back'] != 1 || $row2['close'] != 1) {
			print '<p class="er">Этот депозит невозможно закрыть досрочно</p>';
		} else {
			$sum = sprintf("%01.2f", $row['sum'] - $row['sum'] / 100 * $row2['close_percent']);
			mysql_query('UPDATE users SET pm_balance = pm_balance + '.$sum.' WHERE id = '.$row['user_id'].' LIMIT 1');
			mysql_query("DELETE FROM deposits WHERE id = ".$row['id']." LIMIT 1");
			print '<p class="erok">ДЕПОЗИТ ЗАКРЫТ ДОСРОЧНО!</p>';
		}

	}
?>
<table width="100%" align="center">
<?php
$s = 0;
$result	= mysql_query("SELECT * FROM deposits WHERE user_id = ".$user_id." ORDER BY id ASC");
while($row = mysql_fetch_array($result)) {

	$result2	= mysql_query("SELECT * FROM plans WHERE id = ".$row['plan']." LIMIT 1");
	$row2		= mysql_fetch_array($result2);

print "<tr>
	<td><div style=\"padding: 4px; background-color: #eeeeee;\"><b>".$row2['name']."</b> - Сумма: <b>$".$row['sum']."</b>";
	
	if($row2['back'] == 1 && $row2['close'] == 1) {
		print " [ <a href=\"javascript: if(confirm('Вы действительно хотите закрыть депозит? При закрытии депозита, с вас будет вычтена комиссия в размере ".$row2['close_percent']."%')) top.location.href='?close=".$row['id']."';\">Закрыть депозит</a> ]";
	}
	
	print "</div>под ".$row2['percent']."% в ";
	if($row2['period'] == 1) { print "день"; } elseif($row2['period'] == 2) { print "неделю"; }  elseif($row2['period'] == 4) { print "час"; } else { print "месяц"; }
	print ", сроком ".$row2['days'];
	if($row2['period'] == 4) { print " часов"; } elseif($row2['period'] == 1) { print " дней"; } elseif($row2['period'] == 2) { print " недель"; } elseif($row2['period'] == 3) { print " месяцев"; }
	print "<br />	
	Был открыт: ".date("d.m.Y H:i", $row['date'])."
	</td>
</tr>
<tr>
	<td height=\"1\" bgcolor=\"#cccccc\"></td>
</tr>";

if(cfgSET('autopercent') == "on") {
print "
<tr>
	<td height=\"1\" bgcolor=\"#cccccc\"></td>
</tr>";
}

print "<tr>
	<td height=\"20\"></td>
</tr>";
$s = $s + $row['sum'];
}
?>
</table>
<?php 

	if($s == 0) {
		print '<p class="er">У вас нет открытых депозитов, но вы можете <a href="/deposit/">открыть</a> его.</p>';
	} else {
		print 'Всего открытых депозитов на сумму <b>$'.$s.'</b>';
	}

} else {
	print "<p class=\"er\">Для доступа к данной странице вам необходимо авторизироваться</p>";
	include "../login/login_ru.php";
}
?>