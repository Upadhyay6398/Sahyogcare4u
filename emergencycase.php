<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate</title>
    <?php include("./includes/top.php")?>
          <link rel="icon" href="https://www.sahyogcare4u.org/images/favicons.png" type="image/x-icon">

  <style>
.top-donors-card {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    background-color: #f9f9f9;
    max-width: 400px;
}

.top-donors-card h5 {
    margin-bottom: 15px;
    font-weight: bold;
}

.donor-table {
    width: 100%;
    border-collapse: collapse;
}

.donor-table th, .donor-table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ccc;
}

.donor-table th {
    background-color: #f0f0f0;
    font-weight: 600;
}

.no-donors {
    font-style: italic;
    color: #666;
}
</style>
	
	<meta name="google-site-verification" content="3Sv1MRaMdCRJOeW7TPio056Ow61KrbJntx7BmiHg08Y"/>
	
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-L3TTRSS3S1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-L3TTRSS3S1');
</script>

</head>
<body>
<?php include("./includes/header.php")?>

<?php
$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

if ($slug) {
    $sql = "SELECT * FROM `emergencycase` WHERE `slug` = :slug AND `status` = '1'";
    $stmt = $DB->DB->prepare($sql);
    $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();
    $emergencycase = $stmt->fetch();

    if ($emergencycase) {
        $emergencycase_id = $emergencycase['id'];

        $program_sql = "SELECT * FROM `documents` WHERE `emergencycase_id` = :emergencycase_id ";
        $program_stmt = $DB->DB->prepare($program_sql);
        $program_stmt->bindParam(':emergencycase_id', $emergencycase_id, PDO::PARAM_INT);
        $program_stmt->execute();
        $programs = $program_stmt->fetchAll();

        $gallery_sql = "SELECT * FROM `emergencycase_images` WHERE `emergencycase_id` = :emergencycase_id ";
        $gallery_stmt = $DB->DB->prepare($gallery_sql);
        $gallery_stmt->bindParam(':emergencycase_id', $emergencycase_id, PDO::PARAM_INT);
        $gallery_stmt->execute();
        $gallery_images = $gallery_stmt->fetchAll(); 
    }
}
?>
<?php
function format_in_indian_currency($amount) {
    $amount = (string)$amount;
    $after_decimal = '';
    
    if (strpos($amount, '.') !== false) {
        list($amount, $after_decimal) = explode('.', $amount);
        $after_decimal = '.' . $after_decimal;
    }

    $last_three = substr($amount, -3);
    $rest_units = substr($amount, 0, -3);
    
    if ($rest_units != '') {
        $rest_units = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest_units);
        return $rest_units . "," . $last_three . $after_decimal;
    } else {
        return $last_three . $after_decimal;
    }
}

$total_raised = 0;
$percent_raised = 0;

if ($slug && isset($emergencycase)) {
    $payment_sql = "SELECT SUM(amount) as total_raised FROM payments WHERE `source` = :slug AND payment_status = 'success'";

    try {
        $payment_stmt = $DB->DB->prepare($payment_sql);
        $payment_stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $payment_stmt->execute();

        $payment_data = $payment_stmt->fetch(PDO::FETCH_ASSOC);

        if ($payment_data !== false) {
            $total_raised = $payment_data['total_raised'] ?? 0;
            $goal_amount = $emergencycase['amount'] ?? 0;
            $percent_raised = $goal_amount > 0 ? min(100, round(($total_raised / $goal_amount) * 100)) : 0;
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>
<div class="emergency-case-sec">
    <div class="impact-img top">
        <img src="<?php echo $base_url.'images/shape.png'?>" class="img-fluid w-100" alt="">
    </div>
<h2 class="heading11 heading12 mb-4">Help <span><i><?php echo $emergencycase['name'];?></i></span> Fight <span><?php echo $emergencycase['disease'];?></span></h2>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="emergency-case-inner">
                <div id="main-image-container">
                    <div id="blurred-background"></div>
                    <img id="main-image" src="<?php echo $base_url .'sahyogcare4u-admin/'.$emergencycase['image']; ?>" alt="Main Image">
                </div>
               
   <div class="thumbnail-container">
    <?php 
    foreach ($gallery_images as $index => $gallery_image) { 
        if (!empty($gallery_image['image'])) {
            $image_path = __DIR__ . '/sahyogcare4u-admin/' . $gallery_image['image']; // server path to image
            if (file_exists($image_path)) { ?>
                <img class="thumbnail" src="<?php echo $base_url . 'sahyogcare4u-admin/' . $gallery_image['image']; ?>" alt="Image <?php echo $index + 1; ?>">
            <?php }
        }
    } 
    ?>
</div>



                <div class="col-md-12 px-5">
    <!-- Progress bar container -->
<!-- Progress Bar Display -->
<div class="col-md-12 px-5">
    <!-- Progress bar container -->
    <div class="raiser-bar">
        <div class="progress" style="height: 20px;">
            <div class="progress-bar" role="progressbar"
                 style="width: <?php echo $percent_raised; ?>%;
                        background-color: <?php echo ($percent_raised < 30) ? '#dc3545' : (($percent_raised < 70) ? '#ffc107' : '#28a745'); ?>;"
                 aria-valuenow="<?php echo $percent_raised; ?>" aria-valuemin="0" aria-valuemax="100">
                <?php echo $percent_raised; ?>%
            </div>
        </div>
    </div>
    <div class="raised-money-data mt-2">
        <p>
            <span>₹<?php echo format_in_indian_currency($total_raised); ?></span> 
            <i>raised of ₹<?php echo format_in_indian_currency($emergencycase['amount'] ?? 0); ?> goal</i>
        </p>
    </div>      
</div>    
</div>


                <h2 class="heading11 mt-4">
    <img src="<?php echo $base_url . 'images/heading-icon.png'; ?>" alt=""> Emergency Case
</h2>


                <div class="case-details">
                   

                    <p class="pb-3"><?php echo $emergencycase['description'];?></p>

                <?php
$hasDocument = false;
foreach ($programs as $program) {
    if (!empty($program['documents'])) {
        $hasDocument = true;
        break;
    }
}
?>

<?php if ($hasDocument) { ?>
    <div class="document-sec mt-5">
        <h4>Documents</h4>
        <table class="document-table" border="1" cellpadding="10" cellspacing="0">
            
            <tbody>
                <?php foreach ($programs as $program) {
                    if (!empty($program['documents'])) { ?>
                        <tr>
    <td class="document-name" >  <a href="<?php echo $base_url . 'sahyogcare4u-admin/' . ($program['documents']); ?>" target="_blank" style="text-decoration:none"><?php echo htmlspecialchars($program['name']); ?></a></td>
    <td style="text-align: right;">
        <a href="<?php echo $base_url . 'sahyogcare4u-admin/' . $program['documents']; ?>" target="_blank">
            <button class="view-button">
                <span class="ml-4"><i class="fa fa-eye " aria-hidden="true"></i></span> View
            </button>
        </a>
    </td>
</tr>

                    <?php }
                } ?>
            </tbody>
        </table>
    </div>
<?php } ?>


                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="e-saidebar">
                <div class="program-sidebar-head">
                            <h2>Donate Now</h2>
                        </div>
                        <p>Please select pre-defined amount or fill in custom amount.</p>
               <form class="side-bar-form mt-3" method="post" data-parsley-validate action="../generateCCHash.php">
                   
                   <input type="hidden" name="source" value="<?php echo $slug; ?>">
                              <input type="hidden" class="form-control" id="patient_id" name="patient_id" value="<?php echo htmlspecialchars($emergencycase['id']); ?>">
    <!-- Amount Buttons (Fixed data-amount values) -->
     <div class="amount-option">
    <button type="button" class="amount-btn" data-amount="500">500</button>
    <button type="button" class="amount-btn" data-amount="1000">1000</button>
    <button type="button" class="amount-btn" data-amount="5000">5000</button>
    <button type="button" class="amount-btn" data-amount="10000">10000</button>
     </div>
    <!-- Amount Input Field -->
 <input id="amountInput" name="amount" class="form-control program-input mt-3 mb-3"
    placeholder="Custom Amount" type="text" inputmode="numeric" data-parsley-type="digits"
    data-parsley-pattern-message="Please enter a valid Amount" data-parsley-required="true"
    autocomplete="off" oninput="validateAmount(this)" min="1">

    <!-- Name Input Field -->
    <input class="form-control sidebar-input mb-3" placeholder="Name" type="text" required name="name">

    <!-- Phone Input Field -->
        <input id="mobile" name="mobile" class="form-control program-input mb-3"
        placeholder="Mobile Number" inputmode="numeric" data-parsley-type="digits" type="text" maxlength="10" minlength="10"
        data-parsley-pattern-message="Please enter a valid Mobile Number"
        data-parsley-required="true" autocomplete="off"
        oninput="this.value = this.value.replace(/\D/g, '')">

    <!-- Email Input Field -->
    <input class="form-control sidebar-input mb-3" placeholder="Email" type="email" name="email" required>

    <!-- PAN Number Input Field -->
    <input class="form-control sidebar-input mb-1" placeholder="PAN Number" type="text" name="pan_number">
    <span>Required by Government for tax exemption</span>

    <!-- Secure Payment Notice -->
    <div class="secure-payments-text mt-2">
        <span class="secure-payments-icon">🔒</span> Your payments are secured with CCAvenue
    </div>

    <!-- Checkbox for Regular Updates -->
    <small>
        <label style="margin: 0 0 10px">
            <input type="checkbox" checked> ⁠Send Regular updates via email/whatsapp
        </label>
    </small>

    <!-- Direct Payment Option (Conditional PHP) -->
    <div class="col-md-12 mb-3">
        <div class="text-center">
            <?php if (!empty($emergencycase['accountno'])): ?>
                <a href="<?php echo $base_url . 'account/' . htmlspecialchars($emergencycase['slug']); ?>" class="sidebar-submit-btn" id="directPayBtn">
                    Pay directly to beneficiary’s account
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Donate Button -->
    <div class="text-center">
        <button type="submit" name="DonateNow" class="sidebar-submit-btn">Donate</button>
    </div>

    <!-- Contact Information Section -->
    <div class="col-md-12 mt-3">
        <div class="borderbox">
            <div class="row">
                <div class="col-3 d-flex align-items-center">
                    <a style="color: #2f2f2f;" class="donate-whatsapp" href="https://api.whatsapp.com/send?phone=918743012622&amp;text=&amp;source=&amp;data=">
                        <img class="w-100" src="<?php echo $base_url . 'images/whatsapp3.png'; ?>" alt="WhatsApp">
                    </a>
                </div>
                <div class="col-9 ps-0">
                    <p class="mb-0">If you wish to know more about the case, contact us on WhatsApp at 
                        <a style="color: #2f2f2f; display: inline-block; text-decoration: underline;" class="donate-whatsapp" href="https://api.whatsapp.com/send?phone=918743012622&amp;text=&amp;source=&amp;data=">
                            8743012622
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="borderbox mb-2 mt-3">
            <div class="row">
                <div class="col-md-12">
                    <p class="mb-0">Call us at  
                        <a href="tel:+918860989205" class="text-dark">+91-8860989205</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</form>
            </div>
            <div class="side-bar-qr mt-3">
                <img src="<?php echo $base_url.'images/sahyogcare4u-qr.jpeg'?>" alt="">
<div class="top-donors-card mt-4">
    <h5>Top Donors</h5>

    <?php 
    $topDonorSql = "SELECT name, amount FROM payments 
                    WHERE `source` = :slug 
                    AND payment_status = 'success' 
                    AND name IS NOT NULL AND name != '' 
                    AND LOWER(name) != 'total' 
                    AND amount IS NOT NULL AND amount != 0 
                    ORDER BY CAST(amount AS UNSIGNED) DESC 
                    LIMIT 5";
    $topDonorStmt = $DB->DB->prepare($topDonorSql);
    $topDonorStmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    $topDonorStmt->execute();

    // Fetch top donors as associative array
    $donors = $topDonorStmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?php if (count($donors) > 0): ?>
        <table class="donor-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donors as $donor): ?>
                    <tr>
                        <td><?= htmlspecialchars($donor['name']) ?></td>
                        <td>₹<?= number_format((float)$donor['amount']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-donors">No donors yet.</p>
    <?php endif; ?>
</div>







            <div class="share-container">
                <h2>Each share helps</h2>
                <div class="share-buttons">
                    <a href="https://web.whatsapp.com/send?text=Help%20Saras Khare%20Fight%20Congenital heart defect%20Donate%20now%20on%20website:%20https://www.sahyogcare4u.org/emergencycase.php?id=MzQzNDM0Mjg=" target="_blank" class="share-button whatsapp">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"></path></svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.sahyogcare4u.org/emergencycase.php?id=MzQzNDM0Mjg=" target="_blank" class="share-button facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=https://www.sahyogcare4u.org/emergencycase.php?id=MzQzNDM0Mjg=&amp;text=Help%20Saras Khare%20Fight%20Congenital heart defect%20Donate%20now%20on%20website:" target="_blank" class="share-button twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path></svg>
                    </a>
                    <a href="https://www.instagram.com/sahyogcare4you/" target="_blank" class="share-button twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 30 30" style="fill:#FFFFFF;">
            <path d="M 9.9980469 3 C 6.1390469 3 3 6.1419531 3 10.001953 L 3 20.001953 C 3 23.860953 6.1419531 27 10.001953 27 L 20.001953 27 C 23.860953 27 27 23.858047 27 19.998047 L 27 9.9980469 C 27 6.1390469 23.858047 3 19.998047 3 L 9.9980469 3 z M 22 7 C 22.552 7 23 7.448 23 8 C 23 8.552 22.552 9 22 9 C 21.448 9 21 8.552 21 8 C 21 7.448 21.448 7 22 7 z M 15 9 C 18.309 9 21 11.691 21 15 C 21 18.309 18.309 21 15 21 C 11.691 21 9 18.309 9 15 C 9 11.691 11.691 9 15 9 z M 15 11 A 4 4 0 0 0 11 15 A 4 4 0 0 0 15 19 A 4 4 0 0 0 19 15 A 4 4 0 0 0 15 11 z"></path>
        </svg>
                    </a>
                </div>
               
            </div>
        </div>
    </div>
</div>
<div class="impact-img">
    <img src="<?php echo $base_url.'images/shape.png'?>" class="img-fluid w-100" alt="">
</div>
</div>

<div class="donate-info donate-info-emergency mt70">
    <div class="container">
        <h2>GIVE THE CHILD A CHILDHOOD</h2>
        <p><i>Your support is vital to ensure this change and make a direct &amp; lasting impact on the lives of children. Whether you choose to donate monthly or choose to provide a single gift. You are standing up for every child's right to health, education, equality &amp; protection.</i></p>
        <div class="row mt-3">
            <div class="col-md-8">
                <div class="emergency-info">
                    <h2>For Indian and NRI Donors</h2>
                </div>
                <div class="col-md-6">
                    <div class="bankd2">
                        <h4>SAHYOG CARE FOR YOU</h4>
                        <p>A/c no-924010067539570</p>
                        <p>Axis Bank Ltd.</p>
                        <p>Meera Bagh</p>
                        <p>IFSC-UTIB0000533</p>
                     </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="side-bar-qr mt-3">
                    <img class="p-3" src="<?php echo $base_url.'images/sahyogcare4u-qr.jpeg'?>" alt="">
                    <h4>Scan &amp; Donate</h4>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include("./includes/footer.php")?>
<?php include("./includes/script.php")?>
 <script>
    document.querySelectorAll('.amount-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var amount = this.getAttribute('data-amount');
            document.getElementById('amountInput').value = amount;
        });
    });
</script>

<!-- Parsley.js Validation Initialization (if not already initialized) -->
<script>
    $(document).ready(function() {
        $('form').parsley();
    });
</script>
<script>
  // Sare thumbnails select karo
  const thumbnails = document.querySelectorAll('.thumbnail');
  const mainImage = document.getElementById('main-image');

  thumbnails.forEach(thumbnail => {
    thumbnail.addEventListener('click', () => {
      // Jab thumbnail pe click ho, main image ka src update karo
      mainImage.src = thumbnail.src;
      // Optional: agar alt bhi update karna hai to
      mainImage.alt = thumbnail.alt || 'Main Image';
    });
  });
</script>
<script>
    function validateAmount(input) {
        // Remove all non-numeric characters
        input.value = input.value.replace(/\D/g, '');
        if (input.value === '0' || input.value === '') {
            input.value = '';
        }
        if (parseInt(input.value) < 1) {
            input.value = '1';
        }
    }
</script>
</body>
</html>