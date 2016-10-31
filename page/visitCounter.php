<?php
if (!isset($_COOKIE['id_count'])) $id_count = 0;
else $id_count = $_COOKIE['id_count'];
$id_count++;
setcookie('id_count', $id_count, 0x6FFFFFFF);

header("Content-type: image/png");

$img = imagecreate(88, 31);
$white = imagecolorallocate($img, 255, 255, 255);
$grey = imagecolorallocate($img, 128, 128, 128);
$black = imagecolorallocate($img, 0, 0, 0);

imagerectangle($img, 0, 0, 87, 30, $black);

$fontfile = '/page/arial.ttf';

$str = 'Мой счетчик';
// $str = iconv("windows-1251", "windows-1251", $str);
imagettftext($img, 8, 0, 11, 13, $grey, $fontfile, $str);
$mass = imagettfbbox(12, 0, $fontfile, $id_count);
$width = intval((88 - $mass[2]) / 2);
imagettftext($img, 12, 0, $width, 27, $grey, $fontfile, $id_count);
imagepng($img);
imagedestroy($img);
?>
