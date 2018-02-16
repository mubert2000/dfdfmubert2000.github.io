<?php
$cusers		= mysql_num_rows(mysql_query("SELECT id FROM users")) + cfgSET('fakeusers');
$cwm		= mysql_num_rows(mysql_query("SELECT id FROM users WHERE pm_balance != 0 OR lr_balance != 0")) + cfgSET('fakeactiveusers');

$money	= cfgSET('fakewithdraws');
$query	= "SELECT sum FROM output WHERE status = 2";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$money = $money + $row['sum'];
}

$depmoney	= cfgSET('fakedeposits');
$query	= "SELECT sum FROM deposits WHERE status = 0";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$depmoney = $depmoney + $row['sum'];
}
?>
<table width="100%">
	<tr height="20">
		<td>Start:</td>
		<td align="right"><font color="#0099ff"><?php print date("d.m.Y", cfgSET('datestart')); ?></font></td>
	</tr>
	<tr height="20">
		<td>Members:</td>
		<td align="right"><font color="#0099ff"><?php print $cusers; ?></font></td>
	</tr>
	<tr height="20">
		<td>Active members:</td>
		<td align="right"><font color="#0099ff"><?php print $cwm; ?></font></td>
	</tr>
	<tr height="20">
		<td>Members online</td>
		<td align="right"><font color="#0099ff"><?php print intval(mysql_num_rows(mysql_query("SELECT id FROM users WHERE go_time > ".intval(time() - 1200))) + cfgSET('fakeonline')); ?></font></td>
	</tr>
	<tr height="20">
		<td>Deposits:</td>
		<td align="right"><font color="#0099ff"><?php print $depmoney; ?>$</font></td>
	</tr>
	<tr height="20">
		<td>Withdraw:</td>
		<td align="right"><font color="#0099ff"><?php print $money; ?>$</font></td>
	</tr>
	<tr height="20">
		<td>New member</td>
<?php
	$nu	= mysql_fetch_array(mysql_query("SELECT login FROM users ORDER BY id DESC LIMIT 1"));
?>
		<td align="right"><font color="#0099ff">[ <?php print $nu['login']; ?> ]</font></td>
	</tr>
	<tr height="20">
		<td>New deposit</td>
<?php
	$nd	= mysql_fetch_array(mysql_query("SELECT * FROM deposits ORDER BY id DESC LIMIT 1"));
?>
		<td align="right"><font color="#0099ff">$<?php print $nd['sum']; ?> [ <?php print $nd['username']; ?> ]</font></td>
	</tr>
	<tr height="20">
		<td>New withdraw</td>
<?php
	$no	= mysql_fetch_array(mysql_query("SELECT * FROM output ORDER BY id DESC LIMIT 1"));
?>
		<td align="right"><font color="#0099ff">$<?php print $no['sum']; ?> [ <?php print $no['login']; ?> ]</font></td>
	</tr>
</table>