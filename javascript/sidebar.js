document.addEventListener('DOMContentLoaded', function() {

    // TOGGLE BURGER MENU
    function toggleBurger() {
        var sidebar = document.querySelector('.sidebar');
        var menuText = document.getElementById('menu');
        var burgerMenu = document.querySelector('.burger-menu');
        var burgerCheckbox = document.getElementById('burger');
        var mainContent = document.querySelector('.main-content');
        var navigation = document.querySelector('.navigation'); // Select the navigation element
        var sbMenus = document.querySelectorAll('.sb-menu'); // Select all the sidebar menu items
        var sbBottom = document.getElementById('sidebar-bottom'); // Select the sidebar-bottom
        var sbBottomMenus = document.querySelectorAll('.sb-bottom-menu'); // Select all the sidebar-bottom menu items

        // Toggle the sidebar-closed class based on the checkbox state
        if (burgerCheckbox.checked) {
            sidebar.classList.add('sidebar-closed');
            sidebar.classList.remove('tooltip-disabled'); // Remove 'tooltip-disabled' class when checked
            menuText.style.visibility = 'hidden';
            menuText.style.opacity = '0';
            burgerMenu.classList.add('burger-menu-transformed');
            mainContent.style.margin = '10px 25px 0 85px';
            mainContent.style.padding = '0';
            mainContent.style.paddingTop = 'var(--topbar-height)';
            sbBottom.classList.add('sidebar-closed');

            // Hide the text of the sidebar menu items
            sbMenus.forEach(function(menu) {
                menu.style.display = 'none';
            });

            // Hide the text of the sidebar-bottom menu items
            sbBottomMenus.forEach(function(menu) {
                menu.style.display = 'none';
            });
        } else {
            sidebar.classList.remove('sidebar-closed');
            sidebar.classList.add('tooltip-disabled'); // Add 'tooltip-disabled' class when unchecked
            sbBottom.classList.remove('sidebar-closed');
            menuText.style.visibility = 'visible';
            menuText.style.opacity = '1';
            burgerMenu.classList.remove('burger-menu-transformed');
            mainContent.style.margin = ''; // Add original margin if any
            mainContent.style.padding = ''; // Add original padding if any
            mainContent.style.paddingTop = ''; // Add original padding-top if any

            // Show the text of the sidebar menu items
            sbMenus.forEach(function(menu) {
                menu.style.display = 'inline';
            });

            // Show the text of the sidebar-bottom menu items
            sbBottomMenus.forEach(function(menu) {
                menu.style.display = 'inline';
            });
        }
    }

    document.getElementById('burger').addEventListener('change', toggleBurger);


    // Assuming 'sidebar' and 'sidebar-bottom' are the sidebar elements
    var sidebar = document.querySelector('.sidebar');
    var sidebarBottom = document.querySelector('.sidebar-bottom');
    var burgerCheckbox = document.getElementById('burger');

    // Assuming 'sidebar-menu' is the sidebar menu element
    var sidebarMenu = document.querySelector('.sidebar-menu');

    // Get the computed style of the sidebar menu
    var style = window.getComputedStyle(sidebarMenu);

    // Calculate the total width
    var totalWidth = sidebarMenu.offsetWidth + 
                parseInt(style.marginLeft) + 
                parseInt(style.marginRight) +
                parseInt(style.paddingLeft) + 
                parseInt(style.paddingRight) +
                parseInt(style.borderLeftWidth) + 
                parseInt(style.borderRightWidth);

    function setTooltipState() {
        // Toggle the sidebar-closed class based on the checkbox state
        if (burgerCheckbox.checked) {
            sidebar.classList.add('sidebar-closed');
            sidebar.classList.remove('tooltip-disabled'); // Remove 'tooltip-disabled' class when checked
            sidebarBottom.classList.add('sidebar-closed');
            sidebarBottom.classList.remove('tooltip-disabled');
        } else {
            sidebar.classList.remove('sidebar-closed');
            sidebar.classList.add('tooltip-disabled'); // Add 'tooltip-disabled' class when unchecked
            sidebarBottom.classList.remove('sidebar-closed');
            sidebarBottom.classList.add('tooltip-disabled');
        }
    }

    // Set initial tooltip state when the page is loaded
    window.addEventListener('load', setTooltipState);

    // Update tooltip state when the burger button is toggled
    burgerCheckbox.addEventListener('change', setTooltipState);

    // Set the CSS variable
    document.documentElement.style.setProperty('--sidebar-width', totalWidth + 'px');
    console.log(window.getComputedStyle(document.documentElement).getPropertyValue('--sidebar-width'));

    // Set initial state of burger checkbox when the page is loaded
    window.addEventListener('load', function() {
        // Check if the sidebar is visible
        var sidebar = document.querySelector('.sidebar');
        var isSidebarVisible = window.getComputedStyle(sidebar).display !== 'none';

        // Set the state of the burger checkbox
        var burgerCheckbox = document.getElementById('burger');
        burgerCheckbox.checked = !isSidebarVisible;

        // Set initial tooltip state
        setTooltipState();
    });

    // Listen for window resize
    window.addEventListener('resize', function() {
        var burgerCheckbox = document.getElementById('burger');

        // Check if the viewport is less than 700px
        if (window.matchMedia('(max-width: 700px)').matches) {
            // If burger is not already checked, check it
            if (!burgerCheckbox.checked) {
                burgerCheckbox.checked = true;
                toggleBurger();
            }
        } else {
            // If burger is checked, uncheck it
            if (burgerCheckbox.checked) {
                burgerCheckbox.checked = false;
                toggleBurger();
            }
        }
    });


    // dynamically update the margin-left property based on the sidebar's width when the burger menu is toggled
    var sidebar = document.querySelector('.sidebar');
    var overlayContent = document.querySelector('.overlay-content');
    var burgerCheckbox = document.getElementById('burger');
    
    // Function to dynamically update margin-left based on sidebar width
    function updateMarginLeft() {
        var sidebarWidth = window.getComputedStyle(sidebar).getPropertyValue('--sidebar-width');
        
        // Check if the burger menu is checked (collapsed)
        if (burgerCheckbox.checked) {
            overlayContent.style.marginLeft = '70px'; // Disable margin-left when sidebar is collapsed
        } else {
            overlayContent.style.marginLeft = sidebarWidth; // Set margin-left to the sidebar's width
        }
    }

    // Run updateMarginLeft on page load to set initial state
    window.addEventListener('load', updateMarginLeft);

    // Run updateMarginLeft every time the burger menu is toggled
    burgerCheckbox.addEventListener('change', updateMarginLeft);

    // Optional: Update margin-left on window resize in case the sidebar width changes
    window.addEventListener('resize', updateMarginLeft);



});

