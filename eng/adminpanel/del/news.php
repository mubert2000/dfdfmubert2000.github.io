<?php
/*
������ ������ ���������� ���������� �������� ������������, ����� �����.
����� ������������� ������� �������, ��������� ������ � ����������� �������� ������.
������ ������� �������: http://adminstation.ru/images/docs/doc1.jpg
���� ����������: 14.10.2007 �.

-> ���� �������� ��������
*/
include "../../cfg.php";
include "../../ini.php";
if($status == 1) {
	$id = intval($_GET['id']);
	mysql_query("DELETE FROM news WHERE id = ".$id." LIMIT 1");
	print "<script>alert('������� �������!'); location.href='/news/'</script>";
}
?>