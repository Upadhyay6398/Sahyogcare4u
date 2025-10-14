<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css">
      <link rel="icon" href="images/favicons.png" type="image/x-icon">
        <?php include("./includes/top.php"); ?>
      <?php
    $slug = $_GET['slug'] ?? null;
    if ($slug) {
        $sql = "SELECT * FROM `albumb` WHERE `slug` = :slug AND `status` = '1'";
        $stmt = $DB->DB->prepare($sql);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        $subprogram = $stmt->fetch();

        if ($subprogram) {
            $subprogram_id = $subprogram['id'];

            // Fetch gallery images for the subprogram
            $program_sql = "SELECT * FROM `subprogram_gallery` WHERE `subprogram_id` = :subprogram_id";
            $program_stmt = $DB->DB->prepare($program_sql);
            $program_stmt->bindParam(':subprogram_id', $subprogram_id, PDO::PARAM_INT);
            $program_stmt->execute();
            $programs = $program_stmt->fetchAll();
        }
    }
    ?>
    <?php
    $category = null;
$program = null;

if ($subprogram) {
  
    $program_sql = "SELECT * FROM programs WHERE id = :program_id";
    $program_stmt = $DB->DB->prepare($program_sql);
    $program_stmt->bindParam(':program_id', $subprogram['subprogram_id'], PDO::PARAM_INT);
    $program_stmt->execute();
    $program = $program_stmt->fetch();

    if ($program) {
        // programs.subprogram_id is the category ID
        $category_sql = "SELECT * FROM category WHERE id = :category_id";
        $category_stmt = $DB->DB->prepare($category_sql);
        $category_stmt->bindParam(':category_id', $program['subprogram_id'], PDO::PARAM_INT);
        $category_stmt->execute();
        $category = $category_stmt->fetch();
       
    }
}
?>
        <title><?php echo $slug;?></title>
	
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
            $banner_image = $subprogram['image'];
            if (strpos($banner_image, 'uploads/') === false) {
                $banner_image = 'uploads/' . $banner_image; // Add 'uploads/' if not already included
            }
            ?>
            <img src="<?php echo $base_url . 'sahyogcare4u-admin/' . $banner_image; ?>" class="img-fluid w-100" alt="<?php echo $subprogram['image']; ?>">
            <div class="contact-banner-text">
                <h4><?php echo $subprogram['event_name']; ?></h4> <!-- Use subprograms for the title -->
            </div>
        </div>
    <?php } ?>
    <div class="ourgallery-page ptb70">
        <div class="container">
            <div class="row row-gap-4">

                <?php if (!empty($programs)) { ?>
                    <?php foreach ($programs as $program) { ?>
                        <div class="col-md-4">
                            <div class="event-pic">
                                <?php
                                $gallery_image = $program['image'];
                                if (strpos($gallery_image, 'uploads/') === false) {
                                    $gallery_image = 'uploads/' . $gallery_image;
                                }
                                ?>
                                <a href="<?php echo $base_url . 'sahyogcare4u-admin/' . $gallery_image; ?>" data-fancybox="images" data-caption="<?php echo htmlspecialchars($program['title']); ?>">
                                    <img src="<?php echo $base_url . 'sahyogcare4u-admin/' . $gallery_image; ?>" class="img-fluid w-100" alt="<?php echo htmlspecialchars($program['title']); ?>">
                                </a>
                                <p><?php echo htmlspecialchars(mb_strimwidth($program['title'], 0, 200, '...')); ?></p>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No gallery images available for this subprogram.</p>
                <?php } ?>

            </div>
        </div>
    </div>

    <?php include("./includes/footer.php"); ?>
    <?php include("./includes/script.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-fancybox="images"]').fancybox({
                caption: function(instance, item) {
                    var caption = $(this).data('caption') || '';
                    if (item.type === 'image') {
                        caption = (caption.length ? caption + '<br />' : '') + '';
                    }
                    return caption;
                }
            });
        });
    </script>
</body>

</html>
