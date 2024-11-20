<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>

  <section class="main-content">

    <div class="navigation">
      <div class="menu-tab">
        <h2><b>Order List</b></h2>
        <!-- <p><?php echo date(format: 'l, F j, Y'); ?></p> -->
      </div>

      <div class="orders-flex-div">
          <div id="default-view-header" class="order-lists-buttons">
            <button id="show-all">All</button>
            <button id="show-new">New Orders</button>
            <button id="show-pending">Pending</button>
            <button id="show-completed">Completed</button>
          </div>
          <div id="compact-view-header" class="order-lists-buttons">
                <button>All</button>
                <button>Unfulfilled</button>
                <button>Unpaid</button>
                <button>Open</button>
                <button>Closed</button>
                <button class="add-button">+ Add</button>
          </div>
          <div class="orders-view-and-search">
            <input type="text" placeholder="Search...">
            <select id="orders-view-options">
                <option value="default-view"><img src="/images/svg/view_grid_layout-1024-removebg-preview.png">Default</option>
                <option value="compact-view"><img src="/images/svg/Compact_View-removebg-preview.png">Compact</option>
            </select>
          </div>
      </div>

    </div>

    <div id="default-view" class="container order-list-container">

        <div class="order-list">

              <div class="order-card-grid">
                <a href="view-order.php" class="order-card-link">
                    <div class="customer-information btm-line">
                        <div class="cust-contact-info">
                          <h4>David Moore</h4>
                          <p>+19876543210</p>
                        </div>
                        <div class="status-btn">
                          <button class="status new-order">New Order</button>
                        </div>
                    </div>

                    <div class="shipping-details btm-line">
                        <p>🕓 <span>11:00 AM, 08 Feb, 2024</span></p>
                        <p>📌 <span>Location here</span></p>
                    </div>
                    
                    <div class="total-orders">
                        <table class="total-table">
                            <tr>
                              <td class="tbl-total-items">3 Items</td>
                              <td class="tbl-total-order-amount">$22.00</td>
                            </tr>
                            <tr>
                              <td class="tbl-order-name">1 Spaghetti Bolognese</td>
                              <td class="tbl-order-amount">$12.00</td>
                            </tr>
                            <tr>
                              <td class="tbl-order-name">1 Garlic Bread</td>
                              <td class="tbl-order-amount">$3.50</td>
                            </tr>
                            <tr>
                              <td class="tbl-order-name">1 Caesar Salad</td>
                              <td class="tbl-order-amount">$3.50</td>
                            </tr>
                        </table>
                    </div>
                  </a>
                </div>
                

                <div class="order-card-grid">
                    <div class="customer-information btm-line">
                        <div class="cust-contact-info">
                          <h4>David Moore</h4>
                          <p>+19876543210</p>
                        </div>
                        <div class="status-btn">
                          <button class="status pending">Pending</button>
                        </div>
                    </div>

                    <div class="shipping-details btm-line">
                        <p>🕓 <span>11:00 AM, 08 Feb, 2024</span></p>
                        <p>📌 <span>Location here</span></p>
                    </div>
                    
                    <div class="total-orders">
                        <table class="total-table">
                            <tr>
                              <td class="tbl-total-items">3 Items</td>
                              <td class="tbl-total-order-amount">$22.00</td>
                            </tr>
                            <tr>
                              <td class="tbl-order-name">1 Spaghetti Bolognese</td>
                              <td class="tbl-order-amount">$12.00</td>
                            </tr>
                            <tr>
                              <td class="tbl-order-name">1 Garlic Bread</td>
                              <td class="tbl-order-amount">$3.50</td>
                            </tr>
                            <tr>
                              <td class="tbl-order-name">1 Caesar Salad</td>
                              <td class="tbl-order-amount">$3.50</td>
                            </tr>
                        </table>
                    </div>

                </div>


                <div class="order-card-grid">
                    <div class="customer-information btm-line">
                        <div class="cust-contact-info">
                          <h4>David Moore</h4>
                          <p>+19876543210</p>
                        </div>
                        <div class="status-btn">
                          <button class="status complete">Complete</button>
                        </div>
                    </div>

                    <div class="shipping-details btm-line">
                        <p>🕓 <span>11:00 AM, 08 Feb, 2024</span></p>
                        <p>📌 <span>Location here</span></p>
                    </div>
                    
                    <div class="total-orders">
                        <table class="total-table">
                            <tr>
                              <td class="tbl-total-items">3 Items</td>
                              <td class="tbl-total-order-amount">$22.00</td>
                            </tr>
                            <tr>
                              <td class="tbl-order-name">1 Spaghetti Bolognese</td>
                              <td class="tbl-order-amount">$12.00</td>
                            </tr>
                            <tr>
                              <td class="tbl-order-name">1 Garlic Bread</td>
                              <td class="tbl-order-amount">$3.50</td>
                            </tr>
                            <tr>
                              <td class="tbl-order-name">1 Caesar Salad</td>
                              <td class="tbl-order-amount">$3.50</td>
                            </tr>
                        </table>
                    </div>

                </div>

              <div class="order-card-grid">
                  <div class="customer-information btm-line">
                      <div class="cust-contact-info">
                        <h4>David Moore</h4>
                        <p>+19876543210</p>
                      </div>
                      <div class="status-btn">
                        <button class="status complete">Complete</button>
                      </div>
                  </div>

                  <div class="shipping-details btm-line">
                      <p>🕓 <span>11:00 AM, 08 Feb, 2024</span></p>
                      <p>📌 <span>Location here</span></p>
                  </div>
                  
                  <div class="total-orders">
                        <table class="total-table">
                          <tr>
                            <td class="tbl-total-items">3 Items</td>
                            <td class="tbl-total-order-amount">$22.00</td>
                          </tr>
                          <tr>
                            <td class="tbl-order-name">1 Spaghetti Bolognese</td>
                            <td class="tbl-order-amount">$12.00</td>
                          </tr>
                          <tr>
                            <td class="tbl-order-name">1 Garlic Bread</td>
                            <td class="tbl-order-amount">$3.50</td>
                          </tr>
                          <tr>
                            <td class="tbl-order-name">1 Caesar Salad</td>
                            <td class="tbl-order-amount">$3.50</td>
                          </tr>
                        </table>
                  </div>

              </div>
              
        </div>
    </div>

    <div id="compact-view" class="container">

        <table class="cv-order-table">
            <thead>
                <tr>
                    <th>Order No.</th>
                    <th>Contact Details</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Amount Paid</th>
                    <th>Date of Delivery</th>
                    <th>Delivery Point</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>#1002</td>
                    <td>11 Feb, 2024</td>
                    <td>Wade Warren</td>
                    <td><span class="status pending">Pending</span></td>
                    <td>$20.00</td>
                    <td>N/A</td>
                    <td><span class="status unfulfilled">Unfulfilled</span></td>
                    <td><button class="action-button">View</button></td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>#1004</td>
                    <td>13 Feb, 2024</td>
                    <td>Esther Howard</td>
                    <td><span class="status success">Success</span></td>
                    <td>$22.00</td>
                    <td>N/A</td>
                    <td><span class="status fulfilled">Fulfilled</span></td>
                    <td><button class="action-button">View</button></td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>#1019</td>
                    <td>27 Feb, 2024</td>
                    <td>Theresa Webb</td>
                    <td><span class="status pending">Pending</span></td>
                    <td>$20.00</td>
                    <td>N/A</td>
                    <td><span class="status unfulfilled">Unfulfilled</span></td>
                    <td><button class="action-button">View</button></td>
                </tr>
            </tbody>
        </table>

    </div>























  </section>

  <?php include('partials/footer.php'); ?>

<script>
  // Get the select dropdown
const viewOptions = document.getElementById('orders-view-options');

// Get the containers to toggle
const defaultViewHeader = document.getElementById('default-view-header');
const defaultView = document.getElementById('default-view');
const compactViewHeader = document.getElementById('compact-view-header');
const compactView = document.getElementById('compact-view');

// Function to handle view changes
function toggleView(view) {
    if (view === 'default-view') {
        // Show Default View, Hide Compact View
        defaultViewHeader.style.display = 'flex';
        defaultView.style.display = 'block';
        compactViewHeader.style.display = 'none';
        compactView.style.display = 'none';
    } else if (view === 'compact-view') {
        // Show Compact View, Hide Default View
        defaultViewHeader.style.display = 'none';
        defaultView.style.display = 'none';
        compactViewHeader.style.display = 'flex';
        compactView.style.display = 'block';
    }
}

// Event listener for dropdown change
viewOptions.addEventListener('change', (event) => {
    const selectedView = event.target.value;
    toggleView(selectedView);
});

// Initialize with the default view (optional)
toggleView('default-view');

</script>
<script>
  // Get all the buttons
const showAllBtn = document.getElementById('show-all');
const showNewBtn = document.getElementById('show-new');
const showPendingBtn = document.getElementById('show-pending');
const showCompletedBtn = document.getElementById('show-completed');

// Get all order cards
const orderCards = document.querySelectorAll('.order-card-grid');

// Function to show all orders
function showAllOrders() {
  orderCards.forEach(card => {
    card.style.display = 'block'; // Show all cards
  });
  setActiveButton(showAllBtn); // Set active button
}

// Function to filter orders by status
function filterOrdersByStatus(statusClass) {
  orderCards.forEach(card => {
    const statusBtn = card.querySelector('.status');
    if (statusBtn && statusBtn.classList.contains(statusClass)) {
      card.style.display = 'block'; // Show cards with the specific status
    } else {
      card.style.display = 'none'; // Hide other cards
    }
  });
}

// Function to set active button and remove active class from others
function setActiveButton(activeBtn) {
  // Remove active class from all buttons
  const buttons = document.querySelectorAll('.order-lists-buttons button');
  buttons.forEach(btn => btn.classList.remove('active'));

  // Add active class to the clicked button
  activeBtn.classList.add('active');
}

// Add event listeners to buttons
showAllBtn.addEventListener('click', () => {
  showAllOrders();
  setActiveButton(showAllBtn); // Set this button as active
});

showNewBtn.addEventListener('click', () => {
  filterOrdersByStatus('new-order');
  setActiveButton(showNewBtn); // Set this button as active
});

showPendingBtn.addEventListener('click', () => {
  filterOrdersByStatus('pending');
  setActiveButton(showPendingBtn); // Set this button as active
});

showCompletedBtn.addEventListener('click', () => {
  filterOrdersByStatus('complete');
  setActiveButton(showCompletedBtn); // Set this button as active
});

// By default, show all orders when the page loads
showAllOrders();

</script>


