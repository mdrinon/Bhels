// Function to update order details based on selected cake options

        function updateOrderDetails() {
            // Select all cake-option elements and the single cake dropdown
            document.querySelectorAll('.cake-option, #product-size-pricing').forEach(cakeOption => {
                // Add event listener for clicks on cake-option elements and change event for the dropdown
                if (cakeOption.id === 'product-size-pricing') {
                    cakeOption.addEventListener('change', function() {
                        const selectedOption = cakeOption.options[cakeOption.selectedIndex];
                        
                        // Check if data attributes are present (for size and price)
                        const price = selectedOption.getAttribute('data-price');
                        const size = selectedOption.getAttribute('data-size');

                        // Update order details if valid
                        if (price && size) {
                            document.getElementById('price-range-info').innerText = `₱${price} Above`;
                            document.getElementById('cake-size-info').innerText = `${size} - Single Cake`;
                        }
                    });
                } else {
                    cakeOption.addEventListener('click', function() {
                        // Determine cake type based on the container
                        const isSingleCake = this.closest('#filtered-single-cakes') || this.closest('#product-size-pricing');
                        const cakeType = isSingleCake ? 'Single Cake' : 'Tiered Cake';

                        // Get price and size data
                        const price = this.getAttribute('data-price');
                        const size = JSON.parse(this.getAttribute('data-size'));

                        // Format size
                        const formattedSize = Array.isArray(size) ? size.map(s => `${s}`).join(', ') : size;

                        // Update order details
                        document.getElementById('price-range-info').innerText = `₱${price} Above`;
                        document.getElementById('cake-size-info').innerText = `${formattedSize} - ${cakeType}`;
                        document.getElementById('cake-size-info').innerText = `${formattedSize} - ${cakeType}`;
                    });
                }
            });
        }

        // Initialize event listeners
        updateOrderDetails();


        // Function to handle the cake flavors, dedication, and add-ons selection
        function endSurvey() {
            const flavorsSelect = document.getElementById('flavors-select');
            const dedicationInput = document.getElementById('dedication-input');
            const moneyCakeInput = document.getElementById('money-cake-input');

            // Get the selected values
            const selectedFlavors = flavorsSelect.value;
            const selectedDedication = dedicationInput.value;
            const selectedMoneyCake = moneyCakeInput.value;

            // Update the order details based on the selected values
            document.getElementById('flavors-info').innerText = selectedFlavors;
            document.getElementById('dedication-info').innerText = selectedDedication;
            document.getElementById('money-cake-info').innerText = selectedMoneyCake;

            // Hide the survey section
            document.getElementById('survey-section').style.display = 'none';

            // Show the buttons
            document.getElementById('qpp__edit__order__btn').style.display = 'block';
            document.getElementById('qpp__submit__order__btn').style.display = 'block';

            // Redirect to the order summary section
            document.querySelector('.qpp__order__summary').scrollIntoView({ behavior: 'smooth' });

            // end survey
            endSurvey();
        }


        function editOrder() {
            // Show the survey section again for editing
            document.getElementById('survey-section').style.display = 'block';
            // Scroll to the survey section
            document.getElementById('survey-section').scrollIntoView({ behavior: 'smooth' });
            // Hide checkout button
            document.getElementById('qpp__submit__order__btn').style.display = 'none';
        }


// Function to store the data of the .qpp__order__design__container in localStorage
function storeDesignContainer() {
    const designContainer = document.querySelector('.qpp__order__design__container');
    const designContainerHTML = designContainer.innerHTML;
    localStorage.setItem('designContainerHTML', designContainerHTML);
}

// Function to checkout the order and redirect to the checkout page
function checkoutOrder() {
    const orderDetails = {
        priceRange: document.getElementById('price-range-info').innerText,
        cakeSize: document.getElementById('cake-size-info').innerText,
        flavors: document.getElementById('flavors-info').innerText,
        dedication: document.getElementById('dedication-info').innerText,
        moneyCake: document.getElementById('money-cake-info').innerText,
        designNotes: document.getElementById('design-notes-info').innerText,
        uploadedFiles: selectedFiles.map(file => `ADMIN/uploads/uploadedDesignReferences/${file.uniqueFileName}`)  // Store full paths
    };

    // Save order details to localStorage
    localStorage.setItem('orderDetails', JSON.stringify(orderDetails));
    
    // Store the design container HTML
    storeDesignContainer();

    window.location.href = "checkout.php";

    // Clear order details from sessionStorage
    sessionStorage.removeItem('orderDetails');
}

// Function to load the saved order details from local storage
function loadOrderDetails() {
    const savedOrderDetails = JSON.parse(localStorage.getItem('orderDetails'));

    if (savedOrderDetails) {
        document.getElementById('price-range-info').innerText = savedOrderDetails.priceRange;
        document.getElementById('cake-size-info').innerText = savedOrderDetails.cakeSize;
        document.getElementById('flavors-info').innerText = savedOrderDetails.flavors;
        document.getElementById('dedication-info').innerText = savedOrderDetails.dedication;
        document.getElementById('money-cake-info').innerText = savedOrderDetails.moneyCake;
        document.getElementById('design-notes-info').innerText = savedOrderDetails.designNotes;

        // Load images from the uploaded file paths
        const designContainer = document.querySelector('.qpp__order__design__container');
        designContainer.innerHTML = ''; // Clear any existing content
        savedOrderDetails.uploadedFiles.forEach(filePath => {
            const fileElement = document.createElement('div');
            fileElement.classList.add('qpp__file-preview-item');
            fileElement.innerHTML = `
                <p class="qpp__file-name">${filePath.split('/').pop()}</p>
                <img class="qpp__image-preview" src="${filePath}">
            `;
            designContainer.appendChild(fileElement);
        });
    }
}

// Function to check if order details are already populated
function checkOrderDetailsOnLoad() {
    const orderDetails = JSON.parse(localStorage.getItem('orderDetails'));
    if (orderDetails) {
        // Hide the survey section
        document.getElementById('survey-section').style.display = 'none';

        // Show the order summary and buttons
        document.querySelector('.qpp__order__summary').style.display = 'block';
        document.getElementById('qpp__edit__order__btn').style.display = 'block';
        document.getElementById('qpp__submit__order__btn').style.display = 'block';
    }
}

// Call this function when the page loads
window.addEventListener('DOMContentLoaded', () => {
    loadOrderDetails();
    checkOrderDetailsOnLoad();
});

// Function to clear storage after inactivity
function clearStorageAfterInactivity() {
    const inactivityTime = 10 * 60 * 1000; // 10 minutes
    let inactivityTimer;

    function resetTimer() {
        clearTimeout(inactivityTimer);
        inactivityTimer = setTimeout(() => {
            localStorage.clear();
            sessionStorage.clear();
            alert('Your session has expired due to inactivity.');
        }, inactivityTime);
    }

    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
}

// Call the function to start the inactivity timer
clearStorageAfterInactivity();