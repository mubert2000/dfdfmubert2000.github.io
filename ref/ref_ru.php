<?php
if($login) {
defined('ACCESS') or die();
	print $body;

	$get_user_info = mysql_query("SELECT ref, ref_money FROM users WHERE id = ".$user_id." LIMIT 1");
	$row = mysql_fetch_array($get_user_info);
	 $ref			= $row['ref'];
	 $ref_money		= $row['ref_money'];	

	if($ref) {

		$get_user_info2	= mysql_query("SELECT login FROM users WHERE id = ".$ref." LIMIT 1");
		$row2 			= mysql_fetch_array($get_user_info2);
		 $uplogin	= $row2['login'];
		
		$get_user_info3	= mysql_query("SELECT icq FROM users WHERE id = ".$ref." LIMIT 1");
		$row3 			= mysql_fetch_array($get_user_info3);
		 $upicq	= $row3['icq'];
		$get_user_info4	= mysql_query("SELECT skype FROM users WHERE id = ".$ref." LIMIT 1");
		$row4 			= mysql_fetch_array($get_user_info4);
		 $upskype	= $row4['skype'];
		 

			print "<p>Вас пригласил: <b>".$uplogin." </b> Вы принесли ему: <b>$".$ref_money."</b></p>";}
		if($upicq) {
			print " <p>ICQ Куратора: ".$upicq."</p>";}
        if($upskype) {
			print "<p>Skype Куратора:  ".$upskype."</p>";}
	
?>

<LEGEND><b>Ваша партнёрская ссылка:</b></LEGEND>
<table width="100%">
	<tr align="center">
		<td><input type="text" name="refurl" style="width: 100%;" value="http://<?php print $cfgURL; ?>/?ref=<?php print $login; ?>" /></td>
	</tr>
</table>


<hr color="#cccccc" size="2">
<b>Приглашенные вами рефералы:</b>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#eeeeee">
<tr align="center" bgcolor="#dddddd" >
	<td width="50" style="padding: 3px;"><b>#</b></td>
	<td align="left"><b>Login:</b></td>
	<td align="left"><b>ICQ UIN:</b></td>
	<td align="left"><b>Skype:</b></td>
	<td width="150"><b>Доход $:</b></td>
</tr>
<?php

function PrintRef($refid, $i, $c) {

	$sql	= 'SELECT id, login,icq,skype, ref_money FROM users WHERE ref = '.$refid;
	$rs		= mysql_query($sql);
		$n 	= 1;
		while($a = mysql_fetch_array($rs)) {

			if($i == 1) {

				print "<tr bgcolor=\"#ffffff\" align=\"center\"><td>".$n."</td><td align=\"left\">".$a['login']."</font></td><td align=\"left\">".$a['icq']."</font></td><td align=\"left\">".$a['skype']."</font></td><td>".$a['ref_money']."</td></tr>";

				if($i <= $c) {
					PrintRef($a['id'], intval($i + 1), $c);
				}

			} else {

				print "<tr bgcolor=\"#ffffff\" align=\"center\"><td></td><td align=\"left\" style=\"padding-left: ".$i."0px;\"><font color=\"#999999\">» ".$a['login']."</font></td><td>".$a['icq']."</td><td align=\"left\">".$a['skype']."</td><td>".$a['ref_money']."</td></tr>";

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

		print "<tr align=\"center\" bgcolor=\"#dddddd\"><td><td></td></td><td align=\"right\" colspan=\"2\" style=\"padding: 3px;\"><b>Всего:</b></td><td><b>".sprintf("%01.2f", $m)."</b></td></tr>";

	} else {
		print "<tr bgcolor=\"#ffffff\"><td colspan=\"3\" align=\"center\">Вы пока никого не пригласили!</td></tr>";
	}

print '</table>';
print '';
} else {
	print '<p class="er">Вам необходимо авторизироваться для доступа к данной странице</p>';;
}
?>