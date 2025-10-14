<?php
include("../config.php");

if (isAjax()) { 
    $email    = sanitizeString($_POST['email']);
    $password = sanitizeString($_POST['password']);
    $otp_code = sanitizeString($_POST['google_secret']);

    if (login($email, $password, $otp_code) === true) {
        $arr = ["status" => "success", "msg" => ""];
    } else {
        $arr = ["status" => "error", "msg" => "Invalid login details or 2FA code"];
    }
    
    echo json_encode($arr);
    exit;
}

// Optional fallback response for non-AJAX access
echo json_encode(["status" => "error", "msg" => "Invalid access"]);
