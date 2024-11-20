
document.addEventListener("DOMContentLoaded", function() {
    const profileMenu = document.getElementById('profileMenu');
    const profileSubMenuBtn = document.querySelector('.profile__sub__menu__btn');
    const notificationContainer = document.getElementById('notification-container');
    const notificationTrigger = document.getElementById('notificationTrigger'); // Notifications button
    let hideTimeout;

    // Function to show the profile menu
    function showMenu() {
        clearTimeout(hideTimeout); // Cancel any pending hide action
        profileMenu.classList.add('show');
        profileMenu.classList.remove('hide');
    }

    // Function to show the notification container
    function showNotification() {
        clearTimeout(hideTimeout); // Cancel any pending hide action
        notificationContainer.classList.add('show');
        notificationContainer.classList.remove('hide');
    }

    // Function to hide the profile menu
    function hideMenu() {
        hideTimeout = setTimeout(function() {
            if (!profileMenu.matches(':hover')) {
                profileMenu.classList.add('hide'); // Start fade-out transition
                profileMenu.classList.remove('show');
            }
        }, 0);
    }

    // Function to hide the notification container (only after done hovering)
    function hideNotification() {
        hideTimeout = setTimeout(function() {
            if (!notificationContainer.matches(':hover') && !notificationTrigger.matches(':hover')) {
                notificationContainer.classList.add('hide'); // Start fade-out transition
                notificationContainer.classList.remove('show');
            }
        }, 0); 
    }

    // Ensure notification container stays visible when hovering over the notification button or container
    function keepNotificationVisible() {
        clearTimeout(hideTimeout); // Cancel the hide action if hovering on notification container
        notificationContainer.classList.add('show');
        notificationContainer.classList.remove('hide');
    }

    // Ensure profile menu stays visible when hovering over it or its submenu
    function keepMenuVisible() {
        clearTimeout(hideTimeout); // Cancel the hide action if hovering on profile menu
        profileMenu.classList.add('show');
        profileMenu.classList.remove('hide');
    }

    // Show menu when hovering over the button
    profileSubMenuBtn.addEventListener('mouseover', showMenu);

    // Show menu when hovering over the profile menu itself
    profileMenu.addEventListener('mouseover', showMenu);

    // Show notification container when hovering over the notification button
    notificationTrigger.addEventListener('mouseover', showNotification);

    // Hide the notification container when mouse leaves both the button and the notification container 
    notificationTrigger.addEventListener('mouseout', hideNotification);
    notificationContainer.addEventListener('mouseout', hideNotification);

    // Prevent hiding while hovering on the notification-container
    notificationContainer.addEventListener('mouseover', keepNotificationVisible);

    // Hide the menu when mouse leaves the profile button or the profile menu
    profileSubMenuBtn.addEventListener('mouseout', hideMenu);
    profileMenu.addEventListener('mouseout', hideMenu);

    // hide the profile menu when mouse leaves the notification container
    notificationContainer.addEventListener('mouseout', hideMenu);

    // show again the profile menu when mouse hovered again on the notification container
    notificationContainer.addEventListener('mouseover', keepMenuVisible);

    

    // profile__menu buttons FUNCTIONALITIES

    // Get the logout button element
    const logoutButton = document.getElementById('logoutButton');

    // Add click event listener to the logout button
    logoutButton.addEventListener('click', function() {
        window.location.href = 'logout.php'; // Redirect to logout.php
    });

    // Other existing code...
    


});

// Function to add a notification to the container
function addNotification(message, type) {
    var container = document.getElementById("notification-container");

    // Create a new notification item
    var notification = document.createElement("div");
    notification.className = "notification-item notification-" + type;

    // Create notification message
    var messageSpan = document.createElement("span");
    messageSpan.textContent = message;

    // Create close button
    var closeBtn = document.createElement("span");
    closeBtn.className = "close-btn";
    closeBtn.textContent = "×";
    closeBtn.onclick = function () {
    container.removeChild(notification);
    };

    // Append message and close button to notification
    notification.appendChild(messageSpan);
    notification.appendChild(closeBtn);

    // Append notification to container
    container.appendChild(notification);
}