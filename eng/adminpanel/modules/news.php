<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 14.10.2007 г.

-> Файл публикации новостей
*/
defined('ACCESS') or die();
if ($_GET['go'] == 'go') {
	$subject	 	 = htmlspecialchars($_POST['subject'], ENT_QUOTES, '');
	$text		 	 = addslashes($_POST['text']);
	$description 	 = htmlspecialchars($_POST['description'], ENT_QUOTES, '');
	$keywords	 	 = htmlspecialchars($_POST['keywords'], ENT_QUOTES, '');
	$subject_en	 	 = htmlspecialchars($_POST['subject_en'], ENT_QUOTES, '');
	$text_en		 = addslashes($_POST['text_en']);
	$description_en  = htmlspecialchars($_POST['description_en'], ENT_QUOTES, '');
	$keywords_en	 = htmlspecialchars($_POST['keywords_en'], ENT_QUOTES, '');

	if (!$subject) {
		print '<p class="er">Укажите тему новости!</p>';
	} elseif (!$text) {
		print '<p class="er">Введите текст новости!</p>';
	} else {

		$now	=  date('d.m.Y');
		$sql	= "INSERT INTO news (subject, msg, date, keywords, description, subject_en, msg_en, keywords_en, description_en) values ('".$subject."','".$text."','".$now."', '".$keywords."', '".$description."', '".$subject_en."','".$text_en."', '".$keywords_en."', '".$description_en."')";
		$result	= mysql_query($sql);

		include "modules/rss.php";

		print '<p class="erok">Новость добавлена!</p>';

	}
}
?>
<script type="text/javascript" src="editor/tiny_mce_src.js"></script>
<script type="text/javascript">
	tinyMCE.init({

		mode : "exact",
		elements : "elm1,elm2",
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
<LEGEND><b>Добавить новость</b></LEGEND>
<form action="?a=news&go=go" method="post" name="mainForm">
<table bgcolor="#eeeeee" width="612" align="center" border="0" style="border: solid #cccccc 1px; width: 612px;">
	<tr>
		<td style="padding-left: 2px;">Тема&nbsp;новости:</td>
		<td align="right"><input style="width: 490px;" type="text" name="subject" size="97" /></td>
	</tr>
	<tr>
		<td align="center" style="padding-bottom: 10px;" colspan="2">
		<textarea id="elm1" style="width: 605px;" name="text" cols="103" rows="20"></textarea>
		</td>
	</tr>
	<tr>
		<td style="padding-left: 2px;">Ключевые слова:</td>
		<td align="right"><input style="width: 490px;" type="text" name="keywords" maxlength="250" /></td>
	</tr>
		<tr>
		<td style="padding-left: 2px;">Описание&nbsp;страницы:</td>
		<td align="right"><input style="width: 490px;" type="text" name="description" maxlength="250" /></td>
	</tr>
	<tr>
		<td colspan="2" height="3" bgcolor="#cccccc"></td>
	</tr>
	<tr>
		<td colspan="2" height="30" align="center">Английская версия</td>
	</tr>
	<tr>
		<td style="padding-left: 2px;">Тема&nbsp;новости:</td>
		<td align="right"><input style="width: 490px;" type="text" name="subject_en" size="97" /></td>
	</tr>
	<tr>
		<td align="center" style="padding-bottom: 10px;" colspan="2">
		<textarea id="elm2" style="width: 605px;" name="text_en" cols="103" rows="20"></textarea>
		</td>
	</tr>
	<tr>
		<td style="padding-left: 2px;">Ключевые слова:</td>
		<td align="right"><input style="width: 490px;" type="text" name="keywords_en" maxlength="250" /></td>
	</tr>
		<tr>
		<td style="padding-left: 2px;">Описание&nbsp;страницы:</td>
		<td align="right"><input style="width: 490px;" type="text" name="description_en" maxlength="250" /></td>
	</tr>
</table>
<table align="center" width="624" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="Сохранить!" /></td>
	</tr>
</table>
</form>
</FIELDSET>