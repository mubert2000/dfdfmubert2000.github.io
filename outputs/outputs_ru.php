<?php
function topics_list($page, $num, $status, $query, $cfgURL)
{
?>
<table align="center" width="100%" border="0" bgcolor="#cccccc" cellpadding="1" cellspacing="1">
<tr align="center" height="19">
	<td width="150"><b>Дата</b></td>
	<td><b>Логин</b></td>
	<td width="100"><b>Сумма</b></td>
	<td width="70"><b>Система</b></td>
</tr>
<?php
	$result = mysql_query($query);
	$themes = mysql_num_rows($result);
	$total = intval(($themes - 1) / $num) + 1;
	if (empty($page) or $page < 0) $page = 1;
	if ($page > $total) $page = $total;
	$start = $page * $num - $num;
	$result = mysql_query($query.' LIMIT '.$start.', '.$num);
	$esum	= 0.00;
	$osum	= 0.00;
	while ($topics = mysql_fetch_array($result))
	{

		$esum	= sprintf ("%01.2f", $esum + $topics['sum']);

		print '<tr align="center" bgcolor="#ffffff">
		<td>'.date("d.m.Y H:i:s", $topics['date']).'</td>
		<td align="left"><b>'.$topics['login'].'</b></td>
		<td>'.$topics['sum'].'</td>
		<td>';
		if($topics['paysys'] == 1) { print "PerfectMoney"; } else { print "LibertyReserve"; }
		print '</td></tr>
		';
	}
?>
</table>
<?php
}

$sql = 'SELECT * FROM output';

switch ($sort)
{
case 0:
	$sql .= ' WHERE status = 0 ORDER BY id DESC';
	break;
case 1:
	$sql .= ' WHERE status = 2 ORDER BY id DESC';
	break;
}

$page = intval($_GET['page']);
topics_list($page, 10, $status, $sql, $cfgURL);

}
?>