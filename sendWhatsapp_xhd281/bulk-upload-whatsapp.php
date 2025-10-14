<?php
require("config.php");
require("lock.php");

// Get all uploaded contacts that are pending to be sent
$sql = "SELECT * FROM whatsapp_logs WHERE status = 'pending' ORDER BY id DESC";
$stmt = $DB->DB->prepare($sql);
$stmt->execute();
$pendingContacts = $stmt->fetchAll();
$pendingCount = count($pendingContacts);

// Handle bulk WhatsApp send
if (isset($_POST['send_bulk_whatsapp'])) {
    // Increase execution time for bulk sending
    set_time_limit(300); // 5 minutes
    ini_set('max_execution_time', 300);
    
    $successCount = 0;
    $failCount = 0;
    
    // Get all pending contacts
    $sql = "SELECT * FROM whatsapp_logs WHERE status = 'pending'";
    $stmt = $DB->DB->prepare($sql);
    $stmt->execute();
    $contacts = $stmt->fetchAll();
    
    foreach ($contacts as $contact) {
        // Send WhatsApp message
        $whatsappSent = sendWhatsAppMessage($contact['mobile'], $contact['name'], $contact['amount']);
        
        // Update status in database
        $updateData = [
            'status' => $whatsappSent ? 'sent' : 'failed',
            'id' => $contact['id']
        ];
        
        $updateSql = "UPDATE whatsapp_logs SET status = :status WHERE id = :id";
        $updateStmt = $DB->DB->prepare($updateSql);
        $updateStmt->execute($updateData);
        
        if ($whatsappSent) {
            $successCount++;
        } else {
            $failCount++;
        }
        
        // Small delay to avoid API rate limiting
        usleep(500000); // 0.5 second delay
    }
    
    $_SESSION['msg'] = "Bulk WhatsApp sent! Success: $successCount, Failed: $failCount";
    $_SESSION['msg_type'] = "success";
    header("Location: bulk-upload-whatsapp.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=DEFAULT_TITLE?> | Bulk Upload WhatsApp</title>
<?php include("include/head.php"); ?>
<script type="text/javascript" src="<?=BASE_URL?>assets/widgets/parsley/parsley.js"></script>
<style>
.upload-box {
    border: 2px dashed #ccc;
    padding: 40px;
    text-align: center;
    border-radius: 10px;
    background: #f9f9f9;
    margin-bottom: 20px;
}
.upload-box:hover {
    border-color: #5cb85c;
    background: #f0fff0;
}
.upload-box i {
    font-size: 48px;
    color: #5cb85c;
    margin-bottom: 15px;
}
.sample-format {
    background: #fff;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-top: 20px;
}
.pending-contacts {
    background: #fffacd;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
    border: 2px solid #ffd700;
}
.btn-send-bulk {
    font-size: 18px;
    padding: 15px 30px;
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}
</style>
</head>

<body>
<?php include("include/header-include.php");?> 
<?php include("include/header.php");?> 
<?php include("include/sidebar.php");?>

<div id="page-content-wrapper">
   <div id="page-content">
      <div class="container">
         <div id="page-title">
            <h2>Bulk Upload & Send WhatsApp</h2>
         </div>
         
         <?php 
         if (isset($_SESSION['msg'])) {
            $alertType = ($_SESSION['msg_type'] == "success") ? "alert-success" : "alert-danger";
            echo "<div class='alert $alertType'>" . $_SESSION['msg'] . "</div>";
            unset($_SESSION['msg']);
            unset($_SESSION['msg_type']);
         }
         ?>
         
         <!-- Show pending contacts count and send button -->
         <?php if ($pendingCount > 0): ?>
         <div class="pending-contacts">
            <div class="row">
               <div class="col-md-8">
                  <h3 style="margin-top: 0;">
                     <i class="glyph-icon icon-users"></i> 
                     <?= $pendingCount ?> Contacts Ready to Send
                  </h3>
                  <p>Aapne total <?= $pendingCount ?> contacts upload kiye hain jo pending hain. Neeche button dabake sabhi ko ek saath WhatsApp message bhej sakte hain.</p>
               </div>
               <div class="col-md-4 text-right">
                  <form method="post" onsubmit="return confirm('Kya aap <?= $pendingCount ?> contacts ko WhatsApp message bhejna chahte hain?');">
                     <button type="submit" name="send_bulk_whatsapp" class="btn btn-success btn-lg btn-send-bulk">
                        <i class="glyph-icon icon-send"></i> Send WhatsApp to All (<?= $pendingCount ?>)
                     </button>
                  </form>
               </div>
            </div>
         </div>
         <?php endif; ?>
         
         <div class="row">
            <!-- Upload CSV Section -->
            <div class="col-md-6">
               <div class="panel">
                  <div class="panel-body">
                     <h3 class="title-hero">
                        <i class="glyph-icon icon-upload"></i> Upload CSV/Excel File
                     </h3>
                     
                     <div class="upload-box">
                        <i class="glyph-icon icon-cloud-upload"></i>
                        <h4>Upload Your CSV or Excel File</h4>
                        <p>CSV ya Excel file upload karein jisme Name, Mobile, Amount columns hon</p>
                        
                        <form id="uploadForm" enctype="multipart/form-data">
                           <input type="file" 
                                  name="csv_file" 
                                  id="csv_file" 
                                  accept=".csv,.xlsx,.xls" 
                                  required
                                  style="margin: 20px auto; display: block; width: 300px;">
                           <button type="submit" class="btn btn-lg btn-primary">
                              <i class="glyph-icon icon-upload"></i> Upload & Save to Database
                           </button>
                        </form>
                     </div>
                     
                     <div id="upload-result" style="margin-top: 20px;"></div>
                     
                     <div class="sample-format">
                        <h4><i class="glyph-icon icon-info-circle"></i> File Format Instructions:</h4>
                        <ul style="text-align: left; margin-left: 20px;">
                           <li>CSV ya Excel file (.csv, .xlsx, .xls) upload kar sakte hain</li>
                           <li>First row mein column headings honi chahiye</li>
                           <li><strong>Required Columns:</strong> Name, Mobile, Amount</li>
                           <li>Mobile number 10 digits ka hona chahiye (without +91)</li>
                           <li>Amount number format mein hona chahiye</li>
                        </ul>
                        
                        <h5 style="margin-top: 15px;">Sample Format:</h5>
                        <table class="table table-bordered" style="background: white;">
                           <thead>
                              <tr style="background: #5cb85c; color: white;">
                                 <th>Name</th>
                                 <th>Mobile</th>
                                 <th>Amount</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>Rahul Kumar</td>
                                 <td>9876543210</td>
                                 <td>5000</td>
                              </tr>
                              <tr>
                                 <td>Priya Sharma</td>
                                 <td>9123456789</td>
                                 <td>10000</td>
                              </tr>
                              <tr>
                                 <td>Amit Singh</td>
                                 <td>9988776655</td>
                                 <td>2500</td>
                              </tr>
                           </tbody>
                        </table>
                        
                        <a href="#" onclick="downloadSampleCSV(); return false;" class="btn btn-success">
                           <i class="glyph-icon icon-download"></i> Download Sample CSV
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            
            <!-- Pending Contacts List -->
            <div class="col-md-6">
               <div class="panel">
                  <div class="panel-body">
                     <h3 class="title-hero">
                        <i class="glyph-icon icon-list"></i> Pending Contacts (<?= $pendingCount ?>)
                     </h3>
                     
                     <?php if ($pendingCount > 0): ?>
                     <div style="max-height: 600px; overflow-y: auto;">
                        <table class="table table-striped table-bordered">
                           <thead>
                              <tr>
                                 <th>Sr.</th>
                                 <th>Name</th>
                                 <th>Mobile</th>
                                 <th>Amount</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php 
                              $i = 1;
                              foreach ($pendingContacts as $contact): 
                              ?>
                              <tr>
                                 <td><?= $i ?></td>
                                 <td><?= htmlspecialchars($contact['name']) ?></td>
                                 <td><?= htmlspecialchars($contact['mobile']) ?></td>
                                 <td>₹<?= number_format($contact['amount'], 2) ?></td>
                              </tr>
                              <?php 
                              $i++;
                              endforeach; 
                              ?>
                           </tbody>
                        </table>
                     </div>
                     <?php else: ?>
                     <div class="alert alert-info">
                        <i class="glyph-icon icon-info-circle"></i> 
                        Abhi koi pending contacts nahi hain. Pehle CSV file upload karein.
                     </div>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>
         
         <!-- View All Messages -->
         <div class="text-center" style="margin-top: 20px;">
            <a href="debug-whatsapp.php" class="btn btn-lg btn-warning" style="margin-right: 10px;">
               <i class="glyph-icon icon-bug"></i> Debug Tool - Problem Check Karo
            </a>
            <a href="manage-whatsapp.php" class="btn btn-lg btn-default">
               <i class="glyph-icon icon-list"></i> View All WhatsApp Messages
            </a>
         </div>
      </div>
   </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Download sample CSV
function downloadSampleCSV() {
    var csv = 'Name,Mobile,Amount\n';
    csv += 'Rahul Kumar,9876543210,5000\n';
    csv += 'Priya Sharma,9123456789,10000\n';
    csv += 'Amit Singh,9988776655,2500\n';
    
    var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    var link = document.createElement("a");
    var url = URL.createObjectURL(blob);
    link.setAttribute("href", url);
    link.setAttribute("download", "sample_whatsapp_upload.csv");
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Handle file upload via AJAX
$(document).ready(function() {
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var fileInput = $('#csv_file')[0];
        
        if (fileInput.files.length === 0) {
            $('#upload-result').html('<div class="alert alert-danger">Please select a file to upload!</div>');
            return;
        }
        
        // Show loading
        $('#upload-result').html('<div class="alert alert-info"><i class="glyph-icon icon-spinner icon-spin"></i> Uploading and processing file... Please wait...</div>');
        
        $.ajax({
            url: 'ajax/process-bulk-upload.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',  // Expect JSON response
            success: function(response) {
                console.log('Response received:', response);
                
                // Check if response is already an object (parsed by jQuery)
                var result = response;
                
                if (result.success) {
                    $('#upload-result').html(
                        '<div class="alert alert-success">' +
                        '<strong>✅ Success!</strong><br>' +
                        'Total Records: ' + result.total + '<br>' +
                        'Successfully Uploaded: ' + result.uploaded + '<br>' +
                        'Failed/Skipped: ' + result.failed + '<br>' +
                        (result.errors && result.errors.length > 0 ? '<br><strong>Errors:</strong><br>' + result.errors.join('<br>') : '') +
                        '</div>'
                    );
                    
                    // Reload page after 3 seconds to show updated pending contacts
                    if (result.uploaded > 0) {
                        $('#upload-result').append('<p><i class="glyph-icon icon-spinner icon-spin"></i> Refreshing page in 3 seconds...</p>');
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    }
                } else {
                    $('#upload-result').html(
                        '<div class="alert alert-danger">' +
                        '<strong>❌ Error!</strong><br>' + 
                        result.message + 
                        '</div>'
                    );
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Response Text:', xhr.responseText);
                
                var errorMsg = '<div class="alert alert-danger">';
                errorMsg += '<strong>❌ Upload Failed!</strong><br>';
                errorMsg += 'Status: ' + status + '<br>';
                errorMsg += 'Error: ' + error + '<br>';
                
                // Try to parse error response
                try {
                    var errorResponse = JSON.parse(xhr.responseText);
                    if (errorResponse.message) {
                        errorMsg += '<br>' + errorResponse.message;
                    }
                } catch (e) {
                    // If response is not JSON, show first 500 chars
                    if (xhr.responseText) {
                        errorMsg += '<br><small>Response: ' + xhr.responseText.substring(0, 500) + '</small>';
                    }
                }
                
                errorMsg += '<br><br><strong>Possible Solutions:</strong><br>';
                errorMsg += '1. Check if you are logged in<br>';
                errorMsg += '2. Verify file format (CSV or XLSX)<br>';
                errorMsg += '3. Check column headers (Name, Mobile, Amount)<br>';
                errorMsg += '4. Contact admin if problem persists';
                errorMsg += '</div>';
                
                $('#upload-result').html(errorMsg);
            }
        });
    });
});
</script>

<?php include("include/footer-js.php"); ?>
</body>
</html>


