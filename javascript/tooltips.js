        // TOGGLE TOOLTIP POSITION
        function toggleTooltip() {
            var tooltips = document.querySelectorAll('.tooltip'); // Select all the tooltip elements
            var burgerCheckbox = document.getElementById('burger');

            // Log the selected elements to the console
            console.log(tooltips);
            console.log(burgerCheckbox);

            // Toggle the move-left class based on the checkbox state
            tooltips.forEach(function(tooltip) {
                if (burgerCheckbox.checked) {
                    tooltip.classList.add('move-left');
                } else {
                    tooltip.classList.remove('move-left');
                }
            });
        }

        // Set initial tooltip position when the page is loaded
        window.addEventListener('load', toggleTooltip);