<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Get in Touch with Sahyog Care For You</title>
      <meta name="description" content="Reach out to us for support, volunteering, donations, or partnership opportunities. We’re here to connect, collaborate, and make a difference together.">
       <meta name="keywords" content="NGO contact, get in touch NGO, NGO in Delhi, NGO email, volunteer with NGO, donate to NGO, partner with NGO, NGO address, help poor children NGO">
         <link rel="icon" href="images/favicons.png" type="image/x-icon">
    <?php include("./includes/top.php") ?>
	
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-L3TTRSS3S1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-L3TTRSS3S1');
</script>
	
	<meta name="google-site-verification" content="3Sv1MRaMdCRJOeW7TPio056Ow61KrbJntx7BmiHg08Y"/>
	
</head>

<body>
    <?php include("./includes/header.php") ?>
    <div class="contact-banner-sec">
        <img src="<?php echo $base_url; ?>images/contact-banner.jpg" class="img-fluid w-100" alt="">
        <div class="contact-banner-text">
            <h4>Contact Us</h4>
        </div>
    </div>
    <div class="contact-inner ptb70">
        <div class="container">
            <div class="contact-about">
                <h2>About Sahyog Care</h2>
                <p>The word "Sahyog" means cooperation in Hindi. Working in cooperation with various stakeholders to bring about difference in the lives of underprivileged, deprived women, children and their families and communities is what Sahyog is all about. Sahyog care is a registered voluntary NGO which has been working for the empowerment of marginalized sections of society since 2002. Sahyog Care was started with a view to bring smile in the lives of such people.</p>
            </div>
        
            <div class="contact-about">
                  <div class="d-flex  flex-md-row flex-column">
               <div class="contact-l">
                <h2>For General Enquiries </h2>
                <p> <strong>Sahyog care for you</strong></p>
                <p><i class="fas fa-building"></i> <strong>Head Office - Delhi</strong></p>
                <p><i class="fas fa-map-marker-alt"></i> 22 Basement, Bhera Enclave, Paschim Vihar, New Delhi PIN - 110087</p>
                <p><i class="fas fa-phone"></i> <a href="tel:+91-11-41024510">+91-11-41024510</a></p>
                <p><i class="fas fa-envelope"></i> <a href="mailto:info@sahyogcare4u.org">info@sahyogcare4u.org</a>, <a href="mailto:sahyog.careforyou@gmail.com">sahyog.careforyou@gmail.com</a></p>
                </div>
                <div class="contact-l">
                <h2>For  CSR Colloaboration </h2>
                <p> <strong>Sahyog care for you</strong></p>
                <p><i class="fas fa-building"></i> <strong>Head Office - Delhi</strong></p>
                <p><i class="fas fa-map-marker-alt"></i> 22 Basement, Bhera Enclave, Paschim Vihar, New Delhi PIN - 110087</p>
                <p><i class="fas fa-mobile"></i> <a href="tel:+91-9811169292">+91-9811169292</a></p>
                <p><i class="fas fa-envelope"></i> <a href="mailto:sahyogcareforyou11@gmail.com">sahyogcareforyou11@gmail.com</a>, <a href="mailto:sahyogcsrproject@gmail.com">sahyogcsrproject@gmail.com</a></p>
                </div>
                </div>
                <div class="contact-map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d112020.17532711482!2d77.092803!3d28.670781!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x59cc24b7c83b24c2!2sSahyog+Care+For+You!5e0!3m2!1sen!2sin!4v1531983103036" allowfullscreen></iframe>
                </div>
                <div class="contact-about mt-3">
                    <p><strong>Mumbai Office</strong></p>
                    <p>708,7th Floor, Fenkin Empire Near Dr. Bhanushali Hospital,<br>
                        Thane - 400601, Mumbai, Maharashtra</p>
                </div>
            </div>
             
            
            <div class="contact-about mt-3">
                <h2>Send us a message</h2>
                <div class="contact-form">
                    <form id="enquiryForm" method="POST" data-parsley-validate>
                        <input type="hidden" name="source" value="Contact_us">
                        <div class="col-md-12 mb-4">
                            <input type="text" class="form-control" name="name" placeholder="Your Name*" required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <input type="email" class="form-control" name="email" placeholder="Your Email*" required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <input type="tel" class="form-control" name="phone" placeholder="Your Number*"    name="mobile" 
       inputmode="numeric"  
       data-parsley-type="digits"
       data-parsley-pattern="^[6-9]\d{9}$"
       data-parsley-pattern-message="Please enter a valid phone number starting with 6 to 9 and 10 digits long"
       data-parsley-required="true" 
       autocomplete="off"  
       required 
       oninput="this.value = this.value.replace(/\D/g, '')" 
       maxlength="10" 
       minlength="10" required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <input type="text" class="form-control" name="subject" placeholder="Subject*" required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <textarea rows="4" class="form-control" name="message" placeholder="Your Message" required></textarea>
                        </div>
                        <div class="col-md-12 mb-4">
                <div class="form-group d-flex align-items-center costum-captcha">
                <div class="mr-3 jc__captcha__value pe-4" id="captchaBox" class="form-control"></div>
                
          <input type="text" class="form-control jc__captcha__input text-center captcha-input" id="captcha-input" placeholder="Enter Security Code"  required>
                    </div>
                    <div id="captcha-feedback"></div>
                  </div>
                        <div class="col-md-12 mb-4">
                            <input type="submit" class="contact-btn-submit" value="Submit" id="submit">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php include("./includes/footer.php") ?>
    <?php include("./includes/script.php") ?>
   <script>
    let generatedCaptcha = "";

    function generateCaptcha() {
        const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        let captchaString = "";
        for (let i = 0; i < 8; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            captchaString += characters[randomIndex];
        }
        generatedCaptcha = captchaString;
        document.getElementById('captchaBox').textContent = generatedCaptcha;
    }

    function validateCaptcha() {
        const userInput = document.getElementById('captcha-input').value.trim();
        const feedback = document.getElementById('captcha-feedback');
        const submitButton = document.getElementById('submit');

        if (userInput === "") {
            feedback.style.color = "red";
            feedback.textContent = "Please enter the captcha. It cannot be empty.";
            submitButton.disabled = true;
            return;
        }

        if (userInput === generatedCaptcha) {
            feedback.style.color = "green";
            feedback.textContent = "Captcha is correct.";
            submitButton.disabled = false;
        } else {
            feedback.style.color = "red";
            feedback.textContent = "Captcha is incorrect. Please try again.";
            submitButton.disabled = true;
        }
    }

    window.onload = function () {
        generateCaptcha();
        document.getElementById('captcha-input').addEventListener('input', validateCaptcha);
    };
</script>
</body>

</html>