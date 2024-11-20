<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>

  <section class="main-content">

    <div class="navigation">
      <div class="menu-tab">
        <h6><b>Dashboard</b></h6>
      </div>
      <div class="dashboard-header-content">
        <h2>Welcome, <span>ADMIN</span></h2>
      </div>
    </div>


    <div class="container">
        
      <div class="dashboard_grid_container">

        <div class="dashboard-grid">
          <div class="grid-content">
            <div class="db-svgs">
              <div class="circle-container">
                  <img src="images/svg/dashboard-orders-icon.png" alt="">
              </div>
              <a href="Orders.php">
                <div class="db-arrow-icon"></div>
              </a>
            </div> 
            <div class="grid-content-text">
              <h3>Orders</h3>
              <p>View Orders</p>
            </div>
          </div>
        </div>

        
        <div class="dashboard-grid">
          <div class="grid-content">
          <div class="db-svgs">
            <div class="circle-container">
                <img src="images/svg/dashboard-product-design-icon.png" alt="">
            </div>
            <a href="Designs.php">
              <div class="db-arrow-icon"></div>
            </a>
          </div> 
            <div class="grid-content-text">
              <h3>Products</h3>
              <p>View Cake Designs</p>
            </div>
          </div>
        </div>
        <div class="dashboard-grid">
          <div class="grid-content">
          <div class="db-svgs">
            <div class="circle-container">
                <img src="images/svg/user-generated-content.png" alt="">
            </div>
            <a href="Blog.php">
              <div class="db-arrow-icon"></div>
            </a>
          </div> 
            <div class="grid-content-text">
              <h3>Blog Posts</h3>
              <p>Visit Blog Page</p>
            </div>
          </div>
        </div>
        
        <div class="dashboard-grid">
          <div class="grid-content">
          <div class="db-svgs">
            <div class="circle-container">
                <img src="images/svg/customer-satisfaction.png" alt="">
            </div>
            <a href="manage_users.php">
              <div class="db-arrow-icon"></div>
            </a>
            </div> 
            <div class="grid-content-text">
              <h3>Accounts</h3>
              <p>Manage registered accounts</p>
            </div>
          </div>
        </div>

        <div class="dashboard-grid">
          <div class="grid-content">
          <div class="db-svgs">
            <div class="circle-container">
                <img src="images/svg/archive.png" alt="">
            </div>
            <a href="view_archives.php">
              <div class="db-arrow-icon"></div>
            </a>
            </div> 
            <div class="grid-content-text">
              <h3>Archived Cake Designs</h3>
              <p>Manage Archives</p>
            </div>
          </div>
        </div>
        <div class="dashboard-grid">
          <div class="grid-content">
            <div class="db-svgs">
              <div class="circle-container">
                  <img src="images/svg/growth.png" alt="">
              </div>
              <a href="sales.php">
                <div class="db-arrow-icon"></div>
              </a>
              </div> 
              <div class="grid-content-text">
               <h3>Sales</h3>
               <p>Manage sales</p>
            </div>
          </div>
        </div>
        <div class="dashboard-grid">
          <div class="grid-content">
          <div class="db-svgs">
            <div class="circle-container">
                <img src="images/svg/operation.png" alt="">
            </div>
            <a href="manage_payment.php">
              <div class="db-arrow-icon"></div>
            </a>
          </div> 
            <div class="grid-content-text">
              <h3>Payment</h3>
              <p>Manage Payment</p>
            </div>
          </div>
        </div>
        <div class="dashboard-grid">
          <div class="grid-content">
          <div class="db-svgs">
            <div class="circle-container">
                <img src="images/svg/question.png" alt="">
            </div>
            <a href="FAQs_bot.php">
              <div class="db-arrow-icon"></div>
            </a>
          </div> 
            <div class="grid-content-text">
              <h3>FAQs</h3>
              <p>Manage FAQs</p>
            </div>
          </div>
        </div>

      </div>
    </div>

  </section>

  <?php include('partials/footer.php'); ?>


