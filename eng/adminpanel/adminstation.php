<?php

#################################################
# Kubelance.ru
# ������ �����������  Zorro
# ���������: https://vk.com/kub_elance
# Skype: zorro.red (����� ������� ���� ������)
# ICQ: 602930609
# E-mail: lavric.10@mail.ru
#################################################



include "../cfg.php";

include "../ini.php";

if($status == 1 || $status == 2) {

?>


<!--���������-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

<title>������� ���������� �������� �<?php print $cfgURL; ?>�</title>

<link href="/files/favicon.ico" type="image/x-icon" rel="shortcut icon">

<link href="files/styles.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <!--link href="css/bootstrap.min.css" rel="stylesheet"-->

    <!-- Custom CSS -->
    <link href="/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="/css/jquery.toastmessage.css" rel="stylesheet">
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.toastmessage.js"></script>


   <script src="files/jquery.js"></script>

<!-- ����   -->
 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script type="text/javascript">
$(document).ready(function() {
$("#menu ul").hide();
$("#menu li span").click(function() {
    $("#menu ul:visible").slideUp("normal");
    if (($(this).next().is("ul")) && (!$(this).next().is(":visible"))) {
        $(this).next().slideDown("normal");
    }
});
});
</script>


<style type="text/css">
ul#menu, ul#menu ul{
  list-style:none;
  margin: 0px;
  padding: 0px;
  width: 225px;
  -webkit-box-shadow:0px 0px 5px 0px rgba(50, 50, 50, 0.2);
  -moz-box-shadow:0px 0px 5px 0px rgba(50, 50, 50, 0.2);
  box-shadow: 0px 0px 5px 0px rgba(50, 50, 50, 0.2);}
ul#menu a,ul#menu span{display: block; text-decoration: none;}
ul#menu li {margin-top: 1px;}
ul#menu li a,ul#menu li span{
  background: #428BCA;
  color: #fff;
  padding: 7px;}
ul#menu li a:hover,ul#menu li span:hover{background: #333;}
ul#menu li ul li a{
  background: #575757;
  color: #fff;
  padding-left: 20px;}
ul#menu li ul li a:hover{background: #ddd;}
</style>


<!-- ����   -->






</head>
<body>
    <div id="wrapper"><!--��� ����-->
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">���������</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="/">�� ����</a>
	</div>

	<!-- Top Menu Items -->

    	<div class="collapse navbar-collapse navbar-ex1-collapse">
	<ul class="nav navbar-nav side-nav">


				   <ul id="menu">



 <li><a href="?a=news">�������� �������</a></li>
 <li><a href="?a=add_page">������� ��������</a></li>
 <li><a href="?a=pages">��������� ��������</a></li>
 <li><a href="?a=paysystems">��������� �������</a></li>
 <li><a href="?a=deposits">��������</a></li>



 <li><span>���������</span>
    <ul>
        <li><a href="?a=settings">��������� �������</a></li>
        <li><a href="?a=plans">�������������� �����</a></li>
        <li><a href="?">����������� ������</a></li>
        <li><a href="?a=fake">�������� ����������</a></li>
        <li><a href="?a=users">���������� ��������������</a></li>
        <li><a href="?a=mailto">�������� �������������</a></li>

    </ul>
 </li>
 <li><span>������</span>
    <ul>
        <li><a href="?a=reftop">������� ���������</a></li>
        <li><a href="?a=blacklist">������ ������ IP</a></li>
        <li><a href="?a=edit">����� �������</a></li>
        <li><a href="?a=edit&s=2">���������� �����</a></li>

    </ul>
 </li>




      </ul>




</div>


</nav>

<div id="page-wrapper">
		<div class="container-fluid">
		<div>
			<!-- Nav tabs -->


			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane active" id="home">
					<!-- Flot Charts -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header"></h2>
		<p class="lead">�����- ������ ���������� ��������</p>
	</div>
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i></h3>
			</div>
			<div class="panel-body">
				<div class="flot-chart">
					<div class="flot-chart-content" id="flot-line-chart">
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
							   <?php

$a	= substr(addslashes(htmlspecialchars($_GET['a'], ENT_QUOTES, '')), 0, 15);



	if(!$a) {

		include "modules/index.php";

	} elseif(file_exists("modules/".$a.".php")) {

		include "modules/".$a.".php";

	} else {

		include "modules/error.php";

	}



?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>				</div>
				<div class="tab-pane fade" id="profile">
					<!-- Flot Charts -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">��� ����������</h2>
		<p class="lead">�� ���� �������� ���������� ��� ���������� �������, ������� �������� ����� ��������� �������.</p>
	</div>
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> ����������</h3>
			</div>
			<div class="panel-body">
				<div class="flot-chart">
					<div class="flot-chart-content" id="flot-line-chart">
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>id</th>
										<th>login</th>
										<th>�����</th>
										<th>����</th>
										<th>�������</th>
										<th>������</th>
									</tr>
								</thead>
								<tbody>
																		<tr>
										<td>
											5										</td>
										<td>
											declr										</td>
										<td>
											10.00										</td>
										<td>
											18-06 12:06:25										</td>
										<td>
											Payeer										</td>
										<td>
											�������										</td>
									</tr>
																	<tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>				</div>
			</div>
		</div>
		<script type="text/javascript">
			$('#myTab a').click(function (e) {
				e.preventDefault()
				$(this).tab('show')
			})
		</script>
	</div>
</div><!--�����-->
		<!-- /#wrapper -->



		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>

		<!-- Morris Charts JavaScript -->
		<script src="js/plugins/morris/raphael.min.js"></script>
		<!--<script src="js/plugins/morris/morris.min.js"></script>
		<script src="js/plugins/morris/morris-data.js"></script>-->
		<!-- jQuery Version 1.11.0 -->

	</body>
</html>

<?php

} else {

print "<html><head><script language=\"javascript\">top.location.href='index.php';</script></head><body><a href=\"index.php\"><b>Index</b></a></body></html>";

}

?>