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
                <li><a id="disable" href="checkout.php">
                  <img src="images/svg/checkout.png" alt="check-out">
                </a></li>
                <li><a  id="disable"href="place-order.php">
                  <img src="images/svg/placeorder.png" alt="place-order">
                </a></li> 
                <li><a  id="disable"href="payment.php">
                  <img src="images/svg/paynow.png" alt="payment">
                </a></li> 
            </ul>            
        </div>

        <div class="process-label">
            <p>Step 1: Customize Order</p>
        </div>

    </div>

    
    <div class="process-order-container">
        <div class="desired-cake-design-con">

            <h5>Upload Your Desired Cake Design</h5>

            <div class="desired-cake-design">

                <div class="upload-image">
                    <img class="upload-image-icon" src="images/svg/icons8-album-100.png" alt="">
                    <h5><b>Drop Your Image Here</b></h5>
                    <h6> or <a href=""><u><b>browse</b></u></a> local files </h6>
                </div>
                <div class="upload-image">
                    <img class="upload-image-icon" src="images/svg/icons8-album-100.png" alt="">
                    <h5><b>Drop Your Image Here</b></h5>
                    <h6> or <a href=""><u><b>browse</b></u></a> local files </h6>
                </div>
                <div class="upload-image">
                    <img class="upload-image-icon" src="images/svg/icons8-album-100.png" alt="">
                    <h5><b>Drop Your Image Here</b></h5>
                    <h6> or <a href=""><u><b>browse</b></u></a> local files </h6>
                </div>

            </div>

        </div>

        <!-- Upload desired cake design -->        
        <div class="cust-sel-opt-con">
            <div class="cust-sel-opt">
                <label for="cake-size">Size:</label>
                <select name="cake-size" id="cake-size">
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
            </div>
            <div class="cust-sel-opt">
                <label for="flavor">Flavor:</label>
                <select name="flavor" id="flavor">
                    <option value="chocolate">Chocolate</option>
                    <option value="vanilla">Vanilla</option>
                    <option value="strawberry">Strawberry</option>
                </select>
            </div>
            
            <br>

            <div class="cust-sel-opt">
                <input type="checkbox" id="enable-toppers" onchange="toggleToppers()">
                <label for="enable-toppers">Topper(s)</label>
                <select name="toppers" id="toppers" disabled>
                    <option value="none">None</option>
                    <option value="flowers">Flowers</option>
                    <option value="stars">Stars</option>
                    <option value="hearts">Hearts</option>
                </select>
            </div>

            <div class="cust-sel-opt">
                <input type="checkbox" id="enable-money-cake" onchange="toggleMC()">
                <label for="enable-money-cake">Money Cake</label>
                <input type="number" name="money-cake-amount" id="money-cake-amount" placeholder="amount" disabled>
                
                <div class="info-tooltip-icon">
                    <div class="tip">
                        <div class="icon">?</div>
                        <div class="tooltiptext">Tick the box to enter the amount of money you want to include.</div>
                    </div>
                </div>
            </div>

        </div>


        <div class="cust-dedication-con">

            <div class="cust-dedication-opt1">
                <input type="checkbox" id="enable-dedication" onchange="toggleDedication()">
                <label for="enable-dedication">Want to add Dedication to your Cake?</label>
            </div>

            <div class="cust-dedication-opt2">
                <textarea class="input-fields" name="dedication" id="dedication" cols="30" rows="3" placeholder="Enter Dedication" class="input" disabled maxlength="50"></textarea>
                <span id="charCount"></span>

                <div class="info-tooltip-icon">
                    <div class="tip">
                        <div class="icon">i</div>
                        <div class="tooltiptext">Sample dedication: "Happy Birthday Jay!" Love: Mama </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="cust-note-con">

            <label for="enable-note"><b>Leave a Note</b> <i>(optional)</i> </label>

            <textarea class="input-fields" name="note" id="note" cols="30" rows="6" placeholder="Requesting Something? Leave note and we'll do our best to make it happen:)" class="input" maxlength="500"></textarea><!-- text input box for note, suggestion, recommendation, or requests -->
            <span id="NotecharCount"></span>

        </div>


        <div class="checkout-btn-con">
            <button class="checkout-btn">Proceed to Checkout</button>
        </div>        


    </div>

  </section>
  <script>
            function toggleToppers() {
            var toppersSelect = document.getElementById("toppers");
            var enableToppersCheckbox = document.getElementById("enable-toppers");
            toppersSelect.disabled = !enableToppersCheckbox.checked;
            }

            function toggleMC() {
            var moneyCakeAmountInput = document.getElementById("money-cake-amount");
            var enableMoneyCakeCheckbox = document.getElementById("enable-money-cake");
            moneyCakeAmountInput.disabled = !enableMoneyCakeCheckbox.checked;
            }

            function toggleDedication() {
            var dedicationInput = document.getElementById("dedication");
            var enableDedicationCheckbox = document.getElementById("enable-dedication");
            dedicationInput.disabled = !enableDedicationCheckbox.checked;
            }

            $(document).ready(function() {
                $('#dedication').keyup(function() {
                    var text_length = $('#dedication').val().length;
                    var text_remaining = 50 - text_length;

                    $('#charCount').html(text_length + ' / 50');
                });
            });

            $(document).ready(function() {
                $('#note').keyup(function() {
                    var text_length = $('#note').val().length;
                    var text_remaining = 500 - text_length;

                    $('#NotecharCount').html(text_length + ' / 500');
                });
            });
        </script>


<?php include('partials/footer.php'); ?>