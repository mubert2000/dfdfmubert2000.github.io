<?php
/*
������ ������ ���������� ���������� �������� ������������, ����� �����.
����� ������������� ������� �������, ��������� ������ � ����������� �������� ������.
������ ������� �������: http://adminstation.ru/images/docs/doc1.jpg
���� ����������: 14.10.2007 �. - �������������� 18.04.2009 �.

-> �������� �������� ����� (�������)
*/
defined('ACCESS') or die();

// ������� �������� ����������� ��������
function sch_special_chars($str)
{
	$spch_check_result = 0;
	$special_chars = array("?",">","<","&","|","+",";",":","'","=","/","\"","$","!","@","#","%","^","*","(",")","-","�");
	$str_lenght = strlen($str);
	$i = 0;
	for($i = 0;$i <= $str_lenght;$i++)
	{
		$char_from_str = substr($str,$i,1);
		$check_spch = in_array($char_from_str,$special_chars);
		if($check_spch != false)
		{
 			$spch_check_result = 1;
			break;
		}
	}
if($spch_check_result != 0)
 return 1;
else
 return 0;
}
// ����� ������ �������

	$folder			= "";
	$title			= "";
	$body			= "";
	$keywords		= "";
	$description	= "";
	$lite			= "";

$action = $_GET['action'];
if ($action == "add") {
	$folder			= htmlspecialchars(strtolower($_POST['folder']), ENT_QUOTES, '');
	$title			= htmlspecialchars($_POST['title'], ENT_QUOTES, '');
	$keywords		= htmlspecialchars($_POST['keywords'], ENT_QUOTES, '');
	$description	= htmlspecialchars($_POST['description'], ENT_QUOTES, '');
	$type			= intval($_POST['type']);
	$part			= intval($_POST['part']);
	$nbsp			= "";

	if(!$folder || !$title) {
		print "<p class=\"er\">��������� ���� ������������ ��� ����������</p>";
	}
	elseif(ereg("[�-��-�]",$folder)) {
		print "<p class=\"er\">� ������ ��������� ������� ������ ���������� ��������!</p>";
	}
	elseif(sch_special_chars($folder) != 0) {
		print "<p class=\"er\">� ������ ��������� �����������!</p>";
	}
	elseif(file_exists("../".$folder."/index.php")) {
		print "<p class=\"er\">������ ������ ��� ����������!</p>";
	} else {
		$old_umask = umask(0);
		if(mkdir("../".$folder, "0".$chmod)) {
			umask($old_umask);

			$sql = "INSERT INTO pages (path, title, keywords, description, type, part) VALUES ('".$folder."', '".$title."', '".$keywords."', '".$description."', '".$type."', ".$part.")";

			mysql_query($sql);
			$lastid	= mysql_insert_id();

			$fn		= "../".$folder."/index.php";
			$fo		= fopen($fn, "a+");
			$fw		= fwrite($fo, "<?php\n\t\$page = '".$folder."';\n\t\$file = '".$folder.".php';\n\t\$idpg = ".$lastid.";\n\tinclude '../cfg.php';\n\tinclude '../ini.php';\n\t if(\$lng == \"ru\") {\n\t\tinclude \"../template_ru.php\";\n\t} else {\n\t\tinclude \"../template.php\";\n\t}\n?>");
			fclose($fo);

			if($fw) {


				$fn		= "../".$folder."/".$folder.".php";
				$str = '';
				if($type == 1) {
					$str = "<?php\n\t print \$body;\n?>";
					$fo		= fopen($fn, "a+");
					fwrite($fo, $str);
					fclose($fo);
				} else {
					$str = " ";
					$fo	 = fopen($fn, "a+");
					fwrite($fo, $str);
					fclose($fo);
				}

				$fn		= "../".$folder."/".$folder."_ru.php";
				$str = '';
				if($type == 1) {
					$str = "<?php\n\t print \$body;\n?>";
					$fo		= fopen($fn, "a+");
					fwrite($fo, $str);
					fclose($fo);
				} else {
					$str = " ";
					$fo	 = fopen($fn, "a+");
					fwrite($fo, $str);
					fclose($fo);
				}

				print "<p class=\"erok\">�������� <a href=\"http://".$_SERVER['SERVER_NAME']."/".$folder."/\" target=\"_blank\">http://".$_SERVER['SERVER_NAME']."/".$folder."/</a> �������!</p>";

				$folder			= "";
				$title			= "";
				$body			= "";
				$keywords		= "";
				$description	= "";
			} else {
				print "<p class=\"er\">�� ������� ������� ��������! ������� ������ ����� �� ������ � ����� cfg.php (���������� $<b>chmod</b>)</p>";
				// ������� �����
				rmdir("../".$folder);
				// ������� ������� �� ��
				mysql_query("DELETE FROM pages WHERE id = ".$lastid." LIMIT 1");
			}

		} else {
			print "<p class=\"er\">�� ������� ������� ����������! ���������� �� �������� ����� ����� �� ������.</p>";
		}
	}
}
if(!ini_get(safe_mode)) {
?>
<FIELDSET style="border: solid #666666 1px;">
<LEGEND><b>�������� ��������� ��������</b></LEGEND>
<form action="?a=add_page&action=add" method="post">
<table width="650" bgcolor="#eeeeee" align="center" border="0" style="border: solid #cccccc 1px;">
	<tr>
		<td width="130"><font color="red"><b>!</b></font>������:</td>
		<td><b>http://<?php print $_SERVER['SERVER_NAME']; ?>/</b><input type="text" name="folder" size="30" maxlength="20" value="<?php print $folder; ?>" />/</td>
	</tr>
	<tr>
		<td><font color="red"><b>!</b></font>���������:</td>
		<td><input style="width: 500px;" type="text" name="title" size="80" maxlength="50" value="<?php print $title; ?>" /></td>
	</tr>
	<tr>
		<td>�������� �����:</td>
		<td><input style="width: 500px;" type="text" name="keywords" size="80" maxlength="250" value="<?php print $keywords; ?>" /></td>
	</tr>
	<tr>
		<td>��������&nbsp;��������:</td>
		<td><input style="width: 500px;" type="text" name="description" size="80" maxlength="250" value="<?php print $description; ?>" /></td>
	</tr>
	<tr>
		<td>��� (������):</td>
		<td>
			<select name="type" style="width: 500px;">
				<option value=1>������� ��������</option>
				<option value=2>����������� ������</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>�������:</td>
		<td>
			<select name="part" style="width: 500px;">
				<option value=0>��� ��������</option>
<?php
$result	= mysql_query("SELECT * FROM pages WHERE part = 0 ORDER BY title ASC");
while($row = mysql_fetch_array($result)) {
	$idpart		= $row['id'];
	$titlepart	= $row['title'];
	print "<option value=".$idpart.">".$titlepart."</option>";
}
?>
			</select>
		</td>
	</tr>
</table>
<table align="center" width="660" border="0">
	<tr>
		<td align="right"><input type="image" src="images/save.gif" width="28" height="29" border="0" title="���������!" /></td>
	</tr>
</table>
</form>
</FIELDSET>
<?php
} else {
	print "<p class=\"er\">��� �������� �������, ��� ���������� ��������� Safe Mode � php.ini</p>";
}
?>