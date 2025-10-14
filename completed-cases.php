<!DOCTYPE html>
<html lang="en">
	
<head>
<meta charset="UTF-8">
<meta content="width=device-width,initial-scale=1" name="viewport">
<title>Completed Cases | Sahyogcare4u</title>
  <link rel="icon" href="images/favicons.png" type="image/x-icon">
	
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-L3TTRSS3S1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-L3TTRSS3S1');
</script>
	
	<meta name="google-site-verification" content="3Sv1MRaMdCRJOeW7TPio056Ow61KrbJntx7BmiHg08Y"/>
	
<?php include("./includes/top.php")?>

<?php
$sql = "SELECT * FROM `resolvecase` WHERE `status` = '1'";
$stmt = $DB->DB->prepare($sql);
$stmt->execute();
$resolvecase = $stmt->fetchAll();
?>

<?php include("./includes/header.php")?>
	
	</head>
	<body>
<div class="contact-banner-sec">
    <img src="https://www.sahyogcare4u.org/images/contact-banner.jpg" class="img-fluid w-100" alt="">
    <div class="contact-banner-text">
        <h4>Completed Cases</h4>
    </div>
</div>

<div class="ptb70 news-sec">
    <div class="container">
        <h1 class="headdingg"></h1>
        <div class="row">
            <?php foreach($resolvecase as $resolvecases) { ?>
                <div class="col-md-4">
                    <div class="rcase">
                        <img src="sahyogcare4u-admin/<?php echo htmlspecialchars($resolvecases['resolvecaseimage']); ?>" alt="<?php echo htmlspecialchars($resolvecases['resolvecaseimage']); ?>" class="img-fluid" style="width:100%;object-fit:contain">
                        <div class="rtext">
                            <i class="cred">CASE RESOLVED</i>
                            <span></span>
                            <h5><?php echo $resolvecases['resolvecasename']; ?> (<?php echo $resolvecases['age']; ?>)</h5>
                            <p><?php echo $resolvecases['title']; ?></p>

                            <!-- Use data-* attributes to store dynamic content -->
                            <a class="cbtns" data-bs-toggle="modal" data-bs-target="#exampleModal" 
                               data-name="<?php echo $resolvecases['resolvecasename']; ?>"
                               data-description="<?php echo strip_tags($resolvecases['resolvecasedescription']); ?>">
                               Read More
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include("./includes/footer.php")?>
<?php include("./includes/script.php")?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:#fdd831 !important">
        <h5 class="modal-title" id="exampleModalLabel">Ashim (6 month male)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="modal-description"></p>
      </div>
    </div>
  </div>
</div>

<script>

$('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var name = button.data('name'); 
    var description = button.data('description'); 

    var modal = $(this);
    modal.find('.modal-title').text(name); 
    modal.find('#modal-description').text(description); description
});
</script>
</body>
</html>
