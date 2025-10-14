<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("includes/top.php"); ?>
           <link rel="icon" href="https://www.sahyogcare4u.org/images/favicons.png" type="image/x-icon">

    <title>Kurma Graphs</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
	
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
  
    <?php include("./includes/header.php"); ?>

   




    <div class="impact-sec">
        <div class="impact-img top">
            <img src="https://sahyogcare4u.org/images/torn.png" class="img-fluid w-100" alt="">
        </div>
        <div class="container">
            <div class="row row-gap-5">
                <div class="col-lg-8 col-md-6">
                    <div class="program-content">
                          <div class="vd mb-3">
                  <video playsinline autoplay muted loop style="width: 100%">
                     <source src="images/final edit_3.mp4" type="video/mp4">
                  </video>
                   <?php
// All URLs to be included
$slugs = [
    "kurma-ghars.php"
];

// Base and goal amount (combined)
$base_amount = 15563; // Set as needed
$goal_amount = 4500000; // Set as needed

// Format function remains the same
function format_in_indian_style($number) {
    $number = (string) $number;
    $after_decimal = '';

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

// Fetch combined donation from DB
$total_db_raised = 0;

if (!empty($slugs)) {
    $placeholders = implode(',', array_fill(0, count($slugs), '?'));
    $payment_sql = "SELECT SUM(amount) as total_raised FROM payments WHERE `source` IN ($placeholders) AND payment_status = 'success'";

    try {
        $payment_stmt = $DB->DB->prepare($payment_sql);
        foreach ($slugs as $index => $slug) {
            $payment_stmt->bindValue($index + 1, $slug, PDO::PARAM_STR);
        }
        $payment_stmt->execute();

        $payment_data = $payment_stmt->fetch(PDO::FETCH_ASSOC);
        $total_db_raised = $payment_data['total_raised'] ?? 0;
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

$total_raised = $base_amount + $total_db_raised;
$percent_raised = $goal_amount > 0 ? min(100, round(($total_raised / $goal_amount) * 100)) : 0;
?>

                        <!-- Display the single combined progress bar -->
                        <div class="col-md-12 px-5">
                            <div class="raiser-bar">
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: <?php echo $percent_raised; ?>%;
                        background-color: <?php echo ($percent_raised < 30) ? '#dc3545' : (($percent_raised < 70) ? '#ffc107' : '#28a745'); ?>;"
                                        aria-valuenow="<?php echo $percent_raised; ?>" aria-valuemin="0"
                                        aria-valuemax="100">
                                        <?php echo $percent_raised; ?>%
                                    </div>
                                </div>
                            </div>

                            <div class="raised-money-data mt-2">
                                <p>
                                    <span>₹
                                        <?php echo format_in_indian_style($total_raised); ?>
                                    </span>
                                    <i>raised of ₹
                                        <?php echo format_in_indian_style($goal_amount); ?> goal
                                    </i>
                                </p>
                            </div>
                        </div>
               </div>
                   
                        <div class="program-inner-text">
                        <p>In several villages, women are still confined to Kurma Ghars - menstruation huts - during their monthly cycles. Such poorly maintained places to dwell lack washrooms, electricity, and hygiene. Worse, such living conditions end up making distressed women live in harmful and degrading environments. This does not put their health at risk alone. It also deprives them of dignity and respect.</p>   
                        <p>Sahyog Care has a vision to bring a better alternative to life. We aim to rebuild these Kurma Ghars into community halls, where women can live with dignity. In addition to safe shelter these areas will also offer skill-based training like sewing classes so that women can learn, earn, and take care of their families when they are staying.</p> 
                        <p>Sahyog Care has a vision to bring a better alternative to life. We aim to rebuild these Kurma Ghars into community halls, where women can live with dignity. In addition to safe shelter these areas will also offer skill-based training like sewing classes so that women can learn, earn, and take care of their families when they are staying.
</p>
                        </div>
                    </div>
                </div>
                
                
                                <div class="col-lg-4 col-md-6">
                    <div class="program-sidebar">
                        <div class="program-sidebar-head">
                            <h2>Donate Now</h2>
                        </div>
                        <p>Please select pre-defined amount or fill in custom amount.</p>
                        <form method="post" data-parsley-validate action="../generateCCHash.php">
                             <input type="hidden" name="source" value="kurma-ghars.php">
                            <div class="amount-option">
                                <button type="button" class="amount-btn-program" data-amount="3000">3000</button>
                                <button type="button" class="amount-btn-program" data-amount="6000">6000</button>
                                <button type="button" class="amount-btn-program" data-amount="10000">10000</button>
                            </div>
                        <input id="amountInput" name="amount" class="form-control program-input mt-3 mb-3" placeholder="Custom Amount" type="text" inputmode="numeric" data-parsley-type="digits" data-parsley-pattern-message="Please enter a valid Amount" data-parsley-required="true" autocomplete="off" oninput="if (this.value === '0') { this.value = ''; } else { this.value = this.value.replace(/\D/g, ''); }">

                            <input id="name" name="name" class="form-control program-input mb-3" placeholder="Name" type="text" required>

                            <input id="mobile" name="mobile" class="form-control program-input mb-3" placeholder="Mobile Number" inputmode="numeric" data-parsley-type="digits" type="text" maxlength="10" minlength="10" data-parsley-pattern-message="Please enter a valid Mobile Number" data-parsley-required="true" autocomplete="off" oninput="this.value = this.value.replace(/\D/g, '')">

                            <input id="email" name="email" class="form-control program-input mb-3" placeholder="Email" type="email" required>

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
        <div class="impact-img bottom">
            <img src="https://sahyogcare4u.org/images/torn.png" class="img-fluid w-100" alt="">
        </div>
    </div>



   

    <?php include("./includes/footer.php"); ?>
    <?php include("./includes/script.php"); ?>

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
