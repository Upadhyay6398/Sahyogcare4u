<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="images/favicons.png" type="image/x-icon">
    <?php include("./includes/top.php")?>
    
    <?php
    $slug = isset($_GET['slug']) ? $_GET['slug'] : null;
    $category = null;
    $programs = [];

   
    if ($slug) {
        $sql = "SELECT * FROM `category` WHERE `slug` = :slug AND `status` = '1'";
        $stmt = $DB->DB->prepare($sql);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        $category = $stmt->fetch();
       
        if ($category) {    
            $category_id = $category['id'];
            $program_sql = "SELECT * FROM `programs` WHERE `category_id` = :category_id AND `status` = '1'";
            $program_stmt = $DB->DB->prepare($program_sql);
            $program_stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $program_stmt->execute();
            $programs = $program_stmt->fetchAll();
        } else {
         
            header("HTTP/1.0 404 Not Found");
            echo '<script>window.location.href="index.php";</script>';
            exit;
        }
    }
    ?>

    <title><?= !empty($category['meta_title']) ? htmlspecialchars($category['meta_title']) : 'Programs'; ?></title>
    <meta name="keywords"
        content="<?= !empty($category['meta_keyword']) ? htmlspecialchars($category['meta_keyword']) : ''; ?>">
    <meta name="description"
        content="<?= !empty($category['meta_description']) ? htmlspecialchars($category['meta_description']) : ''; ?>">
    <link rel="canonical" href="https://sahyogcare4u.org/<?= htmlspecialchars($slug); ?>">
	
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

    <div class="hero-sec">
        <img src="sahyogcare4u-admin/<?php echo $category['image']; ?>" class="img-fluid w-100" alt="">
    </div>
    <div class="program-title">
        <h1><?php echo $category['name'] ?></h1>
    </div>

    <div class="impact-sec">
        <div class="impact-img top">
            <img src="images/torn.png" class="img-fluid w-100" alt="">
        </div>
        <div class="container">
            <div class="row row-gap-4">
                <div class="col-lg-8 col-md-6">
                    <div class="program-content">
                        <img src="sahyogcare4u-admin/<?php echo $category['middleimage']; ?>" class="img-fluid" alt="">
                        <div class="program-inner-text">
                            <p><?php echo $category['description']; ?></p>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 col-md-6">
                    <div class="program-sidebar">
                        <div class="program-sidebar-head">
                            <h2>Donate Now</h2>
                        </div>
                        <p class="pb-4">Please select pre-defined amount or fill in custom amount.</p>
                        <form method="post" data-parsley-validate action="generateCCHash.php">
                            <input type="hidden" name="source" value="<?php echo htmlspecialchars($category['name']); ?>">
                            <input type="hidden" class="form-control" id="patient_id" name="patient_id"
                                value="<?php echo htmlspecialchars($category['id']); ?>">
                                
                            <div class="amount-option">
                                <button type="button" class="amount-btn-program" data-amount="3000">3000</button>
                                <button type="button" class="amount-btn-program" data-amount="6000">6000</button>
                                <button type="button" class="amount-btn-program" data-amount="10000">10000</button>
                            </div>
                       <input id="amountInput" name="amount" class="form-control program-input mt-3 mb-3"
       placeholder="Custom Amount" type="text" inputmode="numeric" data-parsley-type="digits"
       data-parsley-pattern-message="Please enter a valid Amount" data-parsley-required="true"
       autocomplete="off" 
       oninput="if (this.value === '0') { this.value = ''; } else { this.value = this.value.replace(/\D/g, ''); }">


                            <input id="name" name="name" class="form-control program-input mb-3" placeholder="Name"
                                type="text" required>

                            <input id="mobile" name="mobile" class="form-control program-input mb-3"
                                placeholder="Mobile Number" inputmode="numeric" data-parsley-type="digits" type="text"
                                maxlength="10" minlength="10"
                                data-parsley-pattern-message="Please enter a valid Mobile Number"
                                data-parsley-required="true" autocomplete="off"
                                oninput="this.value = this.value.replace(/\D/g, '')">

                            <input id="email" name="email" class="form-control program-input mb-3" placeholder="Email"
                                type="email" required>

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
            <img src="images/torn.png" class="img-fluid w-100" alt="">
        </div>
    </div>

    <div class="program-list">
        <div class="container">
            <h2 class="heading11"><img src="images/heading-icon.png" alt=""> <span>OUR</span> INITIATIVES</h2>
            <div class="row mt-5 row-gap-4">
                <?php if (!empty($programs)): ?>
                    <?php foreach ($programs as $program): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="program-box">
                                <a  href="subprogram/<?php echo $program['slug']; ?>">
                                <img src="sahyogcare4u-admin/<?php echo htmlspecialchars($program['subprogramimage']); ?>"
                                    alt="<?php echo htmlspecialchars($program['subprogramtitle']); ?>">
                                    </a>
                                <div class="program-box-content">
                                   <a style="text-decoration:none;" href="subprogram/<?php echo $program['slug']; ?>">

                                    <h3><?php echo htmlspecialchars($program['subprogramtitle']); ?></h3>
                                    </a>
                                    <p>
                                        <?php
                                        $desc = $program['subprogramdescription'];
                                        $shortDesc = mb_substr($desc, 0, 150, 'UTF-8');
                                        echo (strlen($desc) > 150 ? $shortDesc . '...' : $desc);
                                        ?>
                                        <a class="read-more" href="subprogram/<?php echo $program['slug']; ?>">Learn More</a>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No programs found for this category.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include("./includes/footer.php") ?>
    <?php include("./includes/script.php") ?>

    <!-- JavaScript Validation & Amount Autofill -->
    <script>
        document.querySelectorAll('.amount-btn-program').forEach(function (button) {
            button.addEventListener('click', function () {
                var amount = this.getAttribute('data-amount');
                document.getElementById('amountInput').value = amount;
            });
        });
    </script>

</body>

</html>