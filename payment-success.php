<?php
session_start();
include('config.php');
require_once('lib/Mail.php');
require_once('lib/PHPMailerAutoload.php');

// Decryption function
function decrypt($encryptedText, $key) {
    $key = pack('H*', md5($key));
    $iv = pack('C*', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15);
    $encryptedText = hex2bin($encryptedText);
    $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    $pad = ord(substr($decryptedText, -1));
    return substr($decryptedText, 0, -$pad);
}

$workingKey = '837B00989D8265DC30CE0237CDA4C302';

if (isset($_POST["encResp"])) {
    $encResponse = $_POST["encResp"];
    $rcvdString = decrypt($encResponse, $workingKey);
    parse_str($rcvdString, $data); 

    error_log("Decrypted CCAvenue Response: " . $rcvdString);

    if (!$rcvdString || strpos($rcvdString, 'order_status=') === false) {
        header("Location: payment-failed.php");
        exit;
    }

    $order_status = strtolower($data['order_status'] ?? '');
    $order_id = $data['order_id'] ?? '';
    $tracking_id = $data['tracking_id'] ?? '';
    $amount = $data['amount'] ?? '';
    $payment_mode = $data['payment_mode'] ?? 'Online';
    $name = $data['billing_name'] ?? '';
    $mobile = $data['billing_tel'] ?? '';
    $email = $data['billing_email'] ?? '';
    $tstp = date("Y-m-d H:i:s");
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $source = $data['merchant_param1'] ?? '';
    $patient_id = $data['merchant_param2'] ?? '';
    $pan_number = $data['merchant_param3'] ?? '';
    $country = $data['merchant_param4'] ?? '';
    $utm_source = $data['merchant_param5'] ?? '';
    $utm_campaign = $data['merchant_param6'] ?? '';
    $billing_address = $data['billing_address'] ?? '';
    $billing_city = $data['billing_city'] ?? '';
    $billing_state = $data['billing_state'] ?? '';
    $billing_zip = $data['billing_zip'] ?? '';
    $billing_country = $data['billing_country'] ?? '';
    


$full_address = trim("{$billing_address}, {$billing_city}, {$billing_state} - {$billing_zip}, {$billing_country}");

    // Prepare payment data for insertion
    $paymentData = [
        'name'            => $name,
        'mobile'          => $mobile,
        'payment_status'  => $order_status === 'success' ? 'success' : 'failed',
        'amount'          => $amount,
        'email'           => $email,
        'pan_number'      => $pan_number,
        'country'         => $country,
        'tstp'            => $tstp,
        'ip_address'      => $ip_address,
        'source'          => $source,
        'utm_campaign'      =>$utm_campaign,
        'utm_source'        =>$utm_source,
        'patient_id'      => $patient_id,
        'payment_mode'    => $payment_mode,
        'order_id'        => $order_id,
        'address'         => $full_address,
        'tracking_id'     => $tracking_id
       
    ];

    try {
 
        $DB->insert('payments', $paymentData);
         $last_id = $DB->lastInsertId();
         $_SESSION['last_id'] = $last_id; 
        $sqlDelete = "DELETE FROM psu WHERE order_id = :order_id";
        $stmtDelete = $DB->DB->prepare($sqlDelete);
        $stmtDelete->bindParam(':order_id', $order_id);
        $stmtDelete->execute();

        // Handle success or failure redirection
        if ($order_status === "success") {
            // Store data in session to show in thank-you.php
            $_SESSION['txn_id'] = $order_id;
            $_SESSION['amount'] = $amount;
            $_SESSION['name'] = $name;

            // Send email notifications
            $msg = "
                <html><body>
                <table border='1' cellpadding='6'>
                    <tr><td><strong>Name</strong></td><td>$name</td></tr>
                    <tr><td><strong>Email</strong></td><td>$email</td></tr>
                    <tr><td><strong>Mobile</strong></td><td>$mobile</td></tr>
                    <tr><td><strong>Transaction ID</strong></td><td>$order_id</td></tr>
                    <tr><td><strong>Amount</strong></td><td>$amount</td></tr>
                    <tr><td><strong>Payment Mode</strong></td><td>$payment_mode</td></tr>
                    <tr><td><strong>Source</strong></td><td>$source</td></tr>
                    <tr><td><strong>Date</strong></td><td>$tstp</td></tr>
                </table></body></html>";
        
 
            sendmailToAdmin("Payment Success: Sahyogcare4u", $msg);
            sendMailToUserForPayment($email, $name, "Payment Success: Sahyogcare4u", $source);
            
            // Send WhatsApp message via AiSensy (non-blocking)
            try {
                $whatsappSent = sendWhatsAppMessage($mobile, $name, $amount);
                if ($whatsappSent) {
                    error_log("WhatsApp message sent successfully to $mobile");
                } else {
                    error_log("Failed to send WhatsApp message to $mobile");
                }
            } catch (Exception $e) {
                error_log("WhatsApp error: " . $e->getMessage());
                // Continue execution even if WhatsApp fails
            }

            // Redirect to thank-you page
            echo "<script>window.location.href='thank-you.php';</script>";
            exit;
        } else {
            // If payment failed, just redirect to failed page
            header("Location: payment-failed.php");
            exit;
        }
    } catch (Exception $e) {
        error_log("Error inserting payment data: " . $e->getMessage());
        header("Location: payment-failed.php");
        exit;
    }
} else {
    header('Location: payment-failed.php');
    exit;
}
?>
