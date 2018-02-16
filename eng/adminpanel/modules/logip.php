<?php
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
?>
<form action="adminstation.php" method="get">
<FIELDSET style="border: solid #666666 1px; padding: 10px;">
<LEGEND><b>Показать лог авторизации IP</b></LEGEND>
<input type="hidden" name="a" value="logip" />
<table width="100%" border="0">
	<tr>
		<td width="60"><strong>USER ID:</strong></td>
		<td><input class="inp" style="width: 99%;" type="text" name="id" size="93" /></td>
		<td width="32" align="center"><input type="image" src="images/search.gif" width="28" height="29" border="0" title="Поиск!" /></td>
	</tr>
</table>
</FIELDSET>
</form>

<hr />

<form action="adminstation.php" method="get">
<FIELDSET style="border: solid #666666 1px; padding: 10px;">
<LEGEND><b>Показать пользователей с  данным IP</b></LEGEND>
<input type="hidden" name="a" value="logip" />
<table width="100%" border="0">
	<tr>
		<td width="60"><strong>IP:</strong></td>
		<td><input class="inp" style="width: 99%;" type="text" name="ip" size="93" /></td>
		<td width="32" align="center"><input type="image" src="images/search.gif" width="28" height="29" border="0" title="Поиск!" /></td>
	</tr>
</table>
</FIELDSET>
</form>

<hr />

<?php

if($_GET[ip]) {

?>

<table class="tbl">
<tr>
	<th><strong>Дата</strong></th>
	<th><strong>IP</strong></th>
	<th><strong>ID</strong></th>
	<th><strong>Логин</strong></th>
</tr>
<?php

$idlist = "";

$sql	 = "SELECT * FROM logip WHERE ip = '".htmlspecialchars($_GET[ip], ENT_QUOTES, '')."' ORDER BY id DESC";
$rs		 = mysql_query($sql);
while($a = mysql_fetch_array($rs)) {

$sql2	= 'SELECT * FROM users WHERE id = '.$a['user_id'].' LIMIT 1';
$rs_u	= mysql_query($sql2);
$a2		= mysql_fetch_array($rs_u);

if(!substr_count($idlist, "|".$a['user_id']."|")) {

print "<tr>
	<td>".date("d.m.Y H:i:s", $a['date'])."</td>
	<td>".$a['ip']."</td>
	<td>".$a['user_id']."</td>
	<td><a href=\"?a=edit_user&id=".$a['user_id']."\">".$a2['login']."</a></td>
</tr>";

$idlist .= "|".$a['user_id']."|";

}

}

?>
</table>

<?php
} elseif($_GET[id]) {
?>

<table class="tbl">
<tr>
	<th width="50%"><strong>Дата</strong></th>
	<th><strong>IP</strong></th>
	<th><strong>Страна</strong></th>
</tr>
<?php
$sql	 = "SELECT * FROM logip WHERE user_id = ".intval($_GET[id])." ORDER BY id DESC";
$rs		 = mysql_query($sql);
while($a = mysql_fetch_array($rs)) {

$country = getCOUNTRY($a['ip']);

print "<tr>
	<td>".date("d.m.Y H:i:s", $a['date'])."</td>
	<td>".$a['ip']."</td>
	<td><img src=\"/images/flags/".$country.".gif\" width=\"18\" height=\"12\" border=\"0\" alt=\"".$country."\" title=\"".$country."\" /> ".$country."</td>
</tr>";
}

?>
</table>

<?php
}
?>