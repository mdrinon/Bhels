<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>

<?php
require '../dbconnect.php'; // Ensure your dbconnect.php path is correct

// Debugging: Verify the connection to the database
/*
if (!$db) {
    echo '<p>Database connection failed.</p>';
    exit();
} else {
    echo '<p>Database connection successful.</p>';
}
*/

// Fetch avatars from the 'blogposts' collection
$blogpostsCollection = $db->blogposts;
$avatarsCursor = $blogpostsCollection->distinct('designer_avatar');

// Default avatars
$defaultAvatars = [
    // ['value' => 'a1.jpg', 'image' => '../data/blog/a1.jpg', 'label' => 'Avatar 1'],
    // ['value' => 'a2.jpg', 'image' => '../data/blog/a2.jpg', 'label' => 'Avatar 2'],
    // ['value' => 'a3.jpg', 'image' => '../data/blog/a3.jpg', 'label' => 'Avatar 3'],
    // ['value' => 'a4.jpg', 'image' => '../data/blog/a4.jpg', 'label' => 'Avatar 4'],
    // ['value' => 'a5.jpg', 'image' => '../data/blog/a5.jpg', 'label' => 'Avatar 5'],
    // ['value' => 'a6.jpg', 'image' => '../data/blog/a6.jpg', 'label' => 'Avatar 6'],
    ['value' => 'new', 'image' => '', 'label' => 'Upload New Avatar']
];

// Combine fetched avatars with default ones
$avatars = [];
foreach ($defaultAvatars as $defaultAvatar) {
    $avatars[$defaultAvatar['value']] = $defaultAvatar;
}

foreach ($avatarsCursor as $avatar) {
    if (!isset($avatars[$avatar])) {
        $avatars[$avatar] = [
            'value' => $avatar,
            'image' => 'uploads/avatars/' . $avatar, // Adjust path as necessary
            'label' => 'Avatar ' . (count($avatars) + 1) // Dynamic labeling; adjust as needed
        ];
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form has already been submitted
    if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted']) {
        echo '<p>Form has already been submitted. Please refresh the page.</p>';
        exit();
    }

    $title = $_POST['title'];
    $content = $_POST['content'];
    $designer_name = $_POST['designer_name'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];
    $media_type = null;
    $media_url = null;
    $designer_avatar = $_POST['avatar'];

    // Handle avatar upload if a new avatar is selected
    if (isset($_FILES['new_avatar_file']) && $_FILES['new_avatar_file']['error'] == UPLOAD_ERR_OK) {
        $avatar_file = $_FILES['new_avatar_file'];
        $upload_dir = 'uploads/avatars/';

        // Ensure upload directory exists
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0755, true)) {
                echo '<p>Failed to create avatar upload directory.</p>';
                exit();
            }
        }

        // Generate a unique filename for the avatar
        $existing_avatars = glob($upload_dir . 'a*.jpg'); // Get all existing avatars
        $existing_numbers = array_map(function ($file) use ($upload_dir) {
            return intval(str_replace(['a', '.jpg'], '', basename($file)));
        }, $existing_avatars);
        $next_number = $existing_numbers ? max($existing_numbers) + 1 : 1;
        $avatar_filename = 'a' . $next_number . '.jpg';
        $target_file = $upload_dir . $avatar_filename;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($avatar_file['tmp_name'], $target_file)) {
            // Set the avatar filename to be saved in the database
            $designer_avatar = $avatar_filename;
        } else {
            echo '<p>Error uploading avatar file. Please try again.</p>';
            exit();
        }
    }

    // Handle media file upload
    if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['media_file'];
        $upload_dir = 'uploads/';

        // Ensure upload directory exists
        if (!is_dir($upload_dir)) {
            if (mkdir($upload_dir, 0755, true)) {
                // Debugging: Show upload directory creation message
                /*
                echo '<p>Upload directory created: ' . $upload_dir . '</p>';
                */
            } else {
                echo '<p>Failed to create upload directory.</p>';
                exit();
            }
        }

        // Generate a unique filename
        $date_str = date('Ymd');
        $file_number = count(glob($upload_dir . $date_str . '*')) + 1;
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $file_name = $date_str . sprintf('%03d', $file_number) . '.' . $extension;
        $target_file = $upload_dir . $file_name;

        // Debugging: Show file details
        /*
        echo '<p>File to be uploaded:</p>';
        echo '<pre>';
        print_r($file);
        echo '</pre>';
        echo '<p>Target file: ' . $target_file . '</p>';
        */

        // Get file type (image or video)
        $file_type = mime_content_type($file['tmp_name']);
        if (strpos($file_type, 'image') !== false) {
            $media_type = 'image';
        } elseif (strpos($file_type, 'video') !== false) {
            $media_type = 'video';
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Debugging: Show file upload success message
            /*
            echo '<p>File uploaded successfully.</p>';
            */
            $media_url = $target_file;
        } else {
            echo '<p>Error uploading file. Please try again.</p>';
            exit();
        }
    } else {
        echo '<p>No file uploaded or an error occurred during file upload.</p>';
    }

    // Prepare data for MongoDB
    $postData = [
        'title' => $title,
        'content' => $content,
        'designer_name' => $designer_name,
        'date' => $date,
        'category' => $category,
        'tags' => $tags,
        'media_type' => $media_type,
        'media_url' => $media_url,
        'designer_avatar' => $designer_avatar
    ];

    // Debugging: Show the data to be inserted
    /*
    echo '<p>Data to be inserted into the database:</p>';
    echo '<pre>';
    print_r($postData);
    echo '</pre>';
    */

    // Insert the post into MongoDB
    try {
        $blogpostsCollection = $db->blogposts; // Use the correct 'blogposts' collection
        $result = $blogpostsCollection->insertOne($postData);
        
        // Set the session variable to prevent re-submission
        $_SESSION['form_submitted'] = true;

        // Display an alert box and redirect to the blog page
        echo '<script type="text/javascript">';
        echo 'alert("Post added successfully. Click \'OK\' to redirect to blog page.");';
        echo 'window.location.href = "Blog.php";';
        echo '</script>';
        exit();
    } catch (Exception $e) {
        echo '<p>Error adding post: ' . $e->getMessage() . '</p>';
    }

}

// Reset the form submission state on page load
$_SESSION['form_submitted'] = false;
?>


<section class="main-content">
    <div class="bcp-con">
        <div class="blog-top-container">
            <h2 class="header_label">ADD A POST</h2>
            <button class="cancel_btn">x</button>
        </div>
        <div class="blog-new-post-con">
            <div class="new-post-form">
                <form id="postForm" method="post" enctype="multipart/form-data">
                    <div class="upload-image">
                        <div class="upload-image-icon">
                            <img id="media-preview" src="images/svg/icons8-album-100.png" alt="">
                            <h5 id="file-name-text">Browse Local Files</h5>
                        </div>
                        <div class="input-file-container">
                            <input type="file" name="media_file" id="media_file" accept="image/*,video/*" required>
                            <button type="button" id="remove-file-btn" style="display:none;">x</button>
                        </div>
                    </div>
                    <div class="post-details">
                        <div class="post-input-fields">
                            <input class="input-fields" type="text" name="title" placeholder="Title" required>
                            <textarea class="input-fields" name="content" cols="30" rows="10" placeholder="Content" required></textarea>
                            <div class="avatar-selection">
                                <select id="avatar" name="avatar" class="input-fields" required>
                                    <option value="" selected disabled>Select Avatar</option>
                                    <?php foreach ($avatars as $avatar): ?>
                                        <option value="<?php echo htmlspecialchars($avatar['value']); ?>" data-image="<?php echo htmlspecialchars($avatar['image']); ?>">
                                            <?php echo htmlspecialchars($avatar['label']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <!-- Image container for previewing the selected avatar -->
                                <div class="avatar-preview">
                                    <img id="avatar-preview-img" src="" alt="Avatar Preview" style="display: none;">
                                </div>

                                <!-- File input for uploading a new avatar -->
                                <div id="new-avatar-upload" style="display: none;">
                                    <input type="file" id="new-avatar-file" name="new_avatar_file" accept="image/*">
                                </div>
                            </div>
                            
                            <input class="input-fields" type="text" name="designer_name" placeholder="Designer" required>
                            <input class="input-fields" type="date" name="date" id="dateInput" placeholder="Date" required><span id="formattedDate"></span>
                            <input class="input-fields" type="text" name="category" placeholder="Category" required>
                            <input class="input-fields" type="text" name="tags" placeholder="Tags">
                        </div>
                        <div class="post-buttons">
                            <button type="button" class="clear_btn">CLEAR</button>
                            <button type="button" class="preview_btn">PREVIEW</button>
                            <button type="submit" class="post_btn">POST</button>
                        </div>
                    </div>
                </form>
            </div>

            <div id="preview-field" class="new-post-preview">
                <h3>POST PREVIEW</h3>
                <div class="preview-card">
                    <div class="blog-card-image">
                        <img src="" alt="">
                    </div>
                    <div class="blog-card-content">
                        <h4><b></b></h4>
                        <p></p>
                        <div class="blog-card-bot-section">
                            <img src="uploads/avatars/">
                            <p class="Designer"></p>
                            <p class="date"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('partials/footer.php'); ?>

<!-- JavaScript for functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
   
    // // Truncate text in dropdown options
    // function truncateOptionText(selector, maxLength) {
    //     const options = document.querySelectorAll(selector);
    //     options.forEach(option => {
    //         if (option.textContent.length > maxLength) {
    //             option.textContent = option.textContent.slice(0, maxLength - 17) + '...'; 
    //         }
    //     });
    // }

    // // Define the maximum length for the option text
    // const MAX_OPTION_LENGTH = 30; // Increased length for better display

    // // Truncate the text in avatar options initially
    // truncateOptionText('#avatar option', MAX_OPTION_LENGTH);


    const mediaFileInput = document.querySelector('input[name="media_file"]');
    const mediaPreviewContainer = document.querySelector('.upload-image-icon');
    const fileNameText = document.getElementById('file-name-text');
    const removeFileBtn = document.getElementById('remove-file-btn');
    const defaultPreviewSrc = 'images/svg/icons8-album-100.png';
    const previewField = document.getElementById('preview-field');
    const avatarSelect = document.getElementById('avatar');
    const newAvatarUpload = document.getElementById('new-avatar-upload');
    const previewImg = document.getElementById('avatar-preview-img');

    // Function to update the preview with the selected avatar
    function updateAvatarPreview(avatarUrl) {
        const avatarImg = document.querySelector('.blog-card-bot-section img');
        if (avatarUrl) {
            avatarImg.src = avatarUrl;
            avatarImg.style.display = 'block';
        } else {
            avatarImg.src = '';
            avatarImg.style.display = 'none';
        }
    }

    // Handle file selection for media files
    mediaFileInput.addEventListener('change', function() {
        const mediaFile = this.files[0];
        if (mediaFile) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const existingPreview = document.getElementById('media-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }

                const mediaElement = document.createElement(mediaFile.type.startsWith('video/') ? 'video' : 'img');
                mediaElement.id = 'media-preview';
                mediaElement.src = e.target.result;

                if (mediaElement.tagName === 'VIDEO') {
                    mediaElement.controls = true;
                    mediaElement.style.maxHeight = "300px";
                    mediaElement.style.width = "auto";
                    mediaElement.style.maxWidth = "75%";
                } else if (mediaElement.tagName === 'IMG') {
                    mediaElement.style.width = "auto";
                    mediaElement.style.maxWidth = "100%";
                    mediaElement.style.height = "auto";
                }

                mediaPreviewContainer.insertBefore(mediaElement, mediaPreviewContainer.querySelector('h5'));

                const date_str = new Date().toISOString().slice(0, 10).replace(/-/g, '');
                const file_number = ('000' + (document.querySelectorAll('input[type="file"]').length + 1)).slice(-3);
                const extension = mediaFile.name.split('.').pop();
                const file_name = `${date_str}${file_number}.${extension}`;
                fileNameText.innerText = file_name;

                removeFileBtn.style.display = 'inline';
            };
            reader.readAsDataURL(mediaFile);
        }
    });

    // Handle remove file button click
    removeFileBtn.addEventListener('click', function() {
        mediaFileInput.value = "";

        const mediaPreview = document.getElementById('media-preview');
        if (mediaPreview) {
            mediaPreview.remove();
        }

        fileNameText.innerText = 'Browse Local Files';
        removeFileBtn.style.display = 'none';
    });

    // Handle clear button click
    document.querySelector('.clear_btn').addEventListener('click', function() {
        document.getElementById('postForm').reset();

        const mediaPreview = document.getElementById('media-preview');
        if (mediaPreview) {
            mediaPreview.remove();
        }

        const defaultPreview = document.createElement('img');
        defaultPreview.id = 'media-preview';
        defaultPreview.src = defaultPreviewSrc;
        defaultPreview.alt = '';
        mediaPreviewContainer.insertBefore(defaultPreview, mediaPreviewContainer.querySelector('h5'));

        fileNameText.innerText = 'Browse Local Files';
        removeFileBtn.style.display = 'none';
    });

    // Handle preview button click
    document.querySelector('.preview_btn').addEventListener('click', function() {
        const title = document.querySelector('input[name="title"]').value;
        const content = document.querySelector('textarea[name="content"]').value;
        const designerName = document.querySelector('input[name="designer_name"]').value;
        const date = document.querySelector('input[name="date"]').value;
        const mediaFile = document.querySelector('input[name="media_file"]').files[0];
        const avatar = document.querySelector('select[name="avatar"]').value;

        previewField.style.display = 'block';

        document.querySelector('.blog-card-content h4').innerText = title;
        document.querySelector('.blog-card-content p').innerText = content;
        document.querySelector('.Designer').innerText = designerName;
        document.querySelector('.blog-card-bot-section .date').innerText = date;

        if (avatar) {
            const avatarPath = 'uploads/avatars/' + avatar;
            document.querySelector('.blog-card-bot-section img').src = avatarPath;
        }

        if (mediaFile) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const mediaPreviewContainer = document.querySelector('.blog-card-image');
                mediaPreviewContainer.innerHTML = '';
                const mediaElement = document.createElement(mediaFile.type.startsWith('image/') ? 'img' : 'video');
                mediaElement.src = e.target.result;

                if (mediaElement.tagName === 'VIDEO') {
                    mediaElement.controls = true;
                    mediaElement.style.maxHeight = "300px";
                    mediaElement.style.width = "auto";
                    mediaElement.style.maxWidth = "75%";
                } else if (mediaElement.tagName === 'IMG') {
                    mediaElement.style.width = "auto";
                    mediaElement.style.maxWidth = "100%";
                    mediaElement.style.height = "auto";
                }
                mediaPreviewContainer.appendChild(mediaElement);
            };
            reader.readAsDataURL(mediaFile);
        }

        // Scroll to the preview section after updating
        previewField.scrollIntoView({ behavior: 'smooth' });
    });

    // Handle cancel button click
    document.querySelector('.cancel_btn').addEventListener('click', function() {
    window.location.href = 'Blog.php'; // Redirect to the designs page or another relevant page
});


    // Handle avatar selection dropdown change
    avatarSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const selectedValue = selectedOption.value;
        const imageUrl = selectedOption.getAttribute('data-image');

        if (selectedValue === 'new') {
            newAvatarUpload.style.display = 'block';
            previewImg.style.display = 'none';
            updateAvatarPreview('');
        } else {
            previewImg.src = imageUrl;
            previewImg.style.display = 'block';
            newAvatarUpload.style.display = 'none';
            updateAvatarPreview(imageUrl);
        }
    });

    // Handle new avatar file upload
    document.getElementById('new-avatar-file').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const newAvatarUrl = e.target.result;

                const newOption = document.createElement('option');
                newOption.value = file.name;
                newOption.setAttribute('data-image', newAvatarUrl);
                newOption.textContent = 'New Avatar (' + file.name + ')';
                avatarSelect.appendChild(newOption);
                avatarSelect.value = file.name; // Set the new avatar as selected

                // Truncate the new option text if necessary
                truncateOptionText('#avatar option', MAX_OPTION_LENGTH);

                previewImg.src = newAvatarUrl;
                previewImg.style.display = 'block';
                newAvatarUpload.style.display = 'none';
                updateAvatarPreview(newAvatarUrl); // Immediately update the preview
            };
            reader.readAsDataURL(file);
        }
    });
});

</script>




