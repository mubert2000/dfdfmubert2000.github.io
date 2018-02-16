<?php
/*
������ ������ ���������� ���������� �������� ������������, ����� �����.
����� ������������� ������� �������, ��������� ������ � ����������� �������� ������.
������ ������� �������: http://adminstation.ru/images/docs/doc1.jpg
���� ����������: 14.10.2010 �.
#
# ��������: ICQ: 451699555; E-mail: rem-x@i.ua; URL: www.adminstation.ru
#
-> ���� �������� ��������� ����� ������ ��� ������ MySql
*/
include "cfg.php";

// ������� ��������� dump-�� ����� �������
define ("FILES_TO_KEEP", 50);
// ������ ����� �������� � ��������
define ("BACKUP_PERIOD", 20);
// ��������� ����������� � ���� ������
define ("DATABASE_CONF", 'mysql://'.$mysql_login.':'.$mysql_password.'@'.$hostname.'/'.$database);
// ����� ��� �������� backup-��
define ("BACKUP_FOLDER", './backup' );

clearstatcache();
$b_dir = dir(BACKUP_FOLDER);
$b_files = array();
while($file = $b_dir->read()) {
  if (preg_match("/^backup-(\d+)-(\d+)-(\d+)_(\d+)-(\d+)-(\d+)/i", $file, $a)) {
    array_push($b_files, array('n' => $file,
                               't' => mktime($a[4], $a[5], $a[6], $a[2], $a[1], $a[3])));
  }
}
$b_dir->close();

function cmp_file_times($t1, $t2) {
  if ($t1['t'] == $t2['t']) return 0;
  return ($t1['t'] > $t2['t']) ? 1 : -1;
}

$now = time();
$b_count_files = count($b_files);
if ($b_count_files) {
  // ��������� ����� �� ����������� ������� ��������
  usort($b_files, "cmp_file_times");
  // ���� ��������� ���� ������ ���������� �����
  if ($b_files[$b_count_files - 1]['t'] <= $now - BACKUP_PERIOD) {
	// ���� ���� ������ �����, ������� ������ ���-�� ����� ������:
    if ($b_count_files >= FILES_TO_KEEP) {
      for ($i = 0; $i < $b_count_files - FILES_TO_KEEP + 1; $i ++) {
        unlink(BACKUP_FOLDER."/".$b_files[$i]['n']);
      }
    }
    backup();
  }
}else {
  backup();
}

function backup() {
  global $now;
  $file = BACKUP_FOLDER."/backup-".date("d-m-Y_H-i-s", $now).".sql";
  $db = parse_url(DATABASE_CONF);
  $db['path'] = substr($db['path'], 1);
  $q = "mysqldump -u".$db['user']." -p".$db['pass']." -h".$db['host']." ".$db['path']." > ";
  exec($q.$file."; gzip -f ".$file);
}

?>