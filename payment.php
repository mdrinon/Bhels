<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>

<section class="main-content">
    <div class="process-order-container">

        <div class="po-nav-con">
            <ul class="po-nav">
                <li><a id="enable" href="customize.php">
                  <img src="images/svg/customize.png" alt="customize">
                </a></li>
                <li><a id="enable" href="checkout.php">
                  <img src="images/svg/checkout.png" alt="check-out">
                </a></li>
                <li><a id="enable" href="place-order.php">
                  <img src="images/svg/placeorder.png" alt="place-order">
                </a></li> 
                <li><a id="enable" href="payment.php">
                  <img src="images/svg/paynow.png" alt="payment">
                </a></li> 
            </ul>            
        </div>

        <div class="process-label">
            <p>Step 4: Confirm Payment</p>
        </div>

    </div>


    <div class="process-order-container">
        <div class="payment-container">
            <div class="payment__con__info">
                <div class="qr-code-container">
                    <h2>Payment Method</h2>
                    <img class="gcash-logo" src="ADMIN/images/gcash-logo.png" alt="">
                    <?php
                    // Path to the QR code image uploaded by the administrator
                    $qrCodePath = 'ADMIN/uploads/QRcode/QRcode.jpeg'; // Update this path as necessary
                    ?>
                    <img src="<?php echo $qrCodePath; ?>" alt="QR Code" class="qr-code">
                    <div class="receiver-details">
                        <h2 class="reciever__name"><strong>Ma*k R.</strong></h2>
                        <p>09171234567</p>

                    </div>
                </div>
            </div>
            

            <div class="receipt-upload-container">
                <div class="live__folder">
                    <div class="folder__front-side">
                    <div class="folder__tip"></div>
                    <div class="folder__cover"></div>
                    </div>
                    <div class="folder__back-side folder__cover"></div>
                </div>
                <label class="receipt-file-upload">
                    <input class="title" type="file" id="receipt-input" accept="image/*" />Upload Receipt
                    <span id="receipt-filename" style="display: none;">receipt_filename.jpg</span>
                </label>
            </div>


            <div class="uploaded_receipt_container" id="uploaded_receipt_container" style="display: none;">

                <!-- File preview -->
                <div id="receipt_preview" class="preview-container" style="display: none;">
                    <button id="remove_receipt" class="remove-btn">&times;</button>
                    <img src="" alt="Receipt Preview" class="receipt-image" id="receipt-image" />
                </div>

                <!-- Confirm payment button -->
                <button id="confirm_payment" class="confirm-payment-btn" onclick="completeOrder()" >Confirm Payment</button>
            </div>

        </div>


        <div class="order_successful_overlay" style="display: none;">
            <div class="order_successful_card"> 
                <!-- <button type="button" class="order_successful_dismiss_btn">×</button> -->
                <!-- ten seconds countdown display -->
                <div id="countdown" class="order_successful_dismiss_btn"></div>
                <div class="order_successful_header"> 
                    <div class="order_successful_image">
                        <img src="admin/images/svg/order-processing.png" alt="">
                    </div> 
                    <div class="order_successful_content">
                        <span class="order_successful_title">Processing Order</span> 
                        <p class="order_successful_message">Your order is currently being processed, and we are validating your payment. We will notify you once everything is confirmed. Thank you for your patience.</p> 
                    </div> 
                    <div class="order_successful_actions">
                        <button type="button" class="check__status__btn">Check Order Status</button> 
                        <button type="button" class="create__order__btn">Create another Order</button> 
                    </div> 
                </div> 
            </div>
        </div>
    </div>

</section>

<script>
    const confirmPaymentButton = document.getElementById('confirm_payment');
    const overlay = document.querySelector('.order_successful_overlay');
    // const dismissButton = document.querySelector('.order_successful_dismiss_btn');

    // When "Confirm Payment" is clicked, show the overlay
    confirmPaymentButton.addEventListener('click', function () {
        overlay.style.display = 'flex'; // Show the overlay
    });

    // // Close the overlay when the dismiss button is clicked
    // dismissButton.addEventListener('click', function () {
    //     overlay.style.display = 'none'; // Hide the overlay
    // });

    // Optional: Close the overlay when clicking outside the overlay card
    overlay.addEventListener('click', function (event) {
        if (event.target === overlay) {
            overlay.style.display = 'none'; // Hide the overlay if the background is clicked
        }
    });

</script>

<script>
    const receiptInput = document.getElementById('receipt-input');
    const receiptFilename = document.getElementById('receipt-filename');
    const uploadedReceiptContainer = document.getElementById('uploaded_receipt_container');
    const receiptPreviewContainer = document.getElementById('receipt_preview');
    const receiptImage = document.getElementById('receipt-image');
    const removeReceiptButton = document.getElementById('remove_receipt');

    receiptInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            // Check if the selected file is an image
            if (file.type.startsWith('image/')) {
                // Get file extension
                const fileExtension = file.name.split('.').pop();

                // Generate current date and time string
                const currentDate = new Date();
                const timestamp = currentDate.getFullYear() + '-' +
                                  ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' +
                                  ('0' + currentDate.getDate()).slice(-2) + '_' +
                                  ('0' + currentDate.getHours()).slice(-2) + '-' +
                                  ('0' + currentDate.getMinutes()).slice(-2) + '-' +
                                  ('0' + currentDate.getSeconds()).slice(-2);

                // Create the new filename with the date-time and file extension
                const newFilename = `receipt_${timestamp}.${fileExtension}`;

                // Display the new file name
                receiptFilename.textContent = newFilename;
                receiptFilename.style.display = 'inline'; // Show the new file name
                receiptInput.nextSibling.textContent = ''; // Hide "upload receipt" text

                // Display the image preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    receiptImage.src = e.target.result;
                    receiptPreviewContainer.style.display = 'block'; // Show the preview container
                };
                reader.readAsDataURL(file);

                // Show the uploaded_receipt_container
                uploadedReceiptContainer.style.display = 'block';
            } else {
                alert('Please upload an image file.');
                receiptInput.value = ''; // Reset the input if it's not an image
            }
        } else {
            // Hide the uploaded_receipt_container if no file is selected
            uploadedReceiptContainer.style.display = 'none';
        }
    });

    // Handle removing the uploaded receipt
    removeReceiptButton.addEventListener('click', function() {
        receiptInput.value = ''; // Clear the file input
        receiptInput.nextSibling.textContent = 'upload receipt'; // Show "upload receipt" text again
        receiptFilename.style.display = 'none'; // Hide the file name
        receiptPreviewContainer.style.display = 'none'; // Hide the preview container
        receiptImage.src = ''; // Remove the image source

        // Hide the uploaded_receipt_container
        uploadedReceiptContainer.style.display = 'none';
    });


    
    function completeOrder() {
        // Clear order data from both storages
        sessionStorage.removeItem('orderDetails');
        localStorage.removeItem('orderDetails');

        console.log('Order data cleared from sessionStorage and localStorage');

        // Start the countdown when the button is clicked
        startCountdown();

        // Add a delay to simulate processing time and display the '.order_successful_overlay' within 10 seconds before redirecting to Orders.php page
        setTimeout(() => {
        document.querySelector('.order_successful_overlay').style.display = 'flex';
        window.location.href = 'orders.php';
        }, 11000);
    }



    function startCountdown() {
        // Set the countdown time (in seconds)
        let timeLeft = 10;

        // Log the initial time to the console for debugging
        console.log(`Initial time: ${timeLeft}`);

        // Update the countdown every second
        const countdown = setInterval(() => {
        document.getElementById("countdown").innerText = timeLeft;
        console.log(`Countdown at: ${timeLeft}`); // Log current time to console

        // Decrement the time left by 1 second
        timeLeft--;

        // Stop the countdown when timeLeft reaches 0
        if (timeLeft < 1) {
            clearInterval(countdown);
            document.getElementById("countdown").innerText = "0";
            console.log("Countdown finished.");
        }
        }, 1000); // Update every 1000 milliseconds (1 second)
    }

</script>

<?php include('partials/footer.php'); ?>
