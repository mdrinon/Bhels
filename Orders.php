<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>

  <section class="main-content">
    <div class="navigation">
      <div class="menu-tab"><h6><b>Orders</b></h6></div>
    </div>


    <div class="orders-container">
      <div class="orders-left-container">
        <div class="row-wrap">
          <div class="order-card" >
            <div class="tbl-card-header">
              Pending Orders
            </div>
              <table>
                <tr>
                  <th class="order-tbl-th tblclmn1">Order #123456</th>
                  <th class="order-tbl-th" >Price</th>
                  <th class="order-tbl-th" >Discount<th>
                  <th class="order-tbl-th" >Quantity<th>
                  <th class="order-tbl-th" >Total Price</th>
                </tr>
                <tr class="tbl-card-content" >
                    <td class="order-tbl-td tblclmn1">
                      <div class="img_placeholder">
                        <img src="" alt="">
                      </div>
                      <div class="tbl-card-content-row-left-text">
                        <h4>Product Name</h4>
                        <p>Product Description</p>
                      </div>
                    </td>
                    <td class="order-tbl-td" >
                      <div class="cell-content">
                        0.26 lb
                      </div>
                    </td>
                    <td class="order-tbl-td" >
                      <div class="cell-content">
                        $53.00
                      </div>
                    </td>
                    <td class="order-tbl-td" >
                      <div class="cell-content">
                        x 2
                      </div>
                    </td>
                    <td class="order-tbl-td" >
                      <div class="cell-content">
                        $106.00
                      </div>
                    </td>
                </tr>
                <!-- Add more rows as needed -->
              </table>

              <div class="total-payment-section">
                <div class="order-note">
                  <p><b>Order Note</b></p>
                  <p>Ship all the ordered items together by Friday and I send you an email please check. Thanks!</p>
                </div>

                <div class="order-total-payment">
                  <div class="left">
                    <div>Subtotal</div>
                    <div>Shipping</div>
                    <div>Tax</div>

                    <div class="total">Total</div>
                  </div>

                  <div class="right">
                    <div>$313.72</div>
                    <div>$3.50</div>
                    <div>$0.00</div>
                    <div class="total">$317.22</div>
                  </div> 

                </div>

              </div>
          </div>
        </div>
      </div>
      <div class="orders-right-container">
        <div class="row-wrap">
          <div class="recent-orders">
            
            <h4>Recent Orders</h4>

            <div class="recent-order-card">
              <div class="recent-order-img">
                <img src="" alt="">
              </div>
              <div class="product-info">
                <p class="show_hide"><b>Product Name</b></p>
                <!-- <p class="show_hide"><i>Show product info</i></p> -->
                <div class="show_hide-card">
                  <p class="show_hide-pd" > i want the product description to be hidden when the page loads, the appears only when the card is hovered </p>
                </div>
                <p class="show_hide">Jan 01, 2024</p>
              </div>
              <div class="order-status">
                <img src="images/svg/check.png" alt="">
              </div>
            </div>

            <div class="recent-order-card">
              <div class="recent-order-img">
                <img src="" alt="">
              </div>
              <div class="product-info">
                <p class="show_hide"><b>Product Name</b></p>
                <!-- <p class="show_hide"><i>Show product info</i></p> -->
                <div class="show_hide-card">
                  <p class="show_hide-pd" > i want the product description to be hidden when the page loads, the appears only when the card is hovered </p>
                </div>
                <p class="show_hide">Jan 01, 2024</p>
              </div>
              <div class="order-status">
                <img src="images/svg/check.png" alt="">
              </div>
            </div>

            <div class="recent-order-card">
              <div class="recent-order-img">
                <img src="" alt="">
              </div>
              <div class="product-info">
                <p class="show_hide"><b>Product Name</b></p>
                <!-- <p class="show_hide"><i>Show product info</i></p> -->
                <div class="show_hide-card">
                  <p class="show_hide-pd" > i want the product description to be hidden when the page loads, the appears only when the card is hovered </p>
                </div>
                <p class="show_hide">Jan 01, 2024</p>
              </div>
              <div class="order-status">
                <img src="images/svg/cancelled.png" alt="">
              </div>
            </div>

            <div class="recent-order-card">
              <div class="recent-order-img">
                <img src="" alt="">
              </div>
              <div class="product-info">
                <p class="show_hide"><b>Product Name</b></p>
                <!-- <p class="show_hide"><i>Show product info</i></p> -->
                <div class="show_hide-card">
                  <p class="show_hide-pd" > i want the product description to be hidden when the page loads, the appears only when the card is hovered </p>
                </div>
                <p class="show_hide">Jan 01, 2024</p>
              </div>
              <div class="order-status">
                <img src="images/svg/check.png" alt="">
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>    
  </section>

  <?php include('partials/footer.php'); ?>

