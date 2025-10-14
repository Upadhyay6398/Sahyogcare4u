<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css'>
      <link rel="icon" href="images/favicons.png" type="image/x-icon">
    <?php include("./includes/top.php"); ?>
	
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

    <?php
    $slug = isset($_GET['slug']) ? $_GET['slug'] : null;
    $subprogram = null;
    $events = [];

    if ($slug) {
        // Get subprogram info
        $sql = "SELECT * FROM `programs` WHERE `slug` = :slug AND `status` = '1'";
        $stmt = $DB->DB->prepare($sql);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        $subprogram = $stmt->fetch();

        if ($subprogram) {
            $subprogram_id = $subprogram['id'];

            // Get related events
            $event_sql = "SELECT * FROM `albumb` WHERE `subprogram_id` = :subprogram_id AND `status` = '1'";
            $event_stmt = $DB->DB->prepare($event_sql);
            $event_stmt->bindParam(':subprogram_id', $subprogram_id, PDO::PARAM_INT);
            $event_stmt->execute();
            $events = $event_stmt->fetchAll();
        }
    }
    ?>

    <div class="inner-banner">
        <img src="<?php echo $base_url . 'images/gallery-banner.jpg'; ?>" alt="Gallery Banner" class="img-fluid">
        <div class="slider-data">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="slider-data-inner">
                            <h1><?php echo $subprogram ? htmlspecialchars($subprogram['subprogramtitle']) : 'Gallery'; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ourgallery-page ptb70">
        <div class="container">
            <div class="row">
                <?php
                if (!empty($events)) {
                    foreach ($events as $event) {
                        $gallery_sql = "SELECT * FROM `subprogram_gallery` WHERE `subprogram_id` = :event_id";
                        $gallery_stmt = $DB->DB->prepare($gallery_sql);
                        $gallery_stmt->bindParam(':event_id', $event['id'], PDO::PARAM_INT);
                        $gallery_stmt->execute();
                        $gallery_images = $gallery_stmt->fetchAll();

                        foreach ($gallery_images as $image) {
                            $imgPath = $image['image'];
                            if (strpos($imgPath, 'uploads/') === false) {
                                $imgPath = 'uploads/' . $imgPath;
                            }
                            ?>
                            <div class="col-md-4 mb-4">
                                <div class="event-pic">
                                    <a href="<?php echo $base_url . 'sahyogcare4u-admin/' . $imgPath; ?>" data-fancybox="images" data-caption="<?php echo htmlspecialchars($event['event_name']); ?>">
                                        <img src="<?php echo $base_url . 'sahyogcare4u-admin/' . $imgPath; ?>" class="img-fluid" alt="gallery" title="gallery">
                                    </a>
                                    <p><?php echo htmlspecialchars($event['event_name']); ?></p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                } else {
                    echo '<p>No gallery items found for this subprogram.</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <?php include("./includes/footer.php"); ?>
    <?php include("./includes/script.php"); ?>
    <script src='https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js'></script>
    <script>
        $('[data-fancybox="images"]').fancybox({
            caption: function (instance, item) {
                var caption = $(this).data('caption') || '';
                return caption;
            }
        });
    </script>
</body>

</html>
