<?php
require("config.php");
require("lock.php");

// Handle form submission
if (isset($_POST['send_whatsapp'])) {
    $name = trim($_POST['name']);
    $mobile = trim($_POST['mobile']);
    $amount = trim($_POST['amount']);
    $error = "";
    
    // Validations
    if (empty($name)) {
        $error = "Please enter donor name";
        $msg_type = "error";
    } elseif (empty($mobile)) {
        $error = "Please enter mobile number";
        $msg_type = "error";
    } elseif (!preg_match('/^[0-9]{10}$/', $mobile) && !preg_match('/^91[0-9]{10}$/', $mobile)) {
        $error = "Please enter valid 10-digit mobile number";
        $msg_type = "error";
    } elseif (empty($amount) || !is_numeric($amount)) {
        $error = "Please enter valid amount";
        $msg_type = "error";
    } else {
        try {
            // Send WhatsApp message
            $whatsappSent = sendWhatsAppMessage($mobile, $name, $amount);
            
            // Save to database
            $logData = [
                'name' => $name,
                'mobile' => $mobile,
                'amount' => $amount,
                'status' => $whatsappSent ? 'sent' : 'failed',
                'sent_by' => $_SESSION['ADMIN_USER_ID'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $DB->insert('whatsapp_logs', $logData);
            
            if ($whatsappSent) {
                $error = "WhatsApp message sent successfully to $name!";
                $msg_type = "success";
            } else {
                $error = "Failed to send WhatsApp message. Please check logs.";
                $msg_type = "error";
            }
            
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
            $msg_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=DEFAULT_TITLE?> | Send WhatsApp</title>
<?php include("include/head.php"); ?>
<script type="text/javascript" src="<?=BASE_URL?>assets/widgets/parsley/parsley.js"></script>
</head>

<body>
<?php include("include/header-include.php");?> 
<?php include("include/header.php");?> 
<?php include("include/sidebar.php");?>

<div id="page-content-wrapper">
   <div id="page-content">
      <div id="page-title">
         <h2>Send WhatsApp Message</h2>
      </div> 
      <?php include("include/message.php"); ?>
      
      <div class="col-md-6">  
         <div class="panel">
            <div class="panel-body">
               <h3 class="title-hero">
                  Send WhatsApp Message
               </h3>
               <div class="example-box-wrapper">
                  <form class="form-horizontal bordered-row" method="post" id="whatsapp-form" data-parsley-validate="">
                     
                     <div class="form-group">
                        <label class="col-sm-3 control-label">Donor Name</label>
                        <div class="col-sm-6">
                           <input type="text" 
                                  name="name" 
                                  class="form-control" 
                                  placeholder="Enter donor name"
                                  value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>"
                                  required>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-sm-3 control-label">Mobile Number</label>
                        <div class="col-sm-6">
                           <input type="text" 
                                  name="mobile" 
                                  class="form-control" 
                                  placeholder="Enter 10-digit mobile (without +91)"
                                  value="<?= isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : '' ?>"
                                  pattern="[0-9]{10}"
                                  maxlength="10"
                                  required>
                           <p class="help-block">Enter 10-digit number only (Example: 9876543210)</p>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-sm-3 control-label">Amount (₹)</label>
                        <div class="col-sm-6">
                           <input type="number" 
                                  name="amount" 
                                  class="form-control" 
                                  placeholder="Enter amount"
                                  value="<?= isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : '' ?>"
                                  min="1"
                                  step="0.01"
                                  required>
                        </div>
                     </div>

                     <div class="bg-default content-box text-center pad20A mrg25T">
                        <button class="btn btn-lg btn-success" type="submit" name="send_whatsapp">
                           <i class="glyph-icon icon-check"></i> Send WhatsApp Message
                        </button>
                        <a href="manage-whatsapp.php" class="btn btn-lg btn-default">
                           <i class="glyph-icon icon-list"></i> View Messages
                        </a>
                     </div>

                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include("include/footer-js.php"); ?>
</body>
</html>
