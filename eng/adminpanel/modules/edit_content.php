<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 14.10.2007 г.

-> Файл редактирования контента
*/
defined('ACCESS') or die();
$id		= intval($_GET['id']);
$action = $_GET['action'];
if($action == "add") {

	$title			= htmlspecialchars($_POST['title'], ENT_QUOTES, '');
	$body			= addslashes($_POST['body']);
	$keywords		= htmlspecialchars($_POST['keywords'], ENT_QUOTES, '');
	$description	= htmlspecialchars($_POST['description'], ENT_QUOTES, '');
	$title_en		= htmlspecialchars($_POST['title_en'], ENT_QUOTES, '');
	$body_en		= addslashes($_POST['body_en']);
	$keywords_en	= htmlspecialchars($_POST['keywords_en'], ENT_QUOTES, '');
	$description_en	= htmlspecialchars($_POST['description_en'], ENT_QUOTES, '');

	if(!$title) {
		print "<p class=\"er\">Заполните поля обязательные для заполнения!</p>";
	} else {

		mysql_query("UPDATE pages SET title = '".$title."', body = '".$body."', keywords = '".$keywords."', description = '".$description."', title_en = '".$title_en."', body_en = '".$body_en."', keywords_en = '".$keywords_en."', description_en = '".$description_en."' WHERE id = ".$id." LIMIT 1");

			$title			= "";
			$body			= "";
			$keywords		= "";
			$description	= "";
			print "<p class=\"erok\"><b>Изменения сохранены!</p>";
	}
}
$get_page_info = mysql_query("SELECT * FROM pages WHERE id = ".$id." LIMIT 1");
	$row = mysql_fetch_array($get_page_info);
	 $title				= $row['title'];
	 $keywords			= $row['keywords'];
	 $description		= $row['description'];
	 $body				= stripslashes($row['body']);
	 $title_en			= $row['title_en'];
	 $keywords_en		= $row['keywords_en'];
	 $description_en	= $row['description_en'];
	 $body_en			= stripslashes($row['body_en']);
	 $type				= $row['type'];
?>
<FIELDSET style="border: solid #666666 1px;">
<LEGEND><b>Редактирование страницы</b></LEGEND>
<form action="?a=edit_content&id=<?php print $id; ?>&action=add" method="post">
<table bgcolor="#eeeeee" width="612" align="center" border="0" style="border: solid #cccccc 1px; width: 612px;">
	<tr>
		<td style="padding-left: 2px;"><font color="red"><b>!</b></font>Заголовок:</td>
		<td align="right"><input style="width: 490px;" type="text" name="title" maxlength="50" value="<?php print $title; ?>" /></td>
	</tr>
	<?php
	if($type != 2) {
	?>
	<tr>
		<td colspan="2" align="center">
<script type="text/javascript" src="editor/tiny_mce_src.js"></script>
<script type="text/javascript">
	tinyMCE.init({

		mode : "exact",
		elements : "elm1, elm2",
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
		<textarea id="elm1" style="width: 605px; background-color: #ffffff;" name="body" cols="80" rows="20"><?php print $body; ?></textarea>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td style="padding-left: 2px;">Ключевые слова:</td>
		<td align="right"><input style="width: 490px;" type="text" name="keywords" maxlength="250" value="<?php print $keywords; ?>" /></td>
	</tr>
		<tr>
		<td style="padding-left: 2px;">Описание&nbsp;страницы:</td>
		<td align="right"><input style="width: 490px;" type="text" name="description" maxlength="250" value="<?php print $description; ?>" /></td>
	</tr>
	<tr>
		<td colspan="2" height="3" bgcolor="#cccccc"></td>
	</tr>
	<tr>
		<td colspan="2" align="center" height="30">Английская версия:</td>
	</tr>
	<tr>
		<td style="padding-left: 2px;"><font color="red"><b>!</b></font>Заголовок:</td>
		<td align="right"><input style="width: 490px;" type="text" name="title_en" maxlength="50" value="<?php print $title_en; ?>" /></td>
	</tr>
	<?php
	if($type != 2) {
	?>
	<tr>
		<td colspan="2" align="center">
		<textarea id="elm2" style="width: 605px; background-color: #ffffff;" name="body_en" cols="80" rows="20"><?php print $body_en; ?></textarea>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td style="padding-left: 2px;">Ключевые слова:</td>
		<td align="right"><input style="width: 490px;" type="text" name="keywords_en" maxlength="250" value="<?php print $keywords_en; ?>" /></td>
	</tr>
		<tr>
		<td style="padding-left: 2px;">Описание&nbsp;страницы:</td>
		<td align="right"><input style="width: 490px;" type="text" name="description_en" maxlength="250" value="<?php print $description_en; ?>" /></td>
	</tr>
</table>
<table align="center" width="624" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Сохранить!" /></td>
	</tr>
</table>
</form>
</FIELDSET>