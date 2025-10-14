<?php include('config.php');?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Banarsidas Chandiwala Institute of Medical Sciences -Chandiwala Hospital</title>
    <?php include "includes/top-css.php"; ?>
    <style>
        .company-timing{ position: relative; margin: 20px 0; bottom: 0; animation: none}
        .about-img-1 img {aspect-ratio: auto;
                object-fit:contain;}
    </style>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <div class="slider-sec home">
        <div id="carouselExampleFade" class="carousel slide carousel-fade">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/slider01.jpg" class="d-block w-100" alt="Chandi Wala Hospital">
                    <div class="slider-data">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="slider-data-inner">
                                        <p><img src="images/icon-sub-heading.svg"> Your health our priority</p>
                                        <h3> 
                                    Excellence in Every Specialty, <br>
                                    Care in Every Step.</h3>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/slider02.jpg" class="d-block w-100 effectt" alt="Chandi Wala Hospital">
                    <div class="slider-data">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">

                                    <p><img src="images/icon-sub-heading.svg"> Your health our priority</p>
                                    <h3> 
                                    Excellence in Every Specialty, <br>
                                    Care in Every Step.
                                 </h3>                      
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/slider03.jpg" class="d-block w-100" alt="Chandi Wala Hospital">
                    <div class="slider-data">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="slider-data-inner">
                                        <p><img src="images/icon-sub-heading.svg"> Your health our priority</p>
                                        <h3> 
                                    Excellence in Every Specialty, <br>
                                    Care in Every Step.
                                 </h3>
                               </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
        
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>        
        </div>
    </div>
    <div class="about-us mt100">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="about-us-content headding11-left">
                        <h1 class="headding11"> Welcome to <span>BCIMS </span>
                        <span class="line"></span>
                     </h1>
                        <p>A multi-specialty hospital located in a lush green environment. Started as an eye hospital in 1995 and a multi-specialty hospital in 2001. BCIMS is well equipped & has state of art eye department.</p>
                    </div>
                    <div class="about-us-body">
                        <div class="about-info-item">
                            <div class="icon-box">
                                <i class="fa-regular fa-house-medical"></i>
                            </div>
                            <div class="about-info-item-content">
                                <h3>WORLD CLASS FACILITIES</h3>
                            </div>
                        </div>
                        <div class="about-info-item">
                            <div class="icon-box">
                                <i class="fa-solid fa-user-doctor-hair"></i>
                            </div>
                            <div class="about-info-item-content">
                                <h3>EXPERT DOCTORS</h3>
                            </div>
                        </div>
                        <div class="about-info-item">
                            <div class="icon-box">
                                <i class="fa-solid fa-heart-pulse"></i>
                            </div>
                            <div class="about-info-item-content">
                                <h3>OPERATION THEATERS</h3>
                            </div>
                        </div>
                    </div>
                    <div class="company-timing">
                            <h3>Working Hours</h3>
                            <ul>
                                <li><span>Timings : </span> Monday - Saturday</li>
                                <li><span>Eye Care :</span> 09 AM to 05 PM</li>
                                <li><span>Other OPDs :</span> 09 AM to 01 PM</li>
                                <li><span>Ward :</span> 24 hours Monday - Sunday</li>
                            </ul>
                            <figure>
                                <i class="fa-solid fa-clock"></i>
                            </figure>
                        </div>
                    <div class="about-us-btn">
                        <a href="about-us.php" class="btn-default">View More </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">                     
                        <div class="about-img-1">
                            <figure class="image-anime  none1299">
                                <img src="images/collage-doctor.jpg" alt="chandiwala hospital doctors" class="w-100">
                            </figure>         
                         </div>
                </div>
            </div>
        </div>
    </div>
    <div class="specialities-sec ptb70 mt70 bggrey">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="headding11"><img src="images/icon-sub-heading.svg"><br>
                     Our  <span>Specialties </span>
                     <span class="line"></span>
                  </h1>
                </div>
 
                <div class="col-lg-4 col-md-6">
                    <a href="<?= BASE_URL ?>internal-medicine.php">
                        <div class="feature-item">
                            <div class="feature__img"> <img src="images/internal-medicin.jpg" alt="Internal Medicine"> </div>
                            <div class="feature__content">
                                <div class="feature__icon"> <img src="images/internal-medicine-icon.png" alt="Internal Medicine"> </div>
                                <h4 class="feature__title"> Internal Medicine</h4>
                                <p>This department is managed by a team of consultants to provide quality care and cost effective treatment.</p>
                                <div class="btn__link"> <i class="icon-arrow-right icon-outlined"></i> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="<?=BASE_URL?>diabetes.php">
                        <div class="feature-item">
                            <div class="feature__img"> <img src="images/diabetes-image.jpg" alt="Diabetes"> </div>
                            <div class="feature__content">
                                <div class="feature__icon"> <img src="images/diabetes-icon.png" alt="Diabetes"> </div>
                                <h4 class="feature__title"> Diabetes</h4>
                                <p>Diabetes Centre was set up with state of art facilities & equipments.</p>
                                <div class="btn__link"> <i class="icon-arrow-right icon-outlined"></i> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="<?=BASE_URL?>ophthalmology.php">
                        <div class="feature-item">
                            <div class="feature__img"> <img src="images/ophthalmology.jpg" alt="Ophthalmology"> </div>
                            <div class="feature__content">
                                <div class="feature__icon"> <img src="images/ophthalmology.png" alt="Ophthalmology"> </div>
                                <h4 class="feature__title"> Ophthalmology</h4>
                                <p>We started as Eye Hospital and over the year, this department is rated as one of the pioneer Eye facilities in Delhi.</p>
                                <div class="btn__link"> <i class="icon-arrow-right icon-outlined"></i> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="<?=BASE_URL?>ear-nose-throat.php">
                        <div class="feature-item">
                            <div class="feature__img"> <img src="images/ent.jpg" alt="Ear, Nose, Throat"> </div>
                            <div class="feature__content">
                                <div class="feature__icon"> <img src="images/ent.png" alt="Ear, Nose, Throat"> </div>
                                <h4 class="feature__title"> Ear, Nose, Throat</h4>
                                <p>The Audiometry Lab has the latest audiometer, tympanometer and speech therapy facilities.</p>
                                <div class="btn__link"> <i class="icon-arrow-right icon-outlined"></i> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="<?=BASE_URL?>gynaecology-and-obstetrics.php">
                        <div class="feature-item">
                            <div class="feature__img"> <img src="images/gyanecology-and-obstetrics.jpg" alt="Gynaecology & Obstetrics"> </div>
                            <div class="feature__content">
                                <div class="feature__icon"> <img src="images/gyanecology-and-obstetrics-icon.png" alt="Gynaecology & Obstetrics"> </div>
                                <h4 class="feature__title"> Gynaecology & Obstetrics</h4>
                                <p>We have a well equipped Ward, Labour Room, Operation Theatre, Neo Natal Care and Phototherapy.</p>
                                <div class="btn__link"> <i class="icon-arrow-right icon-outlined"></i> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="<?=BASE_URL?>surgery.php">
                        <div class="feature-item">
                            <div class="feature__img"> <img src="images/surgery-image.jpg" alt="Surgery"> </div>
                            <div class="feature__content">
                                <div class="feature__icon"> <img src="images/surgery-icon.png" alt="Surgery"> </div>
                                <h4 class="feature__title"> Surgery</h4>
                                <p>We conduct Laparoscopic surgeries for gall bladder stones, hernia, uterus removal, etc.</p>
                                <div class="btn__link"> <i class="icon-arrow-right icon-outlined"></i> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
                            </div>
                        </div>
                    </a>
                </div>
                 
                <div class="col-md-12 text-center">
                    <a href="specialties.php" class="btn-default">View All </a>
                </div>
            </div>
        </div>
    </div>
    <div class="facilities-sec mt70">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="headding11"><img src="images/icon-sub-heading.svg"><br>
                     Our  <span>Facilities </span>
                     <span class="line"></span>
                  </h1>
                </div>
                <ul>
                    <li>OPD</li>
                    <li>IPD</li>
                    <li>Ultrasound</li>
                    <li>Cardiac Checkup</li>
                    <li>Digital X-Ray</li>
                    <li>Echocardiography</li>
                    <li> Doppler</li>
                    <li>Stress Echo</li>
                    <li>Audiometry Test</li>
                    <li>Diabetes Checkup</li>
                    <li>Health Checkup</li>
                    <li>Vaccination</li>
                </ul>
                <div class="col-md-12 text-center">
                    <a href="<?=BASE_URL?>facilities.php" class="btn-default">View All </a>
                </div>
            </div>
        </div>
    </div>
    <div class="doctor-sec bggrey mt70 ptb70 arrow-btn">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="headding11"><img src="images/icon-sub-heading.svg"><br>
                     Our  <span>Doctors  </span>
                     <span class="line"></span>
                  </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-carousel doctor-slider">
                       
             <?php
$query = "SELECT * FROM doctor_new";
$where = ["status = 1", "is_homeslide = 1"]; // Add the condition here
$params = [];
$types = '';

if ($selectedSpeciality) {
    $where[] = "FIND_IN_SET(?, speciality_id)";
    $params[] = $selectedSpeciality;
    $types .= 'i';
}

if ($selectedDoctor) {
    $where[] = "name = ?";
    $params[] = $selectedDoctor;
    $types .= 's';
}

if (!empty($where)) {
    $query .= " WHERE " . implode(" AND ", $where);
}

$stmt = $con->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $specialityNames = [];
        $specialityIds = explode(',', $row['speciality_id']);
        $placeholders = implode(',', array_fill(0, count($specialityIds), '?'));
        $typeStr = str_repeat('i', count($specialityIds));

        $specStmt = $con->prepare("SELECT name FROM speciality WHERE id IN ($placeholders)");
        $specStmt->bind_param($typeStr, ...$specialityIds);
        $specStmt->execute();
        $specRes = $specStmt->get_result();
        while ($specRow = $specRes->fetch_assoc()) {
            $specialityNames[] = $specRow['name'];
        }
        $specStmt->close();
        $specialityList = implode(', ', $specialityNames);
        ?>

        <div class="team-member-item">
            <div class="team-image">
                <figure class="image-anime">
                    <img src="<?= BASE_URL ?>admin_chandiwala2025xhd/uploads/<?= $row['image'] ?>" alt="Dr. <?= htmlspecialchars($row['name']) ?>">
                </figure>
            </div>
            <div class="team-body">
                <div class="team-content">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <h5><?= htmlspecialchars($specialityList) ?></h5>
                    <h6><?= htmlspecialchars($row['designation']) ?></h6>
                    <h6><?= htmlspecialchars($row['qualification']) ?></h6>
                </div>
                <div class="doctor-btn">
                    <a href="<?=BASE_URL?>doctor-profile-new/<?= $row['url'] ?>" class="btn-default">View Profile</a>
                </div>
            </div>
        </div>

        <?php
    }
}
?>

                    </div>
                    <div class="col-md-12 text-center mt-3">
                        <a href="<?=BASE_URL?>find-a-doctor.php" class="btn-default"> View All </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="our-testimonial ptb70 arrow-btn">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-center">
                            <h1 class="headding11">
                     <span>Patient   </span> Testimonials
                     <span class="line"></span>
                  </h1>                
  </div>
                        <div class="owl-carousel testimonial-slider">
                            <div class="testimonial">
                                <p class="description">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                </p>
                                <div class="testimonial-content">
                                    <div class="pic">
                                        <img src="images/img-1.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <h4 class="name">Williamson</h4>
                                        <span class="post">Web Developer</span>
                                        <ul class="rating">
                                            <li class="fa fa-star"></li>
                                            <li class="fa fa-star"></li>
                                            <li class="fa fa-star"></li>
                                            <li class="fa fa-star"></li>
                                            <li class="fa fa-star"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial">
                                <p class="description">
                                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page
                                </p>
                                <div class="testimonial-content">
                                    <div class="pic">
                                        <img src="images/img-2.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <h4 class="name">kristiana</h4>
                                        <span class="post">Web Designer</span>
                                        <ul class="rating">
                                            <li class="fa fa-star"></li>
                                            <li class="fa fa-star"></li>
                                            <li class="fa fa-star"></li>
                                            <li class="fa fa-star"></li>
                                            <li class="fa fa-star"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <h1 class="headding11">
                     <span>Video   </span> Testimonials
                     <span class="line"></span>
                  </h1>
                        
                        </div>
                        <div class="owl-carousel testimonial-slider">
                            <div class="item-vd">
                                <iframe width="100%" height="310" src="https://www.youtube.com/embed/AByB0o7rLpM?si=x_doarqU_aAmk9i7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                            <div class="item-vd">
                                <iframe width="100%" height="310" src="https://www.youtube.com/embed/AByB0o7rLpM?si=x_doarqU_aAmk9i7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "includes/footer.php"; ?>
    <?php include "includes/script.php"; ?>
    <script>
        $( document ).ready( function () {
            $( ".testimonial-slider" ).owlCarousel( {
                items: 1,
                itemsDesktop: [ 1000, 1 ],
                itemsDesktopSmall: [ 979, 1 ],
                itemsTablet: [ 768, 1 ],
                pagination: false,
                navigation: true,
                navigationText: [ "", "" ],
                autoPlay: true
            } );
        } );

        $( document ).ready( function () {
            $( ".doctor-slider" ).owlCarousel( {
                items: 4,
                itemsDesktop: [ 1000, 3 ],
                itemsDesktopSmall: [ 979, 2 ],
                itemsTablet: [ 768, 1 ],
                pagination: false,
                navigation: true,
                navigationText: [ "", "" ],
                autoPlay: true
            } );
        } );
    </script>
</body>

</html>