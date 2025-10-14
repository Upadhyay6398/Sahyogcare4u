<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("includes/top.php"); ?>
           <link rel="icon" href="https://www.sahyogcare4u.org/images/favicons.png" type="image/x-icon">
     <?php
    $slug = $_GET['slug'] ?? null;
    if ($slug) {
        // Fetch subprogram data
        $sql = "SELECT * FROM `programs` WHERE `slug` = :slug AND `status` = '1'";
        $stmt = $DB->DB->prepare($sql);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        $subprogram = $stmt->fetch();

        if ($subprogram) {
            $subprogram_id = $subprogram['id'];

            // Fetch subprogram timelines
            $program_sql = "SELECT * FROM `subprogram_timelines` WHERE `subprogram_id` = :subprogram_id";
            $program_stmt = $DB->DB->prepare($program_sql);
            $program_stmt->bindParam(':subprogram_id', $subprogram_id, PDO::PARAM_INT);
            $program_stmt->execute();
            $programs = $program_stmt->fetchAll();
        }
    }
    ?>
<title><?= !empty($subprogram['metatitle']) ? htmlspecialchars($subprogram['metatitle']) : 'Subprogram'; ?></title>
    <meta name="keywords" content="<?= !empty($subprogram['metakeyword']) ? htmlspecialchars($subprogram['metakeyword']) : ''; ?>">
    <meta name="description" content="<?= !empty($category['metadescription']) ? htmlspecialchars($subprogram['metadescription']) : ''; ?>">
	
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

   

    <?php if ($subprogram) { ?>
        <div class="contact-banner-sec">
            <?php
            // Ensure the banner image includes 'uploads/' if needed
            $banner_image = $subprogram['subprogrambanner'];
            if (strpos($banner_image, 'uploads/') === false) {
                $banner_image = 'uploads/' . $banner_image; // Add 'uploads/' if not already included
            }
            ?>
            <img src="<?php echo $base_url . 'sahyogcare4u-admin/' . $banner_image; ?>" class="img-fluid w-100" alt="<?php echo $subprogram['subprogramtitle']; ?>">
            <div class="contact-banner-text">
                <h4><?php echo $subprogram['subprogramtitle']; ?></h4>
            </div>
        </div>
    <?php } ?>



    <div class="impact-sec">
        <div class="impact-img top">
            <img src="https://sahyogcare4u.org/images/torn.png" class="img-fluid w-100" alt="">
        </div>
        <div class="container">
            <div class="row row-gap-5">
                <div class="col-lg-8 col-md-6">
                    <div class="program-content">
                        <?php
                        // Ensure the image includes 'uploads/' if needed
                        $subprogram_image = $subprogram['subprogramimage'];
                        if (strpos($subprogram_image, 'uploads/') === false) {
                            $subprogram_image = 'uploads/' . $subprogram_image;
                        }
                        ?>
                        <img src="<?php echo $base_url . 'sahyogcare4u-admin/' . $subprogram_image; ?>" class="img-fluid" alt="<?php echo $subprogram['subprogramtitle']; ?>">

                        <div class="program-inner-text">
                            <p><?php echo $subprogram['subprogramdescription']; ?></p>
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
                             <input type="hidden" name="source" value="<?php echo htmlspecialchars($subprogram['subprogramtitle']); ?>">
                            <input type="hidden" class="form-control" id="patient_id" name="patient_id" value="<?php echo htmlspecialchars($subprogram['id']); ?>">
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
                                <span class="secure-payments-icon">🔒</span> Your payments are secured with CCAvenue
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



    <?php if (!empty($programs)) { ?>
        <section id="unique-horizontal-timeline">
            <div class="unique-contain">
                <h2 class="unique-timeline-heading">PROGRAM TIMELINE</h2>
                <div class="unique-timeline">
                    <div class="unique-timeline-wrapper">
                        <?php foreach ($programs as $program) { ?>
                            <div class="unique-timeline-item">
                                <div class="unique-timeline-content">
                                    <?php
                                    // Ensure the timeline image includes 'uploads/' if needed
                                    $timeline_image = $program['image'];
                                    if (strpos($timeline_image, 'uploads/') === false) {
                                        $timeline_image = 'uploads/' . $timeline_image; // Add 'uploads/' if not already included
                                    }
                                    ?>
                                    <img src="<?php echo $base_url . 'sahyogcare4u-admin/' . $timeline_image; ?>" alt="<?php echo $program['title']; ?>" class="timeline-image">
                                    <h3><?php echo $program['title']; ?></h3>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

    <?php
    $sql = "SELECT * FROM `albumb` WHERE `subprogram_id` = :subprogram_id AND `status` = '1'";
    $stmt = $DB->DB->prepare($sql);
    $stmt->bindParam(':subprogram_id', $subprogram_id, PDO::PARAM_INT);
    $stmt->execute();
    $events = $stmt->fetchAll();
    ?>

    <?php if (!empty($events)) { ?>
        <section class="gallery-sec ptb50">
            <div class="container">
                <h1 class="gallery-title">GALLERY</h1>

                <div class="row mt-3">
                    <?php $count = 0; ?>
                    <?php foreach ($events as $event) { ?>
                        <?php if ($count >= 3) break; ?>
                        <?php
                        $gallery_sql = "SELECT * FROM `subprogram_gallery` WHERE `subprogram_id` = :subprogram_id LIMIT 1";
                        $gallery_stmt = $DB->DB->prepare($gallery_sql);
                        $gallery_stmt->bindParam(':subprogram_id', $event['id'], PDO::PARAM_INT);
                        $gallery_stmt->execute();
                        $gallery_image = $gallery_stmt->fetch();
                        ?>

                        <?php if ($gallery_image) { ?>
                            <div class="col-md-3">
                                <div class="program-box sub-program-box">
                                    <a href="<?php echo $base_url; ?>gallery-details/<?php echo $event['slug']; ?>">
                                        <?php
                                        $gallery_image_path = $gallery_image['image'];
                                        if (strpos($gallery_image_path, 'uploads/') === false) {
                                            $gallery_image_path = 'uploads/' . $gallery_image_path;
                                        }
                                        ?>
                                        <img src="<?php echo $base_url . 'sahyogcare4u-admin/' . $gallery_image_path; ?>" class="img-fluid" alt="<?php echo $event['event_name']; ?>" title="<?php echo $event['event_name']; ?>">
                                    </a>
                                    <div class="program-box-content">
                                   <a href="<?php echo $base_url; ?>gallery-details/<?php echo $event['slug']; ?>"> <h3><?php echo $event['event_name']; ?></h3></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php $count++; ?>
                    <?php } ?>

                    <?php if (count($events) > 3) { ?>
                
                    <div class="col-md-3">
           <a href="<?php echo $base_url; ?>gallery.php/<?php echo $event['id'];?>" class="btn see-more">
                        <span>See More</span>
                    </a>
                </div>
            <?php } ?>
                </div>
            </div>
        </section>
    <?php } ?>

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
