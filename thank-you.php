<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
      <link rel="icon" href="images/favicons.png" type="image/x-icon">
    <?php include("./includes/top.php") ?>
	
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

    <div class="banner">
        <img src="images/donate-banner.jpg" class="img-fluid" alt="" style="height:250px;">
        <div class="slider-data">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="slider-data-inner inner-banner">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ptb70">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4 class="font-bold">Your payment has been successful!</h4>
                    <h5 class="mt-2">Please check your transaction details below.</h5>
                </div>

                <div class="col-lg-6 col-md-8 col-sm-12 m-auto mt-4">
                    <?php
                    if (isset($_SESSION['txn_id']) && isset($_SESSION['amount']) && isset($_SESSION['name'])) {
                        $txn_id = $_SESSION['txn_id'];
                        $amount = $_SESSION['amount'];
                        $name = $_SESSION['name'];

                        echo "
                        <table class='table table-bordered text-center'>
                            <tr><th>Name</th><td>$name</td></tr>
                            <tr><th>Transaction ID</th><td>$txn_id</td></tr>
                            <tr><th>Amount</th><td>₹$amount</td></tr>
                        </table>";

                        // Clear session data after displaying
                        unset($_SESSION['txn_id'], $_SESSION['amount'], $_SESSION['name']);
                    } else {
                        echo "<p>Payment details not found. Please contact support.</p>";
                    }
                    ?>
                   <?php if (isset($_SESSION['last_id'])): ?>
             <p>
                <center>
                <a href="receipt-form.php?id=<?= base64_encode($_SESSION['last_id']) ?>">
                <button class="btn btn-danger">Download Receipt</button>
            </a>
            </center>
            </p>
        <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>
    <?php include("includes/script.php"); ?>
</body>

</html>
