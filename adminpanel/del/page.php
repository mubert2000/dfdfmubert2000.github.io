<?php
/*
������ ������ ���������� ���������� �������� ������������, ����� �����.
����� ������������� ������� �������, ��������� ������ � ����������� �������� ������.
������ ������� �������: http://adminstation.ru/images/docs/doc1.jpg
���� ����������: 4.11.2008 �.

-> ���� �������� ��������
*/

include "../../cfg.php";
include "../../ini.php";
if($status == 1) {
	$f = $_GET['f'];
	if(!$f) {
		print "<html><head><script language=\"javascript\">alert('�� �� ������� ����� �������� ���������� �������'); top.location.href='../adminstation.php?a=pages';</script></head></html>";
	} else {
		unlink("../../".$f."/".$f.".php");
		unlink("../../".$f."/".$f."_ru.php");
		unlink("../../".$f."/index.php");
		rmdir("../../".$f);
		mysql_query("DELETE FROM pages WHERE path = '".$f."' LIMIT 1");
		print "<html><head><script language=\"javascript\">alert('�������� �������!'); top.location.href='../adminstation.php?a=pages';</script></head></html>";
	}
} else {
	include "../../includes/errors/404.php";
}
?>