<?php
include('config.php');

// CCAvenue merchant details
$merchant_id = "46963";
$access_code = "AVLB03BK15AZ70BLZA";
$working_key = "837B00989D8265DC30CE0237CDA4C302";

// Customer inputs from the form
$amount = $_POST['amount'];
$name = $_POST['name'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$patient_id = $_POST['patient_id'];
$country = $_POST['country'];
$pan_number = $_POST['pan_number'];
$source = $_POST['source'] ?? 'Online Payment'; 
$utm_source = $_POST['utm_source'];
$utm_campaign=$_POST['utm_campaign'];
$donationDetails = $_POST['donationDetails'];

 
 
// Generate a unique transaction ID
$txnid = 'TXNID' . round(microtime(true) * 1000) . rand(0, 999);
$tstp = date("Y-m-d H:i:s");
$ip_address = $_SERVER['REMOTE_ADDR'];

// Check if payment record already exists
$sql = "SELECT * FROM `psu` WHERE order_id = :order_id";
$stmt = $DB->DB->prepare($sql);
$stmt->bindParam(':order_id', $txnid);
$stmt->execute();
$existingPayment = $stmt->fetch();

if (!$existingPayment) {
    // Insert data into psu table
    $paymentData = [
        'name'            => $name,
        'mobile'          => $mobile,
        'payment_status'  => 'Go To Gateway', 
        'country'         => $country,
        'pan_number'      => $pan_number,
        'amount'          => $amount,
        'email'           => $email,
        'tstp'            => $tstp,
        'ip_address'      => $ip_address,
        'source'          => $source,
        'patient_id'      => $patient_id,
        'payment_mode' => 'Pending', 
        'order_id'        => $txnid,
        'utm_campaign'  => $utm_campaign,
        'utm_source'      =>  $utm_source
       
    ];
 

    try {
        $res = $DB->insert('psu', $paymentData);
    } catch (Exception $e) {
        error_log("Error inserting payment data: " . $e->getMessage());
    }
}



$redirect_url = 'https://www.sahyogcare4u.org/payment-success.php';
$cancel_url = 'https://www.sahyogcare4u.org/payment-failed.php';

$data = [
    'tid' => $txnid,
    'merchant_id' => $merchant_id,
    'order_id' => $txnid,
    'amount' => $amount,
    'source' => $source,
    'currency' => 'INR',
    'redirect_url' => $redirect_url,
    'cancel_url' => $cancel_url,
    'language' => 'EN',
    'billing_name' => $name,
    'billing_tel' => $mobile,
    'billing_email' => $email,
    'merchant_param1' => $source,
    'merchant_param2' => $patient_id,
    'merchant_param3' => $pan_number,
    'merchant_param4' => $country,
    'merchant_param5' => $utm_source,
    'merchant_param6' => $utm_campaign

];

$merchant_data = http_build_query($data);

// Encrypt function
function encrypt($plainText, $key) {
    $key = pack('H*', md5($key));
    $iv = pack('C*', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15);
    $blockSize = 16;
    $pad = $blockSize - (strlen($plainText) % $blockSize);
    $plainText .= str_repeat(chr($pad), $pad);
    return bin2hex(openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv));
}

$encrypted_data = encrypt($merchant_data, $working_key);

?>

<!DOCTYPE html>
<html>
<head><title>Redirecting to Sahyogcare Payment Gateway...</title></head>
<body onload="document.forms['ccavenue'].submit();">
    <h3>Redirecting to Payment Gateway...</h3>
    <form name="ccavenue" method="post" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
        <input type="hidden" name="encRequest" value="<?= $encrypted_data ?>">
        <input type="hidden" name="access_code" value="<?= $access_code ?>">
    </form>
</body>
</html>
