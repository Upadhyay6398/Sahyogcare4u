<?php
header('Content-Type: application/json');
include('../config.php');
require_once('../lib/Mail.php');
require_once('../lib/PHPMailerAutoload.php');

$response = ['status' => 'error', 'message' => 'Unknown error occurred.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email  = sanitizeString($_POST['email'] ?? '');
    $source = sanitizeString($_POST['source'] ?? '');

    if (empty($email)) {
        $response['message'] = "Please enter Email.";
    } else {
        try {
            // Check if email already exists in the database
            $existing = "SELECT * FROM newsletter WHERE email = :email";
            $stmt = $DB->DB->prepare($existing);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $existingEmail = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingEmail) {
                // If the email already exists
                $response['message'] = 'Your email ID already exists. Please Use another email id';
            } else {
                $tstp = date("d-m-Y h:i A");
                $ip_address = $_SERVER['REMOTE_ADDR'];

                $data = [
                    'email'      => $email,
                    'tstp'       => $tstp,
                    'ip_address' => $ip_address,
                    'source'     => $source
                ];

                // Insert new email into the database
                $res = $DB->insert('newsletter', $data);

                if ($res) {
                    $msg = "<html><body>
                        <table style='width:100%; border: double 5px #000; border-collapse: collapse;'>
                            <tr><td colspan='2' style='background-color:#efefef; font-weight:bold; text-align:center; border-bottom: 3px solid #000;'>Newsletter Detail</td></tr>
                            <tr>
                                <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Email</strong></td>
                                <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($email) . "</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px; border-left: 2px solid #000;border-bottom: 2px solid #000;'><strong>Time</strong></td>
                                <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . $tstp . "</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px; border-left: 2px solid #000;border-bottom: 2px solid #000;'><strong>Source</strong></td>
                                <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . $source . "</td>
                            </tr>
                        </table>
                    </body></html>";

                    // Send emails
                    sendmailToAdmin("Newsletter : Sahyog Care4u", $msg);
                    sendNewsletterMailToUser($email, $name, "Thank you for newsletter subscription at Sahyog Care For You", $source);

                    $response = ['status' => 'success', 'message' => 'Newsletter subscribed successfully.'];
                } else {
                    $response['message'] = 'Unable to submit enquiry. Please try again later.';
                }
            }
        } catch (Exception $e) {
            $response['message'] = 'An error occurred: ' . $e->getMessage();
        }
    }
}

echo json_encode($response);
