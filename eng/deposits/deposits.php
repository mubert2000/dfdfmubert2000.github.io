<?php
defined('ACCESS') or die();
if($login) {

	if($_GET['close']) {

		$result	= mysql_query("SELECT * FROM deposits WHERE id = ".intval($_GET['close'])." AND user_id = ".$user_id." AND status = 0 LIMIT 1");
		$row	= mysql_fetch_array($result);

		$result2	= mysql_query("SELECT * FROM plans WHERE id = ".$row['plan']." LIMIT 1");
		$row2		= mysql_fetch_array($result2);

		if(!$row['id'] || !$row2['id']) {
			print '<p class="er">An error occurred while closing the deposit</p>';
		} elseif($row2['back'] != 1 || $row2['close'] != 1) {
			print '<p class="er">This deposit can not be closed prematurely</p>';
		} else {
			$sum = sprintf("%01.2f", $row['sum'] - $row['sum'] / 100 * $row2['close_percent']);
			mysql_query('UPDATE users SET pm_balance = pm_balance + '.$sum.' WHERE id = '.$row['user_id'].' LIMIT 1');
			mysql_query("DELETE FROM deposits WHERE id = ".$row['id']." LIMIT 1");
			print '<p class="erok">DEPOSIT CLOSED AHEAD!</p>';
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
	<td><div style=\"padding: 4px; background-color: #eeeeee;\"><b>".$row2['name']."</b> - Amount: <b>$".$row['sum']."</b>";
	
	if($row2['back'] == 1 && $row2['close'] == 1) {
		print " [ <a href=\"javascript: if(confirm('Do you really want to close the deposit? When closing a deposit, you will be deducted at the rate of commission ".$row2['close_percent']."%')) top.location.href='?close=".$row['id']."';\">Close deposit</a> ]";
	}
	
	print "</div>";
	print $row2['percent']."% ";
	if($row2['period'] == 1) { print "Daily"; } elseif($row2['period'] == 2) { print "per week"; }  elseif($row2['period'] == 4) { print "hour"; } else { print "per month"; }
	print ", period ".$row2['days'];
	if($row2['period'] == 4) { print " hours"; } elseif($row2['period'] == 1) { print " days"; } elseif($row2['period'] == 2) { print " weeks"; } elseif($row2['period'] == 3) { print " months"; }
	print "<br />	
	Open: ".date("d.m.Y H:i", $row['date'])."
	</td>
</tr>
<tr>
	<td height=\"1\" bgcolor=\"#cccccc\"></td>
</tr>";

if(cfgSET('autopercent') == "on") {
print "
<tr>
	<td align=\"center\"><b>Left until the next payment: <span id=\"deptimer".$row['id']."\"></span></b> [ ".date("H:i d.m.Y", $row['nextdate'])." ]</td>
</tr>
<tr>
	<td class=\"lineclock\">
		<div id=\"percentline".$row['id']."\" class=\"percentline\">&nbsp;</div><script language=\"JavaScript\">
		<!--
			CalcTimePercent(".$row['id'].", ".$row['lastdate'].", ".$row['nextdate'].", ".time().", ".$row2['period'].");
		//-->
		</script>
	</td>
</tr>
<tr>
	<td height=\"1\" bgcolor=\"#cccccc\"></td>
</tr>";
}

print "
<tr>
	<td height=\"20\"></td>
</tr>";
$s = $s + $row['sum'];
}
?>
</table>
<?php 

	if($s == 0) {
		print '<p class="er">You do not open a deposit</p>';
	} else {
		print 'Total deposits in the amount of <b>$'.$s.'</b>';
	}

} else {
	print "<p class=\"er\">To access this page you need to login</p>";
	include "../login/login.php";
}
?>