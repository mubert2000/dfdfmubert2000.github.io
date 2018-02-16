<?php
defined('ACCESS') or die();

$ip			= getip();

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
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#dddddd">
<tr align="center" bgcolor="#dddddd">
	<td><b>Дата:</b></td>
	<td><b>IP:</b></td>
	<td><b>Страна:</b></td>
</tr>
<?php

	$sql	= 'SELECT * FROM logip WHERE user_id = '.$user_id.' order by id DESC';
	$rs		= mysql_query($sql);
	if(mysql_num_rows($rs)) {

		while($a = mysql_fetch_array($rs)) {
				$form_arr	= explode(',', $a['ip']);
				$ip			= trim($form_arr[0]);
				$country = getCOUNTRY($ip);
				print "<tr bgcolor=\"#ffffff\" align=\"center\">
				<td align=\"center\">".date("d.m.Y H:i", $a['date'])."</td>
				<td>".$a['ip']."</td>
				<td><img src=\"/images/flags/".$country.".gif\" width=\"18\" height=\"12\" border=\"0\" alt=\"".$country."\" title=\"".$country."\" /> ".$country."</td>
				</tr>";
		}

	} else {
		print "<tr bgcolor=\"#ffffff\"><td colspan=\"3\" align=\"center\">Нет данных!</td></tr>";
	}
print "</table>";