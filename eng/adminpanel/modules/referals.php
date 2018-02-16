<?php
defined('ACCESS') or die();

function PrintRef($refid, $i, $c) {

	$sql	= 'SELECT id, login, ref_money, reg_time FROM users WHERE ref = '.$refid;
	$rs		= mysql_query($sql);
		$n 	= 1;
		while($a = mysql_fetch_array($rs)) {

			if($i == 1) {

				print "<tr><td>".$n."</td><td align=\"left\">".$a['login']."</font></td><td>".date("d.m.Y H:i", $a['reg_time'])."</td><td>".$a['ref_money']."</td></tr>";

				if($i <= $c) {
					PrintRef($a['id'], intval($i + 1), $c);
				}

			} else {

				print "<tr><td></td><td align=\"left\" style=\"padding-left: ".$i."0px;\"><font color=\"#999999\">» ".$a['login']."</font></td><td>".date("d.m.Y H:i", $a['reg_time'])."</td><td>-</td></tr>";

				if($i <= $c) {
					PrintRef($a['id'], intval($i + 1), $c);
				}

			}
		$n++;
		}
		
}
?>
<table class="tbl">
<tr>
	<th width="50"><b>#</b></th>
	<th class="left"><b>Login:</b></th>
	<th width="110"><b>Зарегистрирован:</b></th>
	<th width="150"><b>Доход $:</b></th>
</tr>
<?php

	$countlvl = mysql_num_rows(mysql_query("SELECT * FROM reflevels"));

	PrintRef(intval($_GET['id']), 1, $countlvl);

	$sql	= 'SELECT login, ref_money FROM users WHERE ref = '.intval($_GET['id']);
	$rs		= mysql_query($sql);

	if(mysql_num_rows($rs)) {

		$m = 0;
		while($a = mysql_fetch_array($rs)) {
			$m = $m + $a['ref_money'];
		}

		print "<tr align=\"center\" bgcolor=\"#dddddd\"><td align=\"right\" colspan=\"3\" style=\"padding: 3px;\"><b>Всего:</b></td><td><b>".sprintf("%01.2f", $m)."</b></td></tr>";

	} else {
		print "<tr bgcolor=\"#ffffff\"><td colspan=\"4\" align=\"center\">Пользователь никого не пригласил!</td></tr>";
	}

print '</table>';
?>