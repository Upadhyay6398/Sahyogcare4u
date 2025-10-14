<?php
session_start();
include('config.php');

$id = 0;
if (isset($_GET['id'])) {
    $id = intval(base64_decode($_GET['id']));
}

if ($id <= 0) {
    header('Location: payment-failed.php');
    exit;
}

try {
    $stmt = $DB->DB->prepare("SELECT * FROM payments WHERE id = ?");
    $stmt->execute([$id]);
    $rs = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$rs) {
        header('Location: payment-success.php');
        exit;
    }

    $data['details'] = json_decode($rs['details'], true);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Donation Receipt | Sahyog Care for You</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        font-family: 'Georgia', serif;
        background: #fff;
        padding: 30px;
        color: #000;
    }

    .receipt-box {
        max-width: 800px;
        margin: auto;
        border: 1px solid #000;
        padding: 30px;
        font-size: 16px;
        line-height: 24px;
    }

    .receipt-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .receipt-box table td {
        padding: 8px;
        vertical-align: top;
    }

    .receipt-box table tr.heading td {
        font-weight: bold;
        border-bottom: 1px solid #000;
    }

    .receipt-box .title {
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }

    .info-label {
        font-weight: bold;
    }

    .amount-box {
        border: 1px solid #000;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
    }

    @media print {
        body {
            zoom: 95%;
        }
        .no-print {
            display: none;
        }
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

<div class="receipt-box">
    <div class="text-center">
        <img src="https://www.sahyogcare4u.org/images/logo.png" style="max-width: 150px;" alt="logo">
        <div class="title">Sahyog Care for You</div>
        <p>
            <strong>Society working for the upliftment of children & women</strong><br>
            All Donations are Exempted U/S 80G (5)(VI) of IT Act 1961<br>
            Regd. Office: 22, Basement, Bhera Enclave, Paschim Vihar, New Delhi - 110087<br>
            Phone: 25264149 | Email: sahyog.careforyou@gmail.com<br>
            Website: www.sahyogcare4u.org
        </p>
    </div>

    <table>
        <tr class="heading">
            <td>Receipt Details</td>
            <td></td>
        </tr>
        <tr>
            <td><span class="info-label">Receipt No:</span> <?= htmlspecialchars($rs['id']) ?></td>
            <td><span class="info-label">Date:</span> <?= date("d M Y", strtotime($rs['tstp'])) ?></td>
        </tr>
        <tr>
            <td colspan="2"><span class="info-label">Received from:</span> <?= htmlspecialchars($rs['name']) ?></td>
        </tr>
        <tr>
            <td colspan="2"><span class="info-label">Email:</span> <?= htmlspecialchars($rs['email']) ?></td>
        </tr>
        <tr>
            <td colspan="2"><span class="info-label">Mobile No:</span> <?= htmlspecialchars($rs['mobile']) ?></td>
        </tr>
        <tr>
            <td colspan="2"><span class="info-label">Address:</span> <?= htmlspecialchars($rs['address']) ?></td>
        </tr>
        <tr>
            <td colspan="2"><span class="info-label">Transaction ID:</span> <?= htmlspecialchars($rs['order_id']) ?></td>
        </tr>
        <tr>
            <td colspan="2"><span class="info-label">Payment Mode:</span> <?= htmlspecialchars($rs['payment_mode']) ?></td>
        </tr>
        <tr>
            <td colspan="2"><span class="info-label">Donation Amount (in words):</span> <?= htmlspecialchars($rs['amount']) ?> INR</td>
        </tr>
    </table>

    <div class="amount-box">
        TOTAL DONATION RECEIVED: ₹<?= number_format($rs['amount'], 2) ?>
    </div>

    <div class="text-end mt-5" style="margin-top: 50px;">
        <p><strong>Authorized Signature</strong></p>
        <p>_________________________</p>
    </div>
</div>

<script>
    window.onload = function () {
        window.print();
    };
</script>

</body>
</html>

<?php unset($_SESSION['last_id']); ?>
