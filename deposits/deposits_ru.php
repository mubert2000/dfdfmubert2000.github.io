<?php
defined('ACCESS') or die();
if($login) {

	if($_GET['close']) {

		$result	= mysql_query("SELECT * FROM deposits WHERE id = ".intval($_GET['close'])." AND user_id = ".$user_id." AND status = 0 LIMIT 1");
		$row	= mysql_fetch_array($result);

		$result2	= mysql_query("SELECT * FROM plans WHERE id = ".$row['plan']." LIMIT 1");
		$row2		= mysql_fetch_array($result2);

		if(!$row['id'] || !$row2['id']) {
			print '<p class="er">��������� ������ ��� �������� ��������</p>';
		} elseif($row2['back'] != 1 || $row2['close'] != 1) {
			print '<p class="er">���� ������� ���������� ������� ��������</p>';
		} else {
			$sum = sprintf("%01.2f", $row['sum'] - $row['sum'] / 100 * $row2['close_percent']);
			mysql_query('UPDATE users SET pm_balance = pm_balance + '.$sum.' WHERE id = '.$row['user_id'].' LIMIT 1');
			mysql_query("DELETE FROM deposits WHERE id = ".$row['id']." LIMIT 1");
			print '<p class="erok">������� ������ ��������!</p>';
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
	<td><div style=\"padding: 4px; background-color: #eeeeee;\"><b>".$row2['name']."</b> - �����: <b>$".$row['sum']."</b>";
	
	if($row2['back'] == 1 && $row2['close'] == 1) {
		print " [ <a href=\"javascript: if(confirm('�� ������������� ������ ������� �������? ��� �������� ��������, � ��� ����� ������� �������� � ������� ".$row2['close_percent']."%')) top.location.href='?close=".$row['id']."';\">������� �������</a> ]";
	}
	
	print "</div>��� ".$row2['percent']."% � ";
	if($row2['period'] == 1) { print "����"; } elseif($row2['period'] == 2) { print "������"; }  elseif($row2['period'] == 4) { print "���"; } else { print "�����"; }
	print ", ������ ".$row2['days'];
	if($row2['period'] == 4) { print " �����"; } elseif($row2['period'] == 1) { print " ����"; } elseif($row2['period'] == 2) { print " ������"; } elseif($row2['period'] == 3) { print " �������"; }
	print "<br />	
	��� ������: ".date("d.m.Y H:i", $row['date'])."
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
		print '<p class="er">� ��� ��� �������� ���������, �� �� ������ <a href="/deposit/">�������</a> ���.</p>';
	} else {
		print '����� �������� ��������� �� ����� <b>$'.$s.'</b>';
	}

} else {
	print "<p class=\"er\">��� ������� � ������ �������� ��� ���������� ����������������</p>";
	include "../login/login_ru.php";
}
?>