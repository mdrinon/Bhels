<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>

<link rel="stylesheet" type="text/css" href="css/orders.css">

<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

use MongoDB\Client as MongoClient;

// Fetch user orders from the database
$orders = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Connect to MongoDB
    $client = new MongoClient("mongodb://localhost:27017");
    $collection = $client->bheldb->orders;

    // Fetch orders for the logged-in user
    $orders = $collection->find(['CustomerDetails.customer_id' => new MongoDB\BSON\ObjectId($user_id)])->toArray();
}
?>

<section class="main-content">
    <div class="navigation">
        <div class="menu-tab"><h6><b>Orders</b></h6></div>
    </div>

    <div class="orders-container">
        <div class="orders-left-container">
            <div class="row-wrap">
                <div class="order-card">
                    <div class="tbl-card-header">
                        Orders
                    </div>
                    <div class="order-list">
                        <br>
                        <?php foreach ($orders as $order): ?>
                            <?php if (in_array($order['order_status'], ['Pending', 'Processing', 'Confirmed'])): ?>
                                <div class="order_container">
                                        <div class="order_status">
                                            <p class="<?php echo htmlspecialchars($order['order_status']) ?>">
                                                <?php echo htmlspecialchars($order['order_status']) ?>
                                            </p>
                                        </div>
                                    <div class="order_data">
                                        <div class="order_data_image_container">
                                            <img src="<?php echo htmlspecialchars($order['PlacedOrderDetails']['selected_files'][0]['cake_design1']['file_path'] . $order['PlacedOrderDetails']['selected_files'][0]['cake_design1']['file_name']); ?>" alt="">
                                        </div>
                                        <div class="order_details_content">
                                            <p class="product_name"><b><?php echo htmlspecialchars($order['PlacedOrderDetails']['product_name']); ?></b></p>
                                            <p class="cake_size"><?php echo htmlspecialchars($order['PlacedOrderDetails']['cake_size']); ?></p>
                                            <p class="cake_flavor"><?php echo htmlspecialchars($order['PlacedOrderDetails']['flavors']); ?></p>
                                            <p class="cake_dedication"><?php echo htmlspecialchars($order['PlacedOrderDetails']['dedication']); ?></p>
                                            <p class="cake_price"><?php echo htmlspecialchars($order['PlacedOrderDetails']['price_range']); ?></p>
                                        </div>
                                        <div class="delivery_details_content">
                                            <p class="delivery_date">📅 <?php echo htmlspecialchars((new DateTime($order['deliveryDetails']['delivery_date']->toDateTime()->format('Y-m-d H:i:s')))->format('M d, Y')); ?></p>
                                            <p class="delivery_time">🕓 <?php echo htmlspecialchars($order['deliveryDetails']['delivery_time']); ?></p>
                                            <p class="delivery_address">🚚 <?php echo htmlspecialchars($order['deliveryDetails']['delivery_address']); ?></p>
                                            <p class="recipient_name">👨🏻‍💼 <?php echo htmlspecialchars($order['deliveryDetails']['contact_person']['contact_person_name']); ?></p>
                                            <p class="recipient_contact">📞 <?php echo htmlspecialchars($order['deliveryDetails']['contact_person']['contact_person_number']); ?></p>
                                        </div>
                                    </div>
                                    <button id="collapsible" class="collapsible">View Details</button>
                                    <div class="bottom_details_container" style="display:none;">
                                        <div class="order_payment_and_notes">
                                            <div class="order_note">
                                                <p><b>Note:</b></p>
                                                <p><?php echo htmlspecialchars($order['PlacedOrderDetails']['note']); ?></p>
                                            </div>
                                            <div class="order_total_payment">
                                                <div>
                                                    <p class="quantity">Quantity: </p>
                                                    <p><?php echo htmlspecialchars($order['quantity']); ?></p>
                                                </div>
                                                <div>
                                                    <p class="subTotal">Subtotal: </p>
                                                    <p>₱<?php echo htmlspecialchars($order['subTotal']); ?></p>
                                                </div>
                                                <div>
                                                    <p class="moneyCake">Money Cake: </p>
                                                    <p><?php echo htmlspecialchars($order['PlacedOrderDetails']['money_cake']); ?></p>
                                                </div>
                                                <div>
                                                    <p class="shippingFee">Shipping Fee: </p>
                                                    <p>₱<?php echo htmlspecialchars($order['shippingFee']); ?></p>
                                                </div>
                                                <div>
                                                    <p class="totalPrice"><b>Total Price: </b></p>
                                                    <p><b>₱<?php echo htmlspecialchars($order['orderTotal']); ?></b></p>
                                                </div>
                                            </div>
                                            <div class="order_action">
                                                <button id="cancel_btn" class="btn red_btn">Cancel Order</button>
                                                <!-- <button id="view_order_details_btn" class="btn green_btn">View Order</button> -->
                                                <button id="pay_now_btn" class="btn green_btn">Pay Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="total-payment-section">
                    </div>
                </div>
            </div>
        </div>

        <div class="orders-right-container">
            <div class="row-wrap">
                <div class="recent-orders">
                    <h4>Recent Orders</h4>
                    <?php foreach ($orders as $order): ?>
                        <?php if ($order['order_status'] === 'Delivered'): ?>
                            <div class="recent-order-card">
                                <div class="recent-order-img">
                                    <img src="<?php echo htmlspecialchars($order['PlacedOrderDetails']['selected_files'][0]['cake_design1']['file_path'] . $order['PlacedOrderDetails']['selected_files'][0]['cake_design1']['file_name']); ?>" alt="">
                                </div>
                                <div class="product-info">
                                    <p class="show_hide"><b><?php echo htmlspecialchars($order['PlacedOrderDetails']['product_name']); ?></b></p>
                                    <div class="show_hide-card">
                                        <p class="show_hide-pd"><?php echo htmlspecialchars($order['PlacedOrderDetails']['note']); ?></p>
                                    </div>
                                    <p class="show_hide"><?php echo htmlspecialchars((new DateTime($order['dateOrdered']->toDateTime()->format('Y-m-d H:i:s')))->format('M d, Y')); ?></p>
                                </div>
                                <div class="order-status">
                                    <img src="images/svg/check.png" alt="">
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="canceled-orders">
                    <h4>Canceled Orders</h4>
                    <?php foreach ($orders as $order): ?>
                        <?php if ($order['order_status'] === 'canceled'): ?>
                            <div class="canceled-order-card">
                                <div class="canceled-order-img">
                                    <img src="<?php echo htmlspecialchars($order['PlacedOrderDetails']['selected_files'][0]['cake_design1']['file_path'] . $order['PlacedOrderDetails']['selected_files'][0]['cake_design1']['file_name']); ?>" alt="">
                                </div>
                                <div class="product-info">
                                    <p class="show_hide"><b><?php echo htmlspecialchars($order['PlacedOrderDetails']['product_name']); ?></b></p>
                                    <div class="show_hide-card">
                                        <p class="show_hide-pd"><?php echo htmlspecialchars($order['PlacedOrderDetails']['note']); ?></p>
                                    </div>
                                    <p class="show_hide"><?php echo htmlspecialchars(date('M d, Y', strtotime($order['dateOrdered']['$date']))); ?></p>
                                </div>
                                <div class="order-status">
                                    <img src="images/svg/cancel.png" alt="">
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <div class="modal-content" id="modalContent"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to update the order total payment section
    function updateOrderTotalPayment() {
        const subtotalElement = document.getElementById('subtotal-amount');
        const shippingElement = document.getElementById('shipping-amount');
        const totalElement = document.getElementById('total-amount');

        let subtotal = 0;
        let shipping = 0;

        // Calculate the subtotal from the pending orders
        const orderRows = document.querySelectorAll('.tbl-card-content');
        orderRows.forEach(row => {
            const totalPriceElement = row.querySelector('.order-item-column:last-child .cell-content');
            if (totalPriceElement) {
                const totalPrice = parseFloat(totalPriceElement.textContent.replace('₱', '').replace(',', '')) || 0;
                subtotal += totalPrice;
            }
        });

        // Calculate the total
        const total = subtotal + shipping;

        // Update the elements with the calculated values
        subtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
        shippingElement.textContent = `₱${shipping.toFixed(2)}`;
        totalElement.textContent = `₱${total.toFixed(2)}`;
    }

    // Call the function to update the order total payment section
    updateOrderTotalPayment();

    // Add event listeners to each pending order row
    const pendingOrderRows = document.querySelectorAll('.tbl-card-content');
    const orderNoteElement = document.querySelector('.order-note p:nth-child(2)');

    pendingOrderRows.forEach(row => {
        row.addEventListener('mouseover', function () {
            const note = row.getAttribute('data-note');
            orderNoteElement.textContent = note || 'No note provided.';
        });
    });

    // Modal functionality
    const modal = document.getElementById('imageModal');
    const modalContent = document.getElementById('modalContent');
    const closeModal = document.querySelector('.close');

    document.querySelectorAll('.img_placeholder .overlay').forEach(overlay => {
        overlay.addEventListener('click', function () {
            const order = this.closest('.tbl-card-content');
            const imagesArray = JSON.parse(order.getAttribute('data-images'));
            modalContent.innerHTML = '';
            imagesArray.forEach(image => {
                const imgElement = document.createElement('img');
                const key = Object.keys(image)[0];
                imgElement.src = image[key].file_path + image[key].file_name;
                modalContent.appendChild(imgElement);
            });
            modal.style.display = 'block';
        });
    });

    closeModal.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

});

    // Collapsible functionality
    document.querySelectorAll('.collapsible').forEach(button => {
        button.addEventListener('click', function () {
            this.classList.toggle('active');

            // Target the .bottom_details_container element
            const content = this.nextElementSibling;

            if (content && content.classList.contains('bottom_details_container')) {
                const currentDisplay = window.getComputedStyle(content).display;
                if (currentDisplay === 'none') {
                    content.style.display = 'block'; // Show the container
                } else {
                    content.style.display = 'none'; // Hide the container
                }
            }
        });
    });
</script>

<?php include('partials/footer.php'); ?>

