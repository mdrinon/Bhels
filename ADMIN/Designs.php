<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>
<?php include('../dbconnect.php'); ?>

<link rel="stylesheet" href="partials/blog.css">

<section class="main-content">

    <div class="navigation">
      <div class="menu-tab"><h6><b>Designs</b></h6></div>
      <div class="nav-label"><h2>Designs</h2></div>
       <div class="group-right">
        <div class="searchbar">

            <div class="SB__InputContainer">
                <input type="text" name="text" class="SB__input" id="input" placeholder="Search">
                
                <label for="input" class="SB__labelforsearch">
                    <svg viewBox="0 0 512 512" class="SB__searchIcon">
                        <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path>
                    </svg>
                </label>
                
                <div class="SB__border"></div>
                
                <button class="SB__micButton" id="micButton">
                    <svg viewBox="0 0 384 512" class="SB__micIcon">
                        <path d="M192 0C139 0 96 43 96 96V256c0 53 43 96 96 96s96-43 96-96V96c0-53-43-96-96-96zM64 216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 89.1 66.2 162.7 152 174.4V464H120c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H216V430.4c85.8-11.7 152-85.3 152-174.4V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 70.7-57.3 128-128 128s-128-57.3-128-128V216z"></path>
                    </svg>
                </button>
            </div>

        </div>
      </div>
    </div>

    <div class="design-container">
      
      <div class="design-filter-options">
        <div class="filter-con-label">
          <p>Filter</p>
          <button>
            <img src="../images/svg/icons8-filter-24.png" alt="filter-icon">
          </button>
        </div>


        <div class="filter-options">

          <?php

            try {

                // Fetch the minimum and maximum prices from the collection
                $cakesCollection = $db->cake_designs; 

                // Aggregation to find min and max price
                $minPriceResult = $cakesCollection->aggregate([
                    ['$group' => ['_id' => null, 'minPrice' => ['$min' => '$price']]]
                ])->toArray();

                $maxPriceResult = $cakesCollection->aggregate([
                    ['$group' => ['_id' => null, 'maxPrice' => ['$max' => '$price']]]
                ])->toArray();

                // Assign the values
                $minPrice = isset($minPriceResult[0]['minPrice']) ? $minPriceResult[0]['minPrice'] : 0;
                $maxPrice = isset($maxPriceResult[0]['maxPrice']) ? $maxPriceResult[0]['maxPrice'] : 0;

            } catch (Exception $e) {
                // Handle connection errors
                echo "Unable to connect to the database: ", $e->getMessage();
                exit();
            }
          ?>

          <div class="filter-price">
            <div class="slider-container">
              <h4><b>Price</b></h4><br>
              <div id="slider-range"></div>
              <p class="amount-value"><span id="amount"></span></p>
            </div>
          </div>

          <?php
              try {
                  // Fetch unique cake types
                  $cakeTypesResult = $cakesCollection->distinct("type");

                  // Fetch unique cake occasions
                  $cakeOccasionsResult = $cakesCollection->distinct("occasion");

              } catch (Exception $e) {
                  // Handle connection errors
                  echo "Unable to connect to the database: ", $e->getMessage();
                  exit();
              }
          ?>

          <!-- Cake Type Filter -->
          <div class="filter-category">
              
              <div class="filter__div">
                <h4><b>Type</b></h4>
                <button id="filterByType" type="button">Apply</button>
              </div>
              <ul id="type-filter-options">
                  <?php foreach ($cakeTypesResult as $type): ?>
                      <li>
                          <input type="checkbox" name="category[]" value="<?php echo $type; ?>">
                          <label><?php echo $type; ?></label>
                      </li>
                  <?php endforeach; ?>
              </ul>
          </div>

          <!-- Cake Occasion Filter -->
          <div class="filter-category">
              <div class="filter__div">
                <h4><b>Occasion</b></h4>
                <button id="filterByOccasion" type="button">Apply</button>
              </div>
              <ul id="occasion-filter-options">
                  <?php foreach ($cakeOccasionsResult as $occasion): ?>
                      <li>
                          <input type="radio" name="occasion" value="<?php echo $occasion; ?>">
                          <label><?php echo $occasion; ?></label>
                      </li>
                  <?php endforeach; ?>
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
        <!-- designs in card gallery -->
        <?php

          try {

              // Select the collection
              $collection = $db->cake_designs;

              // Fetch all cake designs sorted by date in descending order
              $cursor = $collection->find([], ['sort' => ['date' => -1]]);
              
              // Initialize min and max price
              $minPrice = PHP_INT_MAX;
              $maxPrice = 0;

              // Loop to determine the min and max price
              foreach ($cursor as $design) {
                  $price = $design['price'];
                  if ($price < $minPrice) {
                      $minPrice = $price;
                  }
                  if ($price > $maxPrice) {
                      $maxPrice = $price;
                  }
              }

              // Reset the cursor to fetch cake designs again sorted by date
              $cursor = $collection->find([], ['sort' => ['date' => -1]]);

          } catch (Exception $e) {
              echo "Unable to connect to the database: ", $e->getMessage();
              exit();
          }
        ?>

        <?php
            foreach ($cursor as $design): ?>
                <div class="product" 
                    data-id="<?php echo $design['_id']->__toString(); ?>" 
                    data-name="<?php echo htmlspecialchars($design['name']); ?>" 
                    data-image="<?php echo $design['media']['image']; ?>" 
                    data-designer="<?php echo $design['designer']; ?>" 
                    data-date="<?php echo $design['date']; ?>" 
                    data-description="<?php echo $design['description']; ?>" 
                    data-price="<?php echo $design['price']; ?>"
                    data-size="<?php echo htmlspecialchars($design['size']); ?>"
                    data-occasion="<?php echo $design['occasion']; ?>"
                    data-type="<?php echo $design['type']; ?>">

                    <div class="card product-card">
                    <!-- onclick="showOverlay('<-?php echo $design['_id']->__toString(); ?>')" -->
                        <div class="card-image">
                            <img src="<?php echo $design['media']['image']; ?>" alt="Cake Design" id="design-image" class="design-image">
                            <?php if (!empty($design['media']['image'])): ?>
                                <button id="dlbtn" class="DLBtn" onclick="downloadImage('<?php echo $design['media']['image']; ?>', '<?php echo $design['designer']; ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512" class="svgIcon">
                                        <path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path>
                                    </svg>
                                    <span class="icon2"></span>
                                </button>
                            <?php else: ?>
                                <button id="dlbtn" class="DLBtn" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512" class="svgIcon">
                                        <path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path>
                                    </svg>
                                    <span class="icon2"></span>
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="category"> <?php echo $design['type']; ?> </div>
                        <div class="heading">
                          <div class="name"><?php echo htmlspecialchars($design['name']); ?></div>

                        </div>
                        <div class="product-card-con-bottom">
                            <div class="author"> By <span class="name"><?php echo $design['designer']; ?></span> <?php echo $design['date']; ?> </div>
                            <!-- <div class="like-btn">
                                <label class="heart-container">
                                    <input type="checkbox" checked="checked">
                                    <div class="checkmark">
                                        <svg viewBox="0 0 256 256">
                                            <rect fill="none" height="256" width="256"></rect>
                                            <path d="M224.6,51.9a59.5,59.5,0,0,0-43-19.9,60.5,60.5,0,0,0-44,17.6L128,59.1l-7.5-7.4C97.2,28.3,59.2,26.3,35.9,47.4a59.9,59.9,0,0,0-2.3,87l83.1,83.1a15.9,15.9,0,0,0,22.6,0l81-81C243.7,113.2,245.6,75.2,224.6,51.9Z" stroke-width="20px" stroke="#FFF" fill="none"></path>
                                        </svg>
                                    </div>
                                </label>
                            </div> -->
                            <div class="buy-now">
                              <p class="card__view__preview" onclick="showOverlay(this)">View↗️</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

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

      
  <div id="overlay" class="overlay">
      <div class="overlay-content">
          <button id="closeOverlay">❌</button>
          <div class="overlay-container">
              <div class="product-container">
                  <h1 class="product-title">Loading...</h1>
                  <div class="product-grid-container">
                      <div class="first-product-grid-container">
                          <div class="carousel-container">
                              <div class="carousel">
                                  <div class="carousel-images" id="carouselImages">
                                      <img src="" alt="Product Image" class="product-image">
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="second-product-grid-container">
                          <div class="product-grid-container-selection">
                              <div class="pgc-description">
                                  <p class="pgct-description">Loading description...</p>
                              </div>
                              <div class="product-con-price-ratings">
                                  <div class="price-container">
                                      <table>
                                          <tr class="priceRange">
                                              <td><b>Price Range</b></td>
                                              <td>
                                                  <b style="color: #000;">: </b><i style="font-size:15px"></i>
                                                  <span class="product-price" style="color: green;"></span>
                                              </td>
                                          </tr>
                                          <tr class="addedPrice">
                                            <td><i>Size</i></td>
                                            <td><b>: <i id="product-size" class="product-size"></i></b></td>
                                          </tr>
                                          <tr class="cakeType">
                                              <td><i>Type</i></td>
                                              <td><b>: <i id="cakeType">value here</i></b></td>
                                          </tr>
                                          <tr class="cakeOccasion">
                                              <td><i>Occasion</i></td>
                                              <td><b>: <i id="cakeOccasion">value here</i></b></td>
                                          </tr>
                                          <tr class="cakeDesigner">
                                              <td><i>Designer</i></td>
                                              <td><b>: <i id="cakeDesigner">value here</i></b></td>
                                          </tr>
                                          <tr class="cakeDate">
                                              <td><i>Date Created</i></td>
                                              <td><b>: <i id="cakeDate">value here</i></b></td>
                                          </tr>
                                      </table>
                                  </div>
                              </div>
                            </div>       
                            <div class="product-buttons-container" style="justify-content: left;">
                                <button id="edit_cake_btn" class="button"> update </button>
                                <button id="delete_cake_btn" class="button">Delete</button>
                            </div>
                        </div>  
                      </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
</section>
<section class="create-post">

    <div class="create-button">
        <div class="blog_hb_menu_container">
            <button class="blog__menu__icon">
                <span class="blog_hb_menu_btn"></span>
                <span class="blog_hb_menu_btn"></span>
                <span class="blog_hb_menu_btn"></span>
            </button>
            <div class="menu-buttons">
                <button onclick="window.location.href='Add_new_design.php'" class="add-button">
                    <span>Add</span>
                    <video src="images/svg/Plus.mp4"></video>
                </button>
            </div>
        </div>
    </div>

</section>


  <script>

// SPEECH RECOGNITION JAVASCRIPT
// Check if the browser supports the Web Speech API
const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
if (SpeechRecognition) {
    const recognition = new SpeechRecognition();
    recognition.continuous = false; // To stop recognition after one sentence
    recognition.lang = 'en-US'; // Set the language
    recognition.interimResults = false; // Only finalize results

    const micButton = document.getElementById('micButton');
    const input = document.getElementById('input');
    let isRecording = false; // Track the recording state

    micButton.addEventListener('click', function() {
        if (isRecording) {
            // If recording, stop recognition and reset state
            recognition.stop();
            micButton.classList.remove('recording'); // Remove the echo effect
            isRecording = false;
        } else {
            // If not recording, start recognition
            recognition.start();
            micButton.classList.add('recording'); // Add the echo effect
            isRecording = true;
        }
    });

    recognition.addEventListener('result', function(event) {
        const speechToText = event.results[0][0].transcript;
        input.value = speechToText; // Set the transcribed text to the input field

        // Trigger search after speech input
        performSearch(speechToText);
    });

    recognition.addEventListener('end', function() {
        micButton.classList.remove('recording'); // Remove the echo effect when recording stops
        isRecording = false; // Reset recording state
    });

} else {
    alert("Your browser doesn't support speech recognition.");
}

// Function to perform search
function performSearch(query) {
    // Create an AJAX request to send the search query to the server
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'search.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Update the product designs with the search results
            const resultsContainer = document.querySelector('.wrapper');
            resultsContainer.innerHTML = xhr.responseText; // Populate with search results
        }
    };
    xhr.send('query=' + encodeURIComponent(query)); // Send the query to the server
}



    // Function to perform the search
    function triggerSearch(query) {
        console.log("Triggering search for query:", query); // Log the search query
        // Create a new FormData object
        const formData = new FormData();
        formData.append('query', query);

        // Make an AJAX request to the search.php script
        fetch('search.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text()) // Convert the response to text
        .then(data => {
            console.log("Search results received:", data); // Log the response from the PHP script
            const productDisplay = document.querySelector('.products-display'); // Adjust the selector to match your existing product display area
            productDisplay.innerHTML = data; // Replace existing products with the new results
        })
        .catch(error => console.error('Error:', error));
    }

    // SEARCH FUNCTIONALITY USING THE SEARCH.PHP FILE
    document.getElementById('input').addEventListener('input', function() {
        let searchQuery = this.value.trim();

        // If the input is not empty, make an AJAX request to the backend
        if (searchQuery.length > 0) {
            $.ajax({
                url: 'search.php',  // This PHP file will handle the search query
                method: 'POST',
                data: {
                    query: searchQuery
                },
                success: function(response) {
                    // Update the product design container with the new filtered designs
                    document.querySelector('.design-container .wrapper').innerHTML = response;
                },
                error: function() {
                    console.error('An error occurred while searching.');
                }
            });
        } else {
            // If search bar is cleared, reset the designs to show all available products
            location.reload();
        }
    });


    
    $(function() {
        // Slider functionality
        $("#slider-range").slider({
            range: true,
            min: <?php echo $minPrice; ?>,
            max: <?php echo $maxPrice; ?>,
            values: [<?php echo $minPrice; ?>, <?php echo $maxPrice; ?>],
            slide: function(event, ui) {
                $("#amount").html("₱" + ui.values[0] + " - ₱" + ui.values[1]);
                filterDesigns(ui.values[0], ui.values[1]);
            }
        });

        // Ensure both min and max prices are displayed when the page loads
        $("#amount").html("₱" + $("#slider-range").slider("values", 0) + " - ₱" + $("#slider-range").slider("values", 1));

        // Filter designs function
        function filterDesigns(minPrice, maxPrice) {
            $(".product").each(function() {
                var price = parseInt($(this).data("price"));
                if (price >= minPrice && price <= maxPrice) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });

     // Function to filter cake designs by Type
     document.getElementById("filterByType").addEventListener("click", function() {
        // Get all checked checkboxes
        let selectedTypes = [];
        document.querySelectorAll("#type-filter-options input[type='checkbox']:checked").forEach(function(checkbox) {
            selectedTypes.push(checkbox.value);
        });

        // If no type is selected, show all products
        if (selectedTypes.length === 0) {
            document.querySelectorAll(".product").forEach(function(product) {
                product.style.display = "block";
            });
            return;
        }

        // Loop through each product and hide or show based on selected types
        document.querySelectorAll(".product").forEach(function(product) {
            let productType = product.querySelector(".category").textContent.trim();
            if (selectedTypes.includes(productType)) {
                product.style.display = "block"; // Show the product
            } else {
                product.style.display = "none"; // Hide the product
            }
        });
    });

    document.getElementById("filterByOccasion").addEventListener("click", function() {
        // Get selected occasion from radio buttons
        let selectedOccasion = document.querySelector("#occasion-filter-options input[type='radio']:checked");

        // If no occasion is selected, show all products
        if (!selectedOccasion) {
            document.querySelectorAll(".product").forEach(function(product) {
                product.style.display = "block";
            });
            return;
        }

        // Get the selected occasion value
        selectedOccasion = selectedOccasion.value;

        // Loop through each product and hide or show based on the selected occasion
        document.querySelectorAll(".product").forEach(function(product) {
            let productOccasion = product.getAttribute("data-occasion").trim();
            if (productOccasion === selectedOccasion) {
                product.style.display = "block"; // Show the product
            } else {
                product.style.display = "none"; // Hide the product
            }
        });
    });

    document.querySelector(".clear-filter button").addEventListener("click", function() {
      // Reset Price Slider
      $("#slider-range").slider("values", 0, <?php echo $minPrice; ?>);
      $("#slider-range").slider("values", 1, <?php echo $maxPrice; ?>);
      $("#amount").html("₱" + <?php echo $minPrice; ?> + " - ₱" + <?php echo $maxPrice; ?>);

      // Show all products for reset
      $(".product").show(); // Show all products initially

      // Uncheck all type checkboxes
      document.querySelectorAll("#type-filter-options input[type='checkbox']").forEach(function(checkbox) {
          checkbox.checked = false; // Uncheck all type checkboxes
      });

      // Uncheck all occasion radio buttons
      document.querySelectorAll("#occasion-filter-options input[type='radio']").forEach(function(radio) {
          radio.checked = false; // Uncheck all occasion radios
      });

      // Reset and show all products after resetting filters
      filterDesigns(<?php echo $minPrice; ?>, <?php echo $maxPrice; ?>); // Show all products based on the reset price range
    });





    // Show the overlay and populate it with data
    function showOverlay(button) {
        const productElement = button.closest('.product');
        
        // Extract product data from data attributes
        const productName = productElement.getAttribute('data-name');
        const productImage = productElement.getAttribute('data-image');
        const productDesigner = productElement.getAttribute('data-designer');
        const productDate = productElement.getAttribute('data-date');
        const productDescription = productElement.getAttribute('data-description');
        const productPrice = productElement.getAttribute('data-price');
        const productSize =productElement.getAttribute('data-size');
        
        // Populate the overlay content
        document.querySelector('.product-title').textContent = productName;
        document.querySelector('.product-image').src = productImage;
        document.querySelector('.product-image').alt = productName;
        document.querySelector('.product-size').textContent = productSize;
        document.querySelector('.pgct-description').textContent = productDescription;
        document.querySelector('.product-price').textContent = `₱${productPrice}`;
        document.getElementById('cakeType').textContent = productElement.getAttribute('data-type');
        document.getElementById('cakeOccasion').textContent = productElement.getAttribute('data-occasion');
        document.getElementById('cakeDesigner').textContent = productDesigner;
        document.getElementById('cakeDate').textContent = productDate;
        
        // Show the overlay
        overlay.style.display = 'flex';

        // Add event listener for the update button
        document.getElementById('edit_cake_btn').addEventListener('click', function() {
            const cakeId = productElement.getAttribute('data-id');
            window.location.href = `Edit_cake_design.php?id=${cakeId}`;
        });

        // Add event listener for the delete button
        document.getElementById('delete_cake_btn').addEventListener('click', function() {
            const cakeId = productElement.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this cake design?')) {
                window.location.href = `delete_cake_design.php?id=${cakeId}`;
            }
        });
    }

    // Hide the overlay when the close button is clicked
    closeOverlay.addEventListener('click', function() {
        overlay.style.display = 'none';
    });


    // overlay toggle function
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

