<?php

function sendmailToAdmin($subject,$message)
 {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = "sahyogcare4u.org";
        $mail->Port = 587;
        $mail->SMTPSecure = "auto";
        $mail->SMTPAuth = true;
        $mail->Username = "donotreply@sahyogcare4u.org";
        $mail->Password = '7j%#gZ8Hh527QWx2&FU#11pAcZVBBX^thILM$oypO8H9dw47$';
        $mail->setFrom('donotreply@sahyogcare4u.org', 'Sahyog Care4u');
        $mail->addAddress('projectsahyog2018@gmail.com', 'Sahyog Care4u');
        $mail->addAddress('sahyog.donation@gmail.com', 'Sahyog Care4u');
        $mail->addAddress('info@sahyogcare4u.org', 'Sahyog Care4u');
        $mail->addAddress('brajmohanupadhyay962@gmail.com', 'Sahyog Care4u');
        $mail->addBCC('hemukaushik77@gmail.com', 'Sahyog Care4u');
        
        $mail->Subject =$subject;
        $mail->msgHTML($message);
        $mail->send();
        return true;
       } catch (phpmailerException $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    } catch (Exception $e) {
         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
 }

function sendMailToUser($toEmail, $toName, $subject, $source) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = "sahyogcare4u.org";
        $mail->Port = 587;
        $mail->SMTPSecure = "auto";
        $mail->SMTPAuth = true;
        $mail->Username = "donotreply@sahyogcare4u.org";
        $mail->Password = '7j%#gZ8Hh527QWx2&FU#11pAcZVBBX^thILM$oypO8H9dw47$';
        $mail->setFrom('donotreply@sahyogcare4u.org', 'Sahyog Care4u');
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = $subject;
        $templatePath = __DIR__ . '/../emailer/contact.html'; 
        $message = file_get_contents($templatePath);

        // Replace placeholders with actual values
        $message = str_replace('{{name}}', htmlspecialchars($toName), $message);

        $mail->msgHTML($message);
        $mail->AltBody = "Dear $toName,\n\nThank you for your enquiry via $source.\nWe will connect with you as soon as possible.\n\nRegards,\nSahyog Care4u";

        $mail->send();
        return true;
    } catch (phpmailerException $e) {
        error_log("PHPMailer error: {$mail->ErrorInfo}");
    } catch (Exception $e) {
        error_log("General error: {$mail->ErrorInfo}");
    }
    return false;
}
function sendMailToUserForPayment($toEmail, $toName, $subject, $source) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = "sahyogcare4u.org";
        $mail->Port = 587;
        $mail->SMTPSecure = "auto";
        $mail->SMTPAuth = true;
        $mail->Username = "donotreply@sahyogcare4u.org";
        $mail->Password = '7j%#gZ8Hh527QWx2&FU#11pAcZVBBX^thILM$oypO8H9dw47$';
        $mail->setFrom('donotreply@sahyogcare4u.org', 'Sahyog Care4u');
        $mail->addAddress($toEmail, $toName);

        // Normalize the source string to lowercase and trim whitespace
        $sourceKey = strtolower(trim($source));

        // Pick template file and optionally adjust subject based on source
        switch ($sourceKey) {
            case 'baby-sambodhi':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                $subject = "Thank you for supporting Baby Sambodhi";
                break;
            case 'harshil-pandya':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                $subject = "Thank you for supporting Harshil Pandya";
                break;
            case 'nithya-shree':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                $subject = "Thank you for supporting Nithya shree";
                break;
            case 'baby-of-sheetal':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                $subject ="Thank you for supporting Baby of Sheetal";
                break;
            case 'riya':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                    $subject = "Thank you for supporting Riya";
                break;    
            case 'master-kaushik':
                $templatePath = __DIR__ . '/../emailer/payment.html';
              $subject = "Thank you for supporting Master Kaushik";
                break; 
             case 'shreyansh':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                $subject = "Thank you for supporting Shreyansh";
                break;  
           case 'kartik-kumar':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                $subject = "Thank you for supporting Kartik Kumar";
                break; 
            case 'kartik':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                $subject = "Thank you for supporting Kartik";
                break;
           case 'riddhi':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                $subject = "Thank you for supporting riddhi";
                break;
         case 'Janhvi':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                $subject = "Thank you for supporting Janhvi";
                break;
          case 'janhvi':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                $subject = "Thank you for supporting Janhvi";
                break;
         case 'ruby':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                $subject = "Thank you for supporting Ruby";
                break;
            case 'himani':
                $templatePath = __DIR__ . '/../emailer/payment.html';
                $subject = "Thank you for supporting Himani";
                break;
                
            case '/child-labour2.php':
             $templatePath = __DIR__ . '/../emailer/childcare.html';
             $subject="Thank you from Sahyog Care For You";
             break;
             
              case '/child-labour2.phputm_sourcefacebook_and_instagramutm_mediumvideoutm_campaignretargetutm_termchild_rescuefbclidIwY2xjawLkEIhleHRuA2FlbQIxMABicmlkETFaeUpjNnZPbEpvamZDRjdZAR5j_Sn73iyOkC4YjW7sszfXeo60dJZA-siUdxxVhwWa5tfAl97uP7WM_Xd_jg_aem_7vumyaEgg6JXil0yY-_FqA':
                  
             $templatePath = __DIR__ . '/../emailer/childcare.html';
             $subject="Thank you from Sahyog Care For You";
             break;
             
              case '/child-labour2.phputm_sourcefacebook_instagramutm_mediumvideoutm_campaigntrafficutm_termchild_rescue_and_rehabilitationutm_contentdonate_nowfbclidIwY2xjawLhkcVleHRuA2FlbQIxMABicmlkETFXRkFQZEtVdkJYTWM2dFBPAR5kybtNbqmrqiEHA1SdIwwYccx10I-MQPQxQT7E0lMtl59gxvbgUz_4TT71lQ_aem_PDbv-wUoM3nCH50NOJsylw':
                  
             $templatePath = __DIR__ . '/../emailer/childcare.html';
             $subject="Thank you from Sahyog Care For You";
             break;
             
            case '/child-labour2.phputm_sourcefacebook_and_instagramutm_mediumvideoutm_campaignsales_conversionutm_termchild_rescueutm_id120227737921580082utm_content120227737922280082fbclidPAZXh0bgNhZW0BMABhZGlkAasjaWXcE4IBp1I_-_JYB4rWwo19DdmvC7m7NfSmRktd95ewFRVniCGyV-FZeuPgI82GpMMD_aem_hxfx-cSPkeG0Eq1UQVqq4g':
                
             $templatePath = __DIR__ . '/../emailer/childcare.html';
             $subject="Thank you from Sahyog Care For You";
             break;
            
             
              case 'donate-form':
                $templatePath = __DIR__ . '/../emailer/donate.html';
                $subject = "Thank you from Sahyog Care For You";
                break;
             
             default:
                $templatePath = __DIR__ . '/../emailer/default_payment.html';
                $subject = "Thank you for your support";
                break;
        }

        $mail->Subject = $subject;
        $message = file_get_contents($templatePath);

        // Replace placeholders with actual values
        $message = str_replace('{{name}}', htmlspecialchars($toName), $message);
        $message = str_replace('{{source}}', htmlspecialchars($source), $message);
       
        $mail->msgHTML($message);

        $mail->AltBody = "Dear $toName,\n\nThank you for your enquiry via $source.\nWe will connect with you as soon as possible.\n\nRegards,\nSahyog Care4u";

        $mail->send();

        return true;
    } catch (phpmailerException $e) {
        error_log("PHPMailer error: {$mail->ErrorInfo}");
    } catch (Exception $e) {
        error_log("General error: {$mail->getMessage()}");
    }
    return false;
}
function sendMailToUserCreateFundRaiser($toEmail, $toName, $subject, $source) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = "sahyogcare4u.org";
        $mail->Port = 587;
        $mail->SMTPSecure = "auto";
        $mail->SMTPAuth = true;
        $mail->Username = "donotreply@sahyogcare4u.org";
        $mail->Password = '7j%#gZ8Hh527QWx2&FU#11pAcZVBBX^thILM$oypO8H9dw47$';
        $mail->setFrom('donotreply@sahyogcare4u.org', 'Sahyog Care4u');
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = $subject;
        $templatePath = __DIR__ . '/../emailer/fundraiser.html'; 
        $message = file_get_contents($templatePath);

        // Replace placeholders with actual values
        $message = str_replace('{{name}}', htmlspecialchars($toName), $message);

        $mail->msgHTML($message);
        $mail->AltBody = "Dear $toName,\n\nThank you for your enquiry via $source.\nWe will connect with you as soon as possible.\n\nRegards,\nSahyog Care4u";

        $mail->send();
        return true;
    } catch (phpmailerException $e) {
        error_log("PHPMailer error: {$mail->ErrorInfo}");
    } catch (Exception $e) {
        error_log("General error: {$mail->ErrorInfo}");
    }
    return false;
}
function sendNewsletterMailToUser($toEmail, $toName, $subject, $source) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = "sahyogcare4u.org";
        $mail->Port = 587;
        $mail->SMTPSecure = "auto";
        $mail->SMTPAuth = true;
        $mail->Username = "donotreply@sahyogcare4u.org";
        $mail->Password = '7j%#gZ8Hh527QWx2&FU#11pAcZVBBX^thILM$oypO8H9dw47$';
        $mail->setFrom('donotreply@sahyogcare4u.org', 'Sahyog Care4u');
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = $subject;
        $templatePath = __DIR__ . '/../emailer/newsletter.html'; 
        $message = file_get_contents($templatePath);

        // Replace placeholders with actual values
        $message = str_replace('{{name}}', htmlspecialchars($toName), $message);

        $mail->msgHTML($message);
        $mail->AltBody = "Dear $toName,\n\nThank you for your enquiry via $source.\nWe will connect with you as soon as possible.\n\nRegards,\nSahyog Care4u";

        $mail->send();
        return true;
    } catch (phpmailerException $e) {
        error_log("PHPMailer error: {$mail->ErrorInfo}");
    } catch (Exception $e) {
        error_log("General error: {$mail->ErrorInfo}");
    }
    return false;
}

/**
 * Send WhatsApp message via AiSensy API
 * @param string $mobile - Mobile number with country code (e.g., 919876543210)
 * @param string $donorName - Name of the donor
 * @param string $amount - Donation amount
 * @return bool - True on success, False on failure
 */
function sendWhatsAppMessage($mobile, $donorName, $amount = '') {
    try {
        // Validate mobile number - remove any spaces, dashes, or special characters
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        
        // If mobile doesn't start with country code, add 91 for India
        if (strlen($mobile) == 10) {
            $mobile = '91' . $mobile;
        }
        
        // Prepare the API payload
        $payload = [
            'apiKey' => AISENSY_API_KEY,
            'campaignName' => AISENSY_CAMPAIGN_NAME,
            'destination' => $mobile,
            'userName' => $donorName,
            'templateParams' => [
                $donorName  // {{Donor's Name}} parameter
            ]
        ];
        
        // If amount is provided, add it as additional parameter
        if (!empty($amount)) {
            $payload['templateParams'][] = $amount;
        }
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, AISENSY_API_URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        // Keep requests snappy so page flow never blocks
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        
        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        // Log the response for debugging
        error_log("AiSensy WhatsApp API Response - HTTP Code: $httpCode, Response: $response");
        
        if ($curlError) {
            error_log("AiSensy cURL Error: $curlError");
            return false;
        }
        
        // Check if request was successful
        if ($httpCode == 200 || $httpCode == 201) {
            $responseData = json_decode($response, true);
            
            // Check if API returned success
            if (isset($responseData['status']) && ($responseData['status'] === 'success' || $responseData['status'] === true)) {
                return true;
            }
        }
        
        return false;
        
    } catch (Exception $e) {
        error_log("AiSensy WhatsApp Error: " . $e->getMessage());
        return false;
    }
}


