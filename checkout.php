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
                <li><a id="enable" href="checkout.php">
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
            <p>Step 2: Checkout Order</p>
        </div>
    </div>

    <div class="process-order-container">


      <div class="master-container">
        
        <div class="card cart">
          <div class="products">

              <label class="title">Your cart</label>
              
              <div class="checkedout-designs"></div>
              
              <div id="qpp__order__info__details" class="qpp__order__info__details" style="margin:0 0; padding: 20px;"></div>

              <div class="quantity">
                <button id="decrease">
                  <svg fill="none" viewBox="0 0 24 24" height="14" width="14" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" stroke="#47484b" d="M20 12L4 12"></path>
                  </svg>
                </button>
                <input type="number" value="1" min="1" class="quantity-input" id="quantityInput">
                <button id="increase">
                  <svg fill="none" viewBox="0 0 24 24" height="14" width="14" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" stroke="#47484b" d="M12 4V20M20 12H4"></path>
                  </svg>
                </button>
              </div>

          </div>
        </div>

        <div class="cart-footer">

          <div class="card coupons">
            <label class="title">Discount Code</label>
            <form class="form">
                <input type="text" placeholder="Enter code here" class="input_field">
                <button>Apply</button>
            </form>
          </div>

          <div class="card checkout">
            <label class="title">Checkout</label>
            <div class="details">
              <span>Subtotal:</span>
              <span id="subTotal">Loading..</span>
              <span>Money on Cake:</span>
              <span id="moneyCake">Loading..</span>
              <!-- example values for the money-cake and money-cake-info containers are ₱7000 -->
              <span>Shipping fee(s):</span>
              <span id="shipFee">₱0</span>
            </div>
            <div class="checkout--footer">
              <label id="totalPrice" class="price">Loading..</label>
              <button class="checkout-btn">Checkout</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

<?php include('partials/footer.php'); ?>
  
<script>
window.addEventListener('DOMContentLoaded', function () {
    const checkedOutDesignsContainer = document.querySelector('.checkedout-designs');
    const orderInfoDetailsContainer = document.getElementById('qpp__order__info__details');
    const subTotalContainer = document.getElementById('subTotal');

    const sessionOrderDetails = JSON.parse(sessionStorage.getItem('orderDetails')); // For direct orders
    const localOrderDetails = JSON.parse(localStorage.getItem('orderDetails')); // For customized orders

    // Function to calculate and display the subtotal
    function updateSubTotal() {
        let subTotal = 0;
        const quantityInput = document.getElementById('quantityInput');
        const quantity = quantityInput ? parseInt(quantityInput.value, 10) : 1;

        // Get the price from price-range-info if available
        const priceRangeInfo = document.getElementById('price-range-info');
        if (priceRangeInfo && priceRangeInfo.textContent.trim()) {
            const priceValue = parseInt(priceRangeInfo.textContent.replace('₱', ''), 10); // Extract integer value
            if (!isNaN(priceValue)) {
                subTotal += priceValue * quantity;
            }
        }

        // Get the price from product-price if available
        const productPrice = document.getElementById('product-price');
        if (productPrice && productPrice.textContent.trim()) {
            // Remove the '₱' sign and the word 'Amount' from the price
            const priceValue = parseInt(productPrice.textContent.replace('₱', '').replace('Amount', ''), 10);
            if (!isNaN(priceValue)) {
                subTotal += priceValue * quantity;
            }
        }

        // Display the subtotal in the container
        if (subTotalContainer) {
            subTotalContainer.textContent = `₱${subTotal.toLocaleString()}`; // Format with currency symbol
            console.log(`Updated Subtotal: ₱${subTotal}`);
        } else {
            console.warn('Subtotal container not found');
        }
    }

    // Function to calculate and display the money cake value
    function updateMoneyCake() {
        let moneyCakeValue = 0;

        // Get the value from money-cake if available
        const moneyCakeElement = document.getElementById('money-cake');
        if (moneyCakeElement && moneyCakeElement.textContent.trim()) {
            const value = parseInt(moneyCakeElement.textContent.replace('₱', ''), 10); // Extract integer value
            if (!isNaN(value)) {
                moneyCakeValue += value;
            }
        }

        // Get the value from money-cake-info if available
        const moneyCakeInfoElement = document.getElementById('money-cake-info');
        if (moneyCakeInfoElement && moneyCakeInfoElement.textContent.trim()) {
            const value = parseInt(moneyCakeInfoElement.textContent.replace('₱', ''), 10); // Extract integer value
            if (!isNaN(value)) {
                moneyCakeValue += value;
            }
        }

        // Display the money cake value in the container
        const moneyCakeContainer = document.getElementById('moneyCake');
        if (moneyCakeContainer) {
            moneyCakeContainer.textContent = `₱${moneyCakeValue.toLocaleString()}`; // Format with currency symbol
            console.log(`Updated Money Cake: ₱${moneyCakeValue}`);
        } else {
            console.warn('Money Cake container not found');
        }
    }

    // Function to calculate and display the total price
    function updateTotalPrice() {
        const subTotalElement = document.getElementById('subTotal');
        const shipFeeElement = document.getElementById('shipFee');
        const totalPriceElement = document.getElementById('totalPrice');
        const moneyCakeElement = document.getElementById('moneyCake');

        let subTotal = subTotalElement
            ? parseFloat(subTotalElement.textContent.trim().replace('₱', '').replace(',', ''))
            : 0;
        let shipFee = shipFeeElement
            ? parseFloat(shipFeeElement.textContent.trim().replace('₱', '').replace(',', ''))
            : 0;
        let moneyCake = moneyCakeElement
            ? parseFloat(moneyCakeElement.textContent.trim().replace('₱', '').replace(',', ''))
            : 0;

        // Calculate total price
        let totalPrice = subTotal + moneyCake + shipFee;

        // Update the total price container
        if (totalPriceElement) {
            totalPriceElement.textContent = `₱${totalPrice}`;
            console.log(`Updated Total Price: ₱${totalPrice}`);
        } else {
            console.warn('Total Price container not found');
        }
    }

    // Function to update the quantity input value
    function updateQuantity(change) {
        const quantityInput = document.getElementById('quantityInput');
        if (quantityInput) {
            let currentValue = parseInt(quantityInput.value, 10);
            if (!isNaN(currentValue)) {
                currentValue += change;
                if (currentValue < 1) currentValue = 1; // Ensure quantity is at least 1
                quantityInput.value = currentValue;
                console.log(`Updated Quantity: ${currentValue}`);
                updateSubTotal(); // Update subtotal when quantity changes
                updateTotalPrice(); // Update total price when quantity changes
            }
        } else {
            console.warn('Quantity input not found');
        }
    }

    // Add event listeners to the decrease and increase buttons
    const decreaseButton = document.getElementById('decrease');
    const increaseButton = document.getElementById('increase');

    if (decreaseButton) {
        decreaseButton.addEventListener('click', function () {
            updateQuantity(-1);
        });
    } else {
        console.warn('Decrease button not found');
    }

    if (increaseButton) {
        increaseButton.addEventListener('click', function () {
            updateQuantity(1);
        });
    } else {
        console.warn('Increase button not found');
    }

    // Function to display direct order details
    function loadDirectOrderDetails(orderDetails) {
        checkedOutDesignsContainer.innerHTML = `
            <div class="order_top_con">
                <h2 id="product-name" class="product-name">${orderDetails.productName}</h2>
            </div>
            <div class="order_details_con_grid">
                <div class="order_left_con">
                    <img id="cake-design" class="product-image" src="${orderDetails.productImage}" alt="Cake Design">
                </div>
                <div class="order_right_con">
                    <div class="cust-dedication-con">
                        <p class="label"><b>Dedication:</b></p>
                        <p id="dedication" class="dedication">${orderDetails.dedicationEnabled ? orderDetails.dedication : ''}</p>
                    </div>
                    <div class="product-options">
                        <p><b>Size: </b></p>
                        <span id="product-size">${orderDetails.productSize}</span>
                        <p><b>Flavor: </b></p><span id="flavor">${orderDetails.flavor}</span>
                    </div>
                    <div class="product-price">
                        <p class="label"><b>Price: </b></p>
                        <p id="product-price" class="product-price">${orderDetails.productPrice}</p>
                    </div>
                    ${orderDetails.moneyCakeEnabled ? `
                        <div id="co-moneycake-con" class="co-moneycake-con">
                            <p class="label">Money on Cake:</p>
                            <p id="money-cake" class="money-cake">₱${orderDetails.moneyCakeAmount}</p>
                        </div>
                    ` : ''}
                    <div class="cust-note-con">
                        <p class="label"><b>Notes:</b></p>
                        <p id="note" class="note">${orderDetails.note || ''}</p>
                    </div>
                </div>
            </div>
        `;
        checkedOutDesignsContainer.style.display = 'block'; // Ensure visibility
    }

    // Function to display customized order details
    function loadCustomizedOrderDetails(orderDetails) {
        const newHtml = `
            <div class="qpp__order__details__container">
                <p>Price Range:</p>
                <span id="price-range-info">${orderDetails.priceRange}</span>
            </div>
            <div class="qpp__order__details__container">
                <p>Cake Size:</p>
                <span id="cake-size-info">${orderDetails.cakeSize}</span>
            </div>
            <div class="qpp__order__reference__design" style="margin: 10px 0;">
                <p>Reference Cake Design</p>
                <div class="qpp__order__design__container" style="gap: 3px;"></div>
            </div>
            <div class="qpp__order__details__container">
                <p>Note:</p>
                <span id="design-notes-info">${orderDetails.designNotes}</span>
            </div>
            <div class="qpp__order__details__container">
                <p>Flavors:</p>
                <span id="flavors-info">${orderDetails.flavors}</span>
            </div>
            <div class="qpp__order__details__container">
                <p>Dedication:</p>
                <span id="dedication-info">${orderDetails.dedication}</span>
            </div>
            <div class="qpp__order__details__container">
                <p>Add-Ons:</p>
                <span id="add-ons-info">${orderDetails.addOns}</span>
            </div>
            <div class="qpp__order__details__container">
                <p>Money on Cake:</p>
                <span id="money-cake-info">₱${orderDetails.moneyCake}</span>
            </div>
        `;
        orderInfoDetailsContainer.innerHTML = newHtml;

        // Populate the design container with images and filenames
        const designContainer = orderInfoDetailsContainer.querySelector('.qpp__order__design__container');
        orderDetails.uploadedFiles.forEach(filePath => {
            const fileElement = document.createElement('div');
            fileElement.classList.add('qpp__file-preview-item');
            fileElement.innerHTML = `
                <p class="qpp__file-name">${filePath.split('/').pop()}</p>
                <img class="qpp__image-preview" src="${filePath}" alt="Uploaded Design">
            `;
            designContainer.appendChild(fileElement);
        });

        orderInfoDetailsContainer.style.display = 'block'; // Ensure visibility
    }

    // Logic to determine which data to load
    if (sessionOrderDetails) {
        loadDirectOrderDetails(sessionOrderDetails);
        orderInfoDetailsContainer.style.display = 'none'; // Hide customized container
    } else if (localOrderDetails) {
        loadCustomizedOrderDetails(localOrderDetails);
        checkedOutDesignsContainer.style.display = 'none'; // Hide direct order container
    } else {
        // Hide both containers if no order details exist
        checkedOutDesignsContainer.style.display = 'none';
        orderInfoDetailsContainer.style.display = 'none';
    }

    // Function to hide empty containers if child content is not populated
    function hideEmptyContainers() {
        // Array of container selectors to check for empty content
        const elementsToCheck = [
            'price-range-info',
            'cake-size-info',
            'flavors-info',
            'dedication-info',
            'add-ons-info',
            'money-cake-info',
            'design-notes-info',
            'product-name',
            'product-image',
            'dedication',
            'size',
            'flavor',
            'product-price',
            'money-cake',
            'note'
        ];

        // Check each container and hide if empty
        elementsToCheck.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                const content = element.textContent.trim(); // Ensure no leading/trailing whitespace
                console.log(`Checking element with ID: ${id}, Content: "${content}"`);
                if (!content) {
                    console.log(`Hiding parent of element with ID: ${id}`);
                    element.parentElement.style.display = 'none'; // Hide the parent container if empty
                }
            } else {
                console.warn(`Element with ID: ${id} not found`);
            }
        });

        // Check the design container for child elements
        const designContainer = document.querySelector('.qpp__order__design__container');
        if (designContainer) {
            if (!designContainer.hasChildNodes()) {
                console.log('Hiding design container as it has no content');
                designContainer.parentElement.style.display = 'none'; // Hide if no child elements
            }
        } else {
            console.warn('Design container not found');
        }

        // Check if all child containers in the main order details container are hidden
        const mainContainer = document.getElementById('qpp__order__info__details');
        if (mainContainer) {
            const childContainers = mainContainer.querySelectorAll('.qpp__order__details__container, .qpp__order__reference__design');
            const allHidden = Array.from(childContainers).every(child => child.style.display === 'none');

            if (allHidden) {
                console.log('Hiding the main container as all child containers are hidden');
                mainContainer.style.display = 'none'; // Hide the main container if all children are hidden
            }
        } else {
            console.warn('Main container not found');
        }
    }

    // Ensure elements are populated before running the update functions
    setTimeout(() => {
        hideEmptyContainers(); // Call the function to hide empty containers
        updateSubTotal(); // Call the function to update subtotal
        updateMoneyCake(); // Call the function to update money cake value
        updateTotalPrice(); // Call the function to update total price
    }, 1000); // Delay execution to ensure elements are populated

    
    // Function to extract data and redirect with query string
    function extractAndRedirect() {
        const orderInfoDetailsContainer = document.getElementById('qpp__order__info__details');
        const checkedOutDesignsContainer = document.querySelector('.checkedout-designs');
        const subTotalElement = document.getElementById('subTotal');
        const moneyCakeElement = document.getElementById('moneyCake');
        const shipFeeElement = document.getElementById('shipFee');
        const totalPriceElement = document.getElementById('totalPrice');

        // Object to hold the extracted data
        const orderData = {};

        // Extract details from the customized order container
        if (orderInfoDetailsContainer && orderInfoDetailsContainer.style.display !== 'none') {
            orderData.priceRange = document.getElementById('price-range-info')?.textContent.trim() || '';
            orderData.cakeSize = document.getElementById('cake-size-info')?.textContent.trim() || '';
            orderData.designNotes = document.getElementById('design-notes-info')?.textContent.trim() || '';
            orderData.flavors = document.getElementById('flavors-info')?.textContent.trim() || '';
            orderData.dedication = document.getElementById('dedication-info')?.textContent.trim() || '';
            orderData.addOns = document.getElementById('add-ons-info')?.textContent.trim() || '';
            orderData.moneyCake = document.getElementById('money-cake-info')?.textContent.trim() || '';

            // Collect uploaded file previews
            const uploadedFiles = [];
            const designContainer = orderInfoDetailsContainer.querySelector('.qpp__order__design__container');
            if (designContainer) {
                designContainer.querySelectorAll('img.qpp__image-preview').forEach(img => {
                    uploadedFiles.push(img.src);
                });
            }
            orderData.uploadedFiles = uploadedFiles;
        }

        // Extract details from the direct order container
        if (checkedOutDesignsContainer && checkedOutDesignsContainer.style.display !== 'none') {
            orderData.productId = sessionOrderDetails.productId; // Extract product ID
            orderData.productName = document.getElementById('product-name')?.textContent.trim() || '';
            orderData.productImage = document.getElementById('cake-design')?.src || '';
            orderData.dedication = document.getElementById('dedication')?.textContent.trim() || '';
            orderData.productSize = document.getElementById('product-size')?.textContent.trim() || '';
            orderData.flavor = document.getElementById('flavor')?.textContent.trim() || '';
            orderData.productPrice = document.getElementById('product-price')?.textContent.trim() || '';
            orderData.moneyCake = document.getElementById('money-cake')?.textContent.trim() || '';
            orderData.note = document.getElementById('note')?.textContent.trim() || '';
        }

        // Extract global details (subtotal, shipping fee, etc.)
        orderData.subTotal = subTotalElement?.textContent.trim() || '';
        orderData.moneyCakeValue = moneyCakeElement?.textContent.trim() || '';
        orderData.shipFee = shipFeeElement?.textContent.trim() || '';
        orderData.totalPrice = totalPriceElement?.textContent.trim() || '';

        // Extract quantity input value
        const quantityInput = document.getElementById('quantityInput');
        orderData.quantity = quantityInput ? quantityInput.value : '1';

        // Extract selected design ID from sessionStorage
        const selectedDesignId = sessionStorage.getItem('selectedDesignId');
        if (selectedDesignId) {
            orderData.selectedDesignId = selectedDesignId;
        }

        // Serialize data as a query string
        const queryString = new URLSearchParams(orderData).toString();

        // Redirect to the next page with the query string
        window.location.href = `place-order.php?${queryString}`;
    }

    // Attach the function to the checkout button
    const checkoutButton = document.querySelector('.checkout-btn');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', extractAndRedirect);
    } else {
        console.warn('Checkout button not found');
    }

});
</script>