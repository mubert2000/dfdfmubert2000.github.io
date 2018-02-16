<script language="javascript" type="text/javascript" src="files/alt.js"></script>
<?php
defined('ACCESS') or die();
if($status != 1) { exit(); }

$pach	= $_SERVER['DOCUMENT_ROOT'];

if($_GET['act'] == "del") {
	if(unlink($pach."/".$_GET['f'])) {
		print "<p class=\"erok\">Файл успешно удален!</p>";
	} else {
		print "<p class=\"er\">Не удается удалить файл! Удалите его вручную через FTP.</p>";
	}
}

if($_GET['act'] == "add") {
	if(!mysql_num_rows(mysql_query("SELECT * FROM antivirus WHERE filename = '".$_GET['f']."'"))) {
		$fileinfo = stat($pach."/".$_GET['f']);
			$s = filesize($pach."/".$_GET['f']);

			$sql = "INSERT INTO `antivirus` (`filename`, `time`, `size`) VALUES ('".$_GET['f']."', ".$fileinfo[9].", ".$s.")";

			mysql_query($sql) or print mysql_error();
			print "<p class=\"erok\">Файл успешно добавлен в базу!</p>";

	} else {
		$fileinfo = stat($pach."/".$_GET['f']);

			mysql_query("UPDATE `antivirus` SET `time` = ".$fileinfo[9].", `size` = ".filesize($pach."/".$_GET['f'])." WHERE filename = '".$_GET['f']."' LIMIT 1");
			print "<p class=\"erok\">Файл успешно добавлен в базу!</p>";
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
				print "<p class=\"er\">Есть подозрительные файлы</p>";
				return 1;
				break;
			} elseif($time != $fileinfo[9] || $size != filesize($path.$item)) {
				print "<p class=\"er\">Есть подозрительные файлы</p>";
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




// Типы файлов
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
 
	print "<tr><td><img src=\"images/ico/folder.png\" width=\"16\" height=\"16\" title=\"Папка\" /></td><td class=\"left\">".$dir_path."</td><td>-</td><td>-</td><td width=\"50\"></td></tr>";
 
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
				// Если файл новый
				print "<tr bgcolor=\"#ffcccc\"><td>".$prefix." <img src=\"images/ico/".whatfile($item).".png\" width=\"16\" height=\"16\" title=\"Файл\" /> </td>
				<td class=\"left\">".$prefix." ".$item."</td>
				<td>".filesize($path.$item)."</td>
				<td>".date("d.m.Y H:i", $fileinfo[9])."</td>
				<td align=\"center\"><img src=\"images/ico/bug_error.png\" width=\"16\" height=\"16\" alt=\"Данного файла не было ранее на сервере! Если вы уверены в том, что это не ваш новый файл (и не файлы баннеров рекламодателей), настоятельно рекомендуем удалить его! Особое внимание уделите файлам формата .PHP\" /> 
				<img style=\"cursor: hand;\" onclick=\"if(confirm('Выбранный файл будет удален без возможности восстановления!')) top.location.href='?a=antivirus&act=del&f=".$path.$item."';\" src=\"images/ico/del.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"Удалить\" />
				<a href=\"?a=antivirus&act=add&f=".$path.$item."\"><img src=\"images/ico/add.png\" border=\"0\" width=\"16\" height=\"16\" alt=\"Нажмите здесь, если уверены в том, что файл чист\" /></a>
				</td></tr>";
			} elseif($time != $fileinfo[9] || $size != filesize($path.$item)) {
				// Если файл редактирован
				print "<tr bgcolor=\"#ffcccc\"><td>".$prefix." <img src=\"images/ico/".whatfile($item).".png\" width=\"16\" height=\"16\" title=\"Файл\" /> </td>
				<td class=\"left\">".$prefix." ".$item."</td>
				<td>".filesize($path.$item)."</td>
				<td>".date("d.m.Y H:i", $fileinfo[9])."</td>
				<td align=\"center\"><img src=\"images/ico/bug_error.png\" width=\"16\" height=\"16\" alt=\"Данный файл входит в сборку скрипта, но он был изменен! Проверьте файл на подозрительный код!\nДата изменения: ".date("d.m.Y H:i", $fileinfo[9])."\" /> 
				<img style=\"cursor: hand;\" onclick=\"if(confirm('Выбранный файл будет удален без возможности восстановления!')) top.location.href='?a=antivirus&act=del&f=".$path.$item."';\" src=\"images/ico/del.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"Удалить\" />
				<a href=\"?a=antivirus&act=add&f=".$path.$item."\"><img src=\"images/ico/add.png\" border=\"0\" width=\"16\" height=\"16\" alt=\"Нажмите здесь, если уверены в том, что файл чист\" /></a>
				</td></tr>";
			} else {
				// Если файл чист
				print "<tr><td>".$prefix." <img src=\"images/ico/".whatfile($item).".png\" width=\"16\" height=\"16\" title=\"Файл\" /> </td><td class=\"left\">".$prefix." ".$item."</td><td>".filesize($path.$item)."</td><td>".date("d.m.Y H:i", $fileinfo[9])."</td><td></td></tr>";
			}

		} elseif (is_dir($path.$item)) {
			if ($item != "." && $item != "..") {
				print "<tr><td>".$prefix."<img src=\"images/ico/folder.png\" width=\"16\" height=\"16\" title=\"Папка\" /></td><td class=\"left\"> ".$prefix." ".$item."</td><td>-</td><td>-</td><td></td></tr>";
				$new_dir = opendir($path.$item);
				scan_directory($new_dir, $path.$item."/", $prefix." &nbsp; ");
			}
		}
	}
closedir($dir);
}

print "<table class=\"tbl\" width=\"100%\" border=\"0\"><tr><th>Тип файла</td><th>Имя файла</td><th>Размер</td><th>Дата</td><th>Управление</td></tr>";

tree($pach);

print "</table>";
?>