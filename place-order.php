<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>
<link rel="stylesheet" type="text/css" href="css/place-order.css">
<?php
// Fetch user details from the database
$phone = '';
$email = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $phone = getUserDetail($user_id, 'phone');
    $email = getUserDetail($user_id, 'email');
}

$customer_id = $_SESSION['user_id'] ?? '';

// Extract query parameters or POST data
$productName = $_GET['productName'] ?? 'Customized Cake';
$flavor = $_GET['flavors'] ?? $_GET['flavor'] ?? ''; 
$cakeSize = $_GET['productSize'] ?? $_GET['cakeSize'] ?? ''; 
$dedication = $_GET['dedication'] ?? '';
$designNotes = $_GET['designNotes'] ?? $_GET['note'] ?? '';
$moneyCake = $_GET['moneyCake'] ?? '';
$quantity = $_GET['quantity'] ?? '1';
$subTotal = $_GET['subTotal'] ?? '';
$shipFee = $_GET['shipFee'] ?? '';
$totalPrice = $_GET['totalPrice'] ?? '';
$design_id = $_GET['designId'] ?? '';
// Extract uploaded file paths and split them into an array
$uploadedFiles = $_GET['uploadedFiles'] ?? $_GET['productImage'] ?? '';
$filePaths = $uploadedFiles ? explode(',', $uploadedFiles) : [];
?>

<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

use MongoDB\Client as MongoClient;

function insertOrder($orderData) {
    // Connect to MongoDB
    $client = new MongoClient("mongodb://localhost:27017");
    $collection = $client->bheldb->orders;

    // Insert the order data into the 'orders' collection
    $result = $collection->insertOne($orderData);

    return $result->getInsertedId();
}
?>

<style>
#place-order-btn {
    display: flex;
    position: fixed;
    bottom: 20px;
    padding: 15px 20px;
    margin: auto 20%;
    background: #cb5584;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
#place-order-btn:hover {
    background: #c64581;
}
.error-message {
    color: red;
    font-size: 0.6em;
    display: none;    
    position: absolute;
    padding: 0 10px;
}

</style>

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
                <li><a  id="enable"href="place-order.php">
                  <img src="images/svg/placeorder.png" alt="place-order">
                </a></li> 
                <li><a  id="disable"href="payment.php">
                  <img src="images/svg/paynow.png" alt="payment">
                </a></li> 
            </ul>            
        </div>

        <div class="process-label">
            <p>Step 3: Place Order</p>
        </div>

    </div>

    <div class="process-order-container">

        <div class="placed_order_section_container delivery-details" style="border-radius: 8px 8px 0 0;">
            <h2 class="placed_order_section_title">Delivery Details</h2>
            <div class="delivery_details_content">
                <form id="delivery-details-form">
                    <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>">
                    <div class="form-group" id="delivery_date_time">
                        <div>
                            <label for="delivery_date">Delivery Date:</label>
                            <input type="date" id="delivery_date" name="delivery_date" required>
                            <span class="error-message" id="delivery_date_error"></span>
                        </div>
                        <div>
                            <label for="delivery_time">Delivery Time:</label>
                            <input type="time" id="delivery_time" name="delivery_time" required>
                            <span class="error-message" id="delivery_time_error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="delivery_address">Delivery Address:</label>
                        <div>
                            <select id="province" name="province" required>
                                <option value="Albay">Albay</option>
                            </select>
                        </div>
                        <div>
                            <select id="city_municipality" name="city_municipality" required>
                                <option value="" selected disabled>City/Municipality</option>
                                <option value="Guinobatan">Guinobatan</option>
                                <option value="Ligao City">Ligao City</option>
                                <option value="Oas">Oas</option>
                                <option value="Polangui">Polangui</option>
                            </select>
                            <span class="error-message" id="city_municipality_error"></span>
                        </div>
                        <div>
                            <select id="barangay" name="barangay" required>
                                <option value="" selected disabled>Select Barangay</option>
                            </select>
                            <span class="error-message" id="barangay_error"></span>
                        </div>
                        <div>
                            <input type="text" id="zone_purok" name="zone_purok" placeholder="Zone/Purok" required>
                        </div>
                        <div>
                            <input type="text" id="block_lot" name="block_lot" placeholder="Subd. Blk. & Lot No.">
                        </div>
                        <div>
                            <input type="text" id="landmark" name="landmark" placeholder="Landmark (optional)">
                        </div>
                    </div>

                    <div class="form-group">
                        <div>
                            <label for="recipient_name">Recipient Name:</label>
                            <input type="text" id="recipient_name" name="recipient_name" placeholder="First M.I. Last Name" required>
                        </div>
                        <div>
                            <label for="recipient_phone">Recipient Phone Number:</label>
                            <input type="tel" id="recipient_phone" name="recipient_phone" pattern="[0-9]{11}" placeholder="09123456789" required>
                            <span class="error-message" id="recipient_phone_error"></span>
                        </div>
                    </div>
                </form>
                <button id="place-order-btn" type="button" style="display: none;">Place Order</button>
            </div>
        </div>

        <div class="placed_order_section_container customer-details" style="margin-top: 7px;">
            <h2 class="placed_order_section_title">Customer Details</h2>
            <div class="customer_details_content">
                <form action="">
                    <div class="form-group">
                        <div>
                            <label for="fullname">Full Name:</label>
                            <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>" required>
                        </div>
                        <div>
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" value="<?php echo $username; ?>" readonly>
                        </div>
                        <div>
                            <label for="phone">Phone:</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" readonly required>
                        </div>
                        <div>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo $email; ?>" readonly required>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="placed_order_section_container" style="margin-top: 7px;">
            <button type="button" class="collapsible placed_order_section_title">Order Summary</button>
            <div class="content order_summary_content">
                <div class="checkedout-designs">
                    <div class="order_top_con">
                        <h2 id="product-name" class="product-name">
                            <?php echo htmlspecialchars($productName); ?>
                        </h2>
                    </div>
                    <div class="order_details_con_grid">
                        <div class="order_left_con">
                            <p id="design_id" style="display:none">
                                <?php echo htmlspecialchars($design_id); ?>
                            </p>
                            <div class="carousel">
                                <?php foreach ($filePaths as $index => $path): ?>
                                    <img id="cake-design-<?php echo $index; ?>" class="product-image <?php echo $index === 0 ? 'active' : ''; ?>" src="<?php echo htmlspecialchars($path); ?>" alt="Cake Design">
                                <?php endforeach; ?>
                                <button class="prev" onclick="changeSlide(-1)">❮</button>
                                <button class="next" onclick="changeSlide(1)">❯</button>
                            </div>
                            <div class="image-previews">
                                <?php foreach ($filePaths as $index => $path): ?>
                                    <img src="<?php echo htmlspecialchars($path); ?>" alt="Cake Design" onclick="showSlide(<?php echo $index; ?>)">
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="order_right_con">
                            <div class="cust-dedication-con">
                                <p class="label"><b>Dedication:</b></p>
                                <p id="dedication" class="dedication">
                                    <?php echo htmlspecialchars($dedication); ?>
                                </p>
                            </div>
                            <div class="product-options">
                                <p id="product-size"><b>Size: </b>
                                    <?php 
                                    echo htmlspecialchars($cakeSize) ?: htmlspecialchars($_GET['productSize'] ?? ''); 
                                    ?>
                                </p>
                                <p id="flavor"><b>Flavor: </b>
                                    <?php echo htmlspecialchars($flavor) ?: htmlspecialchars($_GET['flavors'] ?? ''); ?>
                                </p>
                            </div>
                            <div class="product-price">
                                <p class="label"><b>Price: </b></p>
                                <p id="product-price" class="product-price">
                                    <?php echo htmlspecialchars($subTotal); ?>
                                </p>
                            </div>
                            <div id="co-moneycake-con" class="co-moneycake-con">
                                <p class="label">Money on Cake:</p>
                                <p id="money-cake" class="money-cake">
                                    <?php echo htmlspecialchars($moneyCake); ?>
                                </p>
                            </div>
                            <div class="cust-note-con">
                                <p class="label"><b>Notes:</b></p>
                                <p id="note" class="note">
                                    <?php echo htmlspecialchars($designNotes); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="placed_order_section_container" style="border-radius: 0 0 8px 8px;">
            <button type="button" class="collapsible placed_order_section_title">Order Total</button>
            <div class="content order_total_content">
                <div class="order_total_details">
                    <p id="quantity"><b>Quantity:</b> <?php echo htmlspecialchars($quantity); ?></p>
                    <p id="subTotal"><b>Subtotal:</b> <?php echo htmlspecialchars($subTotal); ?></p>
                    <p id="shippingFee"><b>Shipping Fee:</b> <?php echo htmlspecialchars($shipFee); ?></p>
                    <p id="orderTotal"><b>Total Price:</b> <?php echo htmlspecialchars($totalPrice); ?></p>
                </div>
            </div>
        </div>

    </div>

</section>

<script src="place-order.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if the order is not a customized order
    const productName = "<?php echo $productName; ?>";
    if (productName !== 'Customized Cake') {
        // Extract the design_id from sessionStorage
        const designId = sessionStorage.getItem('selectedDesignId');
        if (designId) {
            // Add the design_id to the query parameters
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('designId', designId);
            window.history.replaceState({}, '', `${window.location.pathname}?${urlParams}`);
        }
    }
});
</script>


<?php include('partials/footer.php'); ?>

<?php
// Function to get user details from the database
function getUserDetail($user_id, $detail) {
    if (!$user_id) return '';

    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->bheldb->accounts;

    // Find the user by ID
    $user = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($user_id)]);

    // Return the requested detail if it exists
    return $user && isset($user[$detail]) ? htmlspecialchars($user[$detail]) : '';
}
?>