<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>
  
  <section class="main-content">
    <div class="navigation">
      <div class="menu-tab"><h6><b>Designs</b></h6></div>
      <div class="nav-label"><h2>Designs</h2></div>
      <div class="group-right">
        <div class="searchbar">
          <form class="search-bar" action="" method="post">
            <input type="text" name="search_query" placeholder="Search products...">
            <img class="search-icon-button custom-width" src="images/search.jpg">
          </form>
        </div>
        <div>
          <select class="ctrl-btn" id="sorting-option">
            <option value="" disabled selected>Sort by:</option>
            <option value="name">Name</option>
            <option value="price">Price</option>
            <option value="date">Date</option>
          </select>
        </div>
      </div>
    </div>

    <div class="left-container">
      <div class="product-catalog"><!-- sorting container and filtering option must be added after this -->
        <div class="wrapper">

          <div class="product">
            <div class="card product-card">
              <div class="card-image"></div>
              <div class="category"> Illustration </div>
              <div class="heading"> A heading that must span over two lines
                  <div class="author"> By <span class="name">Abi</span> 4 days ago</div>
              </div>
            </div>
          </div>

          <div class="product">
            <div class="card product-card">
              <div class="card-image"></div>
              <div class="category"> Illustration </div>
              <div class="heading"> A heading that must span over two lines
                  <div class="author"> By <span class="name">Abi</span> 4 days ago</div>
              </div>
            </div>
          </div>


          <!-- add more product cards here.. -->

        </div>
      </div>
    </div>


    <div class="pagenum-pagebutton">
      <div class="prev-next-button">      
      <button id="prev-btn" disabled>Previous</button>
      <button id="next-btn">Next</button>
      </div>

      <div class="page-numbers" id="page-numbers"></div>
    </div>


    
  </section>

  <?php include('partials/footer.php'); ?>