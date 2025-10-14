<!doctypehtml><html lang="en"><meta charset="UTF-8"><meta content="width=device-width,initial-scale=1"name="viewport"><title>Account Inormation</title>
  <link rel="icon" href="images/favicons.png" type="image/x-icon">
<?php include("./includes/top.php")?><?php include("./includes/header.php")?><?php
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : null;

if (!empty($slug)) {
    try {
        $sql = "SELECT * FROM `emergencycase` WHERE `slug` = :slug AND `status` = '1'";
        $stmt = $DB->DB->prepare($sql);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        $emergencycase = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array
    } catch (PDOException $e) {
        echo "Database error: " . htmlspecialchars($e->getMessage());
    }
}
?><section class="account-info-sec"><div class="container"><div class="row justify-content-center"><div class="col-md-10"><div class="row"><div class="col-md-6"><div class="bankd"><h4>SAHYOG CARE FOR YOU</h4><p>A/c no - 24010067539570<p>Axis Bank Ltd.<p>Meera Bagh<p>IFSC-UTIB0000533</div><div class="bankd"><h4><?php echo $emergencycase['name'];?></h4><p>A/c no -<?php echo $emergencycase['accountno'];?><p>IFSC:-<?php echo $emergencycase['ifsc'];?><p><?php echo $emergencycase['ifsc_understand'];?><p><?php echo $emergencycase['bankname'];?><p><?php echo $emergencycase['branch'];?></div></div><div class="col-md-6 align-items-center d-flex"><div class="acc-qr"><img alt="Donation QR Code"class="img-fluid"src="<?php echo $base_url.'images/sahyogcare4u-qr.jpeg'?>"style="height:510px"></div></div></div></div></div></div></section><?php include("./includes/footer.php")?><?php include("./includes/script.php")?>