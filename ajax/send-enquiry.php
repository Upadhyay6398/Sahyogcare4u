<?php
header('Content-Type: application/json');
include('../config.php');
require_once('../lib/Mail.php');
require_once('../lib/PHPMailerAutoload.php');

$error = ['status' => 'error', 'message' => 'Unknown error occurred.'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = sanitizeString($_POST['name'] ?? '');
    $email   = sanitizeString($_POST['email'] ?? '');
    $phone   = sanitizeString($_POST['phone'] ?? '');
    $subject = sanitizeString($_POST['subject'] ?? '');
    $message = sanitizeString($_POST['message'] ?? '');
    $source  = sanitizeString($_POST['source'] ?? '');
    
    $error='';

    if (empty($name)) {
       $error = "Please enter Name.";
    } elseif (empty($email)) {
        $error = "Please enter Email.";
    } elseif (empty($phone)) {
        $error = "Please enter Phone Number.";
    } elseif (empty($subject)) {
        $error = "Please enter Subject.";
    } elseif (empty($message)) {
        $error = "Please enter Message.";
    } else {
        try {
            $tstp = date("d-m-Y h:i A");
            $ip_address = $_SERVER['REMOTE_ADDR'];

            $data = [
                'name'       => $name,
                'email'      => $email,
                'phone'      => $phone,
                'subject'    => $subject,
                'message'    => $message,
                'tstp'       => $tstp,
                'ip_address' => $ip_address,
                'source'     => $source
            ];

            // Assuming $DB is initialized and connected
            $res = $DB->insert('enquiry', $data);

            if ($res) {
               $msg = "<html><body>
    <table style='width:100%; border: double 5px #000; border-collapse: collapse;'>
        <tr><td colspan='2' style='background-color:#efefef; font-weight:bold; text-align:center; border-bottom: 3px solid #000;'>Enquiry Detail</td></tr>
        <tr>
            <td style='padding: 10px; border-top: 2px solid #000; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Name</strong></td>
            <td style='padding: 10px; border-top: 2px solid #000; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($name) . "</td>
        </tr>
        <tr>
            <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Email</strong></td>
            <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($email) . "</td>
        </tr>
        <tr>
            <td style='padding: 10px; border-left: 2px solid #000;border-bottom: 2px solid #000;'><strong>Phone</strong></td>
            <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($phone) . "</td>
        </tr>
        <tr>
            <td style='padding: 10px; border-left: 2px solid #000;border-bottom: 2px solid #000;'><strong>Subject</strong></td>
            <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($subject) . "</td>
        </tr>
        <tr>
            <td style='padding: 10px; border-left: 2px solid #000;border-bottom: 2px solid #000;'><strong>Message</strong></td>
            <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . nl2br(htmlspecialchars($message)) . "</td>
        </tr>
         <tr>
            <td style='padding: 10px; border-left: 2px solid #000;border-bottom: 2px solid #000;'><strong>Source</strong></td>
            <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . $source . "</td>
        </tr>
        <tr>
            <td style='padding: 10px; border-left: 2px solid #000;border-bottom: 2px solid #000;'><strong>Time</strong></td>
            <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . $tstp . "</td>
        </tr>
    </table>
</body></html>";

                // Send emails
                sendmailToAdmin("Contact us : Sahyog Care4u", $msg);
                sendMailToUser($email, $name, "Thank you for contacting Sahyog Care For You", $source);

                $response = ['status' => 'success', 'message' => 'Enquiry submitted successfully.'];
            } else {
                $response['message'] = 'Unable to submit enquiry. Please try again later.';
            }
        } catch (Exception $e) {
            $response['message'] = 'An error occurred: ' . $e->getMessage();
        }
    }
}

echo json_encode($response);
