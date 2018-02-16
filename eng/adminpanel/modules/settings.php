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

	print '<p class="erok">Данные сохранены!</p>';

	$cfgOutAdminPercent = sprintf("%01.2f", str_replace(',', '.', $_POST['cfgOutAdminPercent']));

	if($cfgOutAdminPercent >= 0 && $cfgOutAdminPercent <= 100) {
		mysql_query('UPDATE `settings` SET `data` = "'.$cfgOutAdminPercent.'" WHERE cfgname = "cfgOutAdminPercent" LIMIT 1');
	} else {
		print '<p class="er">Процент администратору должен быть установлен в диапазоне от 0 до 100</p>';
	}

	$cfgInstant			= htmlspecialchars($_POST['cfgInstant'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgInstant.'" WHERE cfgname = "cfgInstant" LIMIT 1');

	$cfgTrans			= htmlspecialchars($_POST['cfgTrans'], ENT_QUOTES, '');
	mysql_query('UPDATE `settings` SET `data` = "'.$cfgTrans.'" WHERE cfgname = "cfgTrans" LIMIT 1');

	$cfgTransPercent = sprintf("%01.2f", str_replace(',', '.', $_POST['cfgTransPercent']));

	if($cfgTransPercent >= 0 && $cfgTransPercent <= 100) {
		mysql_query('UPDATE `settings` SET `data` = "'.$cfgTransPercent.'" WHERE cfgname = "cfgTransPercent" LIMIT 1');
	} else {
		print '<p class="er">Процент администратору от суммы перевода, должен быть установлен в диапазоне от 0 до 100</p>';
	}

	$AdminPMpurse			= htmlspecialchars($_POST['AdminPMpurse'], ENT_QUOTES, '');
	if($AdminPMpurse != $cfgPerfect) {
		mysql_query('UPDATE `settings` SET `data` = "'.$AdminPMpurse.'" WHERE cfgname = "AdminPMpurse" LIMIT 1');
	} elseif($AdminPMpurse) {
		print '<p class="er">Админский PerfectMoney кошелек, должен отличаться от кошелька приема средств</p>';
	}

}
$get_lis2		= "SELECT * FROM plans";$query_lis2	= mysql_query($get_lis2);
?>
<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<FIELDSET style="border: solid #666666 1px; padding: 10px;">
<LEGEND><b>НАСТРОЙКИ ПРОЕКТА:</b></LEGEND>
<form action="?a=settings&action=edit" method="post">
<table align="center" width="612" border="0" cellpadding="3" cellspacing="0" style="border: solid #cccccc 1px;">
<tr bgcolor="#eeeeee">
	<td><b>Работа сайта</b>:</td>
	<td align="right"><label><input type="radio" name="cfgOnOff" value="on" <?php if(cfgSET('cfgOnOff') == "on") { print ' checked="checked"'; } ?> /> <font color="green">Включить</font></label> / <label><input type="radio" name="cfgOnOff" value="off" <?php if(cfgSET('cfgOnOff') == "off") { print ' checked="checked"'; } ?> /> <font color="red">ВЫключить</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Вы можете данной опцией включить, или выключить сайт для пользователей. В то же время, для администратора сайт будет полностью доступен." /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>E-mail администратора</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="adminmail" size="70" maxlength="250" value="<?php print cfgSET('adminmail'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="E-mail на который будут отправляться письма с контактной формы, а так же от этого имени будут отправляться все письма пользователям." /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Минимальная сумма на вывод</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgMinOut" size="70" maxlength="250" value="<?php print cfgSET('cfgMinOut'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Укажите минимальную сумму на вывод средств пользователем. Не рекомендуем устанавливать цену ниже 0.1" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Максимальная сумма на вывод</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgMaxOut" size="70" maxlength="250" value="<?php print cfgSET('cfgMaxOut'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Укажите МАКСИМАЛЬНУЮ сумму на вывод средств пользователем." /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Кол-во раз вывода средств в сутки</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgCountOut" size="70" maxlength="250" value="<?php print cfgSET('cfgCountOut'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Укажите кол-во заявок на вывод средств в сутки пользователем. Если указать 0, тогда кол-во заявок будет неограничено." /></td>
</tr>

<tr bgcolor="#dddddd">
	<td><b>Процент при выводе</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPercentOut" size="70" maxlength="250" value="<?php print cfgSET('cfgPercentOut'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Если вы хотите высчитывать от суммы вывода свой процент, укажите этот процент в этом поле. Диапазон процента от 0.00 до 99" /></td>
</tr><tr bgcolor="#eeeeee">	<td><b>Тарифный план при регистрации</b>:</td>	<td align="right"><select name="autoRegPlan">	<option <?php if(cfgSET('autoRegPlan') == 0) { print 'selected';}?> value="0">Не делать авто-депозит</option>		<?php while($rowe = mysql_fetch_array($query_lis2)) {?>		<option <?php if($rowe['id'] == cfgSET('autoRegPlan')) { print 'selected';}?> value="<?php print $rowe['id'];?>"><?php print $rowe['name'].'|от $'.$rowe['minsum'].' до $'.$rowe['maxsum'].'|'.$rowe['percent'].'%';?></option>		<?php } ?>		</select></td>	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="ID автоматического тарифного плана при регистрации" /></td></tr><tr bgcolor="#dddddd">	<td><b>Сумма тарифного плана при регистрации</b>:</td>	<td align="right"><input style="width: 295px;" type="text" name="autoRegPlanSum" size="70" maxlength="250" value="<?php print cfgSET('autoRegPlanSum'); ?>" /></td>	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Сумма депозита в автоматический тарифный план при регистрации" /></td></tr>
<tr bgcolor="#eeeeee">
	<td><b>Дата старта проекта</b>:</td>
	<td align="right">
		<select class="input" name="h" title="Часы">
			<option value="">ЧЧ</option>
		<?php
		$datestart = cfgSET('datestart');
		for($i=0; $i<=24; $i++) {
			print '<option value="'.$i.'"';
			if(intval(date("H", $datestart)) == $i) { print ' selected'; }
			print '>'.$i.'</option>';
		}
		?>
		</select> :
		<select class="input" name="i" title="Минуты">
			<option value="">MM</option>
		<?php
		for($i=0; $i<=60; $i++) {
			print '<option value="'.$i.'"';
			if(intval(date("i", $datestart)) == $i) { print ' selected'; }
			print '>'.$i.'</option>';
		}
		?>
		</select> - 
		<select class="input" name="d" title="День">
			<option value="">ДД</option>
		<?php
		for($i=0; $i<=31; $i++) {
			print '<option value="'.$i.'"';
			if(intval(date("d", $datestart)) == $i) { print ' selected'; }
			print '>'.$i.'</option>';
		}
		?>
		</select>.<select class="input" name="m" title="Месяц">
		<?php
			print '<option value="1"';
			if(intval(date("m", $datestart)) == 1) { print ' selected'; }
			print '>Январь</option>';

			print '<option value="2"';
			if(intval(date("m", $datestart)) == 2) { print ' selected'; }
			print '>Февраль</option>';

			print '<option value="3"';
			if(intval(date("m", $datestart)) == 3) { print ' selected'; }
			print '>Март</option>';

			print '<option value="4"';
			if(intval(date("m", $datestart)) == 4) { print ' selected'; }
			print '>Апрель</option>';

			print '<option value="5"';
			if(intval(date("m", $datestart)) == 5) { print ' selected'; }
			print '>Май</option>';

			print '<option value="6"';
			if(intval(date("m", $datestart)) == 6) { print ' selected'; }
			print '>Июнь</option>';

			print '<option value="7"';
			if(intval(date("m", $datestart)) == 7) { print ' selected'; }
			print '>Июль</option>';

			print '<option value="8"';
			if(intval(date("m", $datestart)) == 8) { print ' selected'; }
			print '>Август</option>';

			print '<option value="9"';
			if(intval(date("m", $datestart)) == 9) { print ' selected'; }
			print '>Сентябрь</option>';

			print '<option value="10"';
			if(intval(date("m", $datestart)) == 10) { print ' selected'; }
			print '>Октябрь</option>';

			print '<option value="11"';
			if(intval(date("m", $datestart)) == 11) { print ' selected'; }
			print '>Ноябрь</option>';

			print '<option value="12"';
			if(intval(date("m", $datestart)) == 12) { print ' selected'; }
			print '>Декабрь</option>';
		?>	
		</select>.<select class="input" name="ye" title="Год">
			<option value="">ГГГГ</option>
		<?php
		for($i=2012; $i<=date(Y); $i++) {
			print '<option value="'.$i.'"';
			if(intval(date("Y", $datestart)) == $i) { print ' selected'; }
			print '>'.$i.'</option>';
		}
		?>
		</select>
	</td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Укажите дату старта вашего проекта. Данная дата будет выводиться в статистике, а так же не будут начисляться проценты до начала даты" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Язык по умолчанию</b>:</td>
	<td align="right"><label><input type="radio" name="cfgLang" value="ru" <?php if(cfgSET('cfgLang') == "ru") { print ' checked="checked"'; } ?> /> Русский</label> / <label><input type="radio" name="cfgLang" value="en" <?php if(cfgSET('cfgLang') == "en") { print ' checked="checked"'; } ?> /> Английский</label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Укажите ваш основной язык. С данного языка будет открываться сайт, пока пользователь его не сменит самостоятельно." /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Начисление процентов</b>:</td>
	<td align="right"><label><input type="radio" name="autopercent" value="on" <?php if(cfgSET('autopercent') == "on") { print ' checked="checked"'; } ?> /> <font color="green">Включить</font></label> / <label><input type="radio" name="autopercent" value="off" <?php if(cfgSET('autopercent') == "off") { print ' checked="checked"'; } ?> /> <font color="red">ВЫключить</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Если вы начисляете проценты вручную и в свободном графике, вам необходимо отключить автоматичское начисление процентов" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Реинвестирование</b>:</td>
	<td align="right"><label><input type="radio" name="cfgReInv" value="on" <?php if(cfgSET('cfgReInv') == "on") { print ' checked="checked"'; } ?> /> <font color="green">Включить</font></label> / <label><input type="radio" name="cfgReInv" value="off" <?php if(cfgSET('cfgReInv') == "off") { print ' checked="checked"'; } ?> /> <font color="red">ВЫключить</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Данная опция включает возможность реинвестировать полученные проценты от вклада" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>SSL</b>:</td>
	<td align="right"><label><input type="radio" name="cfgSSL" value="on" <?php if(cfgSET('cfgSSL') == "on") { print ' checked="checked"'; } ?> /> <font color="green">Установлен</font></label> / <label><input type="radio" name="cfgSSL" value="off" <?php if(cfgSET('cfgSSL') == "off") { print ' checked="checked"'; } ?> /> <font color="red">Не установлен</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Если у вас установлен SSL, то включая данную опцию, сайт будет перенаправлять пользователя по протоколу https://, а так же все платежи будут проходить по защищенному протоколу." /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Подтверждение регистрации по e-mail</b>:</td>
	<td align="right"><label><input type="radio" name="cfgMailConf" value="on" <?php if(cfgSET('cfgMailConf') == "on") { print ' checked="checked"'; } ?> /> <font color="green">Включить</font></label> / <label><input type="radio" name="cfgMailConf" value="off" <?php if(cfgSET('cfgMailConf') == "off") { print ' checked="checked"'; } ?> /> <font color="red">ВЫключить</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Данная опция ограничивает пользователей в авторизации до тех пор, пока не будет подтверждена регистрация по ссылке отправленной на e-mail" /></td>
</tr>
<tr bgcolor="#999999">
	<td height="30" colspan="3" align="center"><b>НАСТРОЙКА ПРИЕМА ОПЛАТЫ:</b></td>
</tr>
<tr bgcolor="#cccccc">
	<td height="25" colspan="3" align="center"><b style="color: #999999;">НАСТРОЙКА PERFECTMONEY</b></td>
</tr>

<tr bgcolor="#dddddd">
	<td><b>PerfectMoney счет</b>:</td>
	<td align="right"><input class="input" style="width: 295px;" type="text" name="cfgPerfect" size="70" maxlength="250" value="<?php print cfgSET('cfgPerfect'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Номер счета в системе PerfectMoney. Начинается с символа U (не путать с ID). Если данное поле оставить пустым, данная система не будет использоваться в проекте." /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>ALTERNATE_PHRASE_HASH</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="ALTERNATE_PHRASE_HASH" size="70" maxlength="250" value="<?php print cfgSET('ALTERNATE_PHRASE_HASH'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="MD5 хеш, ключевого слова для настройки платежей через систему PerfectMoney. В настройках аккаунта PerfectMoney придумайте значение поля: Альтернативная кодовая фраза (Alternate Merchant Passphrase Hash) и сохраните его. MD5 хеш от кодового слова, можете сгенерировать у нас на сайте по адресу: http://adminstation.ru/doc_perfectmoney/" /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Store name</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPAYEE_NAME" size="70" maxlength="250" value="<?php print cfgSET('cfgPAYEE_NAME'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Данное значение используется как имя магазина в системе PerfectMoney." /></td>
</tr>
<tr bgcolor="#cccccc">
	<td height="25" colspan="3" align="center"><b style="color: #999999;">НАСТРОЙКА PAYEER</b></td>
</tr>

<tr bgcolor="#dddddd">
	<td><b>ID магазина</b>:</td>
	<td align="right"><input class="input" style="width: 295px;" type="text" name="cfgPEsid" size="70" maxlength="250" value="<?php print cfgSET('cfgPEsid'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Введите ваш ID магазина в системе payeer.com" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Секретный код</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPEkey" size="70" maxlength="250" value="<?php print cfgSET('cfgPEkey'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Секретный ключ в системе payeer.com (Для магазина. Не путайте с master key)" /></td>
</tr>


<tr bgcolor="#cccccc">
	<td height="25" colspan="3" align="center"><b style="color: #999999;">ПЕРЕВОД СРЕДСТВ МЕЖДУ ПОЛЬЗОВАТЕЛЯМИ</b></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Перевод средств</b>:</td>
	<td align="right"><label><input type="radio" name="cfgTrans" value="on" <?php if(cfgSET('cfgTrans') == "on") { print ' checked="checked"'; } ?> /> <font color="green">Включить</font></label> / <label><input type="radio" name="cfgTrans" value="off" <?php if(cfgSET('cfgTrans') == "off") { print ' checked="checked"'; } ?> /> <font color="red">ВЫключить</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Данная опция позволяет пользователям переводить деньги друг другу внутри системы." /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Процент от перевода</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgTransPercent" size="70" maxlength="250" value="<?php print cfgSET('cfgTransPercent'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Процент администратору от суммы перевода денег между пользователями. Значение от 0 до 99. Данный процент будет суммирован с суммой перевода." /></td>
</tr>

<tr bgcolor="#999999">
	<td height="30" colspan="3" align="center"><b>НАСТРОЙКА АВТОМАТИЧЕСКИХ ВЫПЛАТ ( API ):</b></td>
</tr>
<tr bgcolor="#cccccc">
	<td height="25" colspan="3" align="center"><b style="color: #999999;">НАСТРОЙКА PERFECTMONEY</b></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Автовыплаты PerfectMoney</b>:</td>
	<td align="right"><label><input type="radio" name="cfgAutoPay" value="on" <?php if(cfgSET('cfgAutoPay') == "on") { print ' checked="checked"'; } ?> /> <font color="green">Включить</font></label> / <label><input type="radio" name="cfgAutoPay" value="off" <?php if(cfgSET('cfgAutoPay') == "off") { print ' checked="checked"'; } ?> /> <font color="red">ВЫключить</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Если вы включите автовыплаты, средства будут направляться автоматически пользователям после подачи заявки. Если отключите, то все заявки будут направлены на проверку администрации и будут доступны в разделе: Бухгалтерия" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Ваш ID в PerfectMoney</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPMID" size="70" maxlength="250" value="<?php print cfgSET('cfgPMID'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Ваш ID в платежной системе PerfectMoney. Необходим для авторизации по API." /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Ваш пароль в PerfectMoney</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPMpass" size="70" maxlength="250" value="<?php print cfgSET('cfgPMpass'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Ваш пароль входа в платежной системе PerfectMoney. Необходим для авторизации по API. Если вы не используете автовыплат, рекомендуем не заполнять данное поле" /></td>
</tr>

<tr bgcolor="#cccccc">
	<td height="25" colspan="3" align="center"><b style="color: #999999;">НАСТРОЙКА PAYEER.com</b></td>
</tr>

<tr bgcolor="#dddddd">
	<td><b>Автовыплаты PAYEER.com</b>:</td>
	<td align="right"><label><input type="radio" name="cfgAutoPayPE" value="on" <?php if(cfgSET('cfgAutoPayPE') == "on") { print ' checked="checked"'; } ?> /> <font color="green">Включить</font></label> / <label><input type="radio" name="cfgAutoPayPE" value="off" <?php if(cfgSET('cfgAutoPayPE') == "off") { print ' checked="checked"'; } ?> /> <font color="red">ВЫключить</font></label></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Если вы включите автовыплаты, средства будут направляться автоматически пользователям после подачи заявки. Если отключите, то все заявки будут направлены на проверку администрации и будут доступны в разделе: Бухгалтерия" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Ваш номер счета в Payeer</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPEAcc" size="70" maxlength="250" value="<?php print cfgSET('cfgPEAcc'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Введите ваш номер счета в системе PAYEER.com. Необходим для авторизации по API." /></td>
</tr>
<tr bgcolor="#dddddd">
	<td><b>Ваш ID магазина</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPEidAPI" size="70" maxlength="250" value="<?php print cfgSET('cfgPEidAPI'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Укажите ваш ID магазина в API payeer.com" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Секретный API ключ</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgPEapiKey" size="70" maxlength="250" value="<?php print cfgSET('cfgPEapiKey'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Введите ваш секретный ключ, кокторый вы указали в настройках API к магазину" /></td>
</tr>

<tr bgcolor="#999999">
	<td height="30" colspan="3" align="center"><b>НАСТРОЙКА АВТОПЕРЕВОДА НА АДМИНСКИЙ КОШЕЛЕК PerfectMoney:</b></td>
</tr>

<tr bgcolor="#dddddd">
	<td><b>Процент от суммы пополнения - админу</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="cfgOutAdminPercent" size="70" maxlength="6" value="<?php print cfgSET('cfgOutAdminPercent'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Укажите, какой процент от суммы пополнения переводить на номер счета администратора. Если вы не хотите переводить процент, оставьте значение 0.00. ВНИМАНИЕ! Для автоматического перевода на счет администратора, у вас должны быть введены настройки API" /></td>
</tr>
<tr bgcolor="#eeeeee">
	<td><b>Админский PerfectMoney счет</b>:</td>
	<td align="right"><input style="width: 295px;" type="text" name="AdminPMpurse" size="70" maxlength="8" value="<?php print cfgSET('AdminPMpurse'); ?>" /></td>
	<td width="18"><img style="cursor: help;" src="images/help_ico.png" width="16" height="16" border="0" alt="Укажите номер счета PerfectMoney куда перенаправлять процент. ВНИМАНИЕ! Номер счета должен отличаться от номера счета приема средств и начинаться с символа U" /></td>
</tr>
</table>
<table align="center" width="624" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Сохранить!" /></td>
	</tr>
</table>
</form>
</FIELDSET>