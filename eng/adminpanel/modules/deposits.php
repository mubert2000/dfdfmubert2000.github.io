<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
*/
defined('ACCESS') or die();

if($_GET['action'] == "add_depo") {

	$name	= htmlspecialchars($_POST['name'], ENT_QUOTES, '');
	$sum	= sprintf("%01.2f", $_POST['sum']);
	$plan	= intval($_POST['plan']);
	$paysys	= intval($_POST['paysys']);

	if(!$name || !$sum || !$plan || !$paysys) {
		print '<p class="er">Заполните все поля</p>';
	} elseif(!mysql_num_rows(mysql_query("SELECT * FROM users WHERE login = '".$name."' LIMIT 1"))) {
		print '<p class="er">Пользователь с таким логином не найден</p>';
	} else {
		$query	 = "SELECT id FROM users WHERE login = '".$name."' LIMIT 1";
		$result	 = mysql_query($query);
		$row	 = mysql_fetch_array($result);
		$name_id = $row['id'];


			$result	= mysql_query("SELECT * FROM plans WHERE id = ".$plan." LIMIT 1");
			$row2	= mysql_fetch_array($result);

			if(cfgSET('datestart') <= time()) {
				$lastdate = time();
				if($row2['period'] == 1) {
					$nextdate = $lastdate + 86400;
				} elseif($row2['period'] == 2) {
					$nextdate = $lastdate + 604800;
				} elseif($row2['period'] == 3) {
					$nextdate = $lastdate + 2592000;
				} elseif($row2['period'] == 4) {
					$nextdate = $lastdate + 3600;
				}
			} else {
				$lastdate = time();
				if($row2['period'] == 1) {
					$nextdate = cfgSET('datestart') + 86400;
				} elseif($row2['period'] == 2) {
					$nextdate = cfgSET('datestart') + 604800;
				} elseif($row2['period'] == 3) {
					$nextdate = cfgSET('datestart') + 2592000;
				} elseif($row2['period'] == 4) {
					$nextdate = cfgSET('datestart') + 3600;
				}
			}

			$sql = "INSERT INTO `deposits` (username, user_id, date, plan, sum, paysys, lastdate, nextdate) VALUES ('".$name."', ".$name_id.", ".time().", ".$plan.", ".$sum.", ".$paysys.", ".$lastdate.", ".$nextdate.")";
			mysql_query($sql);

		print '<p class="erok">Депозит добавлен пользователю</p>';
	}

}

if($_GET['action'] == "addpercent") {

	$percent	= sprintf("%01.2f", $_POST['percent']);
	$plan		= intval($_POST['plan']);

	if($percent) {

		if($plan == 0) {
			$wh = "status = 0";
		} else {
			$wh = "status = 0 AND plan = ".$plan;
		}

		$query	= "SELECT * FROM deposits WHERE ".$wh;
		$result	= mysql_query($query);
		while($row = mysql_fetch_array($result)) {

			$p	= sprintf("%01.2f", $row['sum'] / 100 * $percent);

			// Начисляем на баланс
			if($row['paysys'] == 1) {
				mysql_query('UPDATE users SET pm_balance = pm_balance + '.$p.' WHERE id = '.$row['user_id'].' LIMIT 1');
			} elseif($row['paysys'] == 2) {
				mysql_query('UPDATE users SET lr_balance = lr_balance + '.$p.' WHERE id = '.$row['user_id'].' LIMIT 1');
			}

			// Вносим в статистику
			mysql_query('INSERT INTO stat (user_id, date, plan, sum, paysys) VALUES ('.$row['user_id'].', '.time().', '.$row['plan'].', '.$p.', '.$row['paysys'].')');

		}
		print '<p class="erok">Проценты всем зачислены! НЕ ОБНОВЛЯЙТЕ СТРАНИЦУ!</p>';
	} else {
		print '<p class="er">Укажите процент начислений</p>';
	}
}

$money = 0.00;
$query	= "SELECT `sum` FROM `deposits` WHERE status = 0";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$money = $money + $row['sum'];
}
?>
<center><b>Всего открытых депозитов на сумму: $<?php print sprintf("%01.2f", $money); ?></b></center>
<hr />
<table border="0" align="center" width="100%" cellpadding="1" cellspacing="1" bgcolor="#547898">
<colspan><div align="right" style="padding: 2px;">Сортировать по: <a href="?a=deposits&sort=id">ID (дате)</a> | <a href="?a=deposits&sort=sum">Сумме</a> | <a href="?a=deposits&sort=username">Логину</a></div></colspan>
	<tr align="center" height="19" style="background:URL(images/menu.gif) repeat-x top left;">
		<td width="40"><b>ID</b></td>
  		<td><b>Дата</b></td>
		<td><b>Логин</b></td>
		<td><b>Сумма</b></td>
		<td><b>Тарифный план</b></td>
	</tr>
<?php
function users_list($page, $num, $query) {

	$result = mysql_query($query);
	$themes = mysql_num_rows($result);

	if (!$themes) {
		print '<tr><td colspan="9" align="center"><font color="#ffffff"><b>Депозитов пока нет.</b></font></td></tr>';
	} else {

		$total = intval(($themes - 1) / $num) + 1;
		if (empty($page) or $page < 0) $page = 1;
		if ($page > $total) $page = $total;
		$start = $page * $num - $num;
		$result = mysql_query($query." LIMIT ".$start.", ".$num);
		while ($row = mysql_fetch_array($result)) {

		$result2	= mysql_query("SELECT name FROM plans WHERE id = ".$row['plan']." LIMIT 1");
		$row2		= mysql_fetch_array($result2);

			print "<tr bgcolor=\"#eeeeee\" align=\"center\">
			<td>".$row['id']."</td>
			<td>".date("d.m.y H:i", $row['date'])."</td>
			<td align=\"left\"><a href=\"?a=edit_user&id=".$row['user_id']."\"><b>".$row['username']."</b></a></td>
			<td>".$row['sum']."</td>
			<td>".$row2['name']."</td>
		</tr>";
		}

		if ($page != 1) $pervpage = "<a href=?a=deposits&sort=".$_GET['sort']."&page=". ($page - 1) .">««</a>";
		if ($page != $total) $nextpage = " <a href=?a=deposits&sort=".$_GET['sort']."&page=". ($page + 1) .">»»</a>";
		if($page - 2 > 0) $page2left = " <a href=?a=deposits&sort=".$_GET['sort']."&page=". ($page - 2) .">". ($page - 2) ."</a> | ";
		if($page - 1 > 0) $page1left = " <a href=?a=deposits&sort=".$_GET['sort']."&page=". ($page - 1) .">". ($page - 1) ."</a> | ";
		if($page + 2 <= $total) $page2right = " | <a href=?a=deposits&sort=".$_GET['sort']."&page=". ($page + 2) .">". ($page + 2) ."</a>";
		if($page + 1 <= $total) $page1right = " | <a href=?a=deposits&sort=".$_GET['sort']."&page=". ($page + 1) .">". ($page + 1) ."</a>";
		print "<tr height=\"19\"><td colspan=\"5\" bgcolor=\"#ffffff\"><b>Страницы: </b>".$pervpage.$page2left.$page1left."[".$page."]".$page1right.$page2right.$nextpage."</td></tr>";
	}
	print "</table>";
}

if($_GET['sort'] == "id") {
	$sort = "ORDER BY id DESC";
} elseif($_GET['sort'] == "sum") {
	$sort = "order by sum DESC";
} elseif($_GET[sort] == "username") {
	$sort = "order by username ASC";
} else {
	$sort = "order by id ASC";
}

if($_GET['action'] == "search") {
	$su = " AND username = '".htmlspecialchars($_POST['name'], ENT_QUOTES, '')."'";
}

$sql = "SELECT * FROM deposits WHERE status = 0 AND id != 999 ".$su." ".$sort;
users_list(intval($_GET['page']), 50, $sql);
?>
<form action="?a=deposits&action=add_depo" method="post">
<FIELDSET style="border: solid #666666 1px; padding: 10px; margin-top: 20px;">
<LEGEND><b>Открыть депозит пользователю</b></LEGEND>
<table width="100%" border="0">
	<tr>
		<td><strong>Логин:</strong></td>
		<td align="right"><input style="width: 750px;" type="text" name="name" size="93" /></td>
	</tr>
	<tr>
		<td><strong>Сумма:</strong></td>
		<td align="right"><input style="width: 750px;" type="text" name="sum" size="93" value="100.00" /></td>
	</tr>
	<tr>
		<td><strong>Тарифный план:</strong></td>
		<td align="right"><select name="plan" style="width: 750px;">
<?php
$result	= mysql_query("SELECT * FROM plans ORDER BY id ASC");
while($row = mysql_fetch_array($result)) {
	print '<option value="'.$row['id'].'">'.$row['name'].'</option>';
}
?></select>
	</td>
	</tr>
	<tr>
		<td><strong>Платежная система:</strong></td>
		<td align="right"><select name="paysys" style="width: 750px;">
<?php
if($cfgPerfect) {
	print '<option value="1">PerfectMoney</option>';
}
?>
		</select>
	</td>
	</tr>
	<tr>
		<td></td>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Добавить" /></td>
	</tr>
</table>
</FIELDSET>
</form>

<form action="?a=deposits&action=search" method="post">
<FIELDSET style="border: solid #666666 1px; padding: 10px; margin-top: 20px;">
<LEGEND><b>Найти депозиты по логину</b></LEGEND>
<table width="100%" border="0">
	<tr>
		<td width="60"><strong>Поиск:</strong></td>
		<td><input style="width: 825px;" type="text" name="name" size="93" /></td>
		<td align="center"><input type="image" src="images/search.gif" width="28" height="29" border="0" title="Поиск!" /></td>
	</tr>
</table>
</FIELDSET>
</form>

<form action="?a=deposits&action=addpercent" method="post">
<FIELDSET style="border: solid #666666 1px; padding: 10px; margin-top: 20px;">
<LEGEND><b>Начислить проценты по депозитам вручную</b></LEGEND>
<table width="100%" border="0">
	<tr>
		<td><strong>Процент от суммы вклада:</strong></td>
		<td><input style="width: 720px;" type="text" name="percent" size="93" /></td>
		<td></td>
	</tr>
	<tr>
		<td><strong>Тарифный план:</strong></td>
		<td><select name="plan" style="width: 720px;">
		<option value="0">Депозитам во всех тарифных планах</option>
<?php
$result	= mysql_query("SELECT * FROM plans ORDER BY id ASC");
while($row = mysql_fetch_array($result)) {
	print '<option value="'.$row['id'].'">'.$row['name'].'</option>';
}
?></select></td>
		<td align="center"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Начислить!" /></td>
	</tr>
</table>
</FIELDSET>
</form>