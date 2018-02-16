<?php
defined('ACCESS') or die();
if ($_GET['action'] == 'save') {
	$sql = "UPDATE `answers` SET answer = '".addslashes($_POST['text'])."' WHERE id = ".intval($_GET['id'])." LIMIT 1";
 	if (mysql_query($sql)) {
		print '<p class="erok">Комментарий администратора был успешно обновлён!</p>';
	} else {
		print '<p class="er">Произошла ошибка при записи данных в БД</p>';
	}
}

if (isset($_GET['id'])) {

	$sql	= "SELECT `answer` FROM `answers` WHERE id = ".intval($_GET['id'])." LIMIT 1";
	$rs	= mysql_query($sql);
	$a	= mysql_fetch_array($rs);
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
<LEGEND><b>Редактирование комментария к отзыву:</b></LEGEND>
<table bgcolor="#eeeeee" width="612" align="center" border="0" style="border: solid #cccccc 1px; width: 612px;">
<form action="?a=admin_answers&action=save&id=<?php print intval($_GET['id']); ?>" method="post" name="mainForm">
<td>
<textarea id="elm1" style="width: 605px;" name="text" cols="103" rows="20"><?php print $a['answer']; ?></textarea>
</td></tr>
</table>
<table align="center" width="624" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Сохранить!" /></td>
	</tr>
</table>
</form>
</FIELDSET>
<?php
} else {
	print '<p class="er">Номер записи не задан!</p>';
}
?>