<?php
defined('ACCESS') or die();
if($_GET['action'] == "edit") {

	$cfgOnOff				= htmlspecialchars($_POST['cfgOnOff'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgOnOff.'" WHERE cfgname = "cfgOnOff" LIMIT 1');

	$adminmail				= htmlspecialchars($_POST['adminmail'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$adminmail.'" WHERE cfgname = "adminmail" LIMIT 1');

	$cfgPerfect				= htmlspecialchars($_POST['cfgPerfect'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPerfect.'" WHERE cfgname = "cfgPerfect" LIMIT 1');

	$cfgPEsid				= htmlspecialchars($_POST['cfgPEsid'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPEsid.'" WHERE cfgname = "cfgPEsid" LIMIT 1');

	$cfgPEkey				= htmlspecialchars($_POST['cfgPEkey'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPEkey.'" WHERE cfgname = "cfgPEkey" LIMIT 1');

	$cfgPAYEE_NAME			= htmlspecialchars($_POST['cfgPAYEE_NAME'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPAYEE_NAME.'" WHERE cfgname = "cfgPAYEE_NAME" LIMIT 1');

	$ALTERNATE_PHRASE_HASH	= trim(htmlspecialchars($_POST['ALTERNATE_PHRASE_HASH'], ENT_QUOTES, ''));
	mysql_query('UPDATE `settings` SET `data` = "'.$ALTERNATE_PHRASE_HASH.'" WHERE cfgname = "ALTERNATE_PHRASE_HASH" LIMIT 1');

	$cfgAutoPay				= htmlspecialchars($_POST['cfgAutoPay'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgAutoPay.'" WHERE cfgname = "cfgAutoPay" LIMIT 1');

	$cfgReInv				= htmlspecialchars($_POST['cfgReInv'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgReInv.'" WHERE cfgname = "cfgReInv" LIMIT 1');

	$cfgSSL					= htmlspecialchars($_POST['cfgSSL'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgSSL.'" WHERE cfgname = "cfgSSL" LIMIT 1');

	$cfgMailConf			= htmlspecialchars($_POST['cfgMailConf'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgMailConf.'" WHERE cfgname = "cfgMailConf" LIMIT 1');

	$cfgPMID				= htmlspecialchars($_POST['cfgPMID'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPMID.'" WHERE cfgname = "cfgPMID" LIMIT 1');

	$cfgPMpass				= htmlspecialchars($_POST['cfgPMpass'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPMpass.'" WHERE cfgname = "cfgPMpass" LIMIT 1');

	$cfgMinOut				= sprintf("%01.2f", $_POST['cfgMinOut']);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgMinOut.'" WHERE cfgname = "cfgMinOut" LIMIT 1');		$autoRegPlan				= intval($_POST['autoRegPlan']);	mysql_query('UPDATE `settings` SET `data` = "'.$autoRegPlan.'" WHERE cfgname = "autoRegPlan" LIMIT 1');			$autoRegPlanSum				= sprintf("%01.2f", $_POST['autoRegPlanSum']);	mysql_query('UPDATE `settings` SET `data` = "'.$autoRegPlanSum.'" WHERE cfgname = "autoRegPlanSum" LIMIT 1');
	$cfgMaxOut				= sprintf("%01.2f", $_POST['cfgMaxOut']);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgMaxOut.'" WHERE cfgname = "cfgMaxOut" LIMIT 1');

	$cfgCountOut			= intval($_POST['cfgCountOut']);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgCountOut.'" WHERE cfgname = "cfgCountOut" LIMIT 1');

	$cfgPercentOut			= sprintf("%01.2f", $_POST['cfgPercentOut']);
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPercentOut.'" WHERE cfgname = "cfgPercentOut" LIMIT 1');

	$cfgLang				= htmlspecialchars($_POST['cfgLang'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgLang.'" WHERE cfgname = "cfgLang" LIMIT 1');

	$cfgAutoPayPE			= htmlspecialchars($_POST['cfgAutoPayPE'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgAutoPayPE.'" WHERE cfgname = "cfgAutoPayPE" LIMIT 1');

	$cfgPEAcc				= htmlspecialchars($_POST['cfgPEAcc'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPEAcc.'" WHERE cfgname = "cfgPEAcc" LIMIT 1');

	$cfgPEidAPI				= htmlspecialchars($_POST['cfgPEidAPI'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPEidAPI.'" WHERE cfgname = "cfgPEidAPI" LIMIT 1');

	$cfgPEapiKey			= htmlspecialchars($_POST['cfgPEapiKey'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgPEapiKey.'" WHERE cfgname = "cfgPEapiKey" LIMIT 1');


	$h = intval($_POST['h']);
	$i = intval($_POST['i']);
	$d = intval($_POST['d']);
	$m = intval($_POST['m']);
	$ye = intval($_POST['ye']);

	$datestart				= mktime($h,$i,0,$m,$d,$ye);
	mysql_query('UPDATE `settings` SET `data` = "'.$datestart.'" WHERE cfgname = "datestart" LIMIT 1');

	$autopercent			= htmlspecialchars($_POST['autopercent'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$autopercent.'" WHERE cfgname = "autopercent" LIMIT 1');

	print '<p class="erok">������ ���������!</p>';

	$cfgOutAdminPercent = sprintf("%01.2f", str_replace(',', '.', $_POST['cfgOutAdminPercent']));

	if($cfgOutAdminPercent >= 0 && $cfgOutAdminPercent <= 100) {
		mysql_query('UPDATE `settings` SET `data` = "'.$cfgOutAdminPercent.'" WHERE cfgname = "cfgOutAdminPercent" LIMIT 1');
	} else {
		print '<p class="er">������� �������������� ������ ���� ���������� � ��������� �� 0 �� 100</p>';
	}

	$cfgInstant			= htmlspecialchars($_POST['cfgInstant'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgInstant.'" WHERE cfgname = "cfgInstant" LIMIT 1');

	$cfgTrans			= htmlspecialchars($_POST['cfgTrans'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgTrans.'" WHERE cfgname = "cfgTrans" LIMIT 1');

	$cfgTransPercent = sprintf("%01.2f", str_replace(',', '.', $_POST['cfgTransPercent']));

	if($cfgTransPercent >= 0 && $cfgTransPercent <= 100) {
		mysql_query('UPDATE `settings` SET `data` = "'.$cfgTransPercent.'" WHERE cfgname = "cfgTransPercent" LIMIT 1');
	} else {
		print '<p class="er">������� �������������� �� ����� ��������, ������ ���� ���������� � ��������� �� 0 �� 100</p>';
	}

	$AdminPMpurse			= htmlspecialchars($_POST['AdminPMpurse'], ENT_QUOTES, '');
	if($AdminPMpurse != $cfgPerfect) {
		mysql_query('UPDATE `settings` SET `data` = "'.$AdminPMpurse.'" WHERE cfgname = "AdminPMpurse" LIMIT 1');
	} elseif($AdminPMpurse) {
		print '<p class="er">��������� PerfectMoney �������, ������ ���������� �� �������� ������ �������</p>';
	}

}
$get_lis2		= "SELECT * FROM plans";$query_lis2	= mysql_query($get_lis2);
?>
<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<FIELDSET style="border: solid #666666 1px; padding: 10px;">
<LEGEND><b>��������� �������:</b></LEGEND>
<form action="?a=settings&action=edit" method="post">
<table align="center" width="612" border="0" cellpadding="3" cellspacing="0" style="border: solid #cccccc 1px;">
<tr bgcolor="#eeeeee">
	<td><b>������ �����</b>:</td>
	<td align="right"><label><input type="radio" name="cfgOnOff" value="on" <?php if(cfgSET('cfgOnOff') == "on") { print ' checked="checked"'; } ?> /> <font color="green">��������</font></label> / <label><input type="radio" name="cfgOnOff" value="off" <?php if(cfgSET('cfgOnOff') == "off") { print ' checked="checked"'; } ?> /> <font color="red">���������</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="�� ������ ������ ������ ��������, ��� ��������� ���� ��� �������������. � �� �� �����, ��� �������������� ���� ����� ��������� ��������." /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>E-mail ��������������</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="adminmail" size="70" maxlength="250" value="<?php print cfgSET('adminmail'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="E-mail �� ������� ����� ������������ ������ � ���������� �����, � ��� �� �� ����� ����� ����� ������������ ��� ������ �������������." /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>����������� ����� �� �����</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgMinOut" size="70" maxlength="250" value="<?php print cfgSET('cfgMinOut'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������� ����������� ����� �� ����� ������� �������������. �� ����������� ������������� ���� ���� 0.1" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>������������ ����� �� �����</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgMaxOut" size="70" maxlength="250" value="<?php print cfgSET('cfgMaxOut'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������� ������������ ����� �� ����� ������� �������������." /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>���-�� ��� ������ ������� � �����</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgCountOut" size="70" maxlength="250" value="<?php print cfgSET('cfgCountOut'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������� ���-�� ������ �� ����� ������� � ����� �������������. ���� ������� 0, ����� ���-�� ������ ����� ������������." /></td>
</tr>

<tr bgcolor="#dddddd">
	<td><b>������� ��� ������</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPercentOut" size="70" maxlength="250" value="<?php print cfgSET('cfgPercentOut'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� �� ������ ����������� �� ����� ������ ���� �������, ������� ���� ������� � ���� ����. �������� �������� �� 0.00 �� 99" /></td>
</tr><tr bgcolor="#eeeeee">	<td><b>�������� ���� ��� �����������</b>:</td>	<td align="right"><select name="autoRegPlan">	<option <?php if(cfgSET('autoRegPlan') == 0) { print 'selected';}?> value="0">�� ������ ����-�������</option>		<?php while($rowe = mysql_fetch_array($query_lis2)) {?>		<option <?php if($rowe['id'] == cfgSET('autoRegPlan')) { print 'selected';}?> value="<?php print $rowe['id'];?>"><?php print $rowe['name'].'|�� $'.$rowe['minsum'].' �� $'.$rowe['maxsum'].'|'.$rowe['percent'].'%';?></option>		<?php } ?>		</select></td>	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="ID ��������������� ��������� ����� ��� �����������" /></td></tr><tr bgcolor="#dddddd">	<td><b>����� ��������� ����� ��� �����������</b>:</td>	<td align="right"><input style="width: 295px;" type="text" name="autoRegPlanSum" size="70" maxlength="250" value="<?php print cfgSET('autoRegPlanSum'); ?>" /></td>	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="����� �������� � �������������� �������� ���� ��� �����������" /></td></tr>
<tr bgcolor="#eeeeee">
	<td><b>���� ������ �������</b>:</td>
	<td align="right">
		<select class="input" name="h" title="����">
			<option value="">��</option>
		<?php
		$datestart = cfgSET('datestart');
		for($i=0; $i<=24; $i++) {
			print '<option value="'.$i.'"';
			if(intval(date("H", $datestart)) == $i) { print ' selected'; }
			print '>'.$i.'</option>';
		}
		?>
		</select> :
		<select class="input" name="i" title="������">
			<option value="">MM</option>
		<?php
		for($i=0; $i<=60; $i++) {
			print '<option value="'.$i.'"';
			if(intval(date("i", $datestart)) == $i) { print ' selected'; }
			print '>'.$i.'</option>';
		}
		?>
		</select> - 
		<select class="input" name="d" title="����">
			<option value="">��</option>
		<?php
		for($i=0; $i<=31; $i++) {
			print '<option value="'.$i.'"';
			if(intval(date("d", $datestart)) == $i) { print ' selected'; }
			print '>'.$i.'</option>';
		}
		?>
		</select>.<select class="input" name="m" title="�����">
		<?php
			print '<option value="1"';
			if(intval(date("m", $datestart)) == 1) { print ' selected'; }
			print '>������</option>';

			print '<option value="2"';
			if(intval(date("m", $datestart)) == 2) { print ' selected'; }
			print '>�������</option>';

			print '<option value="3"';
			if(intval(date("m", $datestart)) == 3) { print ' selected'; }
			print '>����</option>';

			print '<option value="4"';
			if(intval(date("m", $datestart)) == 4) { print ' selected'; }
			print '>������</option>';

			print '<option value="5"';
			if(intval(date("m", $datestart)) == 5) { print ' selected'; }
			print '>���</option>';

			print '<option value="6"';
			if(intval(date("m", $datestart)) == 6) { print ' selected'; }
			print '>����</option>';

			print '<option value="7"';
			if(intval(date("m", $datestart)) == 7) { print ' selected'; }
			print '>����</option>';

			print '<option value="8"';
			if(intval(date("m", $datestart)) == 8) { print ' selected'; }
			print '>������</option>';

			print '<option value="9"';
			if(intval(date("m", $datestart)) == 9) { print ' selected'; }
			print '>��������</option>';

			print '<option value="10"';
			if(intval(date("m", $datestart)) == 10) { print ' selected'; }
			print '>�������</option>';

			print '<option value="11"';
			if(intval(date("m", $datestart)) == 11) { print ' selected'; }
			print '>������</option>';

			print '<option value="12"';
			if(intval(date("m", $datestart)) == 12) { print ' selected'; }
			print '>�������</option>';
		?>	
		</select>.<select class="input" name="ye" title="���">
			<option value="">����</option>
		<?php
		for($i=2012; $i<=date(Y); $i++) {
			print '<option value="'.$i.'"';
			if(intval(date("Y", $datestart)) == $i) { print ' selected'; }
			print '>'.$i.'</option>';
		}
		?>
		</select>
	</td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������� ���� ������ ������ �������. ������ ���� ����� ���������� � ����������, � ��� �� �� ����� ����������� �������� �� ������ ����" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>���� �� ���������</b>:</td>
	<td align="right"><label><input type="radio" name="cfgLang" value="ru" <?php if(cfgSET('cfgLang') == "ru") { print ' checked="checked"'; } ?> /> �������</label> / <label><input type="radio" name="cfgLang" value="en" <?php if(cfgSET('cfgLang') == "en") { print ' checked="checked"'; } ?> /> ����������</label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������� ��� �������� ����. � ������� ����� ����� ����������� ����, ���� ������������ ��� �� ������ ��������������." /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>���������� ���������</b>:</td>
	<td align="right"><label><input type="radio" name="autopercent" value="on" <?php if(cfgSET('autopercent') == "on") { print ' checked="checked"'; } ?> /> <font color="green">��������</font></label> / <label><input type="radio" name="autopercent" value="off" <?php if(cfgSET('autopercent') == "off") { print ' checked="checked"'; } ?> /> <font color="red">���������</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� �� ���������� �������� ������� � � ��������� �������, ��� ���������� ��������� ������������� ���������� ���������" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>����������������</b>:</td>
	<td align="right"><label><input type="radio" name="cfgReInv" value="on" <?php if(cfgSET('cfgReInv') == "on") { print ' checked="checked"'; } ?> /> <font color="green">��������</font></label> / <label><input type="radio" name="cfgReInv" value="off" <?php if(cfgSET('cfgReInv') == "off") { print ' checked="checked"'; } ?> /> <font color="red">���������</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������ ����� �������� ����������� ��������������� ���������� �������� �� ������" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>SSL</b>:</td>
	<td align="right"><label><input type="radio" name="cfgSSL" value="on" <?php if(cfgSET('cfgSSL') == "on") { print ' checked="checked"'; } ?> /> <font color="green">����������</font></label> / <label><input type="radio" name="cfgSSL" value="off" <?php if(cfgSET('cfgSSL') == "off") { print ' checked="checked"'; } ?> /> <font color="red">�� ����������</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� � ��� ���������� SSL, �� ������� ������ �����, ���� ����� �������������� ������������ �� ��������� https://, � ��� �� ��� ������� ����� ��������� �� ����������� ���������." /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>������������� ����������� �� e-mail</b>:</td>
	<td align="right"><label><input type="radio" name="cfgMailConf" value="on" <?php if(cfgSET('cfgMailConf') == "on") { print ' checked="checked"'; } ?> /> <font color="green">��������</font></label> / <label><input type="radio" name="cfgMailConf" value="off" <?php if(cfgSET('cfgMailConf') == "off") { print ' checked="checked"'; } ?> /> <font color="red">���������</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������ ����� ������������ ������������� � ����������� �� ��� ���, ���� �� ����� ������������ ����������� �� ������ ������������ �� e-mail" /></td>
</tr>
<tr bgcolor="#999999">
	<td height="30" colspan="3" align="center"><b>��������� ������ ������:</b></td>
</tr>
<tr bgcolor="#cccccc">
	<td height="25" colspan="3" align="center"><b style="color: #999999;">��������� PERFECTMONEY</b></td>
</tr>

<tr bgcolor="#dddddd">
	<td><b>PerfectMoney ����</b>:</td>
	<td align="right"><input class="input" style="width: 295px;" type="text" name="cfgPerfect" size="70" maxlength="250" value="<?php print cfgSET('cfgPerfect'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="����� ����� � ������� PerfectMoney. ���������� � ������� U (�� ������ � ID). ���� ������ ���� �������� ������, ������ ������� �� ����� �������������� � �������." /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>ALTERNATE_PHRASE_HASH</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="ALTERNATE_PHRASE_HASH" size="70" maxlength="250" value="<?php print cfgSET('ALTERNATE_PHRASE_HASH'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="MD5 ���, ��������� ����� ��� ��������� �������� ����� ������� PerfectMoney. � ���������� �������� PerfectMoney ���������� �������� ����: �������������� ������� ����� (Alternate Merchant Passphrase Hash) � ��������� ���. MD5 ��� �� �������� �����, ������ ������������� � ��� �� ����� �� ������: http://adminstation.ru/doc_perfectmoney/" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Store name</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPAYEE_NAME" size="70" maxlength="250" value="<?php print cfgSET('cfgPAYEE_NAME'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������ �������� ������������ ��� ��� �������� � ������� PerfectMoney." /></td>
</tr>
<tr bgcolor="#cccccc">
	<td height="25" colspan="3" align="center"><b style="color: #999999;">��������� PAYEER</b></td>
</tr>

<tr bgcolor="#dddddd">
	<td><b>ID ��������</b>:</td>
	<td align="right"><input class="input" style="width: 295px;" type="text" name="cfgPEsid" size="70" maxlength="250" value="<?php print cfgSET('cfgPEsid'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������� ��� ID �������� � ������� payeer.com" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>��������� ���</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPEkey" size="70" maxlength="250" value="<?php print cfgSET('cfgPEkey'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="��������� ���� � ������� payeer.com (��� ��������. �� ������� � master key)" /></td>
</tr>


<tr bgcolor="#cccccc">
	<td height="25" colspan="3" align="center"><b style="color: #999999;">������� ������� ����� ��������������</b></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>������� �������</b>:</td>
	<td align="right"><label><input type="radio" name="cfgTrans" value="on" <?php if(cfgSET('cfgTrans') == "on") { print ' checked="checked"'; } ?> /> <font color="green">��������</font></label> / <label><input type="radio" name="cfgTrans" value="off" <?php if(cfgSET('cfgTrans') == "off") { print ' checked="checked"'; } ?> /> <font color="red">���������</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������ ����� ��������� ������������� ���������� ������ ���� ����� ������ �������." /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>������� �� ��������</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgTransPercent" size="70" maxlength="250" value="<?php print cfgSET('cfgTransPercent'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������� �������������� �� ����� �������� ����� ����� ��������������. �������� �� 0 �� 99. ������ ������� ����� ���������� � ������ ��������." /></td>
</tr>

<tr bgcolor="#999999">
	<td height="30" colspan="3" align="center"><b>��������� �������������� ������ ( API ):</b></td>
</tr>
<tr bgcolor="#cccccc">
	<td height="25" colspan="3" align="center"><b style="color: #999999;">��������� PERFECTMONEY</b></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>����������� PerfectMoney</b>:</td>
	<td align="right"><label><input type="radio" name="cfgAutoPay" value="on" <?php if(cfgSET('cfgAutoPay') == "on") { print ' checked="checked"'; } ?> /> <font color="green">��������</font></label> / <label><input type="radio" name="cfgAutoPay" value="off" <?php if(cfgSET('cfgAutoPay') == "off") { print ' checked="checked"'; } ?> /> <font color="red">���������</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� �� �������� �����������, �������� ����� ������������ ������������� ������������� ����� ������ ������. ���� ���������, �� ��� ������ ����� ���������� �� �������� ������������� � ����� �������� � �������: �����������" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>��� ID � PerfectMoney</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPMID" size="70" maxlength="250" value="<?php print cfgSET('cfgPMID'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="��� ID � ��������� ������� PerfectMoney. ��������� ��� ����������� �� API." /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>��� ������ � PerfectMoney</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPMpass" size="70" maxlength="250" value="<?php print cfgSET('cfgPMpass'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="��� ������ ����� � ��������� ������� PerfectMoney. ��������� ��� ����������� �� API. ���� �� �� ����������� ����������, ����������� �� ��������� ������ ����" /></td>
</tr>

<tr bgcolor="#cccccc">
	<td height="25" colspan="3" align="center"><b style="color: #999999;">��������� PAYEER.com</b></td>
</tr>

<tr bgcolor="#dddddd">
	<td><b>����������� PAYEER.com</b>:</td>
	<td align="right"><label><input type="radio" name="cfgAutoPayPE" value="on" <?php if(cfgSET('cfgAutoPayPE') == "on") { print ' checked="checked"'; } ?> /> <font color="green">��������</font></label> / <label><input type="radio" name="cfgAutoPayPE" value="off" <?php if(cfgSET('cfgAutoPayPE') == "off") { print ' checked="checked"'; } ?> /> <font color="red">���������</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="���� �� �������� �����������, �������� ����� ������������ ������������� ������������� ����� ������ ������. ���� ���������, �� ��� ������ ����� ���������� �� �������� ������������� � ����� �������� � �������: �����������" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>��� ����� ����� � Payeer</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPEAcc" size="70" maxlength="250" value="<?php print cfgSET('cfgPEAcc'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������� ��� ����� ����� � ������� PAYEER.com. ��������� ��� ����������� �� API." /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>��� ID ��������</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPEidAPI" size="70" maxlength="250" value="<?php print cfgSET('cfgPEidAPI'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������� ��� ID �������� � API payeer.com" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>��������� API ����</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPEapiKey" size="70" maxlength="250" value="<?php print cfgSET('cfgPEapiKey'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������� ��� ��������� ����, �������� �� ������� � ���������� API � ��������" /></td>
</tr>

<tr bgcolor="#999999">
	<td height="30" colspan="3" align="center"><b>��������� ������������ �� ��������� ������� PerfectMoney:</b></td>
</tr>

<tr bgcolor="#dddddd">
	<td><b>������� �� ����� ���������� - ������</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgOutAdminPercent" size="70" maxlength="6" value="<?php print cfgSET('cfgOutAdminPercent'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="�������, ����� ������� �� ����� ���������� ���������� �� ����� ����� ��������������. ���� �� �� ������ ���������� �������, �������� �������� 0.00. ��������! ��� ��������������� �������� �� ���� ��������������, � ��� ������ ���� ������� ��������� API" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>��������� PerfectMoney ����</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="AdminPMpurse" size="70" maxlength="8" value="<?php print cfgSET('AdminPMpurse'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="������� ����� ����� PerfectMoney ���� �������������� �������. ��������! ����� ����� ������ ���������� �� ������ ����� ������ ������� � ���������� � ������� U" /></td>
</tr>
</table>
<table align="center" width="624" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="���������!" /></td>
	</tr>
</table>
</form>
</FIELDSET>