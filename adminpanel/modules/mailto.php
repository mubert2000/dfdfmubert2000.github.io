<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 14.10.2007 г.

-> Файл рассылки сообщений пользователям
*/
defined('ACCESS') or die();
if($_GET['go'] == "mailto") {

$subject	= $_POST['subject'];
$msg		= $_POST['msg'];

	$headers = "From: ".$adminmail."\n";
	$headers .= "Reply-to: ".$adminmail."\n";
	$headers .= "X-Sender: < http://".$cfgURL." >\n";
	$headers .= "Content-Type: text/html; charset=windows-1251\n";

	$query	= "SELECT mail FROM users WHERE bot = 0";
	$result	= mysql_query($query);
	while($row = mysql_fetch_array($result)) {
		$mail = $row['mail'];
		mail($mail, $subject, $msg, $headers);
	}
print "<p class=\"erok\">Рассылка доставлена всем пользователям!</p>";
}
?>
<script type="text/javascript" src="editor/tiny_mce_src.js"></script>
<script type="text/javascript">
	tinyMCE.init({

		mode : "exact",
		elements : "elm1",
		theme : "advanced",
		plugins : "cyberfm,safari, inlinepopups,advlink,advimage,advhr,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
		language: "ru",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,hr,|,forecolor,backcolor,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "pasteword,|,bullist,numlist,|,link,image,media,|,tablecontrols,|,replace,charmap,cleanup,fullscreen,preview,code",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		content_css : "/files/styles.css",

		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<FIELDSET>
<LEGEND><b>Рассылка сообщения пользователям</b></LEGEND>
<form action="?a=mailto&go=mailto" method="post" name="mainForm">
<table bgcolor="#eeeeee" width="612" align="center" border="0" style="border: solid #cccccc 1px; width: 612px;">
<tr><td align="center"><input style="width: 605px;" size="97" name="subject" value="Рассылка проекта <?php print $cfgURL; ?>" type="text" maxlength="100"></td></tr>
<tr><td align="center" style="padding-bottom: 10px;"><textarea id="elm1" style="width: 605px;" name="msg" cols="103" rows="20"></textarea></td></tr>
</table>
<table align="center" width="624" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Отправить!" /></td>
	</tr>
</table>
</form>
</FIELDSET>