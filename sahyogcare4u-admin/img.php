<?php
define("UPLOAD_PATH","/home/u969498716/domains/3dproductsindia.in/upload/");

$file = base64_decode($_GET['file']);
$file = str_replace('..','',$file);
$ext  = pathinfo($file,PATHINFO_EXTENSION);

if($ext=="png"){
	$type = 'image/png';
} else if($ext=="jpeg"){
	$type = 'image/jpeg';
} else if($ext=="jpg"){
	$type = 'image/jpeg';
} 

header('Content-Type: '.$type);
header('Content-Length: ' . filesize(UPLOAD_PATH.$file));
echo file_get_contents(UPLOAD_PATH.$file);