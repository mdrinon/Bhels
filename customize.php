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
        <div class="customizing_order_container">
  
            <div id="survey-section" class="question_pop_up_container">
                <!-- Back Arrow -->
                <div class="qpp__back-arrow" id="qpp__back-arrow" onclick="goBack()">← Back</div>

                <!-- First Question -->
                <div class="qpp__form-group qpp__active" id="question1">
                    <label class="qpp__question-label">How would you like to place your order?</label>
                    <div class="qpp__btn-group">
                        <button class="qpp__btn-option" onclick="nextQuestion(2)">Customize my own cake</button>
                        <button class="qpp__btn-option" onclick="confirmRedirect()">Browse cakes and checkout</button>
                    </div>
                </div>

                <!-- Second Question -->
                <div class="qpp__form-group" id="question2">
                    <label class="qpp__question-label">Do you have a specific budget you'd like to stay within for your cake?</label>
                    <!-- Budget Selection Option -->
                    <div class="qpp__btn-group">
                        <label for="budget-select" class="qpp__question-label" style="font-weight: 100; margin: 10px 0">Select from Price Range:</label>
                        <div class="qpp__dropdown-group">
                            <select class="qpp__price-range-option" id="budget-select" class="qpp__dropdown" onchange="toggleContinueButton()">
                                <option value="" disabled selected>Select your budget</option>
                                <option value="500-999">₱500 - ₱999</option>
                                <option value="1000-1999">₱1000 - ₱1999</option>
                                <option value="2000-2999">₱2000 - ₱2999</option>
                                <option value="3000+">Above ₱3000</option>
                                <option value="flexible">Choose by servings or size</option>
                            </select>
                            <button id="continue-budget-btn" class="qpp__btn-option" onclick="nextQuestion(3)" style="display: none;">
                                Continue
                            </button>
                        </div>
                    </div>

                    <div id="filtered-cake-selections" class="qpp__filtered__selection__table" style="display: none;">
                        <h4>Available Cakes:</h4>
                        <div id="filter__single__cake__label"><h5>(Single Cakes)</h5></div>
                        <div id="filtered-single-cakes">
                            <?php
                                // MongoDB connection setup
                                require 'vendor/autoload.php'; // Ensure you have the MongoDB library installed

                                $client = new MongoDB\Client("mongodb://localhost:27017");
                                $collection = $client->bheldb->cake_sizes;

                                // Query the collection to find single cake prices
                                $singleCakes = $collection->find(['type' => 'single']);

                                // Loop through the query result and output HTML for each cake size
                                foreach ($singleCakes as $cake) {
                                    foreach ($cake['sizes'] as $size) {
                                        // Convert the BSONArray to a standard PHP array
                                        $sizeArray = (array) $size['size'];

                                        // Format the size for the alt text (remove quotes and join with ' x ')
                                        $dimensions = implode(' x ', $sizeArray);

                                        // Fetch the image path directly from the database
                                        $imagePath = $size['image_path']; // Use the image path from the database

                                        // Output the HTML for each cake option
                                        echo '
                                        <div id="qpp__filtered__cake__size" class="cake-option" data-size=\''.json_encode($sizeArray).'\' data-price="'.$size['price'].'" style="display: none;">
                                            <div id="checkmark" class="checkmark">✔</div>
                                            <img id="qpp__svg__cake__img" src="'.$imagePath.'" alt="'.$dimensions.' Single Cake" class="qpp__svg__cake__img">
                                            <p>₱'.$size['price'].' above</p>
                                        </div>';

                                    }
                                }
                            ?>

                        </div>

                        <div id="filter__tiered__cake__label"><br><h5>(Tiered Cakes)</h5></div>
                        <div id="filtered-tiered-cakes">
                            
                            <div class="qpp__cake__selection__table"> <!-- removed the id="tiered__cake" due to conflicts, there's already a container with the same id-->
                            <?php
                                // MongoDB connection setup
                                require 'vendor/autoload.php'; // Ensure you have the MongoDB library installed

                                $client = new MongoDB\Client("mongodb://localhost:27017");
                                $collection = $client->bheldb->cake_sizes;

                                // Query the collection to find tiered cake prices
                                $tieredCakes = $collection->find(['type' => 'tiered']);
                                // Loop through the query result and output HTML for each cake size
                                foreach ($tieredCakes as $cake) {
                                    foreach ($cake['sizes'] as $size) {
                                        // Convert the BSONArray to a standard PHP array
                                        $tiersArray = (array) $size['tiers'];

                                        // Format tiers for the alt text (remove quotes and join with ' & ')
                                        $tiers = implode(' & ', $tiersArray);

                                        // Fetch the image path directly from the database
                                        $imagePath = $size['image_path']; // Use the image path from the database

                                        // Output the HTML for each cake option
                                        echo '
                                        <div id="qpp__svg__cake__size" class="cake-option" data-size=\''.json_encode($tiersArray).'\' data-price="'.$size['price'].'"  style="display: none;">
                                            <div class="checkmark">✔</div>
                                            <img id="qpp__svg__cake__img" src="'.$imagePath.'" alt="'.$tiers.' Tiered Cake" class="qpp__svg__cake__img">
                                            <p>₱'.$size['price'].' above</p>
                                        </div>';
                                    }
                                }
                            ?>
                            </div>
                        </div>
                    </div>


                    <div class="qpp__cake__tiers_option" style="display:none">
                        <div class="tiered-cake-selection">
                            <div class="qpp__desired__cake__selection">
                                <label for="tiered-cake-select" class="qpp__question-label" style="font-weight: 100;">
                                    What is your Desired Cake:
                                </label>
                                <select class="qpp__tiered-cake-option qpp__dropdown" id="tiered-cake-select">
                                    <option value="" disabled selected>Select your desired cake</option>
                                    <option value="tiered">Tiered Cake</option>
                                    <option value="single">Single Cake</option>
                                </select>
                            </div>
                            <div id="single__cake" class="single__cake" style="display: none;">
                                <div class="cust-sel-opt-con">
                                    <?php
                                        try {
                                            // Include the MongoDB library
                                            require 'vendor/autoload.php'; // Make sure you have the MongoDB library

                                            // Connect to the MongoDB database
                                            $client = new MongoDB\Client("mongodb://localhost:27017");
                                            $cakesCollection = $client->bheldb->pricing;

                                            // Fetch distinct serving sizes and their associated cake sizes
                                            $singleCakesResult = $cakesCollection->find(['type' => 'single']);

                                            // Prepare an array to group sizes under each serving size
                                            $servingSizeGroups = [];

                                            // Organize the data by serving size
                                            foreach ($singleCakesResult as $cake) {
                                                $servingSize = $cake['serving_size'];
                                                $size = $cake['size'];
                                                $price = $cake['price'];

                                                // Group sizes by serving size
                                                if (!isset($servingSizeGroups[$servingSize])) {
                                                    $servingSizeGroups[$servingSize] = [];
                                                }
                                                $servingSizeGroups[$servingSize][] = [
                                                    'size' => $size,
                                                    'price' => $price
                                                ];
                                            }
                                        } catch (Exception $e) {
                                            // Handle connection errors
                                            echo "Unable to connect to the database: ", $e->getMessage();
                                            exit();
                                        }
                                    ?>

                                    <!-- Dropdown Selection -->
                                    <div class="cust-sel-opt"> 
                                        <label for="cake-size">Size:</label>
                                        <select name="cake-size" id="product-size-pricing">
                                            <option value="" disabled selected>Select size based on the amount</option>
                                            <?php foreach ($servingSizeGroups as $servingSize => $cakes): ?>
                                                <optgroup label="<?php echo $servingSize; ?>">
                                                    <?php foreach ($cakes as $cake): ?>
                                                        <option 
                                                            value="<?php echo $cake['size']; ?>" 
                                                            data-size="<?php echo htmlspecialchars($cake['size']); ?>" 
                                                            data-price="<?php echo htmlspecialchars($cake['price']); ?>"
                                                        >
                                                            <?php echo htmlspecialchars($cake['size']) . " - ₱" . htmlspecialchars($cake['price']) . " Above"; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </optgroup>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div id="tiered__cake" class="qpp__cake__selection__table" style="display: none;">
                            <?php
                                // MongoDB connection setup
                                require 'vendor/autoload.php'; // Ensure you have the MongoDB library installed

                                $client = new MongoDB\Client("mongodb://localhost:27017");
                                $collection = $client->bheldb->pricing;

                                // Query the collection to find tiered cake prices
                                $tieredCakes = $collection->find(['type' => 'tiered']);


                                // Loop through the query result and output HTML for each cake size
                                foreach ($tieredCakes as $cake) {
                                    foreach ($cake['sizes'] as $size) {
                                        // Convert the BSONArray to a standard PHP array
                                        $tiersArray = (array) $size['tiers'];

                                        // Format tiers for the alt text (remove quotes and join with ' & ')
                                        $tiers = implode(' & ', $tiersArray);

                                        // Fetch the image path directly from the database
                                        $imagePath = $size['image_path']; // Use the image path from the database

                                        // Output the HTML for each cake option
                                        echo '
                                        <div class="cake-option qpp__svg__cake__size" data-size=\''.json_encode($tiersArray).'\' data-price="'.$size['price'].'">
                                            <div class="checkmark">✔</div>
                                            <img class="qpp__svg__cake__img" src="'.$imagePath.'" alt="'.$tiers.' Tiered Cake" class="qpp__svg__cake__img">
                                            <p>₱'.$size['price'].' above</p>
                                        </div>';
                                    }
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Third Question -->
                <!-- Submit Design Option -->
                <div class="qpp__form-group" id="question3">
                    <form onsubmit="submitDesign(event)">
                        <label class="qpp__question-label">Submit Your Own Design</label>
                        <div class="qpp__design-upload-group">
                            <!-- Input file for design upload -->
                            <label for="design-upload" class="qpp__upload-label" style="font-size: .8rem;">
                                Upload a Reference of your Cake Design (Max: 5 Files):
                            </label>

                            <div class="qpp__file-upload-container qpp__grid__display">
                                <!-- File input field -->
                                <div class="qpp__file-upload">
                                    <input multiple class="qpp__file-input" id="design-upload" name="design-upload" type="file" accept="image/*" />
                                    <label class="qpp__file-label" for="design-upload">
                                        <i class="qpp__upload-icon">📁</i>
                                        <p>Click here to upload your cake design</p>
                                    </label>
                                </div>
                                
                                <!-- Flexbox container for file previews -->
                                <div class="qpp__uploaded__files qpp__grid__container" id="file-preview-container">
                                 
                                </div>
                                
                            </div>

                            <div class="qpp__cake__details__container">
                                <!-- Optional: Textarea for additional design notes -->
                                <label for="design-notes" class="qpp__upload-label">Add Notes About Your Design (Optional):</label>
                                <textarea id="design-notes" name="design-notes" class="qpp__textarea" placeholder="Add any specific details about your design..."></textarea>
                            </div>

                           
                            <!-- Submit Button -->
                            <button class="qpp__btn-submit qpp__btn-option" type="submit">Submit and Continue</button>
                        </div>
                    </form>
                </div>

                <!-- Fourth Question -->
                <!-- flavors selections, dedications, and optional amount if they want to add money on the cake (money cake) -->
                <div class="qpp__form-group" id="question4">
                    <label class="qpp__question-label">Select Cake Flavors, and Dedication</label>
                    <div class="qpp__flavors__dedication__container">
                        <!-- Flavors Selection -->
                        <div class="qpp__flavors__selection">
                            <label for="flavors-select" class="qpp__upload-label">Select Cake Flavors:</label>
                            <select class="qpp__flavors-option qpp__dropdown" id="flavors-select">
                                <option value="" disabled selected>Select your cake flavors</option>
                                <option value="vanilla">Vanilla</option>
                                <option value="chocolate">Chocolate</option>
                                <option value="strawberry">Strawberry</option>
                                <option value="red-velvet">Red Velvet</option>
                                <option value="ube">Ube</option>
                                <option value="mocha">Mocha</option>
                                <option value="caramel">Caramel</option>
                                <option value="pandan">Pandan</option>
                                <option value="lemon">Lemon</option>
                                <option value="mango">Mango</option>
                                <option value="cheese">Cheese</option>
                                <option value="oreo">Oreo</option>
                                <option value="black-forest">Black Forest</option>
                                <option value="milk-chocolate">Milk Chocolate</option>
                                <option value="dark-chocolate">Dark Chocolate</option>
                                <!-- input flavor field -->
                                <!-- <input type="text" name="flavor" id="flavor" placeholder="Add your own flavor" style="display: none;"> -->
                            </select>
                        </div>
                    </div>
                    <!-- Dedication Input -->
                    <div class="qpp__dedication__selection">
                        <label for="dedication-input" class="qpp__upload-label">Add a Dedication:</label>
                        <input type="text" name="dedication" id="dedication-input" class="qpp__dedication-input" placeholder="Add a dedication to your cake">
                    </div>
                    <div class="qpp__money__cake__selection">
                        <label for="money-cake-input" class="qpp__upload-label">Add Money on the Cake:</label>
                        <input type="number" name="money-cake" id="money-cake-input" class="qpp__money-cake-input" placeholder="Add any amount to be placed on the cake">
                    </div><br>

                    <!-- New Submit Button -->
                    <button class="qpp__btn-submit qpp__btn-option" onclick="endSurvey()">Submit</button>
                    
                </div>
                
            </div>      

            <!-- disable the cursor from hovering in this container -->
            <!-- lessen the opacity that will look like it is disable and cannot be edited -->
            <div class="qpp__order__summary">
                <div class="qpp__order__infos">
                    <!-- order infos listed here based on the selected values and specs -->
                    <div class="qpp__order__info">
                        <div class="qpp__order__info__details">

                            <h4>Oder Details</h4>

                            <!-- edit order button, onclick, the #survey-section will set to style.display 'block' -->
                            <button id="qpp__edit__order__btn" onclick="editOrder()" style="display: none;">
                                Edit Order
                            </button>

                                <div class="qpp__order__details__container">
                                    <p>Price Range:</p>
                                    <span id="price-range-info"></span>
                                </div>
                                <div class="qpp__order__details__container">
                                    <p>Cake Size:</p>
                                    <span id="cake-size-info"></span>
                                </div>
                                <div class="qpp__order__reference__design">
                                    <p>Reference Cake Design</p>
                                    <div class="qpp__order__design__container" style="gap: 3px;"></div>
                                </div>
                                <div class="qpp__order__details__container">
                                    <p>Note:</p>
                                    <span id="design-notes-info"></span>
                                </div>
                                <div class="qpp__order__details__container">
                                    <p>Flavors:</p>
                                    <span id="flavors-info"></span>
                                </div>
                                <div class="qpp__order__details__container">
                                    <p>Dedication:</p>
                                    <span id="dedication-info"></span>
                                </div>
                                <div class="qpp__order__details__container">
                                    <p>Money on Cake:</p>
                                    <span id="money-cake-info"></span>
                                </div>
                            
                            <div class="qpp__submit__btn">
                                <!-- proceed to checkout button -->
                                <button id="qpp__submit__order__btn" class="qpp__btn-submit qpp__btn-option" onclick="checkoutOrder()" style="display: none;">Proceed to Checkout</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>
<script defer src="customize.js"></script>
<script defer src="design-upload-and-rendering.js"></script>
<script defer src="update-order-details.js"></script>
<?php include('partials/footer.php'); ?>