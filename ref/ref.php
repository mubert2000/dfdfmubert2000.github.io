<?php
defined('ACCESS') or die();
if($login) {

	print $body;

	$get_user_info = mysql_query("SELECT ref, ref_money FROM users WHERE id = ".$user_id." LIMIT 1");
	$row = mysql_fetch_array($get_user_info);
	 $ref			= $row['ref'];
	 $ref_money		= $row['ref_money'];	

	if($ref) {

		$get_user_info2	= mysql_query("SELECT login FROM users WHERE id = ".$ref." LIMIT 1");
		$row2 			= mysql_fetch_array($get_user_info2);
		 $uplogin	= $row2['login'];

		print "<p>Your Upline: <b>".$uplogin."</b>;</p>";

	}
?>
<FIELDSET style="border: solid #666666 1px; margin-bottom: 5px;">
<LEGEND><b>Your affiliate link:</b></LEGEND>
<table width="100%">
	<tr align="center">
		<td><input type="text" name="refurl" style="width: 100%;" value="http://<?php print $cfgURL; ?>/?ref=<?php print $login; ?>" /></td>
	</tr>
</table>
</FIELDSET>

<hr color="#cccccc" size="2">
<b>Your referrals:</b>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#eeeeee">
<tr align="center" bgcolor="#ccffcc" style="background:URL(/images/title_bg.gif) repeat-x top left;">
	<td width="50" style="padding: 3px;"><b>#</b></td>
	<td align="left"><b>Login:</b></td>
	<td width="150"><b>Income $:</b></td>
</tr>
<?php

function PrintRef($refid, $i, $c) {

	$sql	= 'SELECT id, login, ref_money FROM users WHERE ref = '.$refid;
	$rs		= mysql_query($sql);
		$n 	= 1;
		while($a = mysql_fetch_array($rs)) {

			if($i == 1) {

				print "<tr bgcolor=\"#ffffff\" align=\"center\"><td>".$n."</td><td align=\"left\">".$a['login']."</font></td><td>".$a['ref_money']."</td></tr>";

				if($i <= $c) {
					PrintRef($a['id'], intval($i + 1), $c);
				}

			} else {

				print "<tr bgcolor=\"#ffffff\" align=\"center\"><td></td><td align=\"left\" style=\"padding-left: ".$i."0px;\"><font color=\"#999999\">» ".$a['login']."</font></td><td>-</td></tr>";

				if($i <= $c) {
					PrintRef($a['id'], intval($i + 1), $c);
				}

			}
		$n++;
		}
		
}

	$countlvl = mysql_num_rows(mysql_query("SELECT * FROM reflevels"));

	PrintRef($user_id, 1, $countlvl);

	$sql	= 'SELECT login, ref_money FROM users WHERE ref = '.$user_id;
	$rs		= mysql_query($sql);

	if(mysql_num_rows($rs)) {

		$m = 0;
		while($a = mysql_fetch_array($rs)) {
			$m = $m + $a['ref_money'];
		}

		print "<tr align=\"center\" bgcolor=\"#dddddd\"><td align=\"right\" colspan=\"2\" style=\"padding: 3px;\"><b>Total:</b></td><td><b>".sprintf("%01.2f", $m)."</b></td></tr>";

	} else {
		print "<tr bgcolor=\"#ffffff\"><td colspan=\"3\" align=\"center\">You have not invited anyone!</td></tr>";
	}

print '</table>';

} else {
	print '<p class="er">You must login to access this page</p>';;
}
?>