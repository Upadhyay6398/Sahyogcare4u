<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahyog Care For You - Our mission is to rescue, rehabilitate, and empower children with education and a safe
        environment.
  <link rel="icon" href="images/favicons.png" type="image/x-icon">
    </title>
    <?php include("./includes/top.php") ?>
    <style>
        .donation-list li {
            margin-bottom: 10px;
            list-style: none;
        }

        .addtocart {
            color: blue;
            cursor: pointer;
            margin-left: 10px;
        }

        table {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #999 !important;
            padding: 10px;
            text-align: left;
            font-size: 13px;
        }

        /* td{
            border: 1px solid #999 !important;

        } */
         .gallery-img{
            padding: 5px;
            border: 1px solid #999 !important;
         }
         .gallery-sec{
            margin-top: 80px;
         }
             .hidden-gallery { display: none; opacity: 0; transform: translateY(20px); }
    .fade-in { display: block !important; opacity: 1 !important; transform: translateY(0) !important; }

    .dbtn1{
        border: none !important;
    }
             
        .headding4 {
            font-size: 22px;
            text-align: left;
            margin: 20px 0 0;
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
    <div class="contact-banner-sec mt-4">
        <h1 class="text-center text-bold child-labour-heading">Carrying the weight of tools instead of a schoolbag <br>
            — but your support can change this</h1>
    </div>


    <div class="impact-sec child-labour-head">
        <div class="impact-img top">
            <img src="images/torn.png" class="img-fluid w-100" alt="">
        </div>
         
    </div>
     

    <div class="donate-info donate-info-emergency mt70">
         <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="program-content">
                        <div class="program-image-cover">
                            <div class="swiper child-labour">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="images/flood-punjab-himachal.jpg" class="img-fluid" alt="">
                                    </div>


                                    <!--
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
-->
                                </div>
                            </div>
                            <?php
                            // All URLs to be included
                            $slugs = [
                                "/child-labour2.php",

                                "/child-labour2.phputm_sourcefacebook_and_instagramutm_mediumvideoutm_campaignretargetutm_termchild_rescuefbclidIwY2xjawLkEIhleHRuA2FlbQIxMABicmlkETFaeUpjNnZPbEpvamZDRjdZAR5j_Sn73iyOkC4YjW7sszfXeo60dJZA-siUdxxVhwWa5tfAl97uP7WM_Xd_jg_aem_7vumyaEgg6JXil0yY-_FqA",
                                "/child-labour2.phputm_sourcefacebook_instagramutm_mediumvideoutm_campaigntrafficutm_termchild_rescue_and_rehabilitationutm_contentdonate_nowfbclidIwY2xjawLhkcVleHRuA2FlbQIxMABicmlkETFXRkFQZEtVdkJYTWM2dFBPAR5kybtNbqmrqiEHA1SdIwwYccx10I-MQPQxQT7E0lMtl59gxvbgUz_4TT71lQ_aem_PDbv-wUoM3nCH50NOJsylw",
                                "/child-labour2.phputm_sourcefacebook_and_instagramutm_mediumvideoutm_campaignsales_conversionutm_termchild_rescueutm_id120227737921580082utm_content120227737922280082fbclidPAZXh0bgNhZW0BMABhZGlkAasjaWXcE4IBp1I_-_JYB4rWwo19DdmvC7m7NfSmRktd95ewFRVniCGyV-FZeuPgI82GpMMD_aem_hxfx-cSPkeG0Eq1UQVqq4g"
                            ];

                            // Base and goal amount (combined)
                            $base_amount = 120893; // Set as needed
                            $goal_amount = 800000; // Set as needed

                            // Format function remains the same
                            function format_in_indian_style( $number ) {
                                $number = ( string )$number;
                                $after_decimal = '';

                                if ( strpos( $number, '.' ) !== false ) {
                                    list( $number, $after_decimal ) = explode( '.', $number );
                                    $after_decimal = '.' . $after_decimal;
                                }

                                $last3 = substr( $number, -3 );
                                $rest = substr( $number, 0, -3 );

                                if ( $rest != '' ) {
                                    $rest = preg_replace( "/\B(?=(\d{2})+(?!\d))/", ",", $rest );
                                    $number = $rest . ',' . $last3;
                                } else {
                                    $number = $last3;
                                }

                                return $number . $after_decimal;
                            }

                            // Fetch combined donation from DB
                            $total_db_raised = 0;

                            if ( !empty( $slugs ) ) {
                                $placeholders = implode( ',', array_fill( 0, count( $slugs ), '?' ) );
                                $payment_sql = "SELECT SUM(amount) as total_raised FROM payments WHERE `source` IN ($placeholders) AND payment_status = 'success'";

                                try {
                                    $payment_stmt = $DB->DB->prepare( $payment_sql );
                                    foreach ( $slugs as $index => $slug ) {
                                        $payment_stmt->bindValue( $index + 1, $slug, PDO::PARAM_STR );
                                    }
                                    $payment_stmt->execute();

                                    $payment_data = $payment_stmt->fetch( PDO::FETCH_ASSOC );
                                    $total_db_raised = $payment_data[ 'total_raised' ] ? ? 0;
                                } catch ( PDOException $e ) {
                                    echo "Database error: " . $e->getMessage();
                                }
                            }

                            $total_raised = $base_amount + $total_db_raised;
                            $percent_raised = $goal_amount > 0 ? min( 100, round( ( $total_raised / $goal_amount ) * 100 ) ) : 0;
                            ?>

                            <!-- Display the single combined progress bar -->
                            <div class="col-md-12 px-5">
                                <div class="raiser-bar">
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo $percent_raised; ?>%;
                        background-color: <?php echo ($percent_raised < 30) ? '#dc3545' : (($percent_raised < 70) ? '#ffc107' : '#28a745'); ?>;" aria-valuenow="<?php echo $percent_raised; ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?php echo $percent_raised; ?>%
                                        </div>
                                    </div>
                                </div>

                                <div class="raised-money-data mt-2">
                                    <p>
                                        <span>₹
                                        <?php echo format_in_indian_style($total_raised); ?>
                                    </span>
                                        <i>raised of ₹
                                        <?php echo format_in_indian_style($goal_amount); ?> goal
                                    </i>
                                    </p>
                                </div>
                            </div>


                            <div class="program-inner-text">

                                <p>Sahyog Care For You stands with the flood-affected families of Punjab and Haryana who have lost their homes, livelihoods, and access to basic necessities. Thousands are struggling for food, clean water, and essential items to survive this crisis. 🙏 Your support can bring hope and relief to these families. Together, we can ensure no one sleeps hungry or thirsty in this hour of need. 💙 Please donate generously and be the reason someone finds strength today.</p>



                                <div class="row">
                                    <div class="col-md-7">

                                        <h4 class="headding4"><strong>FOR ONLINE DONATION</strong></h4>
                                        <p>Sahyog Care For You<br> A/c 924010067539570<br> IFSC UTIB0000533<br> Axis&nbsp;bank

                                        </p>
                                        <p class="mt-2">For details, contact at &#x202A;<a href="tel:+91-7983666348">+91-7983666348 </a>
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <h4 class="headding4"><strong>PAY USING ANY UPI APP</strong></h4>
                                        <img src="images/sahyog-care-qr-code.jpg" alt="Sahyog">
                                    </div>
                                </div>

                                <div class="items-sec">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="headding4"><strong> Items to be delivered in flood affected areas of Punjab and Himachal</strong></h4>
                                        </div>

                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>


                                                        <th scope="col">Items </th>
                                                        <th scope="col">Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>


                                                        <td>Sanitary Napkins
                                                        </td>
                                                        <td>2000 Packet
                                                        </td>
                                                    </tr>
                                                    <tr>


                                                        <td>Baby Diapers
                                                        </td>
                                                        <td>400 Packet
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Tarpaulin

                                                        </td>
                                                        <td>1000 pieces

                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Tarpaulin

                                                        </td>
                                                        <td>1000 pieces

                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Bucket


                                                        </td>
                                                        <td>1000 pieces


                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Sleepers


                                                        </td>
                                                        <td>1000 pieces

                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Sleepers


                                                        </td>
                                                        <td>1000 pieces

                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Soap
                                                        </td>
                                                        <td>1000 pieces

                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>


                                                        <th scope="col">Items </th>
                                                        <th scope="col">Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>


                                                        <td>Dal

                                                        </td>
                                                        <td>1000 kg
                                                        </td>
                                                    </tr>
                                                    <tr>


                                                        <td>Rice

                                                        </td>
                                                        <td>1000 kg.

                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Atta


                                                        </td>
                                                        <td>1000 sack 10kg each


                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Shirts


                                                        </td>
                                                        <td>1000 pieces


                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Pants



                                                        </td>
                                                        <td>1000 pieces



                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Utensil Plates



                                                        </td>
                                                        <td>2000 pieces


                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Bowl (katori)



                                                        </td>
                                                        <td>4000 pieces


                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Spoon

                                                        </td>
                                                        <td>2000 pieces


                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>Drinking glass


                                                        </td>
                                                        <td>2000 pieces



                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="program-sidebar">
                        <form method="post" id="donation-btn" data-parsley-validate action="generateCCHash.php">
                            <input type="hidden" name="source" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                            <?php  
                              $utm_source = isset($_GET['utm_source']) ? htmlspecialchars($_GET['utm_source']) : '';
                            ?>

                            <?php  
                              $utm_campaign = isset($_GET['utm_campaign']) ? htmlspecialchars($_GET['utm_campaign']) : '';
              
                              
                            
                            ?>
                            <input type="hidden" name="utm_source" value="<?php echo $utm_source; ?>">
                            <input id="amountInput" name="amount" class="form-control program-input mt-3 mb-3" placeholder="Custom Amount" type="text" inputmode="numeric" data-parsley-type="digits" data-parsley-pattern-message="Please enter a valid Amount" data-parsley-required="true" autocomplete="off" oninput="this.value = this.value.replace(/\D/g, '')">

                            <input id="name" name="name" class="form-control program-input mb-3" placeholder="Name" type="text" required>

                            <input id="mobile" name="mobile" class="form-control program-input mb-3" placeholder="Mobile Number" inputmode="numeric" data-parsley-type="digits" type="text" maxlength="10" minlength="10" data-parsley-pattern-message="Please enter a valid Mobile Number" data-parsley-required="true" autocomplete="off" oninput="this.value = this.value.replace(/\D/g, '')">

                            <input id="email" name="email" class="form-control program-input mb-3" placeholder="Email" type="email" required>

                            <input id="name" name="pan_number" class="form-control program-input mb-3" placeholder="PAN Number" type="text">

                            <!--<p><strong>*Required for tax exemption</strong></p>-->

                            <div class="secure-payments-text secure-payments-text-program mx-3 mt-2">
                                <span class="secure-payments-icon">🔒</span> Your payments are secured with CCAvenue
                            </div>

                            <div class="text-center">
                                <button type="submit" class="sidebar-submit-btn proram-submit ">UPI Donations</button>
                                <button type="submit" class="sidebar-submit-btn proram-submit mt-3">Credit Card/Debit Card/Net Banking</button>

                            </div>
                        </form>
                        <div class="col-md-12 mt-3">
                            <div class="borderbox">
                                <div class="row">
                                    <div class="col-3 d-flex align-items-center">
                                        <a style="color: #2f2f2f;" class="donate-whatsapp" href="https://api.whatsapp.com/send?phone=918860989205&amp;text=&amp;source=&amp;data=">
                                            <img class="w-100" src="https://sahyogcare4u.org/images/whatsapp3.png"
                                                alt="WhatsApp">
                                        </a>
                                    
                                    </div>
                                    <div class="col-9 ps-0">
                                        <p class="mb-0">If you wish to know more about the case, contact us on WhatsApp at
                                            <a style="color: #2f2f2f; display: inline-block; text-decoration: underline;" class="donate-whatsapp" href="https://api.whatsapp.com/send?phone=918860989205&amp;text=&amp;source=&amp;data=">
                                                8860989205
                                            </a>
                                        
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="borderbox mb-2 mt-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="mb-0">Call us at
                                            <a href="tel:+918860989205" class="text-dark">+91-8860989205</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="side-bar-qr mt-3">
                                <img src="images/sahyogcare4u-qr-child-labour.jpeg" alt="" style='display:none'>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="impact-img bottom">
                <img src="images/torn.png" class="img-fluid w-100" alt="">
            </div>
        </div>
    </div>
    <button class="child-labour-btn"> <a href="#donation-btn">DONATE</a> </button>
    <?php include("./includes/footer-child-labour.php") ?>
    <?php include("./includes/script.php") ?>
    <script>
        const cart = {};

        function updateCartTable() {
            const tbody = document.querySelector("#cartTable tbody");
            tbody.innerHTML = "";
            let totalAmount = 0;

            for (const itemName in cart) {
                const item = cart[itemName];
                const row = document.createElement("tr");
                const itemTotal = item.price * item.quantity;
                totalAmount += itemTotal;

                row.innerHTML = `
      <td>${itemName}</td>
      <td>₹ ${item.price}</td>
      <td>${item.quantity}</td>
      <td>₹ ${itemTotal}</td>
    `;
                tbody.appendChild(row);
            }

            document.getElementById("totalAmount").innerText = `₹ ${totalAmount}`;

            const amountInput = document.getElementById("amountInput");
            if (amountInput) {
                amountInput.value = totalAmount;
            }
        }

        // For donation list items
        document.querySelectorAll(".donation-list li").forEach((listItem) => {
            const addToCartBtn = listItem.querySelector(".addtocart");
            const quantityControls = listItem.querySelector(".quantity-controls");

            if (addToCartBtn) {
                addToCartBtn.addEventListener("click", () => {
                    const name = listItem.getAttribute("data-name");
                    const price = parseInt(listItem.getAttribute("data-price"));

                    cart[name] = {
                        price,
                        quantity: 1
                    };
                    updateCartTable();

                    addToCartBtn.style.display = "none";
                    if (quantityControls) {
                        quantityControls.style.display = "inline-block";
                        quantityControls.querySelector(".qty").innerText = 1;
                    }
                });
            }

            if (quantityControls) {
                const increaseBtn = quantityControls.querySelector(".increase");
                const decreaseBtn = quantityControls.querySelector(".decrease");
                const qtyDisplay = quantityControls.querySelector(".qty");

                increaseBtn.addEventListener("click", () => {
                    const name = listItem.getAttribute("data-name");
                    cart[name].quantity += 1;
                    qtyDisplay.innerText = cart[name].quantity;
                    updateCartTable();
                });

                decreaseBtn.addEventListener("click", () => {
                    const name = listItem.getAttribute("data-name");
                    if (cart[name].quantity > 1) {
                        cart[name].quantity -= 1;
                        qtyDisplay.innerText = cart[name].quantity;
                    } else {
                        delete cart[name];
                        quantityControls.style.display = "none";
                        addToCartBtn.style.display = "inline-block";
                    }
                    updateCartTable();
                });
            }
        });

        // For swiper-slide items (another section, e.g. "You Can Select & Donate individual Ration Item")
        document.querySelectorAll(".swiper-slide").forEach((slide) => {
            const addToCartBtn = slide.querySelector(".addtocart2");
            const quantityControls = slide.querySelector(".quantity-controls");
            const qtyDisplay = quantityControls?.querySelector(".qty");
            const increaseBtn = quantityControls?.querySelector(".increase");
            const decreaseBtn = quantityControls?.querySelector(".decrease");

            if (addToCartBtn) {
                addToCartBtn.addEventListener("click", () => {
                    const name = slide.getAttribute("data-name");
                    const price = parseInt(slide.getAttribute("data-price"));

                    if (cart[name]) {
                        cart[name].quantity += 1;
                    } else {
                        cart[name] = {
                            price,
                            quantity: 1
                        };
                    }
                    updateCartTable();

                    addToCartBtn.style.display = "none";
                    if (quantityControls) {
                        quantityControls.style.display = "inline-block";
                        qtyDisplay.innerText = cart[name].quantity;
                    }
                });
            }

            if (increaseBtn) {
                increaseBtn.addEventListener("click", () => {
                    const name = slide.getAttribute("data-name");
                    if (cart[name]) {
                        cart[name].quantity += 1;
                        qtyDisplay.innerText = cart[name].quantity;
                        updateCartTable();
                    }
                });
            }

            if (decreaseBtn) {
                decreaseBtn.addEventListener("click", () => {
                    const name = slide.getAttribute("data-name");
                    if (cart[name]) {
                        if (cart[name].quantity > 1) {
                            cart[name].quantity -= 1;
                            qtyDisplay.innerText = cart[name].quantity;
                        } else {
                            delete cart[name];
                            quantityControls.style.display = "none";
                            addToCartBtn.style.display = "inline-block";
                        }
                        updateCartTable();
                    }
                });
            }
        });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/interact.js/1.10.11/interact.min.js"></script>
    <script>
        const clippings = [
            // 'https://sahyogcare4u.org/images/child-labour-news-1.jpg',
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

                img.onload = function () {
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
      <script>
    const seeAllBtn = document.getElementById('seeAllBtn');
    seeAllBtn.addEventListener('click', () => {
      document.querySelectorAll('.gallery-block.hidden-gallery').forEach(el => {
        el.classList.add('fade-in');
        el.classList.remove('hidden-gallery');
      });
      seeAllBtn.style.display = 'none';
    });
  </script>
</body>

</html>