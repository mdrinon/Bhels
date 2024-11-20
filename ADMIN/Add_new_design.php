<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>

<?php require '../dbconnect.php'; 

function insertCakeSize($db, $size, $servingSize) {
    try {
        $cakeSizesCollection = $db->cake_sizes; // Use the correct 'cake_sizes' collection
        $cakeSizesCollection->insertOne([
            'size' => $size,
            'serving_size' => $servingSize
        ]);
        return true;
    } catch (Exception $e) {
        echo '<p>Error inserting cake size: ' . $e->getMessage() . '</p>';
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form has already been submitted
    if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted']) {
        echo '<p>Form has already been submitted. Please refresh the page.</p>';
        exit();
    }
    
    $name = $_POST['name'];
    $type = $_POST['type'];
    $occasion = $_POST['occasion'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $designer = $_POST['designer'];
    $date = $_POST['date'];
    $tags = array_map('trim', explode(',', $_POST['tags'])); // Process tags input
    $media_url = null;
    $cakeSize = $_POST['cake-size']; // Get the cake size from the form

    // Handle media file upload
    if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['media_file'];
        $upload_dir = 'uploads/'; // Define the upload directory

        // Check if the upload directory exists; if not, create it
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0775, true); // Create the directory with proper permissions
        }

        // Generate a unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $extension;
        $target_file = $upload_dir . $file_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $media_url = $target_file; // Save the file path for the database
        } else {
            echo '<p>Error uploading media file. Please try again.</p>';
            exit();
        }
    } else {
        echo '<p>No media file uploaded or an error occurred during file upload.</p>';
    }


    // Prepare data for MongoDB
    $postData = [
        'name' => $name,
        'type' => $type,
        'occasion' => $occasion,
        'price' => $price,
        'description' => $description,
        'designer' => $designer,
        'date' => $date,
        'tags' => $tags, // Save tags as an array
        'media' => [
            'image' => $media_url
        ],
        'size' => $cakeSize // Add cake size to the post data
    ];

    // Insert the post into MongoDB
    try {
        $cakeDesignsCollection = $db->cake_designs; // Use the correct 'cake_designs' collection
        $result = $cakeDesignsCollection->insertOne($postData);
        
        // Insert the cake size into the cake_sizes collection
        insertCakeSize($db, $cakeSize, ''); // Adjust the serving size parameter as needed
        
        // Set the session variable to prevent re-submission
        $_SESSION['form_submitted'] = true;

        // Display an alert box and redirect to the design page
        echo '<script type="text/javascript">';
        echo 'alert("Design added successfully. Click \'OK\' to redirect to the design page.");';
        echo 'window.location.href = "Designs.php";';
        echo '</script>';
        exit();
    } catch (Exception $e) {
        echo '<p>Error adding design: ' . $e->getMessage() . '</p>';
    }
}

// Reset the form submission state on page load
$_SESSION['form_submitted'] = false;
?>

<section class="main-content">
    <div class="bcp-con">
        <div class="blog-top-container">
            <h2 class="header_label">ADD A CAKE DESIGN</h2>
            <button class="cancel_btn">x</button>
        </div>
        <div class="blog-new-post-con">
            <div class="new-post-form">
                <form id="designForm" method="post" enctype="multipart/form-data">
                    <div class="upload-image">
                        <div class="upload-image-icon">
                            <img id="media-preview" src="images/svg/icons8-album-100.png" alt="">
                            <h5 id="file-name-text">Browse Local Files</h5>
                        </div>
                        <div class="input-file-container">
                            <input type="file" name="media_file" id="media_file" accept="image/*" required>
                            <button type="button" id="remove-file-btn" style="display:none;">Remove File</button>
                        </div>
                    </div>
                    <div class="post-details">
                        <div class="post-input-fields">
                            <input class="input-fields" type="text" name="name" placeholder="Name" required>
                            <input class="input-fields" type="text" name="type" placeholder="Type" required>
                            <input class="input-fields" type="text" name="occasion" placeholder="Occasion" required>
                            <input class="input-fields" type="number" name="price" placeholder="Price" required>
                            <textarea class="input-fields" name="description" cols="30" rows="5" placeholder="Description" required></textarea>
                            <input class="input-fields" type="text" name="designer" placeholder="Designer" required>
                            <input class="input-fields" type="date" name="date" required>
                            <textarea class="input-fields" name="tags" placeholder="Tags (comma-separated)" required></textarea>

                                <div class="cust-sel-opt" style="display: flex;justify-content: space-between;padding: 5px 0;margin: 0;"> 

                              <?php
                                try {
                                    // Connect to the MongoDB database
                                    $client = new MongoDB\Client("mongodb://localhost:27017");
                                    $cakesCollection = $client->bheldb->pricing;

                                    // Fetch distinct serving sizes and their associated cake sizes
                                    $singleCakesResult = $cakesCollection->find(['type' => 'single']);

                                    // Prepare an array to group sizes under each serving size
                                    $servingSizeGroups = [];

                                    // Organize the data by serving size
                                    foreach ($singleCakesResult as $cake) {
                                        $servingSize = $cake['serving_size'];
                                        $size = $cake['size'];

                                        // Group sizes by serving size
                                        if (!isset($servingSizeGroups[$servingSize])) {
                                            $servingSizeGroups[$servingSize] = [];
                                        }
                                        $servingSizeGroups[$servingSize][] = [
                                            'size' => $size
                                        ];
                                    }
                                } catch (Exception $e) {
                                    // Handle connection errors
                                    echo "Unable to connect to the database: ", $e->getMessage();
                                    exit();
                                }
                                ?>


                                <!-- <div class="cust-sel-opt" style="display: flex;justify-content: space-between;padding: 5px 0;margin: 0;">  -->
                                    <label for="cake-size">Size:</label>
                                    <select style="width:100%; height: 40px;" name="cake-size" id="product-size-pricing">
                                    <?php foreach ($servingSizeGroups as $servingSize => $cakes): ?>
                                            <optgroup label="<?php echo $servingSize; ?>">
                                                <?php foreach ($cakes as $cake): ?>
                                                    <option value='<?php echo $cake['size']; ?>'>
                                                        <?php echo $cake['size']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                        </div>
                        <div class="post-buttons">
                            <button type="button" class="clear_btn">CLEAR</button>
                            <button type="button" class="preview_btn">PREVIEW</button>
                            <button type="submit" class="post_btn">POST</button>
                        </div>
                    </div>
                </form>
            </div>

            <div id="preview-field" class="new-post-preview" style="display:none;">
                <div class="wrapper">
                    <!-- designs in card gallery -->
                    <div class="product">
                        <div class="card product-card">
                            <div class="card-image">
                                <?php if (!empty($design['media']['video'])): ?>
                                    <video controls class="design-video" style="max-height: 300px; width: auto; max-width: 75%;">
                                        <source src="<?php echo $design['media']['video']; ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php else: ?>
                                    <img src="<?php echo $design['media']['image']; ?>" alt="Cake Design" class="design-image" style="width: auto; max-width: 100%; height: auto;">
                                <?php endif; ?>

                                <?php if (!empty($design['media']['image'])): ?>
                                    <button id="dlbtn" class="DLBtn" onclick="downloadImage('<?php echo $design['media']['image']; ?>', '<?php echo $design['designer']; ?>')">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512" class="svgIcon">
                                            <path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path>
                                        </svg>
                                        <span class="icon2"></span>
                                    </button>
                                <?php else: ?>
                                    <button id="dlbtn" class="DLBtn" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512" class="svgIcon">
                                            <path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path>
                                        </svg>
                                        <span class="icon2"></span>
                                    </button>
                                <?php endif; ?>
                            </div>

                            <div class="category" id="preview-type"></div>
                            <div class="heading">
                                <div class="name" id="preview-name"></div>
                            </div>
                            <div class="product-card-con-bottom">
                                <div class="author"> By <span class="name" id="preview-designer"></span> <span id="preview-date"></span> </div>
                                <div class="like-btn">
                                    <label class="heart-container">
                                        <input type="checkbox" checked="checked">
                                        <div class="checkmark">
                                            <svg viewBox="0 0 256 256">
                                                <rect fill="none" height="256" width="256"></rect>
                                                <path d="M224.6,51.9a59.5,59.5,0,0,0-43-19.9,60.5,60.5,0,0,0-44,17.6L128,59.1l-7.5-7.4C97.2,28.3,59.2,26.3,35.9,47.4a59.9,59.9,0,0,0-2.3,87l83.1,83.1a15.9,15.9,0,0,0,22.6,0l81-81C243.7,113.2,245.6,75.2,224.6,51.9Z" stroke-width="20px" stroke="#FFF" fill="none"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </div>
                                <div class="buy-now">
                                    <img src="../images/svg/checkout.png" alt="">
                                </div>
                            </div>
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
    const previewField = document.getElementById('preview-field');
    const mediaFileInput = document.querySelector('input[name="media_file"]');
    const mediaPreviewContainer = document.getElementById('media-preview');
    const fileNameText = document.getElementById('file-name-text');
    const removeFileBtn = document.getElementById('remove-file-btn');
    const defaultPreviewSrc = 'images/svg/icons8-album-100.png';

    // Handle file selection for media files
    mediaFileInput.addEventListener('change', function() {
        const mediaFile = this.files[0];
        if (mediaFile) {
            const reader = new FileReader();
            reader.onload = function(e) {
                mediaPreviewContainer.src = e.target.result;
                fileNameText.innerText = mediaFile.name;
                removeFileBtn.style.display = 'inline';
            };
            reader.readAsDataURL(mediaFile);
        }
    });

    // Handle remove file button click
    removeFileBtn.addEventListener('click', function() {
        mediaFileInput.value = "";
        mediaPreviewContainer.src = defaultPreviewSrc;
        fileNameText.innerText = 'Browse Local Files';
        removeFileBtn.style.display = 'none';
    });

    // Handle clear button click
    document.querySelector('.clear_btn').addEventListener('click', function() {
        document.getElementById('designForm').reset();
        mediaPreviewContainer.src = defaultPreviewSrc;
        fileNameText.innerText = 'Browse Local Files';
        removeFileBtn.style.display = 'none';
        previewField.style.display = 'none';
    });

    // Handle preview button click
    document.querySelector('.preview_btn').addEventListener('click', function() {
        const name = document.querySelector('input[name="name"]').value;
        const type = document.querySelector('input[name="type"]').value;
        const designer = document.querySelector('input[name="designer"]').value;
        const date = document.querySelector('input[name="date"]').value;
        const image = mediaFileInput.files[0] ? URL.createObjectURL(mediaFileInput.files[0]) : '';
        
        document.getElementById('preview-name').innerText = name;
        document.getElementById('preview-type').innerText = type;
        document.getElementById('preview-designer').innerText = designer;
        document.getElementById('preview-date').innerText = date;
        document.getElementById('preview-image').src = image;

        previewField.style.display = 'block';
        previewField.scrollIntoView({ behavior: 'smooth' });
    });

    // Handle cancel button click
    document.querySelector('.cancel_btn').addEventListener('click', function() {
    window.location.href = 'Designs.php'; // Redirect to the designs page or another relevant page
});

});

function downloadImage(imageUrl, designerName) {
    const link = document.createElement('a');
    link.href = imageUrl;
    link.download = `${designerName}_cake_design`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
