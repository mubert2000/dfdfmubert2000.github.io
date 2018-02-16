<?php
defined('ACCESS') or die();
if(!intval($_GET[id])) {
function show_topics ($id, $subj, $msg, $date, $status)
{
	$text = substr($msg, 0, 1000);
	$text = str_replace("\n", "", $text);
	$text = preg_replace('/(<)(.+?)(>)/', '', $text);
	$text = substr($text, 0, 500);

	print "<p>".$date." | <a href=\"?id=".$id."\"><b>".$subj."</b></a>";

	if ($status == 1 || $status == 2)
	{
		print " <a href=\"/adminpanel/adminstation.php?a=edit_news&id=".$id."\"><img src=\"/adminpanel/images/edit_small.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"Редактировать новость\" /></a> ";
		print "<img style=\"cursor: hand;\" onclick=\"if(confirm('Вы уверены?')) top.location.href='/adminpanel/del/news.php?id=".$id."'\";  width=\"12\" height=\"12\" border=\"0\" src=\"/adminpanel/images/del.gif\" alt=\"Удалить новость\" />";
	}
	print "</p><p align=\"justify\">".$text."...</p><hr size=\"1\" color=\"#cccccc\" />";
}

function topics_list($page, $num, $status)
{
	$query	= "SELECT * FROM news ORDER BY id DESC";
	$result	= mysql_query($query);
	$themes = mysql_num_rows($result);
	$total	= intval(($themes - 1) / $num) + 1;
	if(empty($page) or $page < 0) $page = 1;
	if($page > $total) $page = $total;
	$start = $page * $num - $num;
	$result = mysql_query($query." LIMIT ".$start.", ".$num);

	while ($row = mysql_fetch_array($result))
	{
		show_topics($row['id'], $row['subject'], $row['msg'], $row['date'], $status);
	}

	if ($page) {
		if($page != 1) { $pervpage = "<a href=\"?page=". ($page - 1) ."\">««</a>"; }
		if($page != $total) { $nextpage = " <a href=\"?page=".$total."\">»»</a>"; }
		if($page - 2 > 0) { $page2left = " <a href=\"?page=". ($page - 2) ."\">". ($page - 2) ."</a> "; }
		if($page - 1 > 0) { $page1left = " <a href=\"?page=". ($page - 1) ."\">". ($page - 1) ."</a> "; }
		if($page + 2 <= $total) { $page2right = " | <a href=\"?page=". ($page + 2) ."\">". ($page + 2) ."</a> "; }
		if($page + 1 <= $total) { $page1right = " | <a href=\"?page=". ($page + 1) ."\">". ($page + 1) ."</a> "; }
	}
	print "<div class=\"pages\"><b>Страницы:  </b>".$pervpage.$page2left.$page1left." [<b>".$page."</b>] ".$page1right.$page2right.$nextpage."</div>";
}

$page = intval($_GET['page']);
topics_list($page, $num, $status);
} else {

	print "<p align=\"justify\">".stripslashes($news_text)."</p>";
	print '<div class="hline"></div><script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
	<table width="100%"><tr><td><div class="yashare-auto-init" data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,friendfeed,lj"></div></td><td align="right">Дата публикации: <b>'.$news_date.'</b></td></tr></table>';

}
?>