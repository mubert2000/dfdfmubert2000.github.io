<?php
defined('ACCESS') or die();
?>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#cccccc" style="border: solid #cccccc 1px; background:URL(/images/title_bg.gif) repeat-x top left;background-color: #cccccc;">
<tr align="center">
	<td><b>Date:</b></td>
	<td><b>The amount:</b></td>
</tr>
<?php

	$sql	= 'SELECT * FROM output WHERE login = "'.$login.'" order by id DESC';
	$rs		= mysql_query($sql);
	if(mysql_num_rows($rs)) {

		while($a = mysql_fetch_array($rs)) {
				print "<tr bgcolor=\"#ffffff\" align=\"center\">
				<td align=\"left\">".date("d.m.Y H:i", $a['date'])."</td>
				<td>".$a['sum']."</td>
				</tr>";
		}

	} else {
		print "<tr bgcolor=\"#ffffff\"><td colspan=\"3\" align=\"center\">No data!</td></tr>";
	}
print "</table>";