<?php
define("BASE_URL","http://localhost/new-working/sahyogcare4u/sahyogcare4u-admin/");
define('UPLOADS_PATH', dirname(__DIR__) . '/uploads/');

$selected = 'selected="selected"';
$checked  = 'checked="checked"';

define('HOST','localhost');
define('DB','sahyogcare4u');
define('USER','root');
define('PASS','');
define('CHARSET','utf8mb4');

include("lib/DB.php");
$DB = new DB(HOST, USER, PASS, DB);


include("lib/function.php");
sec_session_start();
date_default_timezone_set("Asia/Calcutta");
$date = date("Y-m-d") . " " . date("H:i:s");


define("DEFAULT_TITLE", "Admin");
