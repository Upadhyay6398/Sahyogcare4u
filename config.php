<?php

define('BASE_URL', 'http://localhost/new-working/sahyogcare4u/');
 


$selected = 'selected="selected"';
$checked  = 'checked="checked"';

define('HOST','localhost');
define('DB','sahyogcare4u');
define('USER','root');
define('PASS','');
define('CHARSET','utf8mb4');

include("sahyogcare4u-admin/lib/DB.php");
$DB = new DB(HOST, USER, PASS, DB);


include("sahyogcare4u-admin/lib/function.php");
session_start();
date_default_timezone_set("Asia/Calcutta");
$date = date("Y-m-d") . " " . date("H:i:s");
define("DEFAULT_TITLE", "Sahyogcare4u");

// Other settings
define('CURRENCY', 'INR');
define('LANGUAGE', 'EN');

// AiSensy WhatsApp API Configuration
define('AISENSY_API_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY3ZjRmOTgxMWU0OTI4MGMxODRiY2YyZSIsIm5hbWUiOiJTYWh5b2cgQ2FyZSBGb3IgWW91IiwiYXBwTmFtZSI6IkFpU2Vuc3kiLCJjbGllbnRJZCI6IjY1YjBkM2M3M2JiM2M4NDQ0MTdmZTNhYyIsImFjdGl2ZVBsYW4iOiJGUkVFX0ZPUkVWRVIiLCJpYXQiOjE3NDQxMDc5MDV9.Dn8d7eW0tT2JQOA4SdEKZbPUD5EJdtXhMz9gg51tZ40'); // Replace with your actual API key
define('AISENSY_CAMPAIGN_NAME', 'donate_thank_you'); // Replace with your campaign name
define('AISENSY_API_URL', 'https://backend.aisensy.com/campaign/t1/api/v2');
