
<footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="footer-column">
                        <img class="footer-logo img-fluid" src="<?= BASE_URL ?>images/logo-footer.png"  alt="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-column">
                        <h4>Quick Links</h4>
                        <ul class="quick-links">
                            <li><a href="https://www.sahyogcare4u.org/index.php">Home</a></li>
                            <li><a href="https://www.sahyogcare4u.org/about-us.php">About</a></li>
                            <li><a href="https://www.sahyogcare4u.org/our-team.php">Team</a></li>
                            <li><a href="https://www.sahyogcare4u.org/media.php">Media</a></li>
                            <li><a href="#">Emergency Cases</a></li>
                            <li><a href="https://www.sahyogcare4u.org/contact-us.php">Contact Us</a></li>
                            <li><a href="https://www.sahyogcare4u.org/blog/">Blog</a></li>
                            <li><a href="https://www.sahyogcare4u.org/terms-and-conditions.php">Terms & Conditions</a></li>
                            <li><a href="https://www.sahyogcare4u.org/privacy-policy.php">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-column">
                        <h4>Donate Now</h4>
                        <div class="footer-qr">
                            <img src="<?php echo $base_url.'images/sahyogcare4u-qr.jpeg'?>" class="img-fluid" alt="">
                        </div>
                        <span>Scan to make a difference</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-column">
                        <h4>Stay Connected</h4>
                        <div class="footer-social">
                            <a target="_blank" href="https://www.facebook.com/SahyogCare4You/"><i class="fa-brands fa-facebook"></i></a>
                            <a target="_blank" href="https://www.instagram.com/sahyogcare4you/"><i class="fa-brands fa-instagram"></i></a>
                            <a target="_blank" href="https://x.com/SahyogCare4You"><i class="fa-brands fa-x-twitter"></i></a>
                            <a target="_blank" href="https://www.linkedin.com/company/sahyogcare4you/"><i class="fa-brands fa-linkedin"></i></a>
                            <a target="_blank" href="https://www.youtube.com/@sahyogcare-c7d"><i class="fa-brands fa-youtube"></i></a>
                        </div> 
                        <h4>Newsletter</h4>

                          <form id="newsLetterForm" class="footer-form" method="POST" data-parsley-validate>
    <input type="hidden" name="source" value="News letter">
    <input type="email" class="footer-input" placeholder="Your email address" name="email" required="">
    <button type="submit" class="footer-btn newsletter-btn-submit"><i class="bi bi-send"></i></button>
</form>                            <a href="https://sahyogcare4u.org/Newsletter/Sahyog-Newsletter.pdf" target="_blank" class="sahyog_pdf_button">
                                <i class="bi bi-download"></i> Download Newsletter
                        </a>
                        </div>
                        </div>
                        </div>
                        </div>
                        </footer>
                      <script>
        $(document).ready(function() {
            // Handle form submission
            $('#newsLetterForm').on('submit', function(e) {
                e.preventDefault();
                if ($(this).parsley().isValid()) {
                    var formData = $(this).serialize();

                    $.ajax({
                        url: 'ajax/newsletter.php',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        beforeSend: function() {
                            $('.newsletter-btn-submit').val('Sending...').prop('disabled', true);
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                             window.location.href = "thanks-newsletter.php";  // Redirect after success
                                $('#newsLetterForm')[0].reset();
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('An error occurred. Please try again.');
                            console.log(error);
                        },
                        complete: function() {
                            $('.newsletter-btn-submit').val('Submit').prop('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
