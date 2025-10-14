

function initializeCaptchaValidation() {
  let generatedCaptcha;
  // Function to generate alphanumeric CAPTCHA code
  function generateCaptcha() {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; // Letters (upper and lower case) and numbers
    let captchaString = '';
    for (let i = 0; i < 6; i++) {  // Adjust the length of the CAPTCHA by changing the 6
      const randomIndex = Math.floor(Math.random() * characters.length);
      captchaString += characters[randomIndex];
    }
    generatedCaptcha = captchaString;
    document.getElementById('captchaBox').textContent = generatedCaptcha;
  }

  // Function to check if the entered CAPTCHA matches
  function validateCaptcha() {
    const userInput = document.getElementById('captcha-input').value;
    const feedback = document.getElementById('captcha-feedback');
    const submitButton = document.getElementById('submit');

    if (userInput.trim() === "") {
      feedback.style.color = "red";
      feedback.textContent = "Please enter the CAPTCHA.";
      submitButton.disabled = true;
    } else if (userInput === generatedCaptcha) {
      feedback.style.color = "green";
      feedback.textContent = "Captcha is correct!";
      submitButton.disabled = false;
    } else {
      feedback.style.color = "red";
      feedback.textContent = "Captcha is incorrect. Please try again.";
      submitButton.disabled = true;
    }
  }
  // Function to handle form submission
  function validateForm(event) {
    const userInput = document.getElementById('captcha-input').value;
    if (userInput !== generatedCaptcha) {
      alert("Please correct the CAPTCHA before submitting the form.");
      event.preventDefault();  // Prevent form submission if CAPTCHA is incorrect
      return false;
    }
    return true; // Allow form submission if CAPTCHA is correct
  }

  // Generate CAPTCHA when the page loads
  window.onload = generateCaptcha;

  // Event listener for the CAPTCHA input field to validate as the user types
  document.getElementById('captcha-input').addEventListener('input', validateCaptcha);

  // Attach validateForm to the form's onsubmit event
  document.getElementById('offcanvasForm').onsubmit = validateForm;
}

// Initialize CAPTCHA validation when the script runs
initializeCaptchaValidation();
