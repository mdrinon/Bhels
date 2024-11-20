<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>


<section id="white-bg-content " class="main-content"> 

    <!-- <div id="notification-container" class="notification-container"></div>

    <button onclick="addNotification('This is a success notification!', 'success')">Add Success</button>
    <button onclick="addNotification('This is an error notification!', 'error')">Add Error</button>
    <button onclick="addNotification('This is a warning notification!', 'warning')">Add Warning</button> -->

<div>
    <div id="welcome-section">
        <div class="ws-container">
            <!-- flex layout same with the admin dashboard -->
            <div class="ws-column-con">

            <div class="ws-tag-con">
                <h1>Tailored Treats for Every Occasion!</h1>
                <p>Explore custom cakes that match your unique style for any occasion. From birthdays to weddings, choose from a variety of flavors and designs, or create something special. Make your celebration memorable with a delicious cake that perfectly fits the moment!</p>

                <a href="customize.php">Order Now</a>
                <?php
                // Check if the user is logged in
                if (!isset($_SESSION['username'])) {
                    // If the user is not logged in, show the sign-up button
                    echo '<a href="signup.php" class="cta-button">Sign Up for Free</a>';
                }
                // If the user is logged in, the button will not be displayed
                ?>
            </div>

                <?php
                    // Load Composer's autoloader for MongoDB
                    require 'vendor/autoload.php';

                    // Connect to the MongoDB
                    $client = new MongoDB\Client("mongodb://localhost:27017");
                    $collection = $client->bheldb->blogposts;

                    // Fetch all blogposts that have media_type 'video'
                    $cursor = $collection->find(['media_type' => 'video']);

                    // Prepare an array to store the video URLs
                    $videos = [];

                    foreach ($cursor as $blogpost) {
                        // Append the video URL to the videos array
                        $videos[] = $blogpost['media_url'];
                    }
                ?>
                <div class="carousel-vid-col-con">

                    <div class="ws__carousel">
                        <?php foreach ($videos as $index => $video): ?>
                            <div class="carousel__item <?php 
                                // Assign classes based on the index
                                if ($index == 0) {
                                    echo 'carousel__item--left';
                                } elseif ($index == 1) {
                                    echo 'carousel__item--main';
                                } elseif ($index == 2) {
                                    echo 'carousel__item--right';
                                }
                            ?>">
                                <video id="player" class="js-player" crossorigin playsinline>
                                    <source src="ADMIN/<?php echo $video; ?>" type="video/mp4" size="720">
                                </video>
                            </div>
                        <?php endforeach; ?>

                        <div class="carousel__btns">
                            <button class="carousel__btn" id="leftBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor" fill-rule="evenodd" d="m15 4l2 2l-6 6l6 6l-2 2l-8-8z"/>
                                </svg>
                            </button>
                            <button class="carousel__btn" id="rightBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor" fill-rule="evenodd" d="m9.005 4l8 8l-8 8L7 18l6.005-6L7 6z"/>
                                </svg>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- <div id="hp__carousel-section">
        <h1 class="hp__carousel-section">FEATURED DESIGNS</h1>

        <div class="hp__wrapper">
            <button class="hp__arrow__btn prev" onclick="hpcar__prevSlide()">‹</button>
            <div class="hp__carousel" id="hp__carousel">

                <?php
                    require 'vendor/autoload.php';

                    // Connect to the MongoDB
                    $client = new MongoDB\Client("mongodb://localhost:27017");
                    $collection = $client->bheldb->cake_designs;

                    // Fetch all cake designs (you can add filters if needed)
                    $cursor = $collection->find([]); // Add conditions if you want to filter

                    // Prepare an array to store featured images
                    $featuredImages = [];

                    foreach ($cursor as $design) {
                        // Check if media contains an image and store it
                        if (isset($design['media']['image'])) {
                            $featuredImages[] = $design['media']['image'];
                        }
                    }
                ?>

                <?php foreach ($featuredImages as $image): ?>
                    <div class="hp__item">
                        <img src="ADMIN/<?php echo $image; ?>" alt="Describe Image">
                    </div>
                <?php endforeach; ?>

            </div>
            <button class="hp__arrow__btn next" onclick="hpcar__nextSlide()">›</button>
        </div>
</div>   -->


<!-- <div id="hp__customize-sec">
 
    <div class="question_pop_up_container">
        <div class="qpp__form-group qpp__active" id="question1">
            <label class="qpp__question-label">Cakes often come up in discussions.</label>
            <div class="qpp__btn-group">
                <button class="qpp__btn-option">Customize cake</button>
                <button class="qpp__btn-option">Browse cakes</button>
            </div>
        </div>
    </div>
</div> -->













<!-- <div id="hp__customize-sec">
    <div class="hp__customize-section">
        <div class="hp__order-section">
            <h2>Shop now</h2>
            <form id="order-form">
                <label for="design-upload">Upload your design</label>
                <input type="file" id="design-upload" name="design-upload" accept="image/*">
                <button type="submit">Submit Order</button>
            </form>
        </div>
        <div class="hp__customize-tutorial-vid">
            <video width="320" height="240" controls>
                <source src="sample_tutorial.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>

 
</div> -->


















</section>


<script src="https://cdn.plyr.io/3.6.8/plyr.js"></script>
<script>
    'use strict';

    const carouselItems = document.querySelectorAll('.carousel__item');
    console.log(carouselItems)
    let currentItem = document.querySelector('.carousel__item--main');
    const leftBtn = document.querySelector('#leftBtn');
    const rightBtn = document.querySelector('#rightBtn');


    rightBtn.addEventListener('click', function() {
        currentItem = document.querySelector('.carousel__item--right');
        const leftItem = document.querySelector('.carousel__item--main');
        carouselItems.forEach((item,i) => {
            item.classList = 'carousel__item';
        });
        currentItem.classList.add('carousel__item--main');
        leftItem.classList.add('carousel__item--left');
        const currentId = Array.from(carouselItems).indexOf(currentItem);
        const rightItem = currentId === carouselItems.length -1 ? carouselItems[0] : carouselItems[currentId +1];
        rightItem.classList.add('carousel__item--right');
    });

    leftBtn.addEventListener('click', function() {
        currentItem = document.querySelector('.carousel__item--left');
        const rightItem = document.querySelector('.carousel__item--main');
        carouselItems.forEach((item,i) => {
            item.classList = 'carousel__item';
        });
        currentItem.classList.add('carousel__item--main');
        rightItem.classList.add('carousel__item--right');
        const currentId = Array.from(carouselItems).indexOf(currentItem);
        const leftItem = currentId === 0 ? carouselItems[carouselItems.length-1] : carouselItems[currentId-1];
        leftItem.classList.add('carousel__item--left');
    });
  
    var playerSettings = {
        controls : ['play-large'],
        fullscreen : { enabled: false},
        resetOnEnd : true,
        hideControls  :true,
    clickToPlay:true,
        keyboard : false,
        }

    const players = Plyr.setup('.js-player', playerSettings);

    players.forEach(function(instance,index) {
                instance.on('play',function(){
                    players.forEach(function(instance1,index1){
                    if(instance != instance1){
                            instance1.pause();
                        }
                    });
                });
            });

    $('.video-section').on('translated.owl.carousel', function (event) {
    players.forEach(function(instance,index1){
                    instance.pause();
                    });
    });

</script>

<script>
    let position = 0;
    const hp__carousel = document.getElementById('hp__carousel');
    const totalItems = hp__carousel.children.length - 2; // Adjusted for cloned elements
    let autoSlideInterval;

    // Clone first and last items for seamless transition
    const firstItem = hp__carousel.children[1].cloneNode(true); // Skipping cloned last item
    const lastItem = hp__carousel.children[totalItems].cloneNode(true); // Skipping cloned first item
    hp__carousel.appendChild(firstItem);
    hp__carousel.insertBefore(lastItem, hp__carousel.children[0]);

    function updateCarousel() {
        const itemWidth = hp__carousel.children[1].clientWidth; // Skip the cloned first item
        hp__carousel.style.transition = 'transform 0.5s ease';
        hp__carousel.style.transform = `translateX(-${(position + 1) * itemWidth}px)`; // (position + 1) to account for cloned item
    }

    function hpcar__nextSlide() {
        const itemWidth = hp__carousel.children[1].clientWidth;
        if (position < totalItems - 1) {
            position++;
        } else {
            position = 0;
            hp__carousel.style.transition = 'none';
            hp__carousel.style.transform = `translateX(-${itemWidth}px)`; // Jump to actual first cloned item
            setTimeout(() => {
                hp__carousel.style.transition = 'transform 0.5s ease';
                position = 1;
                updateCarousel();
            }, 50);
            return;
        }
        updateCarousel();
    }

    function hpcar__prevSlide() {
        const itemWidth = hp__carousel.children[1].clientWidth;
        if (position > 0) {
            position--;
        } else {
            position = totalItems - 2;
            hp__carousel.style.transition = 'none';
            hp__carousel.style.transform = `translateX(-${(totalItems) * itemWidth}px)`; // Jump to actual last cloned item
            setTimeout(() => {
                hp__carousel.style.transition = 'transform 0.5s ease';
                position--;
                updateCarousel();
            }, 50);
            return;
        }
        updateCarousel();
    }

    function startAutoSlide() {
        autoSlideInterval = setInterval(hpcar__nextSlide, 2000); // Change slide every 2 seconds
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    document.querySelectorAll('.hp__item').forEach(hp__item => {
        hp__item.addEventListener('mouseenter', stopAutoSlide);
        hp__item.addEventListener('mouseleave', startAutoSlide);
    });

    window.addEventListener('resize', updateCarousel);

    // Start the auto slide when the page loads
    startAutoSlide();
    updateCarousel();
</script>
<script>
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
            closeBtn.className = "close_notif_btn";
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
        function closeBanner() {
    document.getElementById('welcomeBanner').style.display = 'none';
}

    </script>

<?php include('partials/footer.php'); ?>

  