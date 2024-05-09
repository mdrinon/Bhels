<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>

  <section class="main-content">

    <div class="navigation">
      <div class="menu-tab">
        <h6><b>Dashboard</b></h6>
      </div>
      <div class="dashboard-header-content">
        <h1>Welcome, <span>Username</span></h1>
      </div>
    </div>

    <div class="container">
      <div class="dashboard_grid_container">

        <div class="dashboard-grid">
          <div class="grid-content">
            <div class="grid-content-icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="grid-content-text">
              <h3>Orders</h3>
              <p>View your orders and manage your purchases</p>
            </div>
          </div>
        </div>
        
        <div class="dashboard-grid">
          <div class="grid-content">
            <div class="grid-content-icon">
              <i class="fas fa-gift"></i>
            </div>
            <div class="grid-content-text">
              <h3>Reward Points</h3>
              <p>View your reward points and redeem them</p>
            </div>
          </div>
        </div>
        <div class="dashboard-grid">
          <div class="grid-content">
            <div class="grid-content-icon">
              <i class="fas fa-heart"></i>
            </div>
            <div class="grid-content-text">
              <h3>Wishlist</h3>
              <p>View your wishlist and add to cart</p>
            </div>
          </div>
        </div>
        <div class="dashboard-grid">
          <div class="grid-content">
            <div class="grid-content-icon">
              <i class="fas fa-user"></i>
            </div>
            <div class="grid-content-text">
              <h3>Profile</h3>
              <p>View and edit your profile</p>
            </div>
          </div>
        </div>
      </div>


      <div class="recommended-section">
                
        <br>

        <h2>Recommended for you</h2>
        <p>Here are some recommended products for you</p>


      <div class="dashboard-row-wrap">

        <div class="recommended-content">
          <div class="img_placeholder">
            <img src="" alt="">
          </div>
          <div class="rc_text_content">
            <h3>product Name</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odit nulla, aspernatur adipisci odio exercitationem aperiam veritatis, corrupti nesciunt inventore fuga consequuntur vel? Consectetur non necessitatibus voluptas doloribus alias recusandae reiciendis!</p>
          </div>
        </div>

        <div class="recommended-content">
          <div class="img_placeholder">
            <img src="" alt="">
          </div>
          <div class="rc_text_content">
            <h3>product Name</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odit nulla, aspernatur adipisci odio exercitationem aperiam veritatis, corrupti nesciunt inventore fuga consequuntur vel? Consectetur non necessitatibus voluptas doloribus alias recusandae reiciendis!</p>
          </div>
        </div>

        <!-- i want this to display a minimum of 5 contents only, and it has a expand button or AKA show more button illustrated by an arrow down (▽) -->

        <div class="recommended-content">
          <div class="img_placeholder">
            <img src="" alt="">
          </div>
          <div class="rc_text_content">
            <h3>product Name</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odit nulla, aspernatur adipisci odio exercitationem aperiam veritatis, corrupti nesciunt inventore fuga consequuntur vel? Consectetur non necessitatibus voluptas doloribus alias recusandae reiciendis!</p>
          </div>
        </div>


      </div>
    </div>    
  </section>

  <?php include('partials/footer.php'); ?>