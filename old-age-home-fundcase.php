
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <?php include("./includes/top.php");
// Slug and base values
$slug = "old-age-home-fundcase.php";
$base_amount = 35703;
$goal_amount = 225000; // Goal: ₹20,00,000 (20 lakh)

// Function to format number in Indian style
function format_in_indian_style($number) {
    $number = (string) $number;
    $after_decimal = '';

    // Handle decimals
    if (strpos($number, '.') !== false) {
        list($number, $after_decimal) = explode('.', $number);
        $after_decimal = '.' . $after_decimal;
    }

    $last3 = substr($number, -3);
    $rest = substr($number, 0, -3);

    if ($rest != '') {
        $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);
        $number = $rest . ',' . $last3;
    } else {
        $number = $last3;
    }

    return $number . $after_decimal;
}

// Fetch raised amount from DB
if ($slug) {
    $payment_sql = "SELECT SUM(amount) as total_raised FROM payments WHERE `source` = :slug AND payment_status = 'success'";

    try {
        $payment_stmt = $DB->DB->prepare($payment_sql);
        $payment_stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $payment_stmt->execute();

        $payment_data = $payment_stmt->fetch(PDO::FETCH_ASSOC);
        $db_raised = $payment_data['total_raised'] ?? 0;

        $total_raised = $base_amount + $db_raised;
        $percent_raised = $goal_amount > 0 ? min(100, round(($total_raised / $goal_amount) * 100)) : 0;
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    $total_raised = $base_amount;
    $percent_raised = $goal_amount > 0 ? min(100, round(($total_raised / $goal_amount) * 100)) : 0;
}
?>

<title>Old Age Home Women</title>
  <link rel="icon" href="images/favicons.png" type="image/x-icon">
	
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
    <?php include("./includes/header.php") ?>

    <div class="fundcase-sec mtb70">
        <div class="container">
            <div class="row row-gap-4">
                <div class="col-lg-8 col-md-6">
                    <div class="fundcase-wrapper">
                        <img src="images/fundcase-img-3.jpeg" alt="">

                        <div class="fundcase-text">
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

    <!-- Raised amount display -->
    <div class="raised-money-data mt-2">
        <p>
            <span>₹<?php echo format_in_indian_style($total_raised); ?></span>
            <i>raised of ₹<?php echo format_in_indian_style($goal_amount); ?> goal</i>
        </p>
    </div>
                            <h2 class="text-center" >About the Fundraiser</h2>
                            <p>A roof over their heads is a critical need of the elder who are destitute, sick and abandoned by family and those uprooted by disasters. Sahyog care has established model recreational centre for the senior citizens and aged in places such as Delhi. Sahyog care supports 285 old age citizens of India. Sahyog Care aims to disabuse the popular mind-set that regards old age with a sense of pity for their helplessness. Replacing it with an attitude of confidence, fostering respect for them and encouraging fortitude in them. And bringing a little certainly, even fun into their lives. Support of Rs 7500/- is very helpful for one senior citizen to meet his requirement for fooding(Rs3500), lodging(Rs2000), and health(Rs1000) care on monthly basis.</p>
                        </div>
                    </div>
                </div>
                
                
                <div class="col-lg-4 col-md-6">
                    <div class="program-sidebar">
                        <div class="program-sidebar-head">
                            <h2>Donate Now</h2>
                        </div>
                        <form  method="post" data-parsley-validate action="generateCCHash.php">
                           <input type="hidden" name="source" value="old-age-home-fundcase.php">
           <input type="hidden" class="form-control" id="patient_id" name="patient_id" value="<?php echo htmlspecialchars($category['id']); ?>">
    <div class="amount-option">
        <button type="button" class="amount-btn-program" data-amount="3000">3000</button>
        <button type="button" class="amount-btn-program" data-amount="6000">6000</button>
        <button type="button" class="amount-btn-program" data-amount="10000">10000</button>
    </div>
<input id="amountInput" name="amount" class="form-control program-input mt-3 mb-3" placeholder="Custom Amount" type="text" inputmode="numeric" data-parsley-type="digits" data-parsley-pattern-message="Please enter a valid Amount" data-parsley-required="true" autocomplete="off" oninput="if (this.value === '0') { this.value = ''; } else { this.value = this.value.replace(/\D/g, ''); }">


    <input id="name" name="name" class="form-control program-input mb-3"
        placeholder="Name" type="text" required>

    <input id="mobile" name="mobile" class="form-control program-input mb-3"
        placeholder="Mobile Number" inputmode="numeric" data-parsley-type="digits" type="text" maxlength="10" minlength="10"
        data-parsley-pattern-message="Please enter a valid Mobile Number"
        data-parsley-required="true" autocomplete="off"
        oninput="this.value = this.value.replace(/\D/g, '')">

    <input id="email" name="email" class="form-control program-input mb-3"
        placeholder="Email" type="email" required>

    <div class="secure-payments-text secure-payments-text-program mx-3 mt-2">
        <span class="secure-payments-icon">ðŸ”’</span> Your payments are secured with CCAvenue
    </div>

    <div class="text-center">
        <button type="submit" class="sidebar-submit-btn proram-submit">submit</button>
    </div>
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include("./includes/footer.php") ?>
    <?php include("./includes/script.php") ?>

    <!-- JavaScript Validation & Amount Autofill -->
    <script>
    document.querySelectorAll('.amount-btn-program').forEach(function(button) {
        button.addEventListener('click', function() {
            var amount = this.getAttribute('data-amount');
            document.getElementById('amountInput').value = amount;
        });
    });
</script>

</body>

</html>
