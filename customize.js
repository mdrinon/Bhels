// show and hiding functions for the questions and the back arrow button

        let currentQuestionNumber = 1; // Track the current question number globally

        // Handle showing the next question and hiding the current one
        function nextQuestion(questionNumber) {
            const currentQuestion = document.querySelector('.qpp__form-group.qpp__active');
            currentQuestion.classList.remove('qpp__active');
            
            const nextQuestion = document.getElementById('question' + questionNumber);
            nextQuestion.classList.add('qpp__active');
            
            // Update the global current question tracker
            currentQuestionNumber = questionNumber;

            // Show the back arrow after the first question
            if (questionNumber > 1) {
                document.getElementById('qpp__back-arrow').style.display = 'block';
            } else {
                document.getElementById('qpp__back-arrow').style.display = 'none';
            }
        }

        // Function to go back to the previous question
        function goBack() {
            const currentQuestion = document.querySelector('.qpp__form-group.qpp__active');
            const questionNumber = currentQuestionNumber;

            // Logic to go back based on the current question number
            if (questionNumber > 1) {
                currentQuestion.classList.remove('qpp__active');

                if (questionNumber === 4 && document.getElementById('single__cake').style.display !== 'none') {
                    // If we're in Question 4 and selected "Single Cake" in Question 2, go back to Question 2
                    currentQuestionNumber = 2;
                } else if (questionNumber === 4 && document.getElementById('tiered__cake').style.display !== 'none') {
                    // If we're in Question 4 and selected "Tiered Cake" in Question 2, go back to Question 2
                    currentQuestionNumber = 2;
                } else if (questionNumber === 5) {
                    // Special case for Question 5, go directly back to Question 3
                    currentQuestionNumber = 3;
                } else {
                    // In all other cases, just go back to the previous question
                    currentQuestionNumber--;
                }

                // Show the previous question
                const prevQuestion = document.getElementById('question' + currentQuestionNumber);
                prevQuestion.classList.add('qpp__active');
            }

            // Hide the back arrow if on the first question
            if (currentQuestionNumber === 1) {
                document.getElementById('qpp__back-arrow').style.display = 'none';
            }
        }
        

        
// Function to confirm redirect to the browse cakes page
        // Confirm redirect before browsing cakes
        function confirmRedirect() {
            const userConfirmation = confirm("Do you want to browse cakes and proceed to checkout?");
            
            if (userConfirmation) {
                // If user clicks 'Yes', redirect to the designs.php page
                window.location.href = "designs.php";
            } else {
                // If user clicks 'No', do nothing (remain on the same page)
                return false;
            }
        }



// second pop up question starts here

        // Function to toggle the "Continue" button based on selected options
        function toggleContinueButton() {
            const budgetSelect = document.getElementById('budget-select').value;
            const continueButton = document.getElementById('continue-budget-btn');
            const cakeTiersOption = document.querySelector('.qpp__cake__tiers_option');

            // Display cake tiers options if "flexible" is selected; otherwise, show/hide accordingly
            if (budgetSelect === "flexible") {
                continueButton.style.display = 'none';
                cakeTiersOption.style.display = 'block';
                showAllCakes();
            } else {
                continueButton.style.display = 'none';
                cakeTiersOption.style.display = 'none';
                if (budgetSelect) {
                    filterCakesByBudget(budgetSelect);
                } else {
                    showAllCakes();
                }
            }
        }

        // Function to check if a valid selection has been made from the filtered cakes or sizes
        function checkForSelection() {
            const selectedSingleCake = document.querySelector('#filtered-single-cakes .cake-option.active');
            const selectedTieredCake = document.querySelector('#filtered-tiered-cakes .cake-option.active');
            const selectedProductSize = document.getElementById('product-size-pricing').value;
            const continueButton = document.getElementById('continue-budget-btn');

            // Show continue button only if a valid option is selected
            if (selectedSingleCake || selectedTieredCake || selectedProductSize) {
                continueButton.style.display = 'inline-block';
            } else {
                continueButton.style.display = 'none';
            }
        }

        // Event listeners for single and tiered cake options
        document.querySelectorAll('.cake-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.cake-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                checkForSelection(); // Check if a valid option is selected
            });
        });

        // Event listener for product size selection
        const productSizeSelect = document.getElementById('product-size-pricing');
        if (productSizeSelect) {
            productSizeSelect.addEventListener('change', function() {
                checkForSelection();
            });
        }

        // Event listener for budget select dropdown
        document.getElementById('budget-select').addEventListener('change', toggleContinueButton);

        // Show all cakes function (implement your display logic here)
        function showAllCakes() {
            document.querySelectorAll('.cake-option').forEach(option => option.style.display = 'block');
        }

        

        // Function to handle the cake layers selection and continue to the next question
        function handleCakeContinue() {
            // Confirm a cake selection has been made before hiding elements
            const singleCakeContainer = document.getElementById('single__cake');
            const tieredCakeContainer = document.getElementById('tiered__cake');

            if (singleCakeContainer.style.display === 'block' || tieredCakeContainer.style.display === 'flex') {
                // Hide selected cake containers
                singleCakeContainer.style.display = 'none';
                tieredCakeContainer.style.display = 'none';

                // Update question to next (Question 4)
                currentQuestionNumber = 4;
                document.getElementById('question4').classList.add('qpp__active');
                document.getElementById('question2').classList.remove('qpp__active');
            }
        }
     
        

        //funtion to set the display of "filtered-cake-selections" into block afer the user select the budget
        function toggleFilteredSelections() {
            // Get the selected budget value
            const budgetSelect = document.getElementById("budget-select");
            const selectedBudget = budgetSelect.value;

            // Get the filtered selections container
            const filteredSelections = document.getElementById("filtered-cake-selections");

            // Show filtered selections if budget is chosen and not 'flexible'
            if (selectedBudget && selectedBudget !== "flexible") {
                filteredSelections.style.display = "block";
            } else {
                filteredSelections.style.display = "none";
            }
        }

        // Add event listener to call the function when selection changes
        document.getElementById("budget-select").addEventListener("change", toggleFilteredSelections);



        function filterCakesByBudget(budgetRange) {
            let minPrice, maxPrice;

            // Determine price range for filtering
            if (budgetRange.includes('+')) {
                minPrice = parseInt(budgetRange);
                maxPrice = Infinity;
            } else {
                [minPrice, maxPrice] = budgetRange.split('-').map(price => parseInt(price));
            }

            // Filter single cakes and count visible results
            let singleCakesVisible = 0;
            document.querySelectorAll('#filtered-single-cakes .cake-option').forEach(cake => {
                const price = parseInt(cake.getAttribute('data-price'));
                const isVisible = (price >= minPrice && (maxPrice === Infinity || price <= maxPrice));
                cake.style.display = isVisible ? 'block' : 'none';
                if (isVisible) singleCakesVisible++;
            });

            // Filter tiered cakes and count visible results
            let tieredCakesVisible = 0;
            document.querySelectorAll('#filtered-tiered-cakes .cake-option').forEach(cake => {
                const price = parseInt(cake.getAttribute('data-price'));
                const isVisible = (price >= minPrice && (maxPrice === Infinity || price <= maxPrice));
                cake.style.display = isVisible ? 'block' : 'none';
                if (isVisible) tieredCakesVisible++;
            });

            // Toggle visibility of single cakes label
            document.getElementById('filter__single__cake__label').style.display = singleCakesVisible > 0 ? 'block' : 'none';

            // Toggle visibility of tiered cakes label
            document.getElementById('filter__tiered__cake__label').style.display = tieredCakesVisible > 0 ? 'block' : 'none';

            // Show "No available Cake Sizes Found" message if both sections are empty
            const noResultsMessage = document.getElementById('no-results-message');
            if (!noResultsMessage) {
                const message = document.createElement('div');
                message.id = 'no-results-message';
                message.style.display = 'none';
                message.style.color = 'red';
                message.innerHTML = 'No available Cake Sizes Found';
                document.getElementById('filtered-cake-selections').appendChild(message);
            }

            document.getElementById('no-results-message').style.display = (singleCakesVisible === 0 && tieredCakesVisible === 0) ? 'block' : 'none';

            // Reinitialize the selection functionality after filtering
            initializeCakeOptionSelection();
        }

        // Function to handle selection and checkmark display for cake options
        function initializeCakeOptionSelection(selector) {
            const cakeOptions = document.querySelectorAll(selector);

            cakeOptions.forEach(cakeOption => {
                cakeOption.addEventListener('click', function () {
                    // Remove 'selected' class from all cake options on the page
                    document.querySelectorAll('.cake-option').forEach(option => option.classList.remove('selected'));

                    // Add 'selected' class to the clicked option
                    this.classList.add('selected');

                    // Enable the continue button after a selection is made (if applicable)
                    const continueButton = document.getElementById('continue-budget-btn');
                    if (continueButton) {
                        continueButton.style.display = 'inline-block';
                    }
                });
            });
        }

        // Call this function for different sets of cake options
        initializeCakeOptionSelection('.qpp__cake__selection__table .cake-option');
        initializeCakeOptionSelection('#filtered-single-cakes .cake-option');
        initializeCakeOptionSelection('#filtered-tiered-cakes .cake-option');


        

        function handleBudgetSelection() {
            const budgetSelect = document.getElementById("budget-select");
            const selectedBudget = budgetSelect.value;
            
            // Containers
            const filteredSelections = document.getElementById("filtered-cake-selections");
            const tieredOptionContainer = document.querySelector(".qpp__cake__tiers_option");

            // Logic for showing/hiding containers based on budget selection
            if (selectedBudget === "flexible") {
                // Show tiered options container and hide filtered selections
                filteredSelections.style.display = "none";
                tieredOptionContainer.style.display = "block";
            } else if (selectedBudget) {
                // Show filtered selections if budget is a valid range and not 'flexible'
                filteredSelections.style.display = "block";
                tieredOptionContainer.style.display = "none";
            } else {
                // Hide both containers if no selection or invalid selection
                filteredSelections.style.display = "none";
                tieredOptionContainer.style.display = "none";
            }
        }

        // Add event listener to trigger the function on selection change
        document.getElementById("budget-select").addEventListener("change", handleBudgetSelection);

// </script>   


// <script>
