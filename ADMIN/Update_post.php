<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>

<?php
require '../dbconnect.php'; // Ensure your dbconnect.php path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_post'])) {
    $postId = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $designer_name = $_POST['designer_name'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];
    $media_type = null;
    $media_url = null;
    $designer_avatar = $_POST['avatar'];

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
    }

    // Prepare data for MongoDB
    $updateData = [
        'title' => $title,
        'content' => $content,
        'designer_name' => $designer_name,
        'date' => $date,
        'category' => $category,
        'tags' => $tags,
        'designer_avatar' => $designer_avatar
    ];

    if ($media_type && $media_url) {
        $updateData['media_type'] = $media_type;
        $updateData['media_url'] = $media_url;
    }

    // Update the post in MongoDB
    try {
        $collection = $db->blogposts;
        $result = $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($postId)],
            ['$set' => $updateData]
        );

        // Display an alert box and redirect to the blog page
        echo '<script type="text/javascript">';
        echo 'alert("Post updated successfully. Click \'OK\' to redirect to blog page.");';
        echo 'window.location.href = "Blog.php";';
        echo '</script>';
        exit();
    } catch (Exception $e) {
        echo '<p>Error updating post: ' . $e->getMessage() . '</p>';
    }
}
?>

<section class="main-content">
    <div class="bcp-con">
        <div class="blog-top-container">
            <h2 class="header_label">UPDATE POST</h2>
            <button class="cancel_btn">x</button>
        </div>
        <div class="blog-new-post-con">
            <div class="new-post-form">
                <form id="postForm" method="post" enctype="multipart/form-data">
                    <div class="upload-image">
                        <div class="upload-image-icon">
                            <img id="media-preview" src="<?php echo $post['media_url']; ?>" alt="">
                            <h5 id="file-name-text">Browse Local Files</h5>
                        </div>
                        <div class="input-file-container">
                            <input type="file" name="media_file" id="media_file" accept="image/*,video/*">
                            <button type="button" id="remove-file-btn" style="display:none;">x</button>
                        </div>
                    </div>
                    <div class="post-details">
                        <div class="post-input-fields">
                            <input class="input-fields" type="text" name="title" placeholder="Title" value="<?php echo $post['title']; ?>" required>
                            <textarea class="input-fields" name="content" cols="30" rows="10" placeholder="Content" required><?php echo $post['content']; ?></textarea>
                            <div class="avatar-selection">
                                <select id="avatar" name="avatar" class="input-fields" required>
                                    <option value="" selected disabled>Select Avatar</option>
                                    <?php foreach ($avatars as $avatar): ?>
                                        <option value="<?php echo htmlspecialchars($avatar['value']); ?>" data-image="<?php echo htmlspecialchars($avatar['image']); ?>" <?php echo $avatar['value'] === $post['designer_avatar'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($avatar['label']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <!-- Image container for previewing the selected avatar -->
                                <div class="avatar-preview">
                                    <img id="avatar-preview-img" src="uploads/avatars/<?php echo $post['designer_avatar']; ?>" alt="Avatar Preview" style="display: block;">
                                </div>

                                <!-- File input for uploading a new avatar -->
                                <div id="new-avatar-upload" style="display: none;">
                                    <input type="file" id="new-avatar-file" name="new_avatar_file" accept="image/*">
                                </div>
                            </div>
                            
                            <input class="input-fields" type="text" name="designer_name" placeholder="Designer" value="<?php echo $post['designer_name']; ?>" required>
                            <input class="input-fields" type="date" name="date" id="dateInput" placeholder="Date" value="<?php echo $post['date']; ?>" required><span id="formattedDate"></span>
                            <input class="input-fields" type="text" name="category" placeholder="Category" value="<?php echo $post['category']; ?>" required>
                            <input class="input-fields" type="text" name="tags" placeholder="Tags" value="<?php echo $post['tags']; ?>">
                        </div>
                        <div class="post-buttons">
                            <button type="button" class="clear_btn">CLEAR</button>
                            <button type="button" class="preview_btn">PREVIEW</button>
                            <button type="submit" class="post_btn">UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>

            <div id="preview-field" class="new-post-preview"></div>
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

        const mediaPreview = document.getElementById('