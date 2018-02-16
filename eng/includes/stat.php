	  <script src="/includes/raphael-min.js"></script>
  <script src="/includes/morris.js"></script>
  <script src="/includes/prettify.min.js"></script>
  <script src="/includes/example.js"></script>
  <script src="/includes/jquery.liTextLength.js"></script>
    <link rel="stylesheet" href="/includes/prettify.min.css">
  <link rel="stylesheet" href="/includes/morris.css">

<?php
	$nu	= mysql_fetch_array(mysql_query("SELECT login FROM users ORDER BY id DESC LIMIT 1"));
?>
<?php
	$nd	= mysql_fetch_array(mysql_query("SELECT * FROM deposits ORDER BY id DESC LIMIT 1"));
?>
<?php
	$no	= mysql_fetch_array(mysql_query("SELECT * FROM output ORDER BY id DESC LIMIT 1"));
?>
<div class="statistic">
	<div class="wrapper">
		<h1>Статистика Онлайн</h1>
		<div class="last-dep">
              <center><span style="color: #FFF5F6"><span style="font-size: 16px">Последние вклады</span></span></center>
			<ul> <br>
			<span style="color: #FFFFFF">
			   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td>Логин</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<td>Дата</td>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<td class="value">Сумма<hr></td></span>
			<?php
$sql	= 'SELECT * FROM deposits WHERE status = 0 ORDER BY id DESC LIMIT 6';
$rs		= mysql_query($sql);
$i		= 0;
while($a = mysql_fetch_array($rs)) {
	print '
								<center><span style="color: #FFF5F5"><tr>

    							<td>'.$a['username'].'</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<td>'.date("d.m.y H:i", $a['date']).'</td>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;
								<td class="value">$'.$a['sum'].'</td>
								</tr></span></center><span style="color: #FFFFFF">..................................................................................................................</span>
							';
$i++;
}

if($i == 0) {
	print '<tr><td><div class="m"><center>No found!</center></div></td></tr>';
}
?>
							</ul>
		</div>

		<div class="last-with">
			<ul>

               <center><span style="color: #FFF5F6"><span style="font-size: 16px">Топ рефералов</span></span></center><br>
			   
<span style="color: #FFFFFF">
			   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td>Логин</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<td>Пригласил</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<td class="value">Заработал<hr></td></span>
             	<?php
$sql	= 'SELECT * FROM users WHERE reftop >= 0 ORDER BY reftop DESC LIMIT 6';
$rs		= mysql_query($sql);

$i		= 0;
while($a = mysql_fetch_array($rs)) {
$sql2	= 'SELECT * FROM users WHERE ref = '.$a['id'].' ORDER BY id DESC LIMIT 800';
$rs2		= mysql_query($sql2);
$anum2 = mysql_num_rows($rs2);
	print '
								<center><span style="color: #FFF5F5"><tr>
    							<td>'.$a['login'].'</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<td>'.$anum2.'</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<td class="value">$'.$a['reftop'].'</td>
								</tr></span></center><span style="color: #FFFFFF">..................................................................................................................</span>
							';
$i++;
}

if($i == 0) {
	print '<tr><td><div class="m"><center>No found!</center></div></td></tr>';
}
?>







							</ul>
		</div>

		
		<div class="last-with">
			<ul>

               <center><span style="color: #FFF5F6"><span style="font-size: 16px">Последние выплаты</span></span></center><br>
			   
			   <span style="color: #FFFFFF">
			   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td>Логин</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<td>Дата</td>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<td class="value">Сумма<hr></td></span>
             	<?php
$sql	= 'SELECT * FROM output WHERE status = 2 ORDER BY id DESC LIMIT 6';
$rs		= mysql_query($sql);
$i		= 0;
while($a = mysql_fetch_array($rs)) {
	print '
								<center><span style="color: #FFF5F5"><tr>

    							<td>'.$a['login'].'</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<td>'.date("d.m.y H:i", $a['date']).'</td>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;
								<td class="value">$'.$a['sum'].'</td>
								</tr></span></center><span style="color: #FFFFFF">..................................................................................................................</span>
							';
$i++;
}

if($i == 0) {
	print '<tr><td><div class="m"><center>No found!</center></div></td></tr>';
}
$query2gr2	= "SELECT * FROM `graph` ORDER BY id DESC LIMIT 1";
$result2gr2	= mysql_query($query2gr2);
$row2gr2 = mysql_fetch_array($result2gr2);
$depmo = $depmoney - $row2gr2['depmoneyall'];
$withmo = $money - $row2gr2['moneywidthall'];
$cuse = $cusers - $row2gr2['cusersall'];
$query2gr	= "(SELECT * FROM `graph` ORDER BY id DESC LIMIT 5) ORDER BY id ASC";
$result2gr	= mysql_query($query2gr);
?>







							</ul>
		</div>

		<div class="clear"></div>
		<div style="background: rgba(255,255,255,0.6);">
		<div id="bar-statisti"></div>
		<div class="total-stat">
			<ul>
				<li class="users" style="color: rgb(77, 167, 77);">
					<span>Всего пользователей: <b><?php print $cusers; ?></b></span>
				</li>
				<li class="dep" style="color: rgb(11, 98, 164);">
					<span>Всего вкладов: <b>$<?php print $depmoney; ?></b></span>
				</li>
				<li class="with" style="color: rgb(106, 124, 148);">
					<span>Всего выплат: <b>$<?php print $money; ?> </b></span>
				</li>
			</ul>
		</div>
		</div>
		<?php 
$answerssqlka	= "SELECT * FROM `answers`WHERE view = 1 AND part = 0 ORDER BY id DESC LIMIT 3";
$queryanswerssqlka		= mysql_query($answerssqlka);
$numanswersa		= mysql_num_rows($queryanswerssqlka);
if($numanswersa > 0) {
print'<div style="width:100%;"><center style="margin: 20px 0 0 0;"><h1><span style="color: white;">Отзывы </span> <span style="color: rgb(200,200,200);">/</span> <a href="/answers" style="color:white;font-size:13px;"><u><h2 style="display:inline;"> Смотреть все</h2></u></a></h1></center>';
while ($rowa = mysql_fetch_array($queryanswerssqlka)) {
print'
<div class="blockanswer">
<div class="blockanswerinside">
<div class="textansw">'.$rowa['text'].'</div>
</div>
<div class="blockanswerwho">
<span style="background: rgba(255,255,255,0.3); border-radius:3px; border: solid 1px rgba(255,255,255,0.3);">&nbsp;<span style="color:rgb(0, 219, 0);;"><b>'.$rowa['username'].' </b></span>&nbsp;<span style="color:white;">'.date("d.m.Y", $rowa['date']).'</span></span>
</div>
</div>
</div>';
}
}
?>
	</div>
</div>
<script>
$(document).ready(function(){
$('.textansw').liTextLength({
    length: 320,                                    
    afterLength: '<a href="/answers" style="color:white;font-size:13px; text-decoration:none;">...</a>',                                    
    fullText:false
});
});
/*
График старт - By Vitiook
 */
Morris.Bar({
  element: 'bar-statisti',
  hideHover: 'auto',
  data: [
    <?php while($row2gr = mysql_fetch_array($result2gr)) {
echo '{y: \''.date("d-m-y H:i:s", $row2gr['date']).'\', a: '.sprintf("%01.2f", $row2gr['depmoney']).', b: '.sprintf("%01.2f", $row2gr['moneywidth']).', c: '.intval($row2gr['cusers']).' },';
}?>
{y: '<?php print date("d-m-y H:i:s", time());?>', a: <?php print sprintf("%01.2f", $depmo);?>, b: <?php print sprintf("%01.2f", $withmo);?>, c: <?php print $cuse;?> },
  ],
  xkey: 'y',
  ykeys: ['a', 'b', 'c'],
  barColors: ['#0b62a4', 'rgb(106, 124, 148)', '#4da74d'],
  labels: ['Вклады($)', 'Выплаты($)', 'Регистрации']
});
</script>