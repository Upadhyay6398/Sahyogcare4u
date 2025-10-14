<?php
include('config.php');
include('lib/Mail.php');    
include('lib/PHPMailerAutoload.php');

function uploadFile($file) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    $filename = time() . "_" . basename($file["name"]);
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    }
    return null;
}

// ─── Main Submission Logic ───────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name     = ($_POST['name'] ?? '');
    $email    = ($_POST['email'] ?? ''); 
    $phone    = ($_POST['phone'] ?? '');
    $category = ($_POST['category'] ?? '');
    $address  = ($_POST['address'] ?? '');
    $pincode  = ($_POST['pincode'] ?? '');
    $source   = ($_POST['source'] ?? '');

    $error = '';
    if (empty($name))         $error = "Please enter Name.";
    elseif (empty($email))    $error = "Please enter Email.";
    elseif (empty($phone))    $error = "Please enter Phone Number.";
    elseif (empty($category)) $error = "Please select Category.";
    elseif (empty($pincode))  $error = "Please enter Pincode.";

    if (empty($error)) {
        try {
            $tstp = date("d-m-Y h:i A");
            $ip_address = $_SERVER['REMOTE_ADDR'];

            $data = [
                'name'       => $name,
                'email'      => $email,
                'phone'      => $phone,
                'category'   => $category,
                'address'    => $address,
                'pincode'    => $pincode,
                'source'     => $source,
                'tstp'       => $tstp,
                'ip_address' => $ip_address
            ];

            // ─── Category Specific Fields ─────────────────────
            switch ($category) {
                case 'category1': // Medical
                    $data['p_name']       = ($_POST['p_name'] ?? '');
                    $data['med_ailment']  = ($_POST['med_ailment'] ?? '');
                    $data['med_dob']      = ($_POST['med_dob'] ?? '');
                    $data['med_address']  = ($_POST['med_address'] ?? '');
                    $data['med_pincode']  = ($_POST['med_pincode'] ?? '');
                    $data['med_amount']   = ($_POST['med_amount'] ?? '');
                    $data['med_target']   = ($_POST['med_target'] ?? '');
                    $data['h_name']       = ($_POST['h_name'] ?? '');
                    $data['h_address']    = ($_POST['h_address'] ?? '');
                    $data['patient_description'] = ($_POST['patient_description'] ?? '');

                    if (!empty($_FILES['p_image']['name'])) {
                        $data['p_image'] = uploadFile($_FILES['p_image']);
                    }
                    if (!empty($_FILES['p_report']['name'])) {
                        $data['p_report'] = uploadFile($_FILES['p_report']);
                    }

                    // ─── DB Insertion ─────────────────────────────────
                    $res = $DB->insert('fundraiser', $data);
 
                    if ($res) {
                        // ─── Email to Admin (HTML format) ─────────────
                         $msg = "<html><body>
<table style='width:100%; border: double 5px #000; border-collapse: collapse;'>
    <tr><td colspan='2' style='background-color:#efefef; font-weight:bold; text-align:center; border-bottom: 3px solid #000;'>Fundraiser Detail Medical</td></tr>
    
    <tr>
        <td style='padding: 10px; border-top: 2px solid #000; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Name</strong></td>
        <td style='padding: 10px; border-top: 2px solid #000; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($name) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Email</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($email) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Phone</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($phone) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Category</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Medical</strong></td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Address</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . nl2br(htmlspecialchars($address)) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Pin Code</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . nl2br(htmlspecialchars($pincode)) . "</td>
    </tr>
    
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Patient Name</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['p_name']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Ailment</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['med_ailment']) . "</td>
    </tr>
  
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Patient Address</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['med_address']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Patient Pincode</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['med_pincode']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Required Amount</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['med_amount']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Target Date</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['med_target']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Hospital Name</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['h_name']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Hospital Address</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['h_address']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Patient Description</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . nl2br(htmlspecialchars($data['patient_description'])) . "</td>
    </tr>";

if (!empty($data['p_image'])) {
    $msg .= "<tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Patient Image</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>
            <a href='https://sahyogcare4u.org/" . $data['p_image'] . "' target='_blank'>View Image</a>
        </td>
    </tr>";
}

if (!empty($data['p_report'])) {
   $msg .= "<tr>
    <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Medical Report</strong></td>
    <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>
        <a href='https://sahyogcare4u.org/" . $data['p_report'] . "' target='_blank'>View Report</a>
    </td>
</tr>";
}

$msg .= "
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Source</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($source) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Time</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . $tstp . "</td>
    </tr>
</table>
</body></html>";

                        sendmailToAdmin("Fundraiser: Sahyog Care4u", $msg);
                        sendMailToUserCreateFundRaiser($email, $name, "Thank you for contacting Sahyog Care4u", $source);

                        header("Location: thanks-createfundraiser.php");
                        exit;
                    } else {
                        // echo "<div class='alert alert-danger'>Unable to submit enquiry. Please try again later.</div>";
                    }

                    break;
                    
             case 'category2': // Disability

    // Form fields ke names ke hisaab se data capture karna
    $data['med_name']          = $_POST['med_name'] ?? '';
    $data['med_ailment']     = $_POST['dis_ailment'] ?? '';
    $data['dis_percentage']  = $_POST['dis_percentage'] ?? '';
    $data['med_dob']         = $_POST['med_dob'] ?? '';
    $data['dis_income']      = $_POST['dis_income'] ?? '';
    $data['med_amount']      = $_POST['dis_amount_required'] ?? '';
    $data['med_pincode']     = $_POST['dis_pincode'] ?? '';
    $data['med_target']      = $_POST['dis_target_date'] ?? '';
    $data['med_address']     = $_POST['dis_address'] ?? '';
    $data['patient_description'] = $_POST['dis_description'] ?? '';

    // File upload — HTML field name: dis_image
    if (!empty($_FILES['dis_image']['name'])) {
        $data['p_image'] = uploadFile($_FILES['dis_image']);
    }

    // DB Insert
    $res = $DB->insert('fundraiser', $data);

    if ($res) {
        // Email variables (aap apne code mein ye variables pahle se define kar lena)
        $name    = $_POST['name'] ?? '';
        $email   = $_POST['email'] ?? '';
        $phone   = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $pincode = $_POST['pincode'] ?? '';
        $source  = $_POST['source'] ?? '';
        $tstp    = date('Y-m-d H:i:s'); // agar chahiye toh, agar nahi chahiye toh hata do

        // Email message banayein (HTML format)
        $msg = "<html><body>
<table style='width:100%; border: double 5px #000; border-collapse: collapse;'>
    <tr><td colspan='2' style='background-color:#efefef; font-weight:bold; text-align:center; border-bottom: 3px solid #000;'>Fundraiser Detail Disability</td></tr>
    
    <tr>
        <td style='padding: 10px; border-top: 2px solid #000; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Name</strong></td>
        <td style='padding: 10px; border-top: 2px solid #000; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($name) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Email</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($email) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Phone</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($phone) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Category</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Disability</strong></td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Address</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . nl2br(htmlspecialchars($address)) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Pin Code</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . nl2br(htmlspecialchars($pincode)) . "</td>
    </tr>
    
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Patient Name</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['med_name']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Ailment</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['med_ailment']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Date of Birth / Age</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['med_dob']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Disability Percentage</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['dis_percentage']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Annual Income</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['dis_income']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Patient Address</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['med_address']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Patient Pincode</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['med_pincode']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Required Amount</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['med_amount']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Target Date</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($data['med_target']) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Description</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . nl2br(htmlspecialchars($data['patient_description'])) . "</td>
    </tr>";

    if (!empty($data['p_image'])) {
        $msg .= "<tr>
            <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Patient Image</strong></td>
            <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>
                <a href='https://sahyogcare4u.org/" . $data['p_image'] . "' target='_blank'>View Image</a>
            </td>
        </tr>";
    }

    $msg .= "
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Source</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . htmlspecialchars($source) . "</td>
    </tr>
    <tr>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'><strong>Time</strong></td>
        <td style='padding: 10px; border-left: 2px solid #000; border-bottom: 2px solid #000;'>" . $tstp . "</td>
    </tr>
</table>
</body></html>";

        // Email bhejna
        sendmailToAdmin("Fundraiser: Sahyog Care4u", $msg);
        sendMailToUserCreateFundRaiser($email, $name, "Thank you for contacting Sahyog Care4u", $source);

        // Redirect thank you page
        header("Location: thanks-createfundraiser.php");
        exit;

    } else {
        // Agar DB insert fail ho toh
        echo "<div class='alert alert-danger'>Unable to submit enquiry. Please try again later.</div>";
    }

    break;
    
    //Category 3 Ke Start h 
    case 'category3': // Sanitary Napkin

    // Form fields ke names ke hisaab se data capture karna
    
    $data['sn_beneficiary']       = $_POST['sn_beneficiary'] ?? '';
    $data['sn_total_napkin']      = $_POST['sn_total_napkin'] ?? '';
    $data['sn_amount_required']   = $_POST['sn_amount_required'] ?? '';
    $data['sn_target_date']       = $_POST['sn_target_date'] ?? '';
    $data['sn_description']       = $_POST['sn_description'] ?? '';

    // File upload — HTML field name: sn_image
    if (!empty($_FILES['sn_image']['name'])) {
        $uploadedFile = uploadFile($_FILES['sn_image']);
        if ($uploadedFile) {
            $data['sn_image'] = $uploadedFile;
        }
    }

    // DB Insert
    $res = $DB->insert('fundraiser', $data);

    if ($res) {
        $name    = $_POST['name'] ?? '';
        $email   = $_POST['email'] ?? '';
        $phone   = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $pincode = $_POST['pincode'] ?? '';
        $source  = $_POST['source'] ?? '';
        $tstp    = date('Y-m-d H:i:s');

        // Email message banayein 
        $msg = "<html><body>
        <table style='width:100%; border: double 5px #000; border-collapse: collapse;'>
            <tr><td colspan='2' style='background-color:#efefef; font-weight:bold; text-align:center; border-bottom: 3px solid #000;'>Fundraiser Detail - Sanitary Napkin</td></tr>

            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Name</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($name) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Email</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($email) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Phone</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($phone) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Category</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Sanitary Napkin</strong></td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Number of Beneficiaries</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($data['sn_beneficiary']) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Total Number of Napkins Required</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($data['sn_total_napkin']) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Amount Required</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($data['sn_amount_required']) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Target Date</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($data['sn_target_date']) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Description</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . nl2br(htmlspecialchars($data['sn_description'])) . "</td>
            </tr>";

        if (!empty($data['sn_image'])) {
            $msg .= "<tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Image</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>
                    <a href='https://sahyogcare4u.org/" . $data['sn_image'] . "' target='_blank'>View Image</a>
                </td>
            </tr>";
        }

        $msg .= "
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Source</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($source) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Time</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . $tstp . "</td>
            </tr>
        </table>
        </body></html>";

        // Email bhejna 
        sendmailToAdmin("Fundraiser: Sahyog Care4u", $msg);
        sendMailToUserCreateFundRaiser($email, $name, "Thank you for contacting Sahyog Care4u", $source);

        // Redirect thank you page
        header("Location: thanks-createfundraiser.php");
        exit;

    } else {
        // Agar DB insert fail ho toh
        echo "<div class='alert alert-danger'>Unable to submit enquiry. Please try again later.</div>";
    }

    break;
    case 'category4': // Sex Worker

    // Capture POST data
    $data['p_name']              = $_POST['sw_name'] ?? '';
    $data['med_address']         = $_POST['sw_address'] ?? '';
    $data['med_pincode']         = $_POST['sw_pincode'] ?? '';
    $data['sw_dependents']       = $_POST['sw_dependents'] ?? '';
    $data['sw_requirements']     = $_POST['sw_requirements'] ?? '';
    $data['med_target']          = $_POST['sw_target_date'] ?? '';
    $data['patient_description'] = $_POST['sw_description'] ?? '';

    // File upload (if image is used later, add this)
    if (!empty($_FILES['sw_image']['name'])) {
        $data['p_image'] = uploadFile($_FILES['sw_image']);
    }

    // Insert into database
    $res = $DB->insert('fundraiser', $data);

    if ($res) {
        // Common Email Data
        $name    = $_POST['name'] ?? '';
        $email   = $_POST['email'] ?? '';
        $phone   = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $pincode = $_POST['pincode'] ?? '';
        $source  = $_POST['source'] ?? '';
        $tstp    = date('Y-m-d H:i:s');

        // Email Body
        $msg = "<html><body>
<table style='width:100%; border: double 5px #000; border-collapse: collapse;'>
  <tr><td colspan='2' style='background-color:#efefef; font-weight:bold; text-align:center; border-bottom: 3px solid #000;'>Fundraiser Detail — Sex Worker</td></tr>

  <tr><td style='padding:10px; border:2px solid #000;'><strong>Name</strong></td><td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($name) . "</td></tr>
  <tr><td style='padding:10px; border:2px solid #000;'><strong>Email</strong></td><td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($email) . "</td></tr>
  <tr><td style='padding:10px; border:2px solid #000;'><strong>Phone</strong></td><td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($phone) . "</td></tr>
  <tr><td style='padding:10px; border:2px solid #000;'><strong>Category</strong></td><td style='padding:10px; border:2px solid #000;'>Sex Worker</td></tr>
  <tr><td style='padding:10px; border:2px solid #000;'><strong>Address</strong></td><td style='padding:10px; border:2px solid #000;'>" . nl2br(htmlspecialchars($address)) . "</td></tr>
  <tr><td style='padding:10px; border:2px solid #000;'><strong>Pincode</strong></td><td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($pincode) . "</td></tr>

  <tr><td style='padding:10px; border:2px solid #000;'><strong>Applicant Name (Aadhar)</strong></td><td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['p_name']) . "</td></tr>
  <tr><td style='padding:10px; border:2px solid #000;'><strong>Applicant Address</strong></td><td style='padding:10px; border:2px solid #000;'>" . nl2br(htmlspecialchars($data['med_address'])) . "</td></tr>
  <tr><td style='padding:10px; border:2px solid #000;'><strong>Applicant Pincode</strong></td><td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['med_pincode']) . "</td></tr>
  <tr><td style='padding:10px; border:2px solid #000;'><strong>Number of Dependents</strong></td><td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['sw_dependents']) . "</td></tr>
  <tr><td style='padding:10px; border:2px solid #000;'><strong>Requirements</strong></td><td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['sw_requirements']) . "</td></tr>
  <tr><td style='padding:10px; border:2px solid #000;'><strong>Target Date</strong></td><td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['med_target']) . "</td></tr>
  <tr><td style='padding:10px; border:2px solid #000;'><strong>Description</strong></td><td style='padding:10px; border:2px solid #000;'>" . nl2br(htmlspecialchars($data['patient_description'])) . "</td></tr>";

        if (!empty($data['p_image'])) {
            $msg .= "<tr><td style='padding:10px; border:2px solid #000;'><strong>Image</strong></td><td style='padding:10px; border:2px solid #000;'><a href='https://sahyogcare4u.org/" . $data['p_image'] . "' target='_blank'>View Image</a></td></tr>";
        }

        $msg .= "<tr><td style='padding:10px; border:2px solid #000;'><strong>Source</strong></td><td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($source) . "</td></tr>
<tr><td style='padding:10px; border:2px solid #000;'><strong>Time</strong></td><td style='padding:10px; border:2px solid #000;'>" . $tstp . "</td></tr>
</table></body></html>";

        // Send mail
        sendmailToAdmin("Fundraiser: Sahyog Care4u", $msg);
        sendMailToUserCreateFundRaiser($email, $name, "Thank you for contacting Sahyog Care4u", $source);

        // Redirect
        header("Location: thanks-createfundraiser.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Unable to submit enquiry. Please try again later.</div>";
    }

    break;
    
 case 'category5': // Old Age Home

    $data['oah_senior_citizens']   = $_POST['oah_senior_citizens'] ?? '';
    $data['oah_monthly_expense']   = $_POST['oah_monthly_expense'] ?? '';
    $data['oah_male']              = $_POST['oah_male'] ?? '';
    $data['oah_female']            = $_POST['oah_female'] ?? '';
    $data['oah_amount_required']   = $_POST['oah_amount_required'] ?? '';
    $data['oah_target_date']       = $_POST['oah_target_date'] ?? '';
    $data['oah_description']       = $_POST['oah_description'] ?? '';

    // File Upload Fix
    if (!empty($_FILES['oah_image']['name'])) {
        $uploadedFile = uploadFile($_FILES['oah_image']);
        if ($uploadedFile) {
            $data['oah_image'] = $uploadedFile;
        }
    }


    // DB Insert
    $res = $DB->insert('fundraiser', $data);

    if ($res) {
        $name    = $_POST['name'] ?? '';
        $email   = $_POST['email'] ?? '';
        $phone   = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $pincode = $_POST['pincode'] ?? '';
        $source  = $_POST['source'] ?? '';
        $tstp    = date('Y-m-d H:i:s');

        // Email message banayein 
        $msg = "<html><body>
        <table style='width:100%; border: double 5px #000; border-collapse: collapse;'>
            <tr><td colspan='2' style='background-color:#efefef; font-weight:bold; text-align:center; border-bottom: 3px solid #000;'>Fundraiser Detail - Old Age Home</td></tr>

            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Name</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($name) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Email</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($email) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Phone</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($phone) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Category</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Old Age Home</strong></td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Number of Senior Citizens</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($data['oah_senior_citizens']) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Monthly Expense/person</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($data['oah_monthly_expense']) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Male</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($data['oah_male']) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Female</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($data['oah_female']) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Amount Required</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . nl2br(htmlspecialchars($data['oah_amount_required'])) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Targeted Date</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($data['oah_target_date']) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Description</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($data['oah_description']) . "</td>
            </tr>
            ";

        if (!empty($data['oah_image'])) {
            $msg .= "<tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Image</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>
                    <a href='https://sahyogcare4u.org/" . $data['oah_image'] . "' target='_blank'>View Image</a>
                </td>
            </tr>";
        }

        $msg .= "
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Source</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . htmlspecialchars($source) . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; border: 2px solid #000;'><strong>Time</strong></td>
                <td style='padding: 10px; border: 2px solid #000;'>" . $tstp . "</td>
            </tr>
        </table>
        </body></html>";

        // Email bhejna 
        sendmailToAdmin("Fundraiser: Sahyog Care4u", $msg);
        sendMailToUserCreateFundRaiser($email, $name, "Thank you for contacting Sahyog Care4u", $source);

        // Redirect thank you page
        header("Location: thanks-createfundraiser.php");
        exit;

    } else {
        // Agar DB insert fail ho toh
        echo "<div class='alert alert-danger'>Unable to submit enquiry. Please try again later.</div>";
    }

    break;
    
   case 'category6': // Natural Calamity

    // Step 1: Insert general user info into `fundraisers`
    $main = [
        'name'     => $_POST['name'] ?? '',
        'email'    => $_POST['email'] ?? '',
        'phone'    => $_POST['phone'] ?? '',
        'address'  => $_POST['address'] ?? '',
        'pincode'  => $_POST['pincode'] ?? '',
        'source'   => $_POST['source'] ?? '',
        'category' => 'category6',
    ];

    $fundraiser_id = $DB->insert('fundraiser', $main);

    if ($fundraiser_id) {

        // Step 2: Insert into `fundraiser_natural_calamity`
        $data = [
            'fundraiser_id'        => $fundraiser_id,
            'nc_name'              => $_POST['nc_name'] ?? '',
            'nc_calamity_type'     => $_POST['nc_calamity_type'] ?? '',
            'nc_age'               => $_POST['nc_age'] ?? '',
            'nc_income'            => $_POST['nc_income'] ?? '',
            'nc_address'           => $_POST['nc_address'] ?? '',
            'nc_family_members'    => $_POST['nc_family_members'] ?? '',
            'nc_amount_required'   => $_POST['nc_amount_required'] ?? '',
            'nc_target_date'       => $_POST['nc_target_date'] ?? '',
            'nc_description'       => $_POST['nc_description'] ?? '',
        ];

        if (!empty($_FILES['nc_image']['name'])) {
            $uploadedFile = uploadFile($_FILES['nc_image']);
            if ($uploadedFile) {
                $data['nc_image'] = $uploadedFile;
            }
        }

        $res = $DB->insert('fundraiser_natural_calamity', $data);

        if ($res) {
            $tstp = date('Y-m-d H:i:s');

            // Step 3: Prepare email HTML
            $msg = "<html><body>
            <table style='width:100%; border: double 5px #000; border-collapse: collapse;'>
                <tr><td colspan='2' style='background-color:#efefef; font-weight:bold; text-align:center; border-bottom: 3px solid #000;'>Fundraiser Detail - Natural Calamity</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Name</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($main['name']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Email</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($main['email']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Phone</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($main['phone']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Calamity Name</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['nc_name']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Calamity Type</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['nc_calamity_type']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Age</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['nc_age']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Annual Income</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['nc_income']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Address</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['nc_address']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Family Members</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['nc_family_members']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Amount Required</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['nc_amount_required']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Target Date</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['nc_target_date']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Description</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . nl2br(htmlspecialchars($data['nc_description'])) . "</td></tr>";

            if (!empty($data['nc_image'])) {
                $msg .= "<tr>
                    <td style='padding:10px; border:2px solid #000;'><strong>Image</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>
                        <a href='https://sahyogcare4u.org/" . $data['nc_image'] . "' target='_blank'>View Image</a>
                    </td>
                </tr>";
            }

            $msg .= "<tr><td style='padding:10px; border:2px solid #000;'><strong>Source</strong></td>
                        <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($main['source']) . "</td></tr>

                    <tr><td style='padding:10px; border:2px solid #000;'><strong>Time</strong></td>
                        <td style='padding:10px; border:2px solid #000;'>" . $tstp . "</td></tr>
            </table>
            </body></html>";

            // Step 4: Send emails
            sendmailToAdmin("Fundraiser: Natural Calamity - Sahyog Care4u", $msg);
            sendMailToUserCreateFundRaiser($main['email'], $main['name'], "Thank you for contacting Sahyog Care4u", $main['source']);

            // Step 5: Redirect
            header("Location: thanks-createfundraiser.php");
            exit;

        } else {
            echo "<div class='alert alert-danger'>Unable to submit Natural Calamity details. Please try again later.</div>";
        }

    } else {
        echo "<div class='alert alert-danger'>Unable to create fundraiser. Please try again later.</div>";
    }

    break;

case 'category7': // Education

    // Step 1: Insert general user info into `fundraisers`
    $main = [
        'name'     => $_POST['name'] ?? '',
        'email'    => $_POST['email'] ?? '',
        'phone'    => $_POST['phone'] ?? '',
        'address'  => $_POST['address'] ?? '',
        'pincode'  => $_POST['pincode'] ?? '',
        'source'   => $_POST['source'] ?? '',
        'category' => 'category7',
    ];

    $fundraiser_id = $DB->insert('fundraiser', $main);

    if ($fundraiser_id) {

        // Step 2: Insert into `fundraiser_education`
        $data = [
            'fundraiser_id'        => $fundraiser_id,
            'edu_total_students'   => $_POST['edu_total_students'] ?? '',
            'edu_age_group'        => $_POST['edu_age_group'] ?? '',
            'edu_project_name'     => $_POST['edu_project_name'] ?? '',
            'edu_area'             => $_POST['edu_area'] ?? '',
            'edu_amount_required'  => $_POST['edu_amount_required'] ?? '',
            'edu_target_date'      => $_POST['edu_target_date'] ?? '',
            'edu_description'      => $_POST['edu_description'] ?? '',
        ];

        if (!empty($_FILES['edu_category']['name'])) {
            $uploadedFile = uploadFile($_FILES['edu_category']);
            if ($uploadedFile) {
                $data['edu_category'] = $uploadedFile;
            }
        }

        $res = $DB->insert('fundraiser_education', $data);

        if ($res) {
            $tstp = date('Y-m-d H:i:s');

            // Step 3: Prepare email HTML
            $msg = "<html><body>
            <table style='width:100%; border: double 5px #000; border-collapse: collapse;'>
                <tr><td colspan='2' style='background-color:#efefef; font-weight:bold; text-align:center; border-bottom: 3px solid #000;'>Fundraiser Detail - Education</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Name</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($main['name']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Email</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($main['email']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Phone</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($main['phone']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Total Students</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['edu_total_students']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Age Group</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['edu_age_group']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Project Name</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['edu_project_name']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Area</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['edu_area']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Amount Required</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['edu_amount_required']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Target Date</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['edu_target_date']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Description</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . nl2br(htmlspecialchars($data['edu_description'])) . "</td></tr>";

            if (!empty($data['edu_category'])) {
                $msg .= "<tr>
                    <td style='padding:10px; border:2px solid #000;'><strong>BPL Category File</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>
                        <a href='https://sahyogcare4u.org/" . $data['edu_category'] . "' target='_blank'>View File</a>
                    </td>
                </tr>";
            }

            $msg .= "<tr><td style='padding:10px; border:2px solid #000;'><strong>Source</strong></td>
                        <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($main['source']) . "</td></tr>

                    <tr><td style='padding:10px; border:2px solid #000;'><strong>Time</strong></td>
                        <td style='padding:10px; border:2px solid #000;'>" . $tstp . "</td></tr>
            </table>
            </body></html>";

            // Step 4: Send emails
            sendmailToAdmin("Fundraiser: Education - Sahyog Care4u", $msg);
            sendMailToUserCreateFundRaiser($main['email'], $main['name'], "Thank you for contacting Sahyog Care4u", $main['source']);

            // Step 5: Redirect
            header("Location: thanks-createfundraiser.php");
            exit;

        } else {
            echo "<div class='alert alert-danger'>Unable to submit Education details. Please try again later.</div>";
        }

    } else {
        echo "<div class='alert alert-danger'>Unable to create fundraiser. Please try again later.</div>";
    }

    break;

case 'category8': // Any Other Project

    // Step 1: Insert general user info into `fundraisers`
    $main = [
        'name'     => $_POST['name'] ?? '',
        'email'    => $_POST['email'] ?? '',
        'phone'    => $_POST['phone'] ?? '',
        'address'  => $_POST['address'] ?? '',
        'pincode'  => $_POST['pincode'] ?? '',
        'source'   => $_POST['source'] ?? '',
        'category' => 'category8',
    ];

    $fundraiser_id = $DB->insert('fundraiser', $main);

    if ($fundraiser_id) {
        
    
        // Step 2: Insert into `fundraiser_other_project`
        if (!empty($_POST['aop_description'])) {
        $data = [
            'fundraiser_id'        => $fundraiser_id,
            'aop_name'             => $_POST['aop_name'] ?? '',
            'aop_contact_number'   => $_POST['aop_contact_number'] ?? '',
            'aop_age'              => $_POST['aop_age'] ?? '',
            'aop_address'          => $_POST['aop_address'] ?? '',
            'aop_pincode'          => $_POST['aop_pincode'] ?? '',
            'aop_project'          => $_POST['aop_project'] ?? '',
            'aop_amount_required'  => $_POST['aop_amount_required'] ?? '',
            'aop_target_date'      => $_POST['aop_target_date'] ?? '',
            'aop_description'      => $_POST['aop_description'] ?? '',
        ];

        $res = $DB->insert('fundraiser_other_project', $data);
}
        if ($res) {
            $tstp = date('Y-m-d H:i:s');

            // Step 3: Prepare email HTML
            $msg = "<html><body>
            <table style='width:100%; border: double 5px #000; border-collapse: collapse;'>
                <tr><td colspan='2' style='background-color:#efefef; font-weight:bold; text-align:center; border-bottom: 3px solid #000;'>Fundraiser Detail - Any Other Project</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Name</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($main['name']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Email</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($main['email']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Phone</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($main['phone']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Aadhar Name</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['aop_name']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Contact Number</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['aop_contact_number']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Age</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['aop_age']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Address</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['aop_address']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Pincode</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['aop_pincode']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Project</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['aop_project']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Amount Required</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['aop_amount_required']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Target Date</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($data['aop_target_date']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Description</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . nl2br(htmlspecialchars($data['aop_description'])) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Source</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . htmlspecialchars($main['source']) . "</td></tr>

                <tr><td style='padding:10px; border:2px solid #000;'><strong>Time</strong></td>
                    <td style='padding:10px; border:2px solid #000;'>" . $tstp . "</td></tr>
            </table>
            </body></html>";

            // Step 4: Send emails
            sendmailToAdmin("Fundraiser: Any Other Project - Sahyog Care4u", $msg);
            sendMailToUserCreateFundRaiser($main['email'], $main['name'], "Thank you for contacting Sahyog Care4u", $main['source']);

            // Step 5: Redirect
           header("Location: thanks-createfundraiser.php");
            exit;

        } else {
            echo "<div class='alert alert-danger'>Unable to submit project details. Please try again later.</div>";
        }

    } else {
        echo "<div class='alert alert-danger'>Unable to create fundraiser. Please try again later.</div>";
    }

    break;



            }

        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>An error occurred: " . $e->getMessage() . "</div>";
        }

    } else {
        echo "<div class='alert alert-danger'>{$error}</div>";
    }
}
?>

<!DOCTYPE html>

</html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create A Fundraiser</title>

    <?php include("./includes/top2.php") ?>
        <link rel="icon" href="https://www.sahyogcare4u.org/images/favicons.png" type="image/x-icon">
  <style>
    .category-form {
      display: none;
    }
    body {
      width: 100%;
      height: 100%;
      font-size: 18px;
      line-height: 1.5;
      font-family: 'Roboto', sans-serif;
      color: #222;
    }

    .for .container {
      background: #ecf0f4 max-width: 1230px;
      width: 100%;
      margin-top: 70px;
      margin-bottom: 70px;
    }

    .for .form-wrap {
      background: rgba(255, 255, 255, 1);
      width: 100%;
      max-width: 1050px;
      padding: 50px;
      margin: 0 auto;
      position: relative;
      -webkit-border-radius: 10px;
      -moz-border-radius: 10px;
      border-radius: 10px;
      -webkit-box-shadow: 0px 0px 40px rgba(0, 0, 0, 0.15);
      -moz-box-shadow: 0px 0px 40px rgba(0, 0, 0, 0.15);
      box-shadow: 0px 0px 40px rgba(0, 0, 0, 0.15);
    }

    .for .form-wrap:before {
      content: "";
      width: 90%;
      height: calc(100% + 60px);
      left: 0;
      right: 0;
      margin: 0 auto;
      position: absolute;
      top: -30px;
      background: #86cdcc;
      z-index: -1;
      opacity: 0.8;
      -webkit-border-radius: 10px;
      -moz-border-radius: 10px;
      border-radius: 10px;
      -webkit-box-shadow: 0px 0px 40px rgba(0, 0, 0, 0.15);
      -moz-box-shadow: 0px 0px 40px rgba(0, 0, 0, 0.15);
      box-shadow: 0px 0px 40px rgba(0, 0, 0, 0.15);
    }

    .for h1 {
      font-weight: 500;
      font-size: 45px;
      font-family: 'Roboto', sans-serif;
    }

    .for .form-group {
      margin-bottom: 25px;
    }

    .for .form-group>label {
      display: block;
      font-size: 18px;
      color: #000;
    }

    .for .custom-control-label {
      color: #000;
      font-size: 16px;
    }

    .for .form-control {
      height: 50px;
      background: #ecf0f4;
      border-color: transparent;
      padding: 0 15px;
      font-size: 16px;
      -webkit-transition: all 0.3s ease-in-out;
      -moz-transition: all 0.3s ease-in-out;
      -o-transition: all 0.3s ease-in-out;
      transition: all 0.3s ease-in-out;
    }

    .for .form-control:focus {
      border-color: #00bcd9;
      -webkit-box-shadow: 0px 0px 20px rgba(0, 0, 0, .1);
      -moz-box-shadow: 0px 0px 20px rgba(0, 0, 0, .1);
      box-shadow: 0px 0px 20px rgba(0, 0, 0, .1);
    }

    .for textarea.form-control {
      height: 160px;
      padding-top: 15px;
      resize: none;
    }

    .for .top-bar {
      background: #fdd831;
      padding: 0 !important;
    }

    .required-field::after {
      content: "*";
      color: red;
      margin-left: 2px
    }


    @media only screen and (max-width: 991px) {
    .for h1 {
      font-size: 35px;}
    }
    @media only screen and (max-width: 991px) {
    .for h1 {
      font-size: 25px;}
    }
  </style>
<script>
function showForm(category) {
  document.querySelectorAll('.category-form').forEach(form => {
    form.style.display = 'none';
    form.querySelectorAll('input, select, textarea').forEach(field => {
      field.removeAttribute('required');
    });
  });

  const selectedForm = document.getElementById(category + '-form');
  if (selectedForm) {
    selectedForm.style.display = 'block';

    selectedForm.querySelectorAll('input, select, textarea').forEach(field => {
      if (!field.disabled && !field.hasAttribute('readonly')) {
        field.setAttribute('required', 'required');
      }
    });
  }
}
</script>


</head>


<body>

  <?php include('./includes/header.php') ?>
  <?php
  if (!empty($error)) {
    echo "<div style='color: red;'>$error</div>";
  }
  ?>
  <div class="for">
    <div class="container">
      <div class="form-wrap">
        <h1 class="text-center">Start A Fundraiser</h1><br>
        <form method="POST" id="myForm" action="" enctype="multipart/form-data" id="Fundraiser" data-parsley-validate onsubmit="return handleFormSubmit(event)">
        <input type="hidden" name="source" value="Create a Fundraiser">
          <div class="row">
            <div class=col-md-6>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" placeholder="Name" class="form-control" id="name" name="name" value="<?= $_POST['name'] ?>" required>
              </div>
            </div>
            <div class=col-md-6>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" placeholder="Email" class="form-control" id="email" name="email" value="<?= $_POST['email'] ?>" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class=col-md-6>

              <div class="form-group">
                <label for="phone">Mobile No.</label>
                <input type="tel" placeholder="Mobile No." class="form-control" id="phone" name="phone" value="<?= $_POST['phone'] ?>" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern="^[6-9]\d{9}$"
       data-parsley-pattern-message="Please enter a valid phone number starting with 6 to 9 and 10 digits long"
       data-parsley-required="true" 
       autocomplete="off"  
       required 
       oninput="this.value = this.value.replace(/\D/g, '')" 
       maxlength="10" >
              </div>
            </div>
            <div class=col-md-6>

              <div class="form-group">
                <label for="category">Fundraiser Segments: <span class="required-field"></span></label>
                <select class="form-control" id="category" name="category" onchange="showForm(this.value)" required>
                  <option value="">Select Category</option>
                  <option value="category1" <?= ($_POST['category'] == 'category1' ? 'selected="selected"' : '') ?>>Medical</option>
                  <option value="category2" <?= ($_POST['category'] == 'category2' ? 'selected="selected"' : '') ?>>Disability</option>
                  <option value="category3" <?= ($_POST['category'] == 'category3' ? 'selected="selected"' : '') ?>>Sanitary Napkin</option>
                  <option value="category4" <?= ($_POST['category'] == 'category4' ? 'selected="selected"' : '') ?>>Sex Worker</option>
                  <option value="category5" <?= ($_POST['category'] == 'category5' ? 'selected="selected"' : '') ?>>Old Age Home</option>
                  <option value="category6" <?= ($_POST['category'] == 'category6' ? 'selected="selected"' : '') ?>>Natural Calamity</option>
                  <option value="category7" <?= ($_POST['category'] == 'category7' ? 'selected="selected"' : '') ?>>Education</option>
               <option value="category8" <?= ($_POST['category'] == 'category8' ? 'selected="selected"' : '') ?>>Any Other Project</option>
                  
                  
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class=col-md-6>
              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" placeholder="Address" class="form-control" id="address" name="address" value="<?= $_POST['address'] ?>" required>
              </div>
            </div>
            <div class=col-md-6>
              <div class="form-group">
                <label for="pincode">Pincode</label>
                <input type="text" placeholder="Pincode" class="form-control" id="pincode" name="pincode" value="<?= $_POST['pincode'] ?>" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Pin Code starting"
       
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
       maxlength="6" required>
              </div>
            </div>
          </div>

          <div id="category1-form" class="category-form">
            <div class="form-group"><br>
              <div class="row">
                <div class="col-lg-12" style="margin-bottom: 50px; margin-top: 15px;height: 60px; border-bottom: 2px solid black;">
                  <center>
                    <h2>Patient </h2>
                  </center>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="p_name">Patient Name</label>
                    <input type="text" class="form-control" id="p_name" name="p_name" value="<?= $_POST['p_name'] ?>" placeholder="Enter Patient Name">
                 
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="med_ailment">Ailment</label>
                    <input type="text" class="form-control" id="med_ailment" name="med_ailment" value="<?= $_POST['med_ailment'] ?>" placeholder="Enter Ailment">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="med_dob">Date Of Birth</label>
                    <input type="date" class="form-control" id="med_dob" name="med_dob" value="<?= $_POST['med_dob'] ?>" placeholder="Select Date of Birth">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class=col-md-6>
                  <div class="form-group">
                    <label for="med_address">Address</label>
                    <input type="text" placeholder="Address" class="form-control" id="med_address" value="<?= $_POST['med_address'] ?>" name="med_address">
                  </div>
                </div>
                <div class=col-md-6>
                  <div class="form-group">
                    <label for="med_pincode">Pincode</label>
                    <input type="text" placeholder="Pincode" class="form-control" id="med_pincode" value="<?= $_POST['med_pincode'] ?>" name="med_pincode" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Pin Code starting"

       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
       maxlength="6">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="p_image">Patient Image</label>
                    <input type="file" class="form-control" id="p_image" name="p_image" placeholder="Choose Patient Image" accept=".pdf, .jpg, .jpeg">
                      <p>Only pdf,jpg or jpeg allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="p_report">Doctor Report</label>
                    <input type="file" class="form-control" id="p_report" name="p_report" placeholder="Choose Doctor Report" accept=".pdf, .jpg, .jpeg">
                     <p>Only pdf,jpg or jpeg allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="amount">Amount Required</label>
                    <input type="text" class="form-control" id="med_amount" name="med_amount" value="<?= $_POST['med_amount'] ?>" placeholder="Enter Amount Required" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Amount"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
       maxlength="6" >
       <p>Only numeric values allowed</p>
                  </div>
                   
                </div>
               
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="target">Targeted Date</label>
                    <input type="date" class="form-control" id="med_target" name="med_target" value="<?= $_POST['med_target'] ?>" placeholder="Select Targeted Date">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="h_name">Hospital Name</label>
                    <input type="text" class="form-control" id="h_name" name="h_name" value="<?= $_POST['h_name'] ?>" placeholder="Enter Hospital Name">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="h_address">Hospital Address</label>
                    <input type="text" class="form-control" id="h_address" name="h_address" value="<?= $_POST['h_address'] ?>" placeholder="Enter Hospital Address">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="lbel">Description :</label>
                    <textarea rows="3" class="area form-control" id="patient_description" value="<?= $_POST['patient_description'] ?>" name="patient_description" placeholder="Enter Description"><?= (isset($_POST['patient_description']) ? $_POST['patient_description'] : '') ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Category 2 Form -->
          <div id="category2-form" class="category-form">
            <div class="form-group">
              <div class="row">
                <div class="col-lg-12" style="margin-bottom: 50px; margin-top: 15px;height: 60px; border-bottom: 2px solid black;">
                  <center>
                    <h2>Disability </h2>
                  </center>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="med_name">Name (Aadhar Name)</label>
                    <input type="text" class="form-control" id="med_name" name="med_name" value="<?= $_POST['med_name'] ?>" placeholder="Enter Aadhar Name">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dis_ailment">Ailment</label>
                    <input type="text" class="form-control" id="med_ailment" name="dis_ailment" value="<?= $_POST['dis_ailment'] ?>" placeholder="Enter Ailment">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dis_percentage">Disability Percentage</label>
                    <input type="text" class="form-control" id="dis_percentage" name="dis_percentage" value="<?= $_POST['dis_percentage'] ?>" placeholder="Enter Disability Percentage" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Disability Percentage"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
       maxlength="3">
        <p>Only numeric values allowed</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dis_age">Age</label>
                    <input type="text" class="form-control" id="med_dob" value="<?= $_POST['med_dob'] ?>" name="med_dob" placeholder="Enter Age" 
      >
        <p>Only numeric values allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dis_income">Annual Income</label>
                    <input type="text" class="form-control" id="dis_income" value="<?= $_POST['dis_income'] ?>" name="dis_income" placeholder="Enter Annual Income" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Anual Income"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
     >
        <p>Only numeric values allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dis_amount_required">Amount Required</label>
                    <input type="text" class="form-control" id="dis_amount_required" name="dis_amount_required" value="<?= $_POST['dis_amount_required'] ?>" placeholder="Enter Amount Required" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Amount"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
      >
        <p>Only numeric values allowed</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dis_image">Beneficiary Image</label>
                    <input type="file" class="form-control" id="dis_image" name="dis_image" placeholder="No file chosen"  accept=".pdf, .jpg, .jpeg">
                     <p>Only pdf,jpg or jpeg allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dis_pincode">Pincode</label>
                    <input type="text" class="form-control" id="dis_pincode" name="dis_pincode" value="<?= $_POST['dis_pincode'] ?>" placeholder="Enter Pincode" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Amount"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
       maxlength="6">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="dis_target_date">Targeted Date</label>
                    <input type="date" class="form-control" id="dis_target_date" name="dis_target_date" value="<?= $_POST['dis_target_date'] ?>" placeholder="mm/dd/yyyy">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="dis_address">Address</label>
                    <input type="text" class="form-control" id="dis_address" name="dis_address" value="<?= $_POST['dis_address'] ?>" placeholder="Enter Address">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="label">Description</label>
                    <textarea rows="3" class="area form-control" id="dis_description" name="dis_description" value="<?= $_POST['dis_description'] ?>" placeholder="Enter Description"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Category 3 Form -->
          <div id="category3-form" class="category-form">
            <div class="row">
              <div class="col-lg-12" style="margin-bottom: 50px; margin-top: 15px;height: 60px; border-bottom: 2px solid black;">
                <center>
                  <h2>Sanitary Napkin </h2>
                </center>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="sn_beneficiary">Number of Beneficiaries</label>
                  <input type="text" class="form-control" id="sn_beneficiary" name="sn_beneficiary" value="<?= $_POST['sn_beneficiary'] ?>" placeholder="Enter Number of Beneficiaries" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Beneficiaries"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
      >
      <p>Only numeric values allowed</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="sn_total_napkin">Total Number of Napkins Required</label>
                  <input type="text" class="form-control" id="sn_total_napkin" name="sn_total_napkin" value="<?= $_POST['sn_total_napkin'] ?>" placeholder="Enter Total Number of Napkins Required" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Napkings Required"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
       >
       <p>Only numeric values allowed</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="sn_image">Image</label>
                  <input type="file" class="form-control" id="sn_image" name="sn_image" placeholder="No file chosen" accept=".pdf, .jpg, .jpeg">
                     <p>Only pdf,jpg or jpeg allowed</p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="sn_amount_required">Amount Required</label>
                  <input type="text" class="form-control" id="sn_amount_required" name="sn_amount_required" value="<?= $_POST['sn_amount_required'] ?>" placeholder="Enter Amount Required" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Amount"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
     >
       <p>Only numeric values allowed</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="sn_target_date">Targeted Date</label>
                  <input type="date" class="form-control" id="sn_target_date" name="sn_target_date" value="<?= $_POST['sn_target_date'] ?>" placeholder="Select Targeted Date">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="label">Description</label>
                  <textarea rows="3" class="area form-control" id="sn_description" name="sn_description" value="<?= $_POST['sn_description'] ?>" placeholder="Enter Description"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div id="category4-form" class="category-form">
            <div class="form-group">
              <div class="row">
                <div class="col-lg-12" style="margin-bottom: 50px; margin-top: 15px;height: 60px; border-bottom: 2px solid black;">
                  <center>
                    <h2>Sex Worker</h2>
                  </center>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="sw_name">Name (Aadhar Name)</label>
                    <input type="text" class="form-control" id="sw_name" name="sw_name" value="<?= $_POST['sw_name'] ?>" placeholder="Enter Aadhar Name">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="sw_address">Address</label>
                    <input type="text" class="form-control" id="sw_address" name="sw_address" value="<?= $_POST['sw_address'] ?>" placeholder="Enter Address">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="sw_pincode">Pincode</label>
                    <input type="text" class="form-control" id="sw_pincode" name="sw_pincode" value="<?= $_POST['sw_pincode'] ?>" placeholder="Enter Pincode" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Pincode"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
       maxlength="6">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="sw_dependents">Number of Dependents</label>
                    <input type="text" class="form-control" id="sw_dependents" name="sw_dependents" value="<?= $_POST['sw_dependents'] ?>" placeholder="Enter Number of Dependents" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Dependents"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
      >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="sw_requirements">Requirements (Ration)</label>
                    <input type="text" class="form-control" id="sw_requirements" name="sw_requirements" value="<?= $_POST['sw_requirements'] ?>" placeholder="Enter Requirements (Ration)">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="sw_target_date">Targeted Date</label>
                    <input type="date" class="form-control" id="sw_target_date" name="sw_target_date" value="<?= $_POST['sw_target_date'] ?>" placeholder="Select Targeted Date">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="label">Description</label>
                    <textarea rows="3" class="area form-control" id="sw_description" name="sw_description" placeholder="Enter Description"><?= $_POST['sw_target_date'] ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div id="category5-form" class="category-form">
            <div class="form-group">
              <div class="row">
                <div class="col-lg-12" style="margin-bottom: 50px; margin-top: 15px;height: 60px; border-bottom: 2px solid black;">
                  <center>
                    <h2>Old Age Home </h2>
                  </center>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="oah_senior_citizens">Number of Senior Citizens</label>
                    <input type="text" class="form-control" id="oah_senior_citizens" name="oah_senior_citizens" value="<?= $_POST['oah_senior_citizens'] ?>" placeholder="Enter Number of Senior Citizens" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a Senior Citizens"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
      >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="oah_monthly_expense">Monthly Expense/person</label>
                    <input type="text" class="form-control" id="oah_monthly_expense" name="oah_monthly_expense" value="<?= $_POST['oah_monthly_expense'] ?>" placeholder="Enter Monthly Expense per Person" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a Monthly Expense/Person"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
       >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="oah_male">Male</label>
                    <input type="text" class="form-control" id="oah_male" name="oah_male" value="<?= $_POST['oah_male'] ?>" placeholder="Enter Number of Male Senior Citizens" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a Valid Male"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
       >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="oah_female">Female</label>
                    <input type="text" class="form-control" id="oah_female" name="oah_female" value="<?= $_POST['oah_female'] ?>" placeholder="Enter Number of Female Senior Citizens" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Female"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
      >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="oah_image">Image</label>
                    <input type="file" class="form-control" id="oah_image" name="oah_image" placeholder="No file chosen" accept=".pdf, .jpg, .jpeg">
                    <p>Only pdf jpg or jpeg allwed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="oah_amount_required">Amount Required</label>
                    <input type="text" class="form-control" id="oah_amount_required" name="oah_amount_required" value="<?= $_POST['oah_amount_required'] ?>" placeholder="Enter Amount Required" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Required Amount"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
      >
      <p>Only numeric values allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="oah_target_date">Targeted Date</label>
                    <input type="date" class="form-control" id="oah_target_date" name="oah_target_date" value="<?= $_POST['oah_target_date'] ?>" placeholder="Select Targeted Date">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="label">Description</label>
                    <textarea rows="3" class="area form-control" id="oah_description" name="oah_description" placeholder="Enter Description"><?= $_POST['oah_description'] ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div id="category6-form" class="category-form">
            <div class="form-group">
              <div class="row">
                <div class="col-lg-12" style="margin-bottom: 50px; margin-top: 15px;height: 60px; border-bottom: 2px solid black;">
                  <center>
                    <h2>Natural Calamity</h2>
                  </center>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nc_name">Name (Aadhar Name)</label>
                    <input type="text" class="form-control" id="nc_name" name="nc_name" value="<?= $_POST['nc_name'] ?>" placeholder="Enter Aadhar Name">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nc_calamity_type">Calamity type</label>
                    <input type="text" class="form-control" id="nc_calamity_type" name="nc_calamity_type" value="<?= $_POST['nc_calamity_type'] ?>" placeholder="Enter Calamity Type">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nc_age">Age</label>
                    <input type="text" class="form-control" id="nc_age" name="nc_age" value="<?= $_POST['nc_age'] ?>" placeholder="Enter Age" 
       >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nc_income">Annual Income</label>
                    <input type="text" class="form-control" id="nc_income" name="nc_income" value="<?= $_POST['nc_income'] ?>" placeholder="Enter Annual Income" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Amual Income"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
      >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nc_address">Address</label>
                    <input type="text" class="form-control" id="nc_address" name="nc_address" value="<?= $_POST['nc_address'] ?>" placeholder="Enter Address">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nc_family_members">Number of Family Members</label>
                    <input type="text" class="form-control" id="nc_family_members" name="nc_family_members" value="<?= $_POST['nc_family_members'] ?>" placeholder="Enter Number of Family Members" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Family Members"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
      >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nc_amount_required">Amount Required</label>
                    <input type="text" class="form-control" id="nc_amount_required" name="nc_amount_required" value="<?= $_POST['nc_amount_required'] ?>" placeholder="Enter Amount Required" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Amount Required"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
       >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nc_image">Beneficiary Image</label>
                    <input type="file" class="form-control" id="nc_image" name="nc_image" placeholder="No file chosen" accept=".pdf, .jpg, .jpeg">
                    <p>Only Jpeg jpeg of pdf allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nc_target_date">Targeted Date</label>
                    <input type="date" class="form-control" id="nc_target_date" name="nc_target_date" value="<?= $_POST['nc_target_date'] ?>" placeholder="Select Targeted Date">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="label">Description (Overview of Calamity)</label>
                    <textarea rows="3" class="area form-control" id="nc_description" name="nc_description" placeholder="Enter Description"><?= $_POST['nc_target_date'] ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div id="category7-form" class="category-form">
            <div class="form-group">
              <div class="row">
                <div class="col-lg-12" style="margin-bottom: 50px; margin-top: 15px;height: 60px; border-bottom: 2px solid black;">
                  <center>
                    <h2>Education</h2>
                  </center>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="edu_total_students">Total Number of Students</label>
                    <input type="text" class="form-control" id="edu_total_students" name="edu_total_students" value="<?= $_POST['edu_total_students'] ?>" placeholder="Enter Total Number of Students" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Number of Students"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
      >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="edu_age_group">Age Group</label>
                    <input type="text" class="form-control" id="edu_age_group" name="edu_age_group" value="<?= $_POST['edu_age_group'] ?>" placeholder="Enter Age Group" 
      >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="edu_project_name">Name of the Project</label>
                    <input type="text" class="form-control" id="edu_project_name" name="edu_project_name" value="<?= $_POST['edu_project_name'] ?>" placeholder="Enter Name of the Project" >
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="edu_area">Area</label>
                    <input type="text" class="form-control" id="edu_area" name="edu_area" value="<?= $_POST['edu_area'] ?>" placeholder="Enter Area">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="edu_category">Category (BPL)</label>
                    <input type="file" class="form-control" id="edu_category" name="edu_category" placeholder="No file chosen" accept=".pdf, .jpg, .jpeg">
                    <p>Only pdf jpg or jpeg allowed</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="edu_amount_required">Amount Required</label>
                    <input type="text" class="form-control" id="edu_amount_required" name="edu_amount_required" value="<?= $_POST['edu_amount_required'] ?>" placeholder="Enter Amount Required" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Amount Required"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
      >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
              </div>
              <div class="row">
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="edu_target_date">Targeted Date</label>
                    <input type="date" class="form-control" id="edu_target_date" name="edu_target_date" value="<?= $_POST['edu_target_date'] ?>" placeholder="Select Targeted Date">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="label">Description</label>
                    <textarea rows="3" class="area form-control" id="edu_description" name="edu_description" placeholder="Enter Description"><?= $_POST['edu_target_date'] ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div id="category8-form" class="category-form">
            <div class="form-group">
              <div class="row">
                <div class="col-lg-12" style="margin-bottom: 50px; margin-top: 15px;height: 60px; border-bottom: 2px solid black;">
                  <center>
                    <h2>Any Other Project</h2>
                  </center>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="aop_name">Name (Aadhar Name)</label>
                    <input type="text" class="form-control" id="aop_name" name="aop_name" value="<?= $_POST['aop_name'] ?>" placeholder="Enter Aadhar Name">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="aop_contact_number">Contact Number</label>
                    <input type="text" class="form-control" id="aop_contact_number" name="aop_contact_number" value="<?= $_POST['aop_contact_number'] ?>" placeholder="Enter Contact Number" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Age"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" maxlength="10" minlength="10">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="aop_age">Age</label>
                    <input type="text" class="form-control" id="aop_age" name="aop_age" value="<?= $_POST['aop_age'] ?>" placeholder="Enter Age" 
      >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="aop_address">Address</label>
                    <input type="text" class="form-control" id="aop_address" name="aop_address" value="<?= $_POST['aop_address'] ?>" placeholder="Enter Address">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="aop_pincode">Pincode</label>
                    <input type="text" class="form-control" id="aop_pincode" name="aop_pincode" value="<?= $_POST['aop_pincode'] ?>" placeholder="Enter Pincode" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Pincode"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
       maxlength="6">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="aop_project">Project</label>
                    <input type="text" class="form-control" id="aop_project" name="aop_project" value="<?= $_POST['aop_project'] ?>" placeholder="Enter Project">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="aop_amount_required">Amount Required</label>
                    <input type="text" class="form-control" id="aop_amount_required" name="aop_amount_required" value="<?= $_POST['aop_amount_required'] ?>" placeholder="Enter Amount Required" inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Amount"
     
       autocomplete="off"  
        
       oninput="this.value = this.value.replace(/\D/g, '')" 
      >
       <p>Only numeric values allowed</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="aop_target_date">Targeted Date</label>
                    <input type="date" class="form-control" id="aop_target_date" name="aop_target_date" value="<?= $_POST['aop_target_date'] ?>" placeholder="mm/dd/yyyy">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="lbel">Description</label>
                    <textarea rows="3" class="area form-control" id="aop_description" name="aop_description" placeholder="Enter Description"><?= $_POST['aop_target_date'] ?></textarea>
                  </div>
                </div>
              </div>

            </div>
          </div>
           <div class="col-md-6 mb-4">
      <div class="form-group d-flex align-items-center costum-captcha">
        <div class="form-control me-3 jc__captcha__value pe-4 text-center" id="captchaBox"></div>

        <input type="text" class="form-control jc__captcha__input text-center captcha-input"
               id="captcha-input" placeholder="Enter Security Code" required>
      </div>
      <div id="captcha-feedback" class="mt-2"></div>
    </div>
          <center> <button type="submit" class="btn btn-primary fundraiser-btn-submit" style="width:50%; font-size:125%;margin-top:15px;background-color:#86cdcc;">Submit</button></center>


        </form>
      </div>
    </div>
  </div>
    <?php include("./includes/footer.php") ?>
    <?php include("./includes/script.php") ?>
  <script>
     <?php 
       if (!empty($_POST['category'])) {
           echo "showForm('".$_POST['category']."')";
       }
     ?>
  </script>
  
 <script>
    let correctAnswer = 0;

    function generateCaptcha() {
      const num1 = Math.floor(Math.random() * 10) + 1;
      const num2 = Math.floor(Math.random() * 10) + 1;
      const operators = ['+', '-', '*', '/'];
      const operator = operators[Math.floor(Math.random() * operators.length)];

      let question = '';
      switch (operator) {
        case '+':
          correctAnswer = num1 + num2;
          question = `${num1} + ${num2}`;
          break;
        case '-':
          correctAnswer = num1 - num2;
          question = `${num1} - ${num2}`;
          break;
        case '*':
          correctAnswer = num1 * num2;
          question = `${num1} × ${num2}`;
          break;
        case '/':
          const product = num1 * num2; // Ensures clean division
          correctAnswer = product / num1;
          question = `${product} ÷ ${num1}`;
          break;
      }

      document.getElementById('captchaBox').textContent = `What is ${question}?`;
    }

    function validateCaptcha() {
      const userInput = document.getElementById('captcha-input').value.trim();
      const feedback = document.getElementById('captcha-feedback');
      const submitButton = document.getElementById('submit');

      if (userInput === "") {
        feedback.style.color = "red";
        feedback.textContent = "Please enter the result.";
        submitButton.disabled = true;
        return;
      }

      if (parseFloat(userInput) === correctAnswer) {
        feedback.style.color = "green";
        feedback.textContent = "Correct!";
        submitButton.disabled = false;
      } else {
        feedback.style.color = "red";
        feedback.textContent = "Incorrect answer. Try again.";
        submitButton.disabled = true;
      }
    }

    function handleFormSubmit(event) {
      const userInput = document.getElementById('captcha-input').value.trim();
      if (parseFloat(userInput) !== correctAnswer) {
        alert("Please solve the CAPTCHA correctly.");
        event.preventDefault();
        return false;
      }
      return true;
    }

    window.onload = function () {
      generateCaptcha();
      document.getElementById('captcha-input').addEventListener('input', validateCaptcha);
    };
  </script>
       
</body>

</html>