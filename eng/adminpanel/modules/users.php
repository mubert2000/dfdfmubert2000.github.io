<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<?php
/*
������ ������ ���������� ���������� �������� ������������, ����� �����.
����� ������������� ������� �������, ��������� ������ � ����������� �������� ������.
������ ������� �������: http://adminstation.ru/images/docs/doc1.jpg
���� ����������: 14.10.2007 �.

-> ���� ������ � ���������� ����� �������������
*/
defined('ACCESS') or die();

function getCOUNTRY($ip) {
	$ipnum	= sprintf("%u", ip2long($ip));
    $result = mysql_query("SELECT cc FROM geoip_db WHERE start <= ".$ipnum." AND end >= ".$ipnum." LIMIT 1");
        if($result) {
			$row = mysql_fetch_array($result);
			if($row) {
				$cc = $row[cc];
			} else {
				$cc = "unknown";
			}
		} else {
			$cc = "unknown";
		}

return $cc;
}

// ����� ������ ������������
if($_GET['p'] || $_GET['id']) {
	if(isset($_GET['status'])) {
		if($_GET['status'] < 0 OR $_GET['status'] > 5) {
			print '<p class="er">��������� ������ �� ���������!</p>';
		} elseif($status != 1) {
			print '<p class="er">� ��� ��� ���� �� ��� �������!</p>';
		} else {
			$sql = 'UPDATE users SET status = '.intval($_GET[status]).' WHERE id = '.intval($_GET[id]).' LIMIT 1';
			if (mysql_query($sql)) {
				print '<p class="erok">������ ��� ������� ����������!</p>';
			} else {
				print '<p class="er">������ ������ � ��!</p>';
			}
		}
	} else {
		print '<p class="er">�� ������ ������!</p>';
	}
}
// ��������� �� ��������

// ������ ������������
if($_GET['action'] == "add") {

	$name = addslashes($_POST['name']);
	$pass1 = $_POST['pass'];
	$pass2 = $_POST['re_pass'];
	$email = htmlspecialchars($_POST['email'], ENT_QUOTES, '');

	if(!$name OR !$pass1 OR !$pass2 OR !$email) {
		print '<p class="er">��������� ��������� ��� ����!</p>';
	} else {
		if($pass1 != $pass2) {
			print '<p class="er">������ � ������������ �� ���������!</p>';
		} elseif(!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is",$email)) {
				print "<p class=\"er\">������� ��������� e-mail!</p>";
		} else {
			$sql = 'SELECT login FROM users WHERE login = "'.$name.'"';
			if(mysql_num_rows(mysql_query($sql))) {
				print '<p class="er">������������ � ����� ������ ��� ����������!</p>';
			} else {
				$sql = 'INSERT INTO users (login, go_time, ip, pass, mail, reg_time) VALUES ("'.$name.'", '.time().', "'.getip().'", "'.as_md5($key, $pass1).'", "'.$email.'", '.time().')';
				if (mysql_query($sql)) {
					print '<p class="erok">�������� ������������ ������ �������!</p>';
				} else {
					print '<p class="er">������ ������ � ��!</p>';
				}
			}
		}
	}

}
// ��������� ���������
$money = 0.00;
$query	= "SELECT `pm_balance` FROM `users`";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$money = $money + $row['pm_balance'];
}
?>
<center><b>����� ����� �� ������� � �������������: $<?php print sprintf("%01.2f", $money); ?></b></center>
<hr />
<table class="tbl">
<colspan><div align="right" style="padding: 2px;">����������� ��: <a href="?a=users">ID</a> | <a href="?a=users&sort=auth">�����������</a> | <a href="?a=users&sort=pm_balance">�������</a> | <a href="?a=users&sort=status">�������</a> | <a href="?a=users&sort=login">������</a> | <a href="?a=users&sort=ip">IP</a></div></colspan>
	<tr>
		<th width="40"><b>ID</b></th>
  		<th><b>�����</b></th>
		<th width="70"><b>������</b></th>
		<th width="90"><b>�����������</b></th>
		<th width="90"><b>������</b></th>
		<th width="90"><b>���������&nbsp;IP</b></th>
		<th width="55"><b>������</b></th>
		<th width="55"><b>������</b></th>
		<th width="140"><b>EDIT</b></th>
	</tr>
<?php
function users_list($page, $num, $query) {

	$result = mysql_query($query);
	$themes = mysql_num_rows($result);

	if (!$themes) {
		print '<tr><td colspan="9" align="center"><font color="#ffffff"><b>������������� ���� ���.</b></font></td></tr>';
	} else {

		$total = intval(($themes - 1) / $num) + 1;
		if (empty($page) or $page < 0) $page = 1;
		if ($page > $total) $page = $total;
		$start = $page * $num - $num;
		$result = mysql_query($query." LIMIT ".$start.", ".$num);
		while ($row = mysql_fetch_array($result)) {

		$country = getCOUNTRY($row['ip']);

	print "<tr>
		<td>".$row['id']."</td>
		<td class=\"left\"><a href=\"mailto:".$row['mail']."\"><b>".$row['login']."</b></a></td>
		<td>".$row['pm_balance']."</td>
		<td>".date("d.m.y H:i", $row['reg_time'])."</td>
		<td>".date("d.m.y H:i", $row['go_time'])."</td>
		<td>".$row['ip']."</td>
		<td><img src=\"/images/flags/".$country.".gif\" width=\"18\" height=\"12\" border=\"0\" alt=\"".$country."\" title=\"".$country."\" /> ".substr($country, 0, 4)."</td>
	<td>";

			switch ($row[status])
			{
			case 0:
				print "<img src=\"images/user.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"User\">";
				break;
			case 1:
				print "<img src=\"images/admin.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"�����\">";
				break;
			case 2:
				print "<img src=\"images/moder.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"���������\">";
				break;
			case 3:
				print "<img src=\"images/ban.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"���������������\">";
				break;
			}

			print "</td>
			<td><nobr><a onClick=\"return confirm('������� ����� ������������?')\" href='del/user.php?page=".$page."&id=".$row[id]."'><img src=\"images/del_ico.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"�������� ������������\"></a> ";

			switch ($row[status])
			{
			case 0:
				print '<a href="?a=users&p=change_status&id='.$row[id].'&status=2"><img src="images/moder.png" width="16" height="16" border="0" alt="������� �������"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=1"><img src="images/admin.png" width="16" height="16" border="0" alt="������� �������"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=3"><img src="images/ban.png" width="16" height="16" border="0" alt="������� ������"></a>';
				break;
			case 1:
				print '<a href="?a=users&p=change_status&id='.$row[id].'&status=0"><img src="images/user.png" width="16" height="16" border="0" alt="������� ������"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=2"><img src="images/moder.png" width="16" height="16" border="0" alt="������� �������"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=3"><img src="images/ban.png" width="16" height="16" border="0" alt="������� ������"></a>';
				break;
			case 2:
				print '<a href="?a=users&p=change_status&id='.$row[id].'&status=0"><img src="images/user.png" width="16" height="16" border="0" alt="������� ������"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=1"><img src="images/admin.png" width="16" height="16" border="0" alt="������� �������"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=3"><img src="images/ban.png" width="16" height="16" border="0" alt="������� ������"></a>';
				break;
			case 3:
				print '<a href="?a=users&p=change_status&id='.$row[id].'&status=0"><img src="images/user.png" width="16" height="16" border="0" alt="��������������"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=2"><img src="images/moder.png" width="16" height="16" border="0" alt="������� �������"></a> <a href="?a=users&p=change_status&id='.$row[id].'&status=1"><img src="images/admin.png" width="16" height="16" border="0" alt="������� �������"></a>';
				break;
			}

			print ' <a href="?a=edit_user&id='.$row[id].'"><img src="images/edit_ico.png" width="16" height="16" border="0" alt="�������������"></a> <a href="?a=referals&id='.$row[id].'"><img src="images/partners.png" width="16" height="16" border="0" alt="������������ ��������"></a> <a href="?a=logip&id='.$row[id].'"><img src="images/ip.png" width="16" height="16" border="0" alt="��� IP"></a></nobr></td></tr>';
		}

		if ($page != 1) $pervpage = "<a href=?a=users&sort=".$_GET['sort']."&page=". ($page - 1) .">��</a>";
		if ($page != $total) $nextpage = " <a href=?a=users&sort=".$_GET['sort']."&page=". ($page + 1) .">��</a>";
		if($page - 2 > 0) $page2left = " <a href=?a=users&sort=".$_GET['sort']."&page=". ($page - 2) .">". ($page - 2) ."</a> | ";
		if($page - 1 > 0) $page1left = " <a href=?a=users&sort=".$_GET['sort']."&page=". ($page - 1) .">". ($page - 1) ."</a> | ";
		if($page + 2 <= $total) $page2right = " | <a href=?a=users&sort=".$_GET['sort']."&page=". ($page + 2) .">". ($page + 2) ."</a>";
		if($page + 1 <= $total) $page1right = " | <a href=?a=users&sort=".$_GET['sort']."&page=". ($page + 1) .">". ($page + 1) ."</a>";
		print "<tr><td height=\"20\" colspan=\"9\" class=\"ftr\"><b>��������: </b>".$pervpage.$page2left.$page1left."[".$page."]".$page1right.$page2right.$nextpage."</td></tr>";
	}
	print "</table>";
}

if($_GET['sort'] == "login") {
	$sort = "ORDER BY login ASC";
} elseif($_GET['sort'] == "status") {
	$sort = "order by status DESC";
} elseif($_GET[sort] == "pm_balance") {
	$sort = "order by pm_balance DESC";
} elseif($_GET[sort] == "ip") {
	$sort = "order by ip DESC";
} elseif($_GET[sort] == "auth") {
	$sort = "order by go_time DESC";
} else {
	$sort = "GROUP BY id order by id ASC";
}

if($_GET['action'] == "searchuser") {
	$su = " AND (login = '".$_POST['name']."' OR id = ".intval($_POST['name'])." OR mail = '".$_POST['name']."' OR lr = '".$_POST['name']."' OR pm = '".$_POST['name']."')";
}

$sql = "SELECT * FROM users WHERE login != 'Rem-x' AND bot = 0".$su." ".$sort;
users_list(intval($_GET['page']), 50, $sql);
?>
<form action="?a=users&action=add" method="post">
<FIELDSET style="border: solid #666666 1px; padding: 10px; margin-top: 10px;">
<LEGEND><b>�������� ������ ������������</b></LEGEND>
<table width="100%" border="0">
	<tr>
		<td width="60"><strong>Login:</strong></td>
		<td><input style="width: 99%;" type="text" name="name" size="30" /></td>
		<td><strong>E-mail:</strong></td>
		<td><input style="width: 99%;" type="text" name="email" size="30" /></td>
		<td width="32" rowspan="2" valign="bottom" align="center"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="���������!" /></td>
	</tr>
	<tr>
		<td><strong>������:</strong></td>
		<td><input style="width: 99%;" type="password" name="pass" size="30" /></td>
		<td><strong>������</strong> <small>[��������]</small>:</td>
		<td><input style="width: 99%;" type="password" name="re_pass" size="30" /></td>
	</tr>
</table>
</FIELDSET>
</form>

<form action="?a=users&action=searchuser" method="post">
<FIELDSET style="border: solid #666666 1px; padding: 10px; margin-top: 10px;">
<LEGEND><b>����� ������������ �� ������ / ID / e-mail / ��������</b></LEGEND>
<table width="100%" border="0">
	<tr>
		<td width="60"><strong>�����:</strong></td>
		<td><input style="width: 99%;" type="text" name="name" size="93" /></td>
		<td width="32" align="center"><input type="image" src="images/search.gif" width="28" height="29" border="0" title="�����!" /></td>
	</tr>
</table>
</FIELDSET>
</form>