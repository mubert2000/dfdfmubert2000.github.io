<?php
$filename	= "../rss.xml";
$date		= date("D, d M Y H:i:s");
defined('ACCESS') or die();
$header = "<?xml version=\"1.0\" encoding=\"windows-1251\"?>
<rss version=\"2.0\">
<channel>
<title>".$cfgURL."!</title>
<link>http://".$cfgURL."/</link>
<description>RSS канал новостей ".$cfgURL."</description>
<image>
	<url>http://".$cfgURL."/images/88x31.gif</url>
	<title>".$cfgURL."</title>
	<link>http://".$cfgURL."/</link>
	<width>88</width>
	<height>31</height>
</image>
<pubDate>".$date." +0200</pubDate>
";

$footer = "</channel>
</rss>";

  $f = fopen($filename,"w");
  fwrite($f,$header);
  fclose($f);

  $f = fopen($filename,"a");

$query = "SELECT * FROM news order by id DESC LIMIT 50";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$id		= $row['id'];
	$title	= $row['subject'];
	$text	= $row['msg'];
	$date	= $row['date'];

	$text = substr($text,0,5000);
	$text = str_replace("\n","",$text);
	$text = str_replace("&nbsp;","",$text);
	$text = str_replace("&","",$text);
	$text = preg_replace('/(<)(.+?)(>)/', '',$text);
	$text = substr($text,0,1000);

$iMonth	= substr($date,3,2);
$iDay	= substr($date,0,2);
$iYear	= substr($date,6,4);

$txt = "<item>
<title>".$title."</title>
<link>http://".$cfgURL."/news/?id=".$id."</link>
<description>".$text."...</description>
<pubDate>".date("D, d M Y H:i:s", mktime(12, 0, 0, $iMonth, $iDay, $iYear))." +0200</pubDate>
</item>
";

fwrite($f,$txt);

}
  fwrite($f,$footer);
  fclose($f);
?>