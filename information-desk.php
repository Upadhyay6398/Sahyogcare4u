<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Desk | Learn More About Sahyog Care For You Mission & Impact</title>
      <link rel="icon" href="images/favicons.png" type="image/x-icon">
  <meta name="description" content="Find detailed information about our NGO’s vision, programs, impact, and how you can get involved. Your support helps us bring positive change to those in need.">
  <meta name="keywords" content="NGO information, about our NGO, NGO mission, NGO programs, NGO help desk, non-profit organization, NGO activities, volunteer information">

    <?php include("./includes/top.php")?>
     <style>
       .reports-section {
  padding: 2em 0;
  margin-bottom:30px;
  background-color: #fdd831;
}

.section-heading {
  text-align: center;
  margin-bottom: 1em;
}

.report-selector {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 1em;
  font-size:1.5rem;
  margin-bottom: 2em;
}

.report-selector select, .report-selector button {
  padding: 0.5em 1em;
  font-size: 20px;
}

.report-content {
    color:white;
    font-size:1.5rem;
  text-align:center;
}
.transparency-certificates {
  background-color: #86cdcc;
  padding: 60px 0;
}

.section-title {
  text-align: center;
  margin-bottom: 25px;
  font-size: 50px;
  color: #333;
}

.section-title img {
  vertical-align: middle;
  margin-right: 10px;
}

.certificate-carousel {
  position: relative;
  max-width: 1000px;
  margin: 0 auto;
  overflow: hidden;
}

.carousel-container {
  overflow: hidden;
}

.carousel-track {
  display: flex;
  transition: transform 0.5s ease;
}

.certificate-item {
  flex: 0 0 25%;
  padding: 0 10px;
  text-align: center;
}

.thumbnail {
  width: 100%;
    height: 75%;
    background: #fff;
    object-fit: contain;
      border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: transform 0.3s ease;
}

.thumbnail:hover {
  transform: scale(1.05);
}

.certificate-item h3 {
  margin-top: 10px;
  font-size: 20px;
  color: #333;
}

.carousel-button {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: #fdd831;
  color: white;
  border: none;
  font-size: 24px;
  padding: 10px 15px;
  cursor: pointer;
  transition: background-color 0.3s;
  z-index: 10;
}

.carousel-button:hover {
  background-color: rgba(0, 0, 0, 0.7);
}

.carousel-button.prev {
  left: -10px;
}

.carousel-button.next {
  right: -10px;
}

/* Modal styles (unchanged) */
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.9);
}

.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

.documents-section {
  background-color: #f5f5f5;
  padding: 60px 0;
  position: relative;
}

.documents-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: radial-gradient(circle, #ccc 1px, transparent 1px);
  background-size: 20px 20px;
  opacity: 0.3;
  z-index: 0;
}

.container {
  position: relative;
  z-index: 1;
}

.section-title {
  text-align: center;
  margin-bottom: 40px;
  font-size: 2.5rem;
  color: #333;
}

.documents-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 20px;
}

.document-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: #fdd831;
  border-radius: 8px;
  padding: 20px;
  text-decoration: none;
  color: #333;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.document-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.document-item i {
  font-size: 3rem;
  margin-bottom: 10px;
  color: #007bff;
}

.document-item span {
  text-align: center;
  font-weight: 500;
}

#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

@media only screen and (max-width: 991px) {
  .transparency-certificates {
    padding: 30px 0;
}
.section-title {
  font-size: 35px;}
}

@media only screen and (max-width: 767px) {
.certificate-item {
  flex: 0 0 33%;}
  .section-title {
  font-size: 25px;
}
}
@media only screen and (max-width: 575px) {
  .certificate-item {
    flex: 0 0 50%;}
}
   .certificate-item1 {  flex: 0 0 25%;
  padding: 0 10px;
  text-align: center;
}
.certificate-item1 {  flex: 0 0 33%;}
.certificate-item1 {    flex: 0 0 50%;}
.thumbnail1 {  width: 100%;
    height: 75%;
    background: #fff;
    object-fit: contain;
      border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: transform 0.3s ease;
}
   </style>

   
</head>
<body>
<?php include("./includes/header.php")?>
<div class="hero-sec">
        <img src="images/info-deskk-banner.jpg" class="img-fluid w-100" alt="">
</div>
<!-- <div class="program-title info-desk-title">
    <img src="images/info-desk-award-1.jpg" alt="LIMCA - Book of Records">
</div> -->

<div class="transparency-sec ptb70 ">
    <div class="container">
<h2 class="heading11"><img src="images/heading-icon.png" alt=""> Transparency Certificates</h2>

<div class="swiper info-award-swipe">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="info-award-box">
                    <img src="images/info-award-1.png" class="img-fluid" alt="">
                    <h4>Global Giving</h4>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="info-award-box">
                    <img src="images/info-desk-award-1.jpg" alt="LIMCA - Book of Records">
                    <h4>LIMCA - Book of Records</h4>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="info-award-box">
                    <img src="images/info-award-2.png" class="img-fluid" alt="">
                    <h4>Give India</h4>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="info-award-box">
                    <img src="images/info-award-3.png" class="img-fluid" alt="">
                    <h4>Guide Star India GOLD</h4>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="info-award-box">
                    <img src="images/info-award-4.jpg" class="img-fluid" alt="">
                    <h4>Credibility Alliance</h4>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="info-award-box">
                    <img src="images/info-award-5.jpg" class="img-fluid" alt="">
                    <h4>Charities Aid Foundation India</h4>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="info-award-box">
                    <h4>LIMCA - Book of Records</h4>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="info-award-box">
                    <img src="images/info-award-7.png" class="img-fluid" alt="">
                    <h4>Global Giving</h4>
                  </div>
                </div>
              </div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
    </div>
</div>


<div class="info-document-sec ptb70">
        <div class="container">
         <h2 class="heading11">Transparency Certificates</h2>

         <div class="row pt50">
          <div class="col-md-6">
            <div class="row row-gap-4">
              <div class="col-md-4">
                <a href="https://www.sahyogcare4u.org/pdf/RC.pdf" class="document-item">
        <svg class="document-icon" viewBox="0 0 24 24">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"></path>
          <path d="M8 12h8v2H8zm0 4h8v2H8zm0-8h2v2H8z"></path>
        </svg>
        <span class="text-center">Registration Certificate</span>
      </a>
              </div>

              <div class="col-md-4">
                <a href="https://www.sahyogcare4u.org/pdf/80g.pdf" class="document-item">
        <svg class="document-icon" viewBox="0 0 24 24">
          <path d="M21 4H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H3V6h18v12z"></path>
          <path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm0 8.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"></path>
          <path d="M12 10.5c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5 1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"></path>
        </svg>
        <span class="text-center">80G Certificate</span>
      </a>
              </div>
              <div class="col-md-4">
                <a href="https://www.sahyogcare4u.org/pdf/12A.pdf" class="document-item">
        <svg class="document-icon" viewBox="0 0 24 24">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"></path>
          <path d="M10 12H8v-2h2v2zm0 4H8v-2h2v2zm0-8H8V6h2v2zm6 4h-4v-2h4v2zm0 4h-4v-2h4v2zm0-8h-4V6h4v2z"></path>
        </svg>
        <span class="text-center">12A Certificate</span>
      </a>
              </div>


              <div class="col-md-4">
                <a href="https://www.sahyogcare4u.org/files/cpp.pdf" class="document-item">
        <svg class="document-icon" viewBox="0 0 24 24">
          <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"></path>
        </svg>
        <span class="text-center" >Child Protection Policy</span>
      </a>
              </div>


              <div class="col-md-4">
                <a href="https://www.sahyogcare4u.org/files/informationbrochure.pdf" class="document-item">
        <svg class="document-icon" viewBox="0 0 24 24">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path>
        </svg>
        <span class="text-center">Information Brochure</span>
      </a>
    </div>

              <div class="col-md-4">
                <a href="https://www.sahyogcare4u.org/files/FAQ.pdf" class="document-item">
        <svg class="document-icon" viewBox="0 0 24 24">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"></path>
        </svg>
        <span class="text-center">Frequently Asked Questions</span>
      </a>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <img src="images/tp.png" class="img-fluid w-100" alt="">
          </div>
         </div>
        </div>
      </div>
     <section class="reports-section">
  <div class="container">
   
    
    <div class="report-selector">
      <select id="report-type">
        <option value="">Select Report Type</option>
        <option value="financial">Financial Report</option>
        <option value="fcra">FCRA Report</option>
        <option value="annual">Annual Report</option>
      </select>
      
      <select id="report-year">
        <option value="">Select Year</option>
        <!-- Years will be populated dynamically based on report type -->
      </select>
      
      <button id="view-report">View Report</button>
    </div>
    
    <div id="report-content" class="report-content">
      <!-- Report content will be displayed here -->
    </div>
  </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
  const reportType = document.getElementById('report-type');
  const reportYear = document.getElementById('report-year');
  const viewButton = document.getElementById('view-report');
  const reportContent = document.getElementById('report-content');

  const reports = {
    financial: {
      years: ['2023-24','2022-23','2021-22', '2020-21', '2019-20', '2018-19', '2017-18', '2016-17', '2015-16', '2014-15', '2013-14', '2012-13'],
      urls: {
		  '2023-24': 'https://www.sahyogcare4u.org/files/Audit-Report-2023-24.pdf',
        '2022-23': 'https://www.sahyogcare4u.org/files/Audit-Report-2022-23.pdf',
        '2021-22': 'https://www.sahyogcare4u.org/files/Audit-Report-2021-22.pdf',
        '2020-21': 'https://www.sahyogcare4u.org/files/Audit-Report-2020-21.pdf',
        '2019-20': 'https://www.sahyogcare4u.org/files/Audit-Report-2019-20.pdf',
        '2018-19': 'https://www.sahyogcare4u.org/files/audit-report-2018-19.pdf',
        '2017-18': 'https://www.sahyogcare4u.org/files/Financial-2017-18.pdf',
        '2016-17': 'https://www.sahyogcare4u.org/files/Financial-2016-17.pdf',
        '2015-16': 'https://www.sahyogcare4u.org/files/Financial-2015-16.pdf',
        '2014-15': 'https://www.sahyogcare4u.org/files/Financial-2014-15.pdf',
        '2013-14': 'https://www.sahyogcare4u.org/files/Financial-Report-13-14.pdf',
        '2012-13': 'https://www.sahyogcare4u.org/files/financial_performance.pdf'
      }
    },
    fcra: {
      years: ['2021-22', '2019-20', '2018-19', '2017-18', '2016-17', '2015-16'],
      urls: {
        '2021-22': 'https://www.sahyogcare4u.org/files/fcra-2021-22.pdf',
        '2019-20': 'https://www.sahyogcare4u.org/files/fcra-2019-20.pdf',
        '2018-19': 'https://www.sahyogcare4u.org/files/fcra-2018-19.pdf',
        '2017-18': 'https://www.sahyogcare4u.org/files/fcra-q1-q2-2017-2018.pdf',
        '2016-17': 'https://www.sahyogcare4u.org/files/fcra-2016-2017.pdf',
        '2015-16': 'https://www.sahyogcare4u.org/files/fcra-q3-q4-2015-2016.pdf'
      }
    },
    annual: {
      years: ['2022-23', '2021-22', '2020-21', '2019-20', '2018-19', '2017-18', '2016-17', '2015-16'],
      urls: {
        '2022-23': 'https://www.sahyogcare4u.org/files/annual2023.pdf',
        '2021-22': 'https://www.sahyogcare4u.org/files/annual2022.pdf',
        '2020-21': 'https://www.sahyogcare4u.org/files/annual2021.pdf',
        '2019-20': 'https://www.sahyogcare4u.org/files/annual1920.pdf',
        '2018-19': 'https://www.sahyogcare4u.org/files/annual1819.pdf',
        '2017-18': 'https://www.sahyogcare4u.org/files/annual1718.pdf',
        '2016-17': 'https://www.sahyogcare4u.org/files/annual1617.pdf',
        '2015-16': 'https://www.sahyogcare4u.org/files/annual1516.pdf'
      }
    }
  };

  reportType.addEventListener('change', function() {
    reportYear.innerHTML = '<option value="">Select Year</option>';
    if (this.value) {
      reports[this.value].years.forEach(year => {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        reportYear.appendChild(option);
      });
    }
  });

  viewButton.addEventListener('click', function() {
    if (reportType.value && reportYear.value) {
      const url = reports[reportType.value].urls[reportYear.value];
      if (url) {
        reportContent.innerHTML = `<embed src="${url}" type="application/pdf" width="100%" height="600px" />`;
      } else {
        reportContent.innerHTML = '<p>Report not available.</p>';
      }
    } else {
      reportContent.innerHTML = '<p>Please select both report type and year.</p>';
    }
  });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
  const track = document.querySelector('.carousel-track');
  const items = document.querySelectorAll('.certificate-item');
  const prevButton = document.querySelector('.carousel-button.prev');
  const nextButton = document.querySelector('.carousel-button.next');
  const itemWidth = items[0].offsetWidth;
  let position = 0;

  // Clone items for infinite loop
  items.forEach(item => {
    const clone = item.cloneNode(true);
    track.appendChild(clone);
  });

  function moveCarousel(direction) {
    position += direction * itemWidth;
    const limit = -itemWidth * items.length;

    if (position > 0) {
      position = limit;
    } else if (position <= limit) {
      position = 0;
    }

    track.style.transform = `translateX(${position}px)`;
  }

  prevButton.addEventListener('click', () => moveCarousel(1));
  nextButton.addEventListener('click', () => moveCarousel(-1));

  // Modal functionality
  const modal = document.getElementById('certificateModal');
  const modalImg = document.getElementById('modalImage');
  const captionText = document.getElementById('caption');
  const closeBtn = document.getElementsByClassName('close')[0];

  document.querySelectorAll('.thumbnail').forEach(img => {
    img.onclick = function() {
      modal.style.display = 'block';
      modalImg.src = this.src;
      captionText.innerHTML = this.alt;
    }
  });

  closeBtn.onclick = function() {
    modal.style.display = 'none';
  }

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = 'none';
    }
  }
});
</script>
<script src='https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js'></script> 
<?php include("./includes/footer.php")?>
<?php include("./includes/script.php")?>
</body>
</html>