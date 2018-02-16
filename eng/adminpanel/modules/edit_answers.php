<?php
defined('ACCESS') or die();
$action = $_GET['action'];
if ($action == 'save') {
	$text = addslashes($_POST['text']);
	$radi = intval($_POST['radio']);

	$sql = "UPDATE answers SET text = '".$text."', yes = '".$radi."', view = ".intval($_POST['view'])." WHERE id = ".intval($_GET['id'])." LIMIT 1";
	if (mysql_query($sql)) {
		print "<p class=\"erok\">Запись обновлена!</p>";
	} else {
		print "<p class=\"er\">Произошла ошибка при записи данных в БД</p>";
	}
}

if (isset($_GET['id'])) {
	$sql	= "SELECT * FROM answers WHERE id = ".intval($_GET['id'])." LIMIT 1";
	$rs	= mysql_query($sql);
	$a	= mysql_fetch_assoc($rs);
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
<FIELDSET style="border: solid #666666 1px;">
<LEGEND><b>Редактирование отзыва:</b></LEGEND>
<form action="?a=edit_answers&action=save&id=<?php print $_GET['id']; ?>" method="post" name="mainForm">
<table bgcolor="#eeeeee" width="612" align="center" border="0" style="border: solid #cccccc 1px; width: 612px;">
<tr>
	<td><textarea id="elm1" style="width: 605px;" cols="103" rows="20" name="text"><?php print $a['text']; ?></textarea></td>
</tr>
<tr>
	<td align="center">
		<input type="radio" name="radio" value="1" <?php if ($a['yes'] == 1) echo 'checked'; ?> /> <img src="/images/yes.gif" width="15" height="15" border="0" alt="Положительный отзыв" /> 
		<input type="radio" name="radio" value="2" <?php if ($a['yes'] == 2) echo 'checked'; ?> /> <img src="/images/no.gif" width="15" height="15" border="0" alt="Отрицательный отзыв" />
		<input type="checkbox" name="view" value="1" <?php if ($a['view'] == 1) echo 'checked="checked"'; ?> /> <b>выводить</b>
	</td>
</tr>
</table>
<table align="center" width="624" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Сохранить!" /></td>
	</tr>
</table>
</form>
</FIELDSET>
<?php
}
?>