<?php
/*
������ ������ ���������� ���������� �������� ������������, ����� �����.
����� ������������� ������� �������, ��������� ������ � ����������� �������� ������.
������ ������� �������: http://adminstation.ru/images/docs/doc1.jpg
���� ����������: 4.11.2008 �.

-> ���� �������� ������ �� ����� �������
*/

include "../../cfg.php";
include "../../ini.php";

if ($status == 1) {
	if ($_GET['id']) {
		//$sql = 'DELETE FROM output WHERE `id` = '.$_GET['id'].' LIMIT 1';
		$sql = "UPDATE output SET status = 3 WHERE id = ".$_GET['id']." LIMIT 1";
		if (mysql_query($sql)) {
			echo "<html><head><script>alert('����� ��������!'); top.location.href='../adminstation.php?a=edit';</script></head></html>";
		} else {
			echo "<html><head><script>alert('�� ������ ������� ������!'); top.location.href='../adminstation.php?a=edit';</script></head></html>";
		}
	} else {
		echo "<html><head><script>alert('�� ������� ������!'); top.location.href='../adminstation.php?a=edit';</script></head></html>";
	}
}
?>