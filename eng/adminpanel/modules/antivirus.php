<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<?php
defined('ACCESS') or die();
if($status != 1) { exit(); }

$pach	= $_SERVER['DOCUMENT_ROOT'];

if($_GET['act'] == "del") {
	if(unlink($pach."/".$_GET['f'])) {
		print "<p class=\"erok\">���� ������� ������!</p>";
	} else {
		print "<p class=\"er\">�� ������� ������� ����! ������� ��� ������� ����� FTP.</p>";
	}
}

if($_GET['act'] == "add") {
	if(!mysql_num_rows(mysql_query("SELECT * FROM antivirus WHERE filename = '".$_GET['f']."'"))) {
		$fileinfo = stat($pach."/".$_GET['f']);
			$s = filesize($pach."/".$_GET['f']);

			$sql = "INSERT INTO `antivirus` (`filename`, `time`, `size`) VALUES ('".$_GET['f']."', ".$fileinfo[9].", ".$s.")";

			mysql_query($sql) or print mysql_error();
			print "<p class=\"erok\">���� ������� �������� � ����!</p>";

	} else {
		$fileinfo = stat($pach."/".$_GET['f']);

			mysql_query("UPDATE `antivirus` SET `time` = ".$fileinfo[9].", `size` = ".filesize($pach."/".$_GET['f'])." WHERE filename = '".$_GET['f']."' LIMIT 1");
			print "<p class=\"erok\">���� ������� �������� � ����!</p>";
	}
}

// ALARM
function scan_directory_alarm(&$dir, $path) {

	while ($item = readdir($dir)) {
		if (is_file($path.$item)) {
			$fileinfo = stat($path.$item);

			$getfile	= mysql_query("SELECT * FROM antivirus WHERE filename = '".$path.$item."' LIMIT 1");
			$row		= mysql_fetch_array($getfile);
			$time		= $row['time'];
			$size		= $row['size'];

			if(!mysql_num_rows(mysql_query("SELECT * FROM antivirus WHERE filename = '".$path.$item."'"))) {
				print "<p class=\"er\">���� �������������� �����</p>";
				return 1;
				break;
			} elseif($time != $fileinfo[9] || $size != filesize($path.$item)) {
				print "<p class=\"er\">���� �������������� �����</p>";
				return 1;
				break;
			}

		} elseif (is_dir($path.$item)) {
			if ($item != "." && $item != "..") {
				$new_dir = opendir($path.$item);
				if(scan_directory_alarm($new_dir, $path.$item."/")) { break; }
			}
		}
	}
closedir($dir);
}

$dir = opendir($pach);
chdir($pach);
scan_directory_alarm($dir, "");




// ���� ������
function whatfile($item) {
	$ext = substr(strrchr($item,"."),1);

	if($ext == "php" || $ext == "phtml") {
		$ext = "php";
	} elseif($ext == "html" || $ext == "htm") {
		$ext = "html";
	} elseif($ext == "js") {
		$ext = "js";
	} elseif($ext == "css") {
		$ext = "css";
	} elseif($ext == "txt") {
		$ext = "txt";
	} elseif($ext == "gif") {
		$ext = "gif";
	} elseif($ext == "jpg") {
		$ext = "jpg";
	} elseif($ext == "psd") {
		$ext = "psd";
	} elseif($ext == "xls") {
		$ext = "xls";
	} elseif($ext == "xml") {
		$ext = "xml";
	} elseif($ext == "swf" || $ext == "flv") {
		$ext = "swf";
	} elseif($ext == "mp3" || $ext == "wav") {
		$ext = "mp3";
	} elseif($ext == "mp4" || $ext == "avi") {
		$ext = "avi";
	} elseif($ext == "zip" || $ext == "rar") {
		$ext = "zip";
	} elseif($ext == "png" || $ext == "ico" || $ext == "bmp" || $ext == "tif") {
		$ext = "img";
	} elseif($ext == "doc" || $ext == "docx" || $ext == "rtf") {
		$ext = "doc";
	} else {
		$ext = "no";
	}

return $ext;
}

function tree($dir_path) {
	if (!is_dir($dir_path)) return;
 
	$dir = opendir($dir_path);
	chdir($dir_path);
 
	print "<tr><td><img src=\"images/ico/folder.png\" width=\"16\" height=\"16\" title=\"�����\" /></td><td class=\"left\">".$dir_path."</td><td>-</td><td>-</td><td width=\"50\"></td></tr>";
 
    scan_directory($dir, "", " &nbsp; ");
}
 
function scan_directory(&$dir, $path, $prefix) {
	while ($item = readdir($dir)) {
		if (is_file($path.$item)) {
			$fileinfo = stat($path.$item);

			$getfile	= mysql_query("SELECT * FROM antivirus WHERE filename = '".$path.$item."' LIMIT 1");
			$row		= mysql_fetch_array($getfile);
			$time		= $row['time'];
			$size		= $row['size'];

			if(!mysql_num_rows(mysql_query("SELECT * FROM antivirus WHERE filename = '".$path.$item."'"))) {
				// ���� ���� �����
				print "<tr bgcolor=\"#ffcccc\"><td>".$prefix." <img src=\"images/ico/".whatfile($item).".png\" width=\"16\" height=\"16\" title=\"����\" /> </td>
				<td class=\"left\">".$prefix." ".$item."</td>
				<td>".filesize($path.$item)."</td>
				<td>".date("d.m.Y H:i", $fileinfo[9])."</td>
				<td align=\"center\"><img src=\"images/ico/bug_error.png\" width=\"16\" height=\"16\" alt=\"������� ����� �� ���� ����� �� �������! ���� �� ������� � ���, ��� ��� �� ��� ����� ���� (� �� ����� �������� ��������������), ������������ ����������� ������� ���! ������ �������� ������� ������ ������� .PHP\" /> 
				<img style=\"cursor: hand;\" onclick=\"if(confirm('��������� ���� ����� ������ ��� ����������� ��������������!')) top.location.href='?a=antivirus&act=del&f=".$path.$item."';\" src=\"images/ico/del.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"�������\" />
				<a href=\"?a=antivirus&act=add&f=".$path.$item."\"><img src=\"images/ico/add.png\" border=\"0\" width=\"16\" height=\"16\" alt=\"������� �����, ���� ������� � ���, ��� ���� ����\" /></a>
				</td></tr>";
			} elseif($time != $fileinfo[9] || $size != filesize($path.$item)) {
				// ���� ���� ������������
				print "<tr bgcolor=\"#ffcccc\"><td>".$prefix." <img src=\"images/ico/".whatfile($item).".png\" width=\"16\" height=\"16\" title=\"����\" /> </td>
				<td class=\"left\">".$prefix." ".$item."</td>
				<td>".filesize($path.$item)."</td>
				<td>".date("d.m.Y H:i", $fileinfo[9])."</td>
				<td align=\"center\"><img src=\"images/ico/bug_error.png\" width=\"16\" height=\"16\" alt=\"������ ���� ������ � ������ �������, �� �� ��� �������! ��������� ���� �� �������������� ���!\n���� ���������: ".date("d.m.Y H:i", $fileinfo[9])."\" /> 
				<img style=\"cursor: hand;\" onclick=\"if(confirm('��������� ���� ����� ������ ��� ����������� ��������������!')) top.location.href='?a=antivirus&act=del&f=".$path.$item."';\" src=\"images/ico/del.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"�������\" />
				<a href=\"?a=antivirus&act=add&f=".$path.$item."\"><img src=\"images/ico/add.png\" border=\"0\" width=\"16\" height=\"16\" alt=\"������� �����, ���� ������� � ���, ��� ���� ����\" /></a>
				</td></tr>";
			} else {
				// ���� ���� ����
				print "<tr><td>".$prefix." <img src=\"images/ico/".whatfile($item).".png\" width=\"16\" height=\"16\" title=\"����\" /> </td><td class=\"left\">".$prefix." ".$item."</td><td>".filesize($path.$item)."</td><td>".date("d.m.Y H:i", $fileinfo[9])."</td><td></td></tr>";
			}

		} elseif (is_dir($path.$item)) {
			if ($item != "." && $item != "..") {
				print "<tr><td>".$prefix."<img src=\"images/ico/folder.png\" width=\"16\" height=\"16\" title=\"�����\" /></td><td class=\"left\"> ".$prefix." ".$item."</td><td>-</td><td>-</td><td></td></tr>";
				$new_dir = opendir($path.$item);
				scan_directory($new_dir, $path.$item."/", $prefix." &nbsp; ");
			}
		}
	}
closedir($dir);
}

print "<table class=\"tbl\" width=\"100%\" border=\"0\"><tr><th>��� �����</td><th>��� �����</td><th>������</td><th>����</td><th>����������</td></tr>";

tree($pach);

print "</table>";
?>