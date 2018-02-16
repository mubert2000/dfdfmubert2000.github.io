<?php
umask(0);
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
$w = $_GET['w'];
$h = $_GET['h'];
$i = $_GET['i'];
$img = ROOT.$i;
$size = getimagesize($img);

if (!$size || !$w || !$h) {
	header('HTTP/1.0 404 Not Found');
	return;
}

header("Cache-Control: max-age=3600, must-revalidate");

$tnw = $size[0];
$tnh = $size[1];

if ($tnw > $w) {
	$tnh = $tnh / ($tnw / $w);
	$tnw = $w;
}
if ($tnh > $h) {
	$tnw = $tnw / ($tnh / $h);
	$tnh = $h;
}

$tnw = (int)$tnw;
$tnh = (int)$tnh;

header("Content-type: image/jpeg");
$bgimg = imagecreatefromjpeg($img);
$thumb = imagecreatetruecolor($tnw, $tnh);
imagecopyresampled($thumb, $bgimg, 0, 0, 0, 0, $tnw, $tnh, $size[0], $size[1]);
imagejpeg($thumb, '', 90);
imagedestroy($thumb);
?>