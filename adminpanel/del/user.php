<?php
/*
������ ������ ���������� ���������� �������� ������������, ����� �����.
����� ������������� ������� �������, ��������� ������ � ����������� �������� ������.
������ ������� �������: http://adminstation.ru/images/docs/doc1.jpg
���� ����������: 14.10.2007 �.

-> �������� ������������ � ����
*/
include "../../cfg.php";
include "../../ini.php";
if($status == 1) {
	$id = intval($_GET['id']);
	mysql_query("DELETE FROM users WHERE id = ".$id." LIMIT 1");

	print "<html><head><script language=\"javascript\">alert('������������ �����!'); location.href='../adminstation.php?a=users&page=".$_GET['page']."'</script></head></html>";
} else {
	print "<html><head><script language=\"javascript\">alert('� ��� ��� ���� �� ���������� ������ ��������!'); location.href='../adminstation.php?a=users&page=".$_GET['page']."'</script></head></html>";
}
?>