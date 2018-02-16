<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<?php
/*
Данный скрипт разработан Михайленко Виктором Леонидовичем, далее автор.
Любое использование данного скрипта, разрешено только с письменного согласия автора.
Скрипт защещён законом: http://adminstation.ru/images/docs/doc1.jpg
Дата разработки: 14.10.2007 г.

-> Файл вывода созданых страниц
*/
defined('ACCESS') or die();
$view = intval($_GET['view']);
if($view == 0 || $view == 1) {
	mysql_query("UPDATE pages SET view = ".$view." WHERE id = ".intval($_GET[id])." LIMIT 1");
}
?>
<table width="100%">
<?php
$result	= mysql_query("SELECT id, title, path, type, view FROM pages WHERE part = 0 ORDER BY id ASC");
while($row = mysql_fetch_array($result)) {
$id		= $row['id'];
$title	= $row['title'];
$folder	= $row['path'];
$page	= $row['type'];
$view	= $row['view'];

print "<tr>
	<td><b>".$title."</b><br />ссылка: <u>http://".$_SERVER['SERVER_NAME']."/".$folder."</u></td>
	<td width=\"20\"><a href=\"../".$folder."/\" target=\"_blank\"><img src=\"images/prew.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Просмотреть страницу\" /></a></td>
	<td width=\"20\"><a href=\"?a=edit_content&id=".$id."\"><img src=\"images/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать\" /></a></td>";

	if($view == 0) {
		print "	<td width=\"20\"><a href=\"?a=pages&id=".$id."&view=1\"><img src=\"images/no_view.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Не выводится в меню\" /></a></td>";
	} else {
		print "<td width=\"20\"><a href=\"?a=pages&id=".$id."&view=0\"><img src=\"images/view.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Выводится в меню\" /></a></td>";
	}

print "<td width=\"20\">";

	if($page == 1) {
		print "<img src=\"images/no_install.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"В этот раздел нельзя инсталлировать модуль\" /></td><td width=\"20\"><a style=\"cursor:hand\" onclick=\"if(confirm('Вы действительно хотите удалить данную страницу?')) top.location.href='del/page.php?f=".$folder."';\"><img src=\"images/delite.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить\" /></a>";
	} else {
		print "<a href=\"?a=install&page=".$id."\"><img src=\"images/install.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Инсталлировать модуль\" /></a></td><td width=\"20\"><img src=\"images/no_delite.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Запрограммированный раздел\" />";
	}

print "	</td>
</tr>
<tr>
	<td colspan=\"6\" height=\"1\" bgcolor=\"#cccccc\"></td>
</tr>";

$result2	= mysql_query("SELECT id, title, path, type, view FROM pages WHERE part = ".$id." ORDER BY id ASC");
while($row2 = mysql_fetch_array($result2))
{
$id2		= $row2['id'];
$title2		= $row2['title'];
$folder2	= $row2['path'];
$page2		= $row2['type'];
$view2		= $row2['view'];

print "<tr>
	<td style=\"padding-left: 10px;\"><font color=\"#888888\"><b>» ".$title2."</b><br />ссылка: <u>http://".$_SERVER['SERVER_NAME']."/".$folder2."</u></font></td>
	<td width=\"20\"><a href=\"../".$folder2."/\" target=\"_blank\"><img src=\"images/prew.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Просмотреть страницу\" /></a></td>
	<td width=\"20\"><a href=\"?a=edit_content&id=".$id2."\"><img src=\"images/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать\" /></a></td>";

	if($view2 == 0) {
		print "<td width=\"20\"><a href=\"?a=pages&id=".$id2."&view=1\"><img src=\"images/no_view.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Не выводится в меню\" /></a></td>";
	} else {
		print "<td width=\"20\"><a href=\"?a=pages&id=".$id2."&view=0\"><img src=\"images/view.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Выводится в меню\" /></a></td>";
	}

print "	<td width=\"20\">";

	if($page2 == 1) {
		print "<img src=\"images/no_install.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"В этот раздел нельзя инсталлировать модуль\" /></td><td width=\"20\"><a style=\"cursor:hand\" onclick=\"if(confirm('Вы действительно хотите удалить данную страницу?')) top.location.href='del/page.php?f=".$folder2."';\"><img src=\"images/delite.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить\" /></a>";
	} else {
		print "<a href=\"?a=install&page=".$id2."\"><img src=\"images/install.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Инсталлировать модуль\" /></a></td><td width=\"20\"><img src=\"images/no_delite.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Запрограммированный раздел\" />";
	}

print "	</td>
</tr>
<tr>
	<td colspan=\"6\" height=\"1\" bgcolor=\"#cccccc\"></td>
</tr>";
}

}
?>
</table>