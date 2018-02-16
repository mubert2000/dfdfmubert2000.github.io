<?php
defined('ACCESS') or die();
?>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#dddddd">
<tr align="center" bgcolor="#dddddd">
	<td><b>Дата:</b></td>
	<td><b>Сумма:</b></td>
</tr>
<?php

	$sql	= 'SELECT * FROM stat WHERE user_id = '.$user_id.' order by id DESC';
	$rs		= mysql_query($sql);
	if(mysql_num_rows($rs)) {

		while($a = mysql_fetch_array($rs)) {
				print "<tr bgcolor=\"#ffffff\" align=\"center\">
				<td align=\"center\">".date("d.m.Y H:i", $a['date'])."</td>
				<td>".$a['sum']."</td>
				</tr>";
		}

	} else {
		print "<tr bgcolor=\"#ffffff\"><td colspan=\"3\" align=\"center\">Нет данных!</td></tr>";
	}
print "</table>";