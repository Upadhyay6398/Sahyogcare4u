<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahyog Care for You - Leading change across the nation</title>
    <meta name="description" content="Sahyog Care For You is an NGO empowering children, women, youth, and armed forces across India. Join our mission to create lasting change donate online today.">
  <meta name="keywords" content="NGO for Child Labour rescue, child labour rehabilitation, ngo for women livelihood, ngo for child education, ngo for armed forces welfare">
  <link rel="shortcut icon" href="images/fav-icons.png" type="image/x-icon">
    <?php include("./includes/top.php")?>
 <style>
/* SECTION STYLING */
.featured-sec {
  padding: 80px 0;
  background-color: #fff;
}



.container {
  max-width: 1300px;
  margin: 0 auto;
  padding: 0 20px;
}


#posts {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
}


.featured-sec-box {
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.featured-sec-box:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
}


.featured-sec-box img.card-img {
  width: 100%;
  height: 220px;

}


.featured-sec-box-data {
  padding: 20px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.featured-sec-box-data h5 {
  font-size: 13px;
  text-transform: uppercase;
  color: #d62828;
  letter-spacing: 2px;
  margin-bottom: 6px;
}

.featured-sec-box-data .date {
  font-size: 16px;
  color: black;
  margin-bottom: 10px;
}

.featured-sec-box-data h4 {
  font-size: 18px;
  color: #222;
  font-weight: 600;
  margin-bottom: 14px;
  line-height: 1.4;
  min-height: 48px;
}

.featured-sec-box-data a {
  margin-top: auto;
  font-size: 14px;
  color: #d62828;
  font-weight: 500;
  text-decoration: none;
  transition: color 0.3s ease;
}

.featured-sec-box-data a:hover {
  color: #a31717;
}


.main-button-div {
  text-align: center;
  margin-top: 50px;
}

.btnn {
  padding: 12px 28px;
  background-color: green;

  color: #fff;
  text-decoration: none;
  border-radius: 20px;
  font-weight: 500;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

.btnn:hover {
  background-color: #a01717;
}

.btnn i {
  margin-left: 6px;
}
</style>



</head>

<body>
  <?php include("./includes/header.php"); ?>

<?php 
$sql = "SELECT * FROM slider WHERE status = 1 ORDER BY priority ASC";
$stmt = $DB->DB->prepare($sql);
$stmt->execute();
$slider = $stmt->fetchAll();

?>

<div class="hero-sec">
    <div class="swiper heroslide">
        <div class="swiper-wrapper">
            <?php foreach($slider as $sliders): ?>
                <div class="swiper-slide">
                    <img src="<?php echo $base_url .'sahyogcare4u-admin/'.$sliders['image']; ?>" class="img-fluid w-100" alt="">
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
       
    </div>
    
</div>

<div class="container">
     <div class="row">
     <div class="col-md-12">
    <div class="banner-sahyog mt-4">
    <a href="https://sahyogcare4u.org/urgent-attention.php">
    <img src="images/sahyog-banner.jpg" class="img-fluid desktop-block" alt="Banner Sahyog">
    <img src="images/sahyog-mobile.jpg" class="img-fluid mobile-block" alt="Banner Sahyog">
    </a>
    </div>
    </div>
    </div>
    </div>

    <div class="impact-sec">
        <div class="impact-img top">
            <img src="images/torn.png" class="img-fluid w-100" alt="">
        </div>
        <div class="container">
            <div class="row row-reverse-sm">
                <div class="col-md-6">
                    <div class="impact-text">
                        <h2>OUR IMPACT</h2>
                    <p>Sahyog Care for You, a non-profit organisation, has been committed to the social sector for more than 20 years. Sahyog Care for You is involved in various sectors, all working towards making a positive difference in society. Ranging from child development and education to women empowerment, armed forces skill development, and child rescue and rehabilitation, these initiatives exemplify a commitment to holistic social progress.</p>
                    <a href="about-us.php" class="sahyog-learn-more-btn">Learn More</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <video src="images/header.mp4" autoplay="" loop="" muted="" style="width: 100%; border-radius: 10px;"></video>
                </div>
            </div>
            <div class="row mt-4 row-gap-4">
                <div class="col-lg-2 col-md-4">
                    <div class="impact-small-box">
                        <img src="images/jawan.jpg" class="img-fluid" alt="">
                        <h3>Jawans</h3>
                        <h4>17,693 +</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="impact-small-box">
                        <img src="images/families.jpg" class="img-fluid" alt="">
                        <h3>Families</h3>
                        <h4>18,14,013 +</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="impact-small-box">
                        <img src="images/childrens.jpg" class="img-fluid" alt="">
                        <h3>Children</h3>
                        <h4>8,03,725 +</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="impact-small-box">
                        <img src="images/youth.jpg" class="img-fluid" alt="">
                        <h3>Youth</h3>
                        <h4>35,165 +</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="impact-small-box">
                        <img src="images/women.jpg" class="img-fluid" alt="">
                        <h3>Women</h3>
                        <h4>1,53,400 +</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="impact-small-box">
                        <img src="images/trees-planted.jpg" class="img-fluid" alt="">
                        <h3>Trees Planted</h3>
                        <h4>1,74,111 +</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="impact-img bottom">
            <img src="images/torn.png" class="img-fluid w-100" alt="">
        </div>
    </div>

    <div class="news-sec pt70">
        <div class="container">
            <h2 class="heading11"><img src="images/heading-icon.png" alt=""> <span>NEWS </span> BOARD</h2>
            <div class="row row-gap-3 mt-4">
                        <div class="bulletin-board"><div class="cork-texture"></div>
                        <div class="clipping" style="width: 170.794px; height: 161.4px; left: 398.368px; top: 54.3342px; transform: rotate(-11deg);">
                            <div class="pin"></div><img src="https://sahyogcare4u.org/images/child-labour-news-1.jpg" alt="Clipping 1" style="width: 100%; height: 100%; object-fit: contain;"></div><div class="clipping" style="width: 170.794px; height: 161.4px; left: 571.409px; top: 0px; transform: rotate(-6deg);"><div class="pin"></div><img src="https://sahyogcare4u.org/images/child-labour-news-2.jpg" alt="Clipping 2" style="width: 100%; height: 100%; object-fit: contain;"></div><div class="clipping" style="width: 102.411px; height: 161.4px; left: 0px; top: 107.6px; transform: rotate(-13deg);"><div class="pin"></div><img src="https://sahyogcare4u.org/images/child-labour-news-3.jpg" alt="Clipping 3" style="width: 100%; height: 100%; object-fit: contain;"></div><div class="clipping" style="width: 90.8784px; height: 161.4px; left: 442.938px; top: 0px; transform: rotate(-3deg);"><div class="pin"></div><img src="https://sahyogcare4u.org/images/child-labour-news-4.jpg" alt="Clipping 4" style="width: 100%; height: 100%; object-fit: contain;"></div><div class="clipping" style="width: 285px; height: 111.557px; left: 152.054px; top: 0px; transform: rotate(11deg);"><div class="pin"></div><img src="https://sahyogcare4u.org/images/child-labour-news-5.jpg" alt="Clipping 5" style="width: 100%; height: 100%; object-fit: contain;"></div><div class="clipping" style="width: 74.0367px; height: 161.4px; left: 0px; top: 0px; transform: rotate(3deg);"><div class="pin"></div><img src="https://sahyogcare4u.org/images/child-labour-news-6.jpg" alt="Clipping 6" style="width: 100%; height: 100%; object-fit: contain;"></div><div class="clipping" style="width: 161.4px; height: 161.4px; left: 0px; top: 50.5558px; transform: rotate(-12deg);"><div class="pin"></div><img src="https://sahyogcare4u.org/images/child-labour-news-7.jpg" alt="Clipping 7" style="width: 100%; height: 100%; object-fit: contain;"></div><div class="clipping" style="width: 164.694px; height: 161.4px; left: 595.306px; top: 36.9624px; transform: rotate(-11deg);"><div class="pin"></div><img src="https://sahyogcare4u.org/images/child-labour-news-8.jpg" alt="Clipping 8" style="width: 100%; height: 100%; object-fit: contain;"></div><div class="clipping" style="width: 240.896px; height: 161.4px; left: 143.57px; top: 48.5916px; transform: rotate(8deg);"><div class="pin"></div><img src="https://sahyogcare4u.org/images/child-labour-news-9.jpg" alt="Clipping 9" style="width: 100%; height: 100%; object-fit: contain;"></div><div class="clipping" style="width: 161.4px; height: 161.4px; left: 187.018px; top: 107.6px; transform: rotate(-15deg);"><div class="pin"></div><img src="https://sahyogcare4u.org/images/child-labour-news-10.jpg" alt="Clipping 10" style="width: 100%; height: 100%; object-fit: contain;"></div></div>
                       </div>
        </div>
    </div>

<div class="featured-sec ptb70 mt70">
    <div class="container">
        <h2 class="heading11">
            <img src="images/heading-icon.png" alt=""> OUR FEATURED PROGRAMS
        </h2>
        <?php
        $sql = "SELECT * FROM `category` WHERE `status` = '1' AND `show_home_page`='1'";
        $stmt = $DB->DB->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="row pt50 justify-content-center row-gap-4">
            <?php foreach ($categories as $category) { ?>
                <div class="col-lg-3 col-md-4">
                    <div class="featured-box">
                        <a href="<?php echo htmlspecialchars($category['slug']); ?>" style="text-decoration: none;">
                            <img src="sahyogcare4u-admin/<?php echo htmlspecialchars($category['middleimage']); ?>" class="img-fluid w-100" alt="<?php echo htmlspecialchars($category['name']); ?>">
                            <div class="featured-box-text">
                                <h4><?php echo htmlspecialchars($category['name']); ?></h4>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>



    <?php
// Format number in Indian style
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

// Dynamic fundraisers list
$fundraisers = [
    [
        'slug' => 'education-for-all-fundcase.php',
        'title' => 'Education for all',
        'description' => 'Sahyog care for you aims to be improving the education...',
        'image' => 'images/child-eduation-home.webp',
        'base_amount' => 55060,
        'goal_amount' => 300000
    ],
    [
        'slug' => 'sanitary-napkin-fundcase.php',
        'title' => 'Sanitary Napkin',
        'description' => 'The price of poor menstrual hygiene can be devastating...',
        'image' => 'images/sanitary-home.png',
        'base_amount' => 120893,
        'goal_amount' => 800000
    ],
    [
        'slug' => 'old-age-home-fundcase.php',
        'title' => 'Old Age Home',
        'description' => 'A roof over their heads is a critical need of the elderly...',
        'image' => 'images/oldage-home.webp',
        'base_amount' => 35703,
        'goal_amount' => 225000
    ]
];
?>

<div class="fundraiser-sec ptb70">
    <div class="container">
        <h2 class="heading11"><img src="images/heading-icon.png" alt=""> <span>Our</span> Active Fundraisers</h2>
        <div class="row mt-4 row-gap-4 justify-content-center">

         
            <div class="col-md-6">
                <div class="fundraiser-box">
                    <div class="fundraiser-img">
                        <img src="images/trafficking-home.webp" alt="">
                    </div>
                    <div class="fundraiser-text">
                        <h4>Child Trafficking and Child Labor</h4>
                        <p>Child labour and bonded labour are critical human rights issues that rob children of their childhood, education, and dignity, often forcing them into hazardous working conditions.</p>
                        <a href="child-labour2.php" class="btn btn-donate">Donate Now</a>
                    </div>
                </div>
            </div>

           
            <?php foreach ($fundraisers as $fund): 
                $slug = $fund['slug'];
                $base_amount = $fund['base_amount'];
                $goal_amount = $fund['goal_amount'];

                try {
                    $stmt = $DB->DB->prepare("SELECT SUM(amount) as total_raised FROM payments WHERE `source` = :slug AND payment_status = 'success'");
                    $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
                    $stmt->execute();
                    $db_raised = $stmt->fetch(PDO::FETCH_ASSOC)['total_raised'] ?? 0;
                } catch (PDOException $e) {
                    $db_raised = 0;
                }

                $total_raised = $base_amount + $db_raised;
                $percent_raised = $goal_amount > 0 ? min(100, round(($total_raised / $goal_amount) * 100)) : 0;
                $progress_color = ($percent_raised < 30) ? '#dc3545' : (($percent_raised < 70) ? '#ffc107' : '#28a745');
            ?>
            <div class="col-md-6">
                <div class="fundraiser-box">
                    <div class="fundraiser-img">
                        <img src="<?php echo $fund['image']; ?>" alt="">
                    </div>
                    <div class="fundraiser-text">
                        <h4><?php echo $fund['title']; ?></h4>
                        <p><?php echo $fund['description']; ?></p>

                        <div class="raiser-bar">
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar" role="progressbar"
                                     style="width: <?php echo $percent_raised; ?>%; background-color: <?php echo $progress_color; ?>;"
                                     aria-valuenow="<?php echo $percent_raised; ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo $percent_raised; ?>%
                                </div>
                            </div>
                        </div>

                        <div class="raised-info mt-2">
                            <span><?php echo $percent_raised; ?>%</span>
                            <p>₹<?php echo format_in_indian_style($total_raised); ?> raised of ₹<?php echo format_in_indian_style($goal_amount); ?> goal</p>
                        </div>

                        <a href="<?php echo $slug; ?>" class="btn btn-donate">Donate Now</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="featured-sec">
          
  <div class="container">
      <h2 class="heading11 mb-4"><img src="images/heading-icon.png" alt=""> <span>Our</span> Latest Blogs</h2>
    <div class="row" id="posts"></div>

    <div class="main-button-div">
       
      <a href="https://www.sahyogcare4u.org/blog/" class="btnn">
        View all blogs <i class="fa-regular fa-arrow-right-long"></i>
      </a>
    </div>
  </div>
</div>

    <div class="awards-sec ">
        <div class="container">
            <h2 class="heading11"><img src="images/heading-icon.png" alt=""> <span>Our</span> Awards and Achievements</h2>
            <div class="carousel-container-custom">
                <div class="carousel-custom">
                    <div class="carousel-item-custom carousel-item-active" id="carousel-slide1">
                        <img src="images/award-1.jpg" alt="sahyogcare4u Award 01">
                    </div>
                    <div class="carousel-item-custom" id="carousel-slide2">
                        <img src="images/award-2.jpg" alt="sahyogcare4u Award 02">
                    </div>
                    <div class="carousel-item-custom" id="carousel-slide3">
                        <img src="images/award-3.jpg" alt="sahyogcare4u Award 03">
                    </div>
                                 <div class="carousel-item-custom" id="carousel-slide5">
                        <img src="images/award-7.jpg" alt="sahyogcare4u Award 04">
                    </div>
                    <div class="carousel-item-custom" id="carousel-slide6">
                        <img src="images/awards-1.jpg" alt="sahyogcare4u Award 05">
                    </div>
                    <div class="carousel-item-custom" id="carousel-slide7">
                        <img src="images/awards-2.jpg" alt="sahyogcare4u Award 06">
                    </div>
                </div>

                <button class="arrow-button arrow-prev" onclick="prevSlide()">&#10094;</button>
                <button class="arrow-button arrow-next" onclick="nextSlide()">&#10095;</button>

                <div class="carousel-dots-custom">
                    <span class="dot-custom" onclick="goToSlide(0)"></span>
                    <span class="dot-custom" onclick="goToSlide(1)"></span>
                    <span class="dot-custom" onclick="goToSlide(2)"></span>
                    <span class="dot-custom" onclick="goToSlide(3)"></span>
                    <span class="dot-custom" onclick="goToSlide(4)"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="impact-sec test-sec">
        <div class="impact-img top">
            <img src="images/torn.png" class="img-fluid w-100" alt="">
        </div>
        <div class="container">
            <div class="test-inner ptb50">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="test-head">
                            <h2>
                                Feedback From Our Partners and Donors
                               </h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="swiper test-swiper">
                            <div class="swiper-wrapper">
                              
                              <div class="swiper-slide">
                                <div class="test-box">
                                    <img src="images/test-1.jpg" alt="">
                                    <h5>Colnel Mukesh Kumar Tiwari</h5>
                                    <span>Director - army welfare organisation</span>
                                    <p>Sahyog Care For You recently conducted a Solar PV Installer Program at AWPO, Bhopal. The event was...</p>
                                </div>
                              </div>
                              <div class="swiper-slide">
                                <div class="test-box">
                                    <img src="images/test-2.jpg" alt="">
                                    <h5>Gurvinder Singh</h5>
                                    <span>Director AWPO</span>
                                    <p>I would like to thank Sahyog Care For You for such a meaningful initiative!
                                        Logistics and supply...</p>
                                </div>
                              </div>
                              <div class="swiper-slide">
                                <div class="test-box">
                                    <img src="images/test-3.jpg" alt="">
                                    <h5>Rahul Kumar</h5>
                                    <span>Donor</span>
                                    <p>Sahyog is doing such wonderful work with feeding the needy. I make a donation every month happy to see...</p>
                                </div>
                              </div>
                              <div class="swiper-slide">
                                <div class="test-box">
                                    <img src="images/test-3.jpg" alt="">
                                    <h5>Prakash Raj</h5>
                                    <span>Donor</span>
                                    <p>Thank you Sahyog for such a great initiative. Their ideology of accepting contributions at the lowest...</p>
                                </div>
                              </div>
                              <div class="swiper-slide">
                                <div class="test-box">
                                    <img src="images/test-4.jpeg" alt="">
                                    <h5>Anil Chaudhary</h5>
                                    <span>International Cricket Umpire, Donor</span>
                                    <p>Hi, I'm Anil Chaudhary, International Cricket Umpire, Requesting you all to support Sahyog care for you...</p>
                                </div>
                              </div>
                              <div class="swiper-slide">
                                <div class="test-box">
                                    <img src="images/test-3.jpg" alt="">
                                    <h5>Sam Khan</h5>
                                    <span>Donor</span>
                                    <p>Hello Everyone! My name is Sam Khan. I've been with the Sahyog care team for over 1 year. I feel...</p>
                                </div>
                              </div>
                              <div class="swiper-slide">
                                <div class="test-box">
                                    <img src="images/test-3.jpg" alt="">
                                    <h5>Mr. Abhay Deep Dubey</h5>
                                    <span>Donor</span>
                                    <p>Hi, My name is Mr Abhay Deep Dubey. We have been associated with Sahyog care for a very long time. Even...</p>
                                </div>
                              </div>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                          </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="impact-img bottom">
            <img src="images/torn.png" class="img-fluid w-100" alt="">
        </div>
    </div>

    <div class="partner-sec ptb70">
        <div class="container">
            <h2 class="heading11"><img src="images/heading-icon.png" alt=""> <span>Our</span> Partners</h2>
            <div class="swiper partner-swipe">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-1.jpeg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-2.jpeg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-3.jpeg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-4.png" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-5.jpeg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-6.jpeg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-7.png" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-8.png" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-9.jpeg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-10.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-11.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-12.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-13.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-14.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-15.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-16.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-17.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-18.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-19.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-20.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-21.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-22.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-23.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-24.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-25.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-26.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-27.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-28.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-29.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-30.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-31.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-32.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-33.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-34.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-35.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-36.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-37.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-38.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-39.png" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-40.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-41.jpeg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-42.jpg" alt=""></div>
                  </div>
                  <div class="swiper-slide">
                    <div class="part-item"><img src="images/partner-43.png" alt=""></div>
                  </div>
                </div>
              </div>
        </div>
    </div>

   <script async src="https://www.googletagmanager.com/gtag/js?id=G-L3TTRSS3S1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-L3TTRSS3S1');
</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CTFFDTQD9E"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-CTFFDTQD9E');
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/interact.js/1.10.11/interact.min.js"></script>
        <script>
            const clippings = [
                'https://sahyogcare4u.org/images/child-labour-news-1.jpg',
                'https://sahyogcare4u.org/images/child-labour-news-2.jpg',
                'https://sahyogcare4u.org/images/child-labour-news-3.jpg',
                'https://sahyogcare4u.org/images/child-labour-news-4.jpg',
                'https://sahyogcare4u.org/images/child-labour-news-5.jpg',
                'https://sahyogcare4u.org/images/child-labour-news-6.jpg',
                'https://sahyogcare4u.org/images/child-labour-news-7.jpg',
                'https://sahyogcare4u.org/images/child-labour-news-8.jpg',
                'https://sahyogcare4u.org/images/child-labour-news-9.jpg',
                'https://sahyogcare4u.org/images/child-labour-news-10.jpg',
            ];

            let highestZIndex = 1;

            function positionClippings() {
                const board = document.querySelector('.bulletin-board');
                board.innerHTML = '<div class="cork-texture"></div>'; // Clear existing clippings

                const boardWidth = board.clientWidth;
                const boardHeight = board.clientHeight;

                const positions = generatePositions(boardWidth, boardHeight, clippings.length);

                clippings.forEach((src, index) => {
                    const img = new Image();
                    img.src = src;
                    img.alt = `Clipping ${index + 1}`;

                    img.onload = function() {
                        const div = document.createElement('div');
                        div.className = 'clipping';

                        const pin = document.createElement('div');
                        pin.className = 'pin';
                        div.appendChild(pin);

                        const aspectRatio = img.naturalWidth / img.naturalHeight;
                        const zoomFactor = 1.5; // Adjust this value to control zoom level

                        let width = boardWidth * 0.25 * zoomFactor; // Base width as 25% of board width, then zoomed
                        let height = width / aspectRatio;

                        // Adjust size if height is too large
                        if (height > boardHeight * 0.6) {
                            height = boardHeight * 0.6;
                            width = height * aspectRatio;
                        }

                        div.style.width = `${width}px`;
                        div.style.height = `${height}px`;

                        img.style.width = '100%';
                        img.style.height = '100%';
                        img.style.objectFit = 'contain';

                        div.appendChild(img);

                        const {
                            x,
                            y
                        } = positions[index];

                        // Ensure the clipping stays within the board boundaries
                        const leftPosition = Math.max(0, Math.min(x - width / 4, boardWidth - width));
                        const topPosition = Math.max(0, Math.min(y - height / 4, boardHeight - height));

                        div.style.left = `${leftPosition}px`;
                        div.style.top = `${topPosition}px`;
                        div.style.transform = `rotate(${Math.floor(Math.random() * 30 - 15)}deg)`;

                        board.appendChild(div);
                        setupInteractions(div);
                    };
                });
            }

            function generatePositions(boardWidth, boardHeight, count) {
                const gridSize = Math.ceil(Math.sqrt(count * 1.5)); // Increase grid size for better distribution
                const cellWidth = boardWidth / gridSize;
                const cellHeight = boardHeight / gridSize;

                const positions = [];
                for (let i = 0; i < count; i++) {
                    const row = Math.floor(i / gridSize);
                    const col = i % gridSize;

                    const x = col * cellWidth + Math.random() * (cellWidth * 0.5);
                    const y = (row * cellHeight + Math.random() * (cellHeight * 0.5));

                    positions.push({
                        x,
                        y
                    });
                }

                return positions.sort(() => Math.random() - 0.5);
            }

            function setupInteractions(clipping) {
                clipping.addEventListener('mousedown', bringToFront);
                clipping.addEventListener('touchstart', bringToFront);

                interact(clipping).draggable({
                    inertia: true,
                    modifiers: [
                        interact.modifiers.restrictRect({
                            restriction: 'parent',
                            endOnly: true
                        })
                    ],
                    listeners: {
                        move: dragMoveListener,
                    }
                });
            }

            function bringToFront(event) {
                highestZIndex++;
                this.style.zIndex = highestZIndex;
            }

            function dragMoveListener(event) {
                const target = event.target;
                const x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                const y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                target.style.transform = `translate(${x}px, ${y}px) rotate(${getRotation(target)}deg)`;

                target.setAttribute('data-x', x);
                target.setAttribute('data-y', y);
            }

            function getRotation(el) {
                const st = window.getComputedStyle(el, null);
                const tm = st.getPropertyValue("-webkit-transform") ||
                    st.getPropertyValue("-moz-transform") ||
                    st.getPropertyValue("-ms-transform") ||
                    st.getPropertyValue("-o-transform") ||
                    st.getPropertyValue("transform");
                if (tm !== "none") {
                    const values = tm.split('(')[1].split(')')[0].split(',');
                    const angle = Math.round(Math.atan2(values[1], values[0]) * (180 / Math.PI));
                    return (angle < 0 ? angle + 360 : angle);
                }
                return 0;
            }

            document.addEventListener('DOMContentLoaded', positionClippings);
            window.addEventListener('resize', positionClippings);
        </script>
        

    <?php include("./includes/footer.php")?>
    <?php include("./includes/script.php")?>
     

<script>
function blogContent() {
  fetch('https://sahyogcare4u.org/blog/wp-json/wp/v2/posts?_embed&per_page=6')
    .then(response => response.json())
    .then(data => {
      const postsContainer = document.getElementById('posts');
      postsContainer.innerHTML = '';

      let count = 0;
      for (const post of data) {
        // Check if image exists
        if (!(post._embedded && post._embedded['wp:featuredmedia'])) continue;

        const image = post._embedded['wp:featuredmedia'][0].source_url;
        const dateObj = new Date(post.date);
        const options = { day: '2-digit', month: 'long', year: 'numeric' };
        const formattedDate = dateObj.toLocaleDateString('en-GB', options);

        // Create card element
        const postElement = document.createElement('div');
        postElement.classList.add('featured-sec-box');

        postElement.innerHTML = `
          <img src="${image}" class="card-img" alt="${post.title.rendered}">
          <div class="featured-sec-box-data">
            <h5>Article</h5>
            <span class="date">${formattedDate}</span>
            <h4>${post.title.rendered}</h4>
            <a href="${post.link}" target="_blank">Read More <i class="fa fa-chevron-right"></i></a>
          </div>
        `;

        postsContainer.appendChild(postElement);

        count++;
        if (count === 3) break; // Show only 3 with images
      }

      if (count === 0) {
        postsContainer.innerHTML = "<p>No blog posts with images were found.</p>";
      }
    })
    .catch(error => {
      console.error('Error fetching blog posts:', error);
      document.getElementById('posts').innerHTML = "<p>Blog posts fetch nahi ho paaye. Kripya later try karein.</p>";
    });
}

blogContent();
</script>

</body>

</html>