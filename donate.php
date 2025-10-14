<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Now | Support Our Mission & Change Lives Today - Sahyog Care For You </title>
    <meta name="description"
        content="Make a difference today! Donate now to support education, healthcare, and basic needs for underprivileged children and communities. Every contribution counts.">
    <meta name="keywords"
        content="donate now, NGO donation, help poor children, sponsor education, NGO India, support a cause, child welfare, non-profit donation, online donation, give bac">
          <link rel="icon" href="images/favicons.png" type="image/x-icon">
    <?php include("./includes/top.php") ?>
    <style>
        .selected {
            border: 2px solid #007bff !important;
            background-color: #e6b800 !important;
        }
    </style>
	
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
        <img src="<?php echo $base_url . 'images/donate-banner.jpg' ?>" class="img-fluid w-100" alt="">
    </div>
    <div class="donate-head ptb70">
        <div class="container">
            <h2 class="heading11 mb-5"><img src="<?php echo $base_url . 'images/heading-icon.png' ?>" alt="">Support Now
            </h2>
            <h4>In every 10 minutes a child drops out of school & the future of another Indian will be smashed! </h4>
            <span>The reason: lack of funds!</span>
        </div>
    </div>

    <div class="donate-info">
        <div class="container">
            <h2>GIVE THE CHILD A CHILDHOOD</h2>
            <p><i>Your support is vital to ensure this change and make a direct & lasting impact on the lives of
                    children. Whether you choose to donate monthly or choose to provide a single gift. You are standing
                    up for every child's right to health, education, equality & protection.</i></p>
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="bankd">
                        <h4>SAHYOG CARE FOR YOU</h4>
                        <p>A/c no-924010067539570</p>
                        <p>Axis Bank Ltd.</p>
                        <p>Meera Bagh</p>
                        <p>IFSC-UTIB0000533</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="donate-qr">
                        <img src="<?php echo $base_url . 'images/sahyog-donate-page.jpeg' ?>" alt="">
                        <h4>Scan & Donate</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="donate-form-tab ptb70">
        <div class="container">

            <ul class="tabs mb-5">
                <li class="tab-link current" data-tab="tab-1">For Indian and NRI Donors</li>
                <li class="tab-link" data-tab="tab-2">For Foreign Nationals/Foreign Citizens</li>
            </ul>

            <div id="tab-1" class="tab-content current">
                <div class="donate-form-wrapper">
                    <div class="col-md-12">
                        <div class="donate-form-head">
                            <p>CHOOSE A CAUSE AND SELECT YOUR AMOUNT </p>
                        </div>
                    </div>

                    <form class="donation-form pt-2" js-parsasly-validate data-parsley-validate
                        action="generateCCHash.php" method="POST" id="donate-form">

                        <!-- Hidden inputs for category-wise donation -->
                        <input type="hidden" name="source" value="donate-form">
                         <input type="hidden" name="donationDetails" id="donationInfo" value="">
                        <div class="row pb-4">
                            <div class="col-md-12 mt-3">
                                <h4>CHILD TRAFFICKING AND CHILD LABOUR RESCUE</h4>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control amount-btn-program" readonly="" type="text"
                                    data-amount="2500" value="2500">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="text" placeholder="Any Other Amount" name="amount"
                                    id="amountInput">
                            </div>
                        </div>

                        <div class="row pb-4">
                            <div class="col-md-12 pb-2">
                                <h4>EDUCATION</h4>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control amount-btn-program-education" readonly type="text"
                                    value="6000" data-amount-education="6000">
                                <p>(for education of 1 child for 1 year)</p>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control amount-btn-program-education" readonly type="text"
                                    value="12000" data-amount-education="12000">
                                <p>(for education of 2 children for 1 year)</p>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control amount-btn-program-education" readonly type="text"
                                    value="18000" data-amount-education="18000">
                                <p>(for education of 3 children for 1 year)</p>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" type="text" placeholder="Any Other Amount"
                                    id="education-input">
                            </div>
                        </div>

                        <div class="row pb-4">
                            <div class="col-md-12 pb-2">
                                <h4>HEALTH (EMERGENCY)</h4>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control amount-btn-program-health" readonly type="text" value="5000"
                                    data-amount-health="5000">
                            </div>
                            <div class="col-md-3">
                                <input class="form-control amount-btn-program-health" readonly type="text" value="10000"
                                    data-amount-health="10000">
                            </div>
                            <div class="col-md-3">
                                <input class="form-control amount-btn-program-health" readonly type="text" value="20000"
                                    data-amount-health="20000">
                            </div>
                            <div class="col-md-3">
                                <input class="form-control amount-btn-program-health" readonly type="text" value="50000"
                                    data-amount-health="50000">
                            </div>
                            <div class="col-md-12 mt-3">
                                <input class="form-control" type="text" placeholder="Any Other Amount"
                                    id="health-input">
                            </div>
                        </div>

                        <div class="row pb-4">
                            <div class="col-md-12 pb-2">
                                <h4>VOCATIONAL TRAINING & EMPLOYMENT TO WOMEN</h4>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control amount-btn-program-women" readonly type="text" value="6000"
                                    data-amount-women="6000">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="text" placeholder="Any Other Amount" id="women-input">
                            </div>
                        </div>

                        <div class="row pb-4">
                            <div class="col-md-12 pb-2">
                                <h4>CONTRIBUTE FOR CHILD REHABILITATION</h4>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control amount-btn-program-rehiblitation" readonly type="text"
                                    value="6000" data-amount-rehiblitation="6000">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="text" placeholder="Any Other Amount"
                                    id="rehiblitation">
                            </div>
                        </div>

                        <div class="row pb-4">
                            <div class="col-md-12 pb-2">
                                <h4>CONTRIBUTE FOR ARMED FORCES WELFARE/WAR WIDOWS WELFARE</h4>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control amount-btn-program-arm-forces" readonly type="text"
                                    value="5000" data-amount-arm-forces="5000">
                            </div>
                            <div class="col-md-3">
                                <input class="form-control amount-btn-program-arm-forces" readonly type="text"
                                    value="1000" data-amount-arm-forces="1000">
                            </div>
                            <div class="col-md-3">
                                <input class="form-control amount-btn-program-arm-forces" readonly type="text"
                                    value="2000" data-amount-arm-forces="2000">
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" type="text" placeholder="Any Other Amount" id="arm-forces">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="donate-form-head donate-form-head2">
                                <p>YOU ARE DONATING AS GUEST </p>
                            </div>
                        </div>

                        <!-- Category table display -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="category-container">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Amount (INR)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="category-table-body">
                                            <!-- JS will insert rows -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total Amount</th>
                                                <th id="category-total-amount">0</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row pt-4 pb-4 row-gap-3">
                            <div class="col-md-6">
                                <input class="form-control" type="text" placeholder="Name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="tel" placeholder="Mobile Number"
                                    placeholder="Your Number" type="tel" name="mobile" inputmode="numeric"
                                    data-parsley-type="digits" data-parsley-pattern="^[6-9]\d{9}$"
                                    data-parsley-pattern-message="Please enter a valid phone number starting with 6 to 9 and 10 digits long"
                                    data-parsley-required="true" autocomplete="off" required
                                    oninput="this.value = this.value.replace(/\D/g, '')" maxlength="10" minlength="10"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="email" placeholder="Email" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="text" placeholder="Country" name="country"
                                    Value="India" required>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" readonly type="text" placeholder="Amount" name="amount"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="text" placeholder="PAN Card" name="pan_number">
                            </div>
                           
                            <div class="col-md-12 text-center mt-3">
                                <button type="submit" class="payment-gateway-text" name="Submit">Donate Now</button>
                            </div>
                            <div class="col-md-12 text-center">
                                <p class=""><u>Secure Payments powered by CCAvenue</u></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="tab-2" class="tab-content">
                <div class="col-md-12">
                    <div class="donate-form-head">
                        <p>FOR FOREIGN NATIONALS/FOREIGN CITIZENS</p>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <h4>TO DONATE</h4>
                    <span class="pt-2">REACH OUT TO US VIA EMAIL:</span><br>
                    <span><strong>Email: <a
                                href="prasadkn@sahyogcare4u.org">prasadkn@sahyogcare4u.org</a></strong></span>
                </div>
            </div>

        </div>
    </div>

    <?php include("./includes/footer.php") ?>
    <?php include("./includes/script.php") ?>
    <script>
        $(document).ready(function () {
            $('form').parsley();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const amountFields = [
                { selector: "#amountInput", category: "Child trafficking and child labour rescue" },
                { selector: "#education-input", category: "Education" },
                { selector: "#health-input", category: "Health (Emergency)" },
                { selector: "#women-input", category: "Vocational training & employment to women" },
                { selector: "#rehiblitation", category: "Contribute for child rehabilitation" },
                { selector: "#arm-forces", category: "Contribute for armed forces welfare/war widows welfare" }
            ];

            const presetFields = {
                "Education": '[data-amount-education]',
                "Health": '[data-amount-health]',
                "Women Empowerment": '[data-amount-women]',
                "Child Rehabilitation": '[data-amount-rehiblitation]',
                "Armed Forces": '[data-amount-arm-forces]'
            };

            const readonlyAmountInput = document.querySelectorAll('input[name="amount"]')[1];
            const tableBody = document.querySelector(".category-table-body");
            const totalAmountField = document.getElementById("category-total-amount");

            function getInputValue(selector) {
                const el = document.querySelector(selector);
                const val = parseFloat(el?.value || 0);
                return isNaN(val) ? 0 : val;
            }

            function addCategoryField(category, amount) {
                const row = document.createElement("tr");
                row.innerHTML = `
            <td>${category}</td>
            <td>${amount}</td>
        `;
                tableBody.appendChild(row);
            }

            function calculateTotal() {
                let total = 0;
                tableBody.innerHTML = "";

                amountFields.forEach(({ selector, category }) => {
                    const value = getInputValue(selector);
                    if (value > 0) {
                        total += value;
                        addCategoryField(category, value);
                    }
                });

                for (const [category, selector] of Object.entries(presetFields)) {
                    document.querySelectorAll(selector).forEach(el => {
                        if (el.classList.contains("selected")) {
                            const value = parseFloat(el.value);
                            if (!isNaN(value)) {
                                total += value;
                                addCategoryField(category, value);
                            }
                        }
                    });
                }

                readonlyAmountInput.value = total > 0 ? total : "";
                totalAmountField.textContent = total;
            }

            // Input manual amount listener
            amountFields.forEach(({ selector }) => {
                const el = document.querySelector(selector);
                if (el) {
                    el.addEventListener("input", function () {
                        // Unselect related preset buttons if any
                        const categoryMatch = amountFields.find(f => f.selector === selector)?.category;
                        if (categoryMatch && presetFields[categoryMatch]) {
                            document.querySelectorAll(presetFields[categoryMatch]).forEach(btn => btn.classList.remove("selected"));
                        }

                        // Special case for General amount
                        if (selector === "#amountInput") {
                            const generalBtn = document.querySelector('[data-amount="2500"]');
                            if (generalBtn) generalBtn.classList.remove("selected");
                        }

                        calculateTotal();
                    });
                }
            });

            // Preset buttons toggle for all categories
            for (const [category, selector] of Object.entries(presetFields)) {
                document.querySelectorAll(selector).forEach(el => {
                    el.addEventListener("click", function () {
                        const isSelected = el.classList.contains("selected");

                        // Always unselect all in this category first
                        document.querySelectorAll(selector).forEach(btn => btn.classList.remove("selected"));

                        // Toggle current only if previously unselected
                        if (!isSelected) {
                            el.classList.add("selected");
                            const inputField = amountFields.find(f => f.category === category);
                            if (inputField) {
                                const input = document.querySelector(inputField.selector);
                                if (input) input.value = "";
                            }
                        }

                        calculateTotal();
                    });
                });
            }

            // General amount ₹2500 button
            const generalBtn = document.querySelector('[data-amount="2500"]');
            if (generalBtn) {
                generalBtn.addEventListener("click", function () {
                    const isSelected = generalBtn.classList.contains("selected");
                    generalBtn.classList.toggle("selected");

                    if (!isSelected) {
                        const generalInput = document.querySelector("#amountInput");
                        if (generalInput) generalInput.value = "";
                    }

                    calculateTotal();
                });
            }

            // Initial call
            calculateTotal();
        });
    </script>

    <!-- <script>
        // Helper function to get total for a category
        function getCategoryAmount(category) {
            let sum = 0;

            // Manual input
            const manualField = amountFields.find(f => f.category === category);
            if (manualField) {
                sum += getInputValue(manualField.selector);
            }

            // Presets
            const selector = presetFields[category];
            if (selector) {
                document.querySelectorAll(selector).forEach(el => {
                    if (el.classList.contains("selected")) {
                        const val = parseFloat(el.value);
                        if (!isNaN(val)) sum += val;
                    }
                });
            }
            return sum;
        }

        // Update hidden fields for PHP
        document.querySelector('input[name="categories[Education]"]').value = getCategoryAmount("Education");
        document.querySelector('input[name="categories[Health]"]').value = getCategoryAmount("Health");
        document.querySelector('input[name="categories[Women Empowerment]"]').value = getCategoryAmount("Women Empowerment");
        document.querySelector('input[name="categories[Child Rehabilitation]"]').value = getCategoryAmount("Child Rehabilitation");
        document.querySelector('input[name="categories[Armed Forces]"]').value = getCategoryAmount("Armed Forces");
        document.querySelector('input[name="categories[General]"]').value = getInputValue("#amountInput");

    </script> -->
    <script>
        document.querySelector('donation-form').addEventListener('submit', function (e) {
            const amountField = this.querySelector('input[name="amount"]');

            if (!amountField.value || amountField.value.trim() === "" || amountField.value === "0") {
                e.preventDefault();  // stop form submission
                alert("PLS SELECT AT LEAST ONE CAUSE AND SPECIFY DONATION AMOUNT.");
                amountField.focus();
            } else {

                logDonationDetails();
            }
        });
    </script>

    <script>

        function logDonationDetails() {
            const donationRows = document.querySelectorAll('.row.pb-4');
            const donationInformation = document.getElementById("donationInfo");
            const donationDetails = [];
            let totalAmount = 0;

            donationRows.forEach(row => {
                const heading = row.querySelector('h4');
                if (!heading) return;

                const headingText = heading.textContent.trim();
                let rowAmount = 0;

                const selectedPresets = row.querySelectorAll('input[readonly].selected');
                selectedPresets.forEach(preset => {
                    const amount = parseFloat(preset.value || 0);
                    if (!isNaN(amount)) {
                        rowAmount += amount;
                    }
                });

                const customInputs = row.querySelectorAll('input[type="text"]:not([readonly])');
                customInputs.forEach(input => {
                    if (input.placeholder === "Any Other Amount" && input.value) {
                        const amount = parseFloat(input.value || 0);
                        if (!isNaN(amount)) {
                            rowAmount += amount;
                        }
                    }
                });

                if (rowAmount > 0) {
                    donationDetails.push({
                        heading: headingText,
                        amount: rowAmount
                    });
                    totalAmount += rowAmount;
                }
            });

            donationDetails.push({
                heading: "TOTAL DONATION",
                amount: totalAmount
            });


            donationInformation.value = JSON.stringify(donationDetails);
            sessionStorage.setItem('donationDetails', JSON.stringify(donationDetails));

            console.log("=== DONATION DETAILS ===");
            donationDetails.forEach(detail => {
                console.log(`${detail.heading}: ₹${detail.amount}`);
            });
            console.log("=======================");

            return JSON.stringify(donationDetails);
        }



    </script>

</body>

</html>