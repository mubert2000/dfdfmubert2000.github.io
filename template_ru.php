<?php
defined('ACCESS') or die();
if(cfgSET('cfgOnOff') == "off" && $status != 1) {
	include "includes/errors/tehwork.php";
	exit();
} elseif(cfgSET('cfgOnOff') == "off" && $status == 1) {
	print '<p align="center" class="warn">Сайт отключен</p>';
}
?>



<!DOCTYPE html>
<html lang="en-US" style="" class=" js flexbox flexboxlegacy canvas canvastext draganddrop rgba multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients csstransitions generatedcontent video audio localstorage desktop portrait csstransforms csstransforms3d"><!--<![endif]--><head>
<title>Veritas Donum</title>
<meta name="description" content=" | ">
<meta charset="UTF-8"><script type="text/javascript" src="http://bam.nr-data.net/1/72d7dcce33?a=1388850&amp;pl=1442670590544&amp;v=686.b365e66&amp;to=ZV1TZ0FTVkFVWkwKXlwXcFBHW1dcG0lZBFQfUF5eVg%3D%3D&amp;ap=2180&amp;be=835&amp;fe=2332&amp;dc=1721&amp;f=%5B%5D&amp;perf=%7B%22timing%22:%7B%22of%22:1442670590544,%22n%22:0,%22dl%22:786,%22di%22:2556,%22ds%22:2556,%22de%22:2736,%22dc%22:3162,%22l%22:3167,%22le%22:3174,%22r%22:699,%22re%22:780,%22f%22:780,%22dn%22:780,%22dne%22:780,%22c%22:780,%22ce%22:780,%22rq%22:781,%22rp%22:784,%22rpe%22:785%7D,%22navigation%22:%7B%22rc%22:1%7D%7D&amp;at=SRpQEQlJRU8%3D&amp;jsonp=NREUM.setToken"></script><script src="http://js-agent.newrelic.com/nr-686.min.js"></script><script type="text/javascript" async="" src="http://www.google-analytics.com/ga.js"></script><script async="" src="//ajax.cloudflare.com/cdn-cgi/nexp/dok3v=e9627cd26a/cloudflare.min.js"></script><script type="text/javascript">
//<![CDATA[
try{if (!window.CloudFlare) {var CloudFlare=[{verbose:0,p:1442427997,byc:0,owlid:"cf",bag2:1,mirage2:0,oracle:0,paths:{cloudflare:"/cdn-cgi/nexp/dok3v=1613a3a185/"},atok:"bad9f7431c4583d8841bd3a97cd74a16",petok:"65a5c9fddddb89c5be3b51d0fb69cdd26aa7fc4d-1442670551-86400",betok:"470df66b28ebf796a72e31a4d8ef0178e17df49a-1442670551-120",zone:"template-help.com",rocket:"0",apps:{"abetterbrowser":{"ie":"7"},"ga_key":{"ua":"UA-7078796-5","ga_bs":"2"}}}];!function(a,b){a=document.createElement("script"),b=document.getElementsByTagName("script")[0],a.async=!0,a.src="//ajax.cloudflare.com/cdn-cgi/nexp/dok3v=e9627cd26a/cloudflare.min.js",b.parentNode.insertBefore(a,b)}()}}catch(e){};
//]]>
</script>
<script type="text/javascript">window.NREUM||(NREUM={}),__nr_require=function(e,n,t){function r(t){if(!n[t]){var o=n[t]={exports:{}};e[t][0].call(o.exports,function(n){var o=e[t][1][n];return r(o?o:n)},o,o.exports)}return n[t].exports}if("function"==typeof __nr_require)return __nr_require;for(var o=0;o<t.length;o++)r(t[o]);return r}({QJf3ax:[function(e,n){function t(e){function n(n,t,a){e&&e(n,t,a),a||(a={});for(var u=c(n),f=u.length,s=i(a,o,r),p=0;f>p;p++)u[p].apply(s,t);return s}function a(e,n){f[e]=c(e).concat(n)}function c(e){return f[e]||[]}function u(){return t(n)}var f={};return{on:a,emit:n,create:u,listeners:c,_events:f}}function r(){return{}}var o="nr@context",i=e("gos");n.exports=t()},{gos:"7eSDFh"}],ee:[function(e,n){n.exports=e("QJf3ax")},{}],3:[function(e,n){function t(e){return function(){r(e,[(new Date).getTime()].concat(i(arguments)))}}var r=e("handle"),o=e(1),i=e(2);"undefined"==typeof window.newrelic&&(newrelic=window.NREUM);var a=["setPageViewName","addPageAction","setCustomAttribute","finished","addToTrace","inlineHit","noticeError"];o(a,function(e,n){window.NREUM[n]=t("api-"+n)}),n.exports=window.NREUM},{1:12,2:13,handle:"D5DuLP"}],gos:[function(e,n){n.exports=e("7eSDFh")},{}],"7eSDFh":[function(e,n){function t(e,n,t){if(r.call(e,n))return e[n];var o=t();if(Object.defineProperty&&Object.keys)try{return Object.defineProperty(e,n,{value:o,writable:!0,enumerable:!1}),o}catch(i){}return e[n]=o,o}var r=Object.prototype.hasOwnProperty;n.exports=t},{}],D5DuLP:[function(e,n){function t(e,n,t){return r.listeners(e).length?r.emit(e,n,t):void(r.q&&(r.q[e]||(r.q[e]=[]),r.q[e].push(n)))}var r=e("ee").create();n.exports=t,t.ee=r,r.q={}},{ee:"QJf3ax"}],handle:[function(e,n){n.exports=e("D5DuLP")},{}],XL7HBI:[function(e,n){function t(e){var n=typeof e;return!e||"object"!==n&&"function"!==n?-1:e===window?0:i(e,o,function(){return r++})}var r=1,o="nr@id",i=e("gos");n.exports=t},{gos:"7eSDFh"}],id:[function(e,n){n.exports=e("XL7HBI")},{}],G9z0Bl:[function(e,n){function t(){var e=d.info=NREUM.info,n=f.getElementsByTagName("script")[0];if(e&&e.licenseKey&&e.applicationID&&n){c(p,function(n,t){n in e||(e[n]=t)});var t="https"===s.split(":")[0]||e.sslForHttp;d.proto=t?"https://":"http://",a("mark",["onload",i()]);var r=f.createElement("script");r.src=d.proto+e.agent,n.parentNode.insertBefore(r,n)}}function r(){"complete"===f.readyState&&o()}function o(){a("mark",["domContent",i()])}function i(){return(new Date).getTime()}var a=e("handle"),c=e(1),u=window,f=u.document;e(2);var s=(""+location).split("?")[0],p={beacon:"bam.nr-data.net",errorBeacon:"bam.nr-data.net",agent:"js-agent.newrelic.com/nr-686.min.js"},d=n.exports={offset:i(),origin:s,features:{}};f.addEventListener?(f.addEventListener("DOMContentLoaded",o,!1),u.addEventListener("load",t,!1)):(f.attachEvent("onreadystatechange",r),u.attachEvent("onload",t)),a("mark",["firstbyte",i()])},{1:12,2:3,handle:"D5DuLP"}],loader:[function(e,n){n.exports=e("G9z0Bl")},{}],12:[function(e,n){function t(e,n){var t=[],o="",i=0;for(o in e)r.call(e,o)&&(t[i]=n(o,e[o]),i+=1);return t}var r=Object.prototype.hasOwnProperty;n.exports=t},{}],13:[function(e,n){function t(e,n,t){n||(n=0),"undefined"==typeof t&&(t=e?e.length:0);for(var r=-1,o=t-n||0,i=Array(0>o?0:o);++r<o;)i[r]=e[n+r];return i}n.exports=t},{}]},{},["G9z0Bl"]);</script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="//gmpg.org/xfn/11">
<link rel="icon" href="/filessite/favicon.ico" type="image/x-icon">
<link rel="pingback" href="/filessite//xmlrpc.php">
<link rel="stylesheet" type="text/css" media="all" href="/filessite/bootstrap.css">
<link rel="stylesheet" type="text/css" media="all" href="/filessite/responsive.css">
<link rel="stylesheet" type="text/css" media="all" href="/filessite/camera.css">
<link rel="stylesheet" type="text/css" media="all" href="/filessite/style.css">

<link rel="stylesheet" id="flexslider-css" href="/filessite/flexslider.css?ver=2.2.0" type="text/css" media="all">
<link rel="stylesheet" id="owl-carousel-css" href="/filessite/owl.carousel.css?ver=1.24" type="text/css" media="all">
<link rel="stylesheet" id="owl-theme-css" href="/filessite/owl.theme.css?ver=1.24" type="text/css" media="all">
<link rel="stylesheet" id="font-awesome-css" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css?ver=3.2.1" type="text/css" media="all">
<link rel="stylesheet" id="cherry-plugin-css" href="/filessite/cherry-plugin.css?ver=1.2.6" type="text/css" media="all">
<link rel="stylesheet" id="cherry-lazy-load-css" href="/filessite/lazy-load.css?ver=1.0" type="text/css" media="all">
<link rel="stylesheet" id="cherry-parallax-css" href="/filessite/parallax.css?ver=1.0.0" type="text/css" media="all">
<link rel="stylesheet" id="contact-form-7-css" href="/filessite/styles.css?ver=3.8" type="text/css" media="all">
<link rel="stylesheet" id="theme52603-css" href="/filessite/main-style.css" type="text/css" media="all">
<link rel="stylesheet" id="magnific-popup-css" href="/filessite/magnific-popup.css?ver=0.9.3" type="text/css" media="all">
<link rel="stylesheet" id="options_typography_Open+Sans-css" href="//fonts.googleapis.com/css?family=Open+Sans&amp;subset=latin" type="text/css" media="all">
<link rel="stylesheet" id="mpce-theme-css" href="/filessite/theme.css?ver=1.5.6" type="text/css" media="all">
<link rel="stylesheet" id="mpce-bootstrap-grid-css" href="/filessite/bootstrap-grid.min.css?ver=1.5.6" type="text/css" media="all">
<script type="text/javascript" src="/filessite/jquery-1.7.2.min.js?ver=1.7.2"></script><style type="text/css">.cf-hidden { display: none; } .cf-invisible { visibility: hidden; }</style>
<script type="text/javascript" src="/filessite/theme-script.js?ver=1.0"></script>
<script type="text/javascript" src="/filessite/circles.min.js?ver=1.0"></script>
<script type="text/javascript" src="/filessite/jquery.counterup.min.js?ver=1.0"></script>
<script type="text/javascript" src="/filessite/jquery-migrate-1.2.1.min.js?ver=1.2.1"></script>
<script type="text/javascript" src="/filessite/swfobject.js?ver=2.2-20120417"></script>
<script type="text/javascript" src="/filessite/modernizr.js?ver=2.0.6"></script>
<script type="text/javascript" src="/filessite/jflickrfeed.js?ver=1.0"></script>
<script type="text/javascript" src="/filessite/jquery.easing.1.3.js?ver=1.3"></script>
<script type="text/javascript" src="/filessite/custom.js?ver=1.0"></script>
<script type="text/javascript" src="/filessite/bootstrap.min.js?ver=2.3.0"></script>
<script type="text/javascript" src="/filessite/jquery.elastislide.js?ver=1.2.6"></script>
<style type="text/css">body{background-color:#f2f5f8}.header{background-color:#4389a2}</style>
<style type="text/css">h1{font:normal 48px/62px Open Sans;color:#34495e;}h2{font:normal 36px/50px Open Sans;color:#31384d;}h3{font:normal 30px/39px Open Sans;color:#31384d;}h4{font:normal 28px/32px Open Sans;color:#31384d;}h5{font:normal 22px/29px Open Sans;color:#31384d;}h6{font:normal 18px/29px Open Sans;color:#31384d;}body{font-weight:normal;}.logo_h__txt,.logo_link{font:normal 32px/42px Open Sans;color:#ffffff;}.sf-menu>li>a{font:normal 16px/22px Open Sans;color:#ffffff;}.nav.footer-nav a{font:normal 15px/23px Open Sans;color:#4389a2;}</style>


<!--<![endif]-->
<script type="text/javascript">
		// Init navigation menu
		jQuery(function(){
		// main navigation init
			jQuery('ul.sf-menu').superfish({
				delay: 1000, // the delay in milliseconds that the mouse can remain outside a sub-menu without it closing
				animation: {
					opacity: "show",
					height: "show"
				}, // used to animate the sub-menu open
				speed: "normal", // animation speed
				autoArrows: false, // generation of arrow mark-up (for submenu)
				disableHI: true // to disable hoverIntent detection
			});

		//Zoom fix
		//IPad/IPhone
			var viewportmeta = document.querySelector && document.querySelector('meta[name="viewport"]'),
				ua = navigator.userAgent,
				gestureStart = function () {
					viewportmeta.content = "width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0";
				},
				scaleFix = function () {
					if (viewportmeta && /iPhone|iPad/.test(ua) && !/Opera Mini/.test(ua)) {
						viewportmeta.content = "width=device-width, minimum-scale=1.0, maximum-scale=1.0";
						document.addEventListener("gesturestart", gestureStart, false);
					}
				};
			scaleFix();
		})
	</script>
 
<script type="text/javascript">
		jQuery(document).ready(function(){
			if(!device.mobile() && !device.tablet()){
				jQuery('header .nav-wrap').tmStickUp({
					correctionSelector: jQuery('#wpadminbar')
				,	listenSelector: jQuery('.listenSelector')
				,	active: true				,	pseudo: true				});
			}
		})
	</script>
<script type="text/javascript">
/* <![CDATA[ */
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-7078796-5']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

(function(b){(function(a){"__CF"in b&&"DJS"in b.__CF?b.__CF.DJS.push(a):"addEventListener"in b?b.addEventListener("load",a,!1):b.attachEvent("onload",a)})(function(){"FB"in b&&"Event"in FB&&"subscribe"in FB.Event&&(FB.Event.subscribe("edge.create",function(a){_gaq.push(["_trackSocial","facebook","like",a])}),FB.Event.subscribe("edge.remove",function(a){_gaq.push(["_trackSocial","facebook","unlike",a])}),FB.Event.subscribe("message.send",function(a){_gaq.push(["_trackSocial","facebook","send",a])}));"twttr"in b&&"events"in twttr&&"bind"in twttr.events&&twttr.events.bind("tweet",function(a){if(a){var b;if(a.target&&a.target.nodeName=="IFRAME")a:{if(a=a.target.src){a=a.split("#")[0].match(/[^?=&]+=([^&]*)?/g);b=0;for(var c;c=a[b];++b)if(c.indexOf("url")===0){b=unescape(c.split("=")[1]);break a}}b=void 0}_gaq.push(["_trackSocial","twitter","tweet",b])}})})})(window);
/* ]]> */
</script>
<style type="text/css">@media(max-width: 767px){.sf-menu{display:none;} .select-menu{display: block;}}</style></head>

<body class="page page-id-7 page-template page-template-page-fullwidth-php" >
<div id="motopress-main" class="main-holder">
 
<header class="motopress-wrapper header">
<div class="container">
<div class="row">
<div class="span12" data-motopress-wrapper-file="wrapper/wrapper-header.php" data-motopress-wrapper-type="header" data-motopress-id="55ff2045df5f2">
<div class="nav-wrap" style="position: relative; top: 0px;">
<div class="row">
<div class="span3" data-motopress-type="static" data-motopress-static-file="static/static-logo.php">
 
<div class="logo pull-left">
<a href="/" class="logo_h logo_h__img"><img src="/filessite/logo.png" alt="Sandy" title=""></a>
</div>
  </div>
<div class="span9">
<div class="menu-wrap" data-motopress-type="static" data-motopress-static-file="static/static-nav.php">
 
<nav class="nav nav__primary clearfix">
<ul id="topnav" class="sf-menu sf-js-enabled"><li id="menu-item-1807" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="/">Главная</a></li>

<li id="menu-item-1811" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="/news/">Новости</a></li>
<li id="menu-item-1812" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="/faq/">FAQ</a></li>
<li id="menu-item-1805" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="/about/">О компании</a></li>

</li>
<li id="menu-item-1809" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="/contacts/">Контакты</a></li>

 <?php

if(!$login) {
?>
<li id="menu-item-1813" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="/registration/">Регистрация</a></li>
<?php
} else {

?>
<?php

}

?>



 <?php

if(!$login) {
?>
<li id="menu-item-1813" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="/login/">Авторизация</a></li>
<?php
} else {

?>
<li id="menu-item-1814" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a href="/deposit/">Кабинет</a>
<?php

}

?>

</ul></nav>  </div>


</div>
</div>
</div><div class="pseudoStickyBlock" style="position: relative; display: block; height: 0px;"></div> </div>
</div>
</div>
</header><div class="block2">
    <div class="wrapper" style="    background: #FFF;     padding: 40px;">
		<h3><?php print $title; ?>:</h3>
		<br>
	   	<?php		
	defined('ACCESS') or die();
	
	$cusers		= mysql_num_rows(mysql_query("SELECT id FROM users")) + cfgSET('fakeusers');
$cwm		= mysql_num_rows(mysql_query("SELECT id FROM users WHERE pm_balance != 0 OR lr_balance != 0")) + cfgSET('fakeactiveusers');

$money	= cfgSET('fakewithdraws');
$query	= "SELECT sum FROM output WHERE status = 2";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$money = $money + $row['sum'];
}

$depmoney	= cfgSET('fakedeposits');
$query	= "SELECT sum FROM deposits WHERE status = 0";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$depmoney = $depmoney + $row['sum'];
}
	
	if(!$page) {
		include "includes/index.php";
	} elseif(file_exists("../".$page."/index.php")) {

		include "../".$page."/".$page."_ru.php";
	} else {
		include "includes/errors/404.php";
	}
	
#$dategraph = "\'".date("d-m-y H:i:s", time())."\'";
#$graph1 = mysql_query('SELECT * FROM graph ORDER BY date DESC LIMIT 1');
#$graph = mysql_fetch_array($graph1);
#if($graph['date'] < (time() - 86400)) {
#$graphres = '{ y: '.$dategraph.', a: '.sprintf("%01.2f", $depmoney).', b: '.sprintf("%01.2f", $money).', c: '.$cusers.' },';
#mysql_query("INSERT INTO `graph` (`date`, `graphres`) VALUES ('".time()."', '".$graphres."')");
#}
?>
		</div>
	</div>
</div>		
<footer class="motopress-wrapper footer">
<div class="container">
<div class="row">
<div class="span12" data-motopress-wrapper-file="wrapper/wrapper-footer.php" data-motopress-wrapper-type="footer" data-motopress-id="55fd381d05ab6">
<div class="full-width-bg">
<div class="row">
<center><div class="span12" data-motopress-type="dynamic-sidebar" data-motopress-sidebar-id="footer-sidebar-1">
<img src="https://veritas-donum.com/images/partners.png"></div></center></div> </div>
</div>
</div>
<div class="row copyright">
<div class="span4 with-padding">
<div style="
    padding-left: 5px;
" data-motopress-type="static" data-motopress-static-file="static/static-footer-text.php">
<div id="footer-text" class="footer-text">
<a href="#" title="" class="footer-logo">VD</a>
<p class="desc">Одна из лидирующих компаний Российского сегмента</p>
 
</div> </div>
<div class="social-wrap" data-motopress-type="static" data-motopress-static-file="static/static-social.php">
<script type="text/javascript">(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();</script>
<div class="pluso" data-background="#ebebeb" data-options="big,square,line,horizontal,nocounter,theme=04" data-services="vkontakte,facebook,twitter,google"></div></div>
</div>
<div class="span2" data-motopress-type="static" data-motopress-static-file="static/static-footer-nav.php">
<div><h4>Навигация</h4></div>
<nav class="nav footer-nav">
<ul id="menu-footer-menu" class="menu"><li id="menu-item-1816" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-203 current_page_item menu-item-1816"><a href="/">Главная</a></li>
<li id="menu-item-1821" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1821"><a href="/about/">О компании</a></li>
<li id="menu-item-1820" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1820"><a href="/news/">Новости</a></li>
<li id="menu-item-1819" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1819"><a href="/faq/">FAQ</a></li>
<li id="menu-item-1817" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1817"><a href="/registration/">Регистрация</a></li>
<li id="menu-item-1818" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1818"><a href="/login/">Авторизация</a></li>
</ul> </nav>
</div>
<div class="span3" data-motopress-type="dynamic-sidebar" data-motopress-sidebar-id="footer-sidebar-2">
<div id="text-6" class="visible-all-devices "> <div class="textwidget"><p style="
    font: bold 25px/1.2em 'Open Sans', sans-serif;
" class="telephone">926 433 76 13</p>
<p class="desc">ПН - ПН с 9:00 до 19:00</p>
<p class="city">Нижний Новгород</p>
<p>ул. Ленина д. 41/2, 603135</p></div>
</div> </div>
<div class="span3" data-motopress-type="dynamic-sidebar" data-motopress-sidebar-id="footer-sidebar-3">
<div id="text-7" class="visible-all-devices "><h4>Информация</h4> <div class="textwidget">Компания предоставляет услуги на основании закона Российской федерации о доверительном управлении</div>
</div> </div>
</div> </div>
</div>
</div>
</footer>
 
</div>
<div id="back-top-wrapper" class="visible-desktop">
<p id="back-top" style="display: none;">
<a href="#top"><span></span></a> </p>
</div>
<script type="text/javascript" src="/filessite/comment-reply.min.js?ver=4.0.8"></script>
<script type="text/javascript" src="/filessite/cherry.lazy-load.js?ver=1.0"></script>
<script type="text/javascript" src="/filessite/device.min.js?ver=1.0.0"></script>
<script type="text/javascript" src="/filessite/jquery.mousewheel.min.js?ver=3.0.6"></script>
<script type="text/javascript" src="/filessite/jquery.simplr.smoothscroll.min.js?ver=1.0"></script>
<script type="text/javascript" src="/filessite/cherry.parallax.js?ver=1.0.0"></script>
<script type="text/javascript" src="/filessite/jquery.form.min.js?ver=3.50.0-2014.02.05"></script>
<script type="text/javascript" src="/filessite/scripts.js?ver=3.8"></script>
<script type="text/javascript" src="/filessite/waypoints.min.js?ver=1.0"></script>
<script type="text/javascript" src="/filessite/superfish.js?ver=1.5.3"></script>
<script type="text/javascript" src="/filessite/jquery.mobilemenu.js?ver=1.0"></script>
<script type="text/javascript" src="/filessite/jquery.magnific-popup.min.js?ver=0.9.3"></script>
<script type="text/javascript" src="/filessite/jquery.flexslider-min.js?ver=2.2.2"></script>
<script type="text/javascript" src="/filessite/jplayer.playlist.min.js?ver=2.3.0"></script>
<script type="text/javascript" src="/filessite/jquery.jplayer.min.js?ver=2.6.0"></script>
<script type="text/javascript" src="/filessite/tmstickup.js?ver=1.0.0"></script>
<script type="text/javascript" src="/filessite/device.min.js?ver=1.0.0"></script>
<script type="text/javascript" src="/filessite/jquery.zaccordion.min.js?ver=2.1.0"></script>
<script type="text/javascript" src="/filessite/camera.min.js?ver=1.3.4"></script>
<script type="text/javascript" src="/filessite/jquery.debouncedresize.js?ver=1.0"></script>
<script type="text/javascript" src="/filessite/jquery.ba-resize.min.js?ver=1.1"></script>
<script type="text/javascript" src="/filessite/jquery.isotope.js?ver=1.5.25"></script>
<script type="text/javascript" src="/filessite/cherry-plugin.js?ver=1.2.6"></script>
<script type="text/javascript" src="/filessite/jquery.mousewheel.min.js?ver=3.0.6"></script>
<script type="text/javascript" src="/filessite/jquery.simplr.smoothscroll.min.js?ver=1.0"></script>

<script type="text/javascript">
				deleteCookie('cf-cookie-banner');
			</script>
 

</body></html>