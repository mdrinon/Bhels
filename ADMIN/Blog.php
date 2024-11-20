<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>

<link rel="stylesheet" href="partials/blog.css">
<?php include '../dbconnect.php'; ?>

<section class="main-content">
    <div class="blog-container">
        <div class="blog-left-container">
            <div class="blog-header">
                <h2>DISCOVER OUR LATEST POST</h2>
            </div>

            <div class="blog-content">
                <?php
                // Select the collection
                $collection = $db->blogposts;

                // Fetch the blog posts
                $cursor = $collection->find();

                foreach ($cursor as $post): ?>
                    <div class="blog-card">
                        <div class="blog-card-image">
                            <?php if ($post['media_type'] == 'video'): ?>
                                <video controls>
                                    <source src="<?php echo $post['media_url']; ?>" type="video/mp4">
                                </video>
                            <?php else: ?>
                                <img src="<?php echo $post['media_url']; ?>" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="blog-card-content">
                            <h4><b><?php echo $post['title']; ?></b></h4>
                            <p><?php echo $post['content']; ?></p>
                            
                            <div class="blog-card-bot-section">

                                 <img src="uploads/avatars/<?php echo $post['designer_avatar']; ?>" alt="">
                                
                                <p class="Designer"><?php echo $post['designer_name']; ?></p>
                                <p><?php echo $post['date']; ?></p>
                            </div><br>
                            <button class="edit-post-btn" data-id="<?php echo $post['_id']; ?>">Edit</button>
                            <button class="delete-post-btn" data-id="<?php echo $post['_id']; ?>" data-media-url="<?php echo $post['media_url']; ?>">Delete</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


        <div class="blog-right-container">

            <div class="blog-search">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="icon">
                    <g>
                    <path
                        d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"
                    ></path>
                    </g>
                </svg>
                <input class="input" type="search" placeholder="Read about.." />
            </div>

            <br><h3>TOP POSTS</h3>

            <?php
            // Fetch the top posts (e.g., based on views or likes)
            $topPostsCursor = $collection->find([], ['limit' => 5, 'sort' => ['views' => -1]]);

            foreach ($topPostsCursor as $topPost): ?>
                <div class="blog-right-card">
                    <div class="blog-right-card-img">
                        <video autoplay muted loop style="height: 50px;"> 
                            <source src="images/svg/cake_placeholder.mp4">
                        </video>
                    </div>
                    <h4><b><?php echo $topPost['title']; ?></b></h4>
                </div>
            <?php endforeach; ?>

            <br>
            <h3>FOLLOW US</h3>

            <div class="social-media-icons">
                <div class="socials-container">
                    <a class="social-button" href="#">
                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <path
                        d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"
                        ></path>
                    </svg>
                    </a>
                    <a class="social-button" href="#">
                    <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                        <path
                        d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"
                        ></path>
                    </svg>
                    </a>
                    <a class="social-button" href="#">
                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <path
                        d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"
                        ></path>
                    </svg>
                    </a>
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
                <button onclick="window.location.href='Create_new_post.php'" class="add-button">
                    <span>Add</span>
                    <video src="images/svg/Plus.mp4"></video>
                </button>
                <!-- <button class="edit-button">
                    <span>Edit</span>
                    <video src="images/svg/Left.mp4"></video>
                </button> -->
            </div>
        </div>
    </div>

</section>

<!-- Modal for updating blog post -->
<div id="updatePostModal" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <h2>Update Post</h2>
        <form id="updatePostForm" method="post" enctype="multipart/form-data">
            <input type="hidden" id="post_id" name="post_id">
            <label for="title">Title:</label>
            <input type="text" id="update_title" name="title" required>
            
            <label for="content">Content:</label>
            <textarea id="update_content" name="content" cols="30" rows="10" required></textarea>
            
            <label for="designer_name">Designer:</label>
            <input type="text" id="update_designer_name" name="designer_name" required>
            
            <label for="date">Date:</label>
            <input type="date" id="update_date" name="date" required>
            
            <label for="category">Category:</label>
            <input type="text" id="update_category" name="category" required>
            
            <label for="tags">Tags:</label>
            <input type="text" id="update_tags" name="tags">
            
            <label for="media_file">Media File:</label>
            <input type="file" id="update_media_file" name="media_file" accept="image/*,video/*">
            
            <label for="avatar">Avatar:</label>
            <select id="update_avatar" name="avatar" required>
                <option value="" selected disabled>Select Avatar</option>
                <!-- Options will be populated dynamically -->
            </select>
            
            <button type="submit" name="update_post" class="btn btn-primary">Update Post</button>
            <br><br>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality
    var updateModal = document.getElementById("updatePostModal");
    var updateClose = updateModal.getElementsByClassName("modal-close")[0];

    updateClose.onclick = function() {
        updateModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == updateModal) {
            updateModal.style.display = "none";
        }
    }

    // Edit button functionality
    document.querySelectorAll('.edit-post-btn').forEach(function(btn) {
        btn.onclick = function() {
            var postId = btn.getAttribute('data-id');
            
            // Fetch post data from the server
            fetch('get_post.php?id=' + postId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('post_id').value = data._id;
                    document.getElementById('update_title').value = data.title;
                    document.getElementById('update_content').value = data.content;
                    document.getElementById('update_designer_name').value = data.designer_name;
                    document.getElementById('update_date').value = data.date;
                    document.getElementById('update_category').value = data.category;
                    document.getElementById('update_tags').value = data.tags;

                    // Populate avatar options
                    var avatarSelect = document.getElementById('update_avatar');
                    avatarSelect.innerHTML = '<option value="" selected disabled>Select Avatar</option>';
                    data.avatars.forEach(function(avatar) {
                        var option = document.createElement('option');
                        option.value = avatar.value;
                        option.textContent = avatar.label;
                        if (avatar.value === data.designer_avatar) {
                            option.selected = true;
                        }
                        avatarSelect.appendChild(option);
                    });

                    updateModal.style.display = "block";
                })
                .catch(error => console.error('Error fetching post data:', error));
                // hide the section 'create-post' when the modal is open
                document.querySelector('.create-post').style.display = 'none';
        }
    });

    // Delete button functionality
    document.querySelectorAll('.delete-post-btn').forEach(function(btn) {
        btn.onclick = function() {
            var postId = btn.getAttribute('data-id');
            var mediaUrl = btn.getAttribute('data-media-url');

            if (confirm('Are you sure you want to delete this post?')) {
                fetch('delete_post.php?id=' + postId + '&media_url=' + encodeURIComponent(mediaUrl), {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Post deleted successfully.');
                        window.location.reload();
                    } else {
                        alert('Error deleting post: ' + data.error);
                    }
                })
                .catch(error => console.error('Error deleting post:', error));
            }
        }
    });
});
</script>