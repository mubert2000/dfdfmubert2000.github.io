<?php
defined('ACCESS') or die();
?>
<script type="text/javascript">
<!--
	var h=<?php print intval(date('G')); ?>;
	var m=<?php print intval(date('i')); ?>;
	var s=<?php print intval(date('s')); ?>;
	setInterval("showtime()",1000);

	function showtime() {
		s++;
		if (s>=60) {
			s=0;
			m++;
			if (m>=60) {
				m=0;
				h++;
				if (h>=24) h=0;
			}
		}
		s = s+"";
		m = m+"";
		h = h+"";
		if (s.length<2) s = "0"+s;
		if (m.length<2) m = "0"+m;
		if (h.length<2) h = "0"+h;
		document.getElementById("time").innerHTML = h+":"+m+":"+s;
	}

	$(document).ready(function(){
	$('#getContent').click(function(){
	$.ajax({
		url: "/adminpanel/modules/serverip.php",
		cache: false,
		beforeSend: function() {
			$('#divContent').html('<center><img src="images/loader.gif" width="16" height="16" border="0" alt="" /> Определяем IP адрес...</center>');
		},
		success: function(html){
			$("#divContent").html(html);
		}
	});
	return false;
	});
	});
-->
</script>
<?php
print '<table width="100%">
<tr height="20">
	<td colspan="2">IP адрес сервера</td>
	<td colspan="2">phpinfo();</td>
	<td colspan="2">Дата / время сервера:</td>
</tr>
<tr height="3" bgcolor="#dddddd">
	<td colspan="2"></td>
	<td colspan="2"></td>
	<td colspan="2"></td>
</tr>
<tr>
	<td width="20"><img src="images/serverip_ico.png" width="16" height="16" border="0" alt="" /></td>
	<td width="33%"><a href="#" id="getContent">Показать</a></td>
	<td width="20"><img src="images/phpinfo_ico.png" width="16" height="16" border="0" alt="" /></td>
	<td width="33%"><a href="modules/phpinf.php" target="_blank">Открыть</a></td>
	<td width="20"><img src="images/clock_ico.png" width="16" height="16" border="0" alt="" /></td>
	<td><b style="float: left; padding-right: 7px;">'.date("d.m.Y").'</b> <div id="time"></div></td>
</tr>
</table><hr /><div id="divContent"></div>';
?>