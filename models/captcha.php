<?php
session_save_path('/home/users/web/b2874/ipg.hitchmede/cgi-bin/tmp');
session_start();
$md5_hash = md5(rand(0,99999));
$security_code = substr($md5_hash, 25, 5); 
$enc = md5($security_code);
$_SESSION['captcha'] = $enc;
$width = 100;
$height = 20;

$image = ImageCreate($width, $height);
$white = ImageColorAllocate($image, 255, 255, 255);
$black = ImageColorAllocate($image, 0, 0, 0);
$red = ImageColorAllocate($image, 200, 0, 0);
$grey = ImageColorAllocate($image, 200, 200, 200);

ImageFill($image, 0, 0, $grey);
ImageString($image, 10, 5, 0, $security_code, $red);

header("Content-Type: image/png"); 
ImagePng($image);
ImageDestroy($image);