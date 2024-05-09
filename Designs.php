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
        <!-- <div>
          <select class="ctrl-btn" id="sorting-option">
            <option value="" disabled selected>Sort by:</option>
            <option value="name">Name</option>
            <option value="price">Price</option>
            <option value="date">Date</option>
          </select>
        </div> -->
      </div>
    </div>

    <div class="design-container">
      
      <div class="design-filter-options">
        <div class="filter-con-label">
          <p>Filter</p>
          <button>
            <img src="images/svg/icons8-filter-24.png" alt="filter-icon">
          </button>
        </div>

          <!-- Price Range Slider -->
          <!-- <div class="price-range-slider">
              <label for="priceRange">Price Range: </label>
              <input type="range" id="priceRange" name="priceRange" min="1" max="15000" value="7500" oninput="updatePriceDisplay(this.value)">
              <span id="priceDisplay">₱7500</span>
          </div> -->

          <!-- Dual-Handle Range Slider -->
          <!-- <div class="slider-container">
            <label for="minPrice">Min Price: ₱<span id="minPriceLabel">1</span></label>
            <input type="range" id="minPrice" name="minPrice" min="1" max="15000" value="1" oninput="updatePriceDisplay()">
            <label for="maxPrice">Max Price: ₱<span id="maxPriceLabel">15000</span></label>
            <input type="range" id="maxPrice" name="maxPrice" min="1" max="15000" value="15000" oninput="updatePriceDisplay()">
          </div> -->

        <div class="filter-options">

          <div class="filter-price">
            <div class="slider-container">
              <h4><b>Price</b></h4><br>
              <div id="slider-range"></div>
              <p class="amount-value">₱<span id="amount"></span></p>
            </div>
          </div>

          <div class="filter-category">
            <h4><b>Category</b></h4>
            <ul>
              <li>
                <input type="checkbox" id="category1" name="category[]" value="Chocolate Moist">
                <label for="category1">Chocolate Moist</label>
              </li>
              <li>
                <input type="checkbox" id="category2" name="category[]" value="Carrot Cake">
                <label for="category2">Carrot Cake</label>
              </li>
              <li>
                <input type="checkbox" id="category3" name="category[]" value="Fondant Cake">
                <label for="category3">Fondant Cake</label>
              </li>
              <li>
                <input type="checkbox" id="category3" name="category[]" value="Fondant Cake">
                <label for="category3">Marble Cake</label>
              </li>
              <li>
                <input type="checkbox" id="category3" name="category[]" value="Fondant Cake">
                <label for="category3">Banana Cake</label>
              </li>
              <li>
                <input type="checkbox" id="category3" name="category[]" value="Fondant Cake">
                <label for="category3">Fruit Cake</label>
              </li>
              <li>
                <input type="checkbox" id="category3" name="category[]" value="Fondant Cake">
                <label for="category3">Mango Cake</label>
              </li>
              <li>
                <input type="checkbox" id="category3" name="category[]" value="Fondant Cake">
                <label for="category3">Chiffon Cake</label>
              </li>
            </ul>
          </div>

          <div class="filter-rating">
            <h4><b>Rating</b></h4>
            <ul>
              <li>
                <input type="checkbox" id="rating1" name="rating[]" value="1">
                <label for="rating1">1 Star</label>
              </li>
              <li>
                <input type="checkbox" id="rating2" name="rating[]" value="2">
                <label for="rating2">2 Stars</label>
              </li>
              <li>
                <input type="checkbox" id="rating3" name="rating[]" value="3">
                <label for="rating3">3 Stars</label>
              </li>
              <li>
                <input type="checkbox" id="rating4" name="rating[]" value="4">
                <label for="rating4">4 Stars</label>
              </li>
              <li>
                <input type="checkbox" id="rating5" name="rating[]" value="5">
                <label for="rating5">5 Stars</label>
              </li>
            </ul>
          </div>

          <div class="clear-filter">
            <button>✕ Clear Filters</button>
          </div>
        </div>
      </div>

      <div class="product-designs">

        <!-- sorting container and filtering option must be added after this -->
        

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


          <div class="pagenum-pagebutton">
            <div class="prev-next-button">      
            <button id="prev-btn" disabled>Previous</button>
            <button id="next-btn">Next</button>
            </div>

            <div class="page-numbers" id="page-numbers"></div>
          </div>

      </div>

    </div>
  </section>

         <!-- <script>
          // Function to update the price display
          function updatePriceDisplay(value) {
              document.getElementById('priceDisplay').textContent = '₱' + value;
          }
        </script> -->

        <!-- <script>
          // Function to update the price display labels
          function updatePriceDisplay() {
            var minPrice = document.getElementById('minPrice').value;
            var maxPrice = document.getElementById('maxPrice').value;
            document.getElementById('minPriceLabel').textContent = minPrice;
            document.getElementById('maxPriceLabel').textContent = maxPrice;
          }
        </script> -->

        <script>
        $( function() {
          $( "#slider-range" ).slider({
            range: true,
            min: 1,
            max: 15000,
            values: [ 1, 15000 ],
            slide: function( event, ui ) {
              $( "#amount" ).html( ui.values[ 0 ] + " - ₱" + ui.values[ 1 ] );
            }
          });
          $( "#amount" ).html( $( "#slider-range" ).slider( "values", 0 ) +
            " - ₱" + $( "#slider-range" ).slider( "values", 1 ) );
        } );
        </script>
  <?php include('partials/footer.php'); ?>