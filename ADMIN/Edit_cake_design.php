<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>
<?php require '../dbconnect.php'; 

// Fetch the cake design data based on the provided ID
$cakeId = $_GET['id'];
$cakeDesign = $db->cake_designs->findOne(['_id' => new MongoDB\BSON\ObjectId($cakeId)]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $occasion = $_POST['occasion'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $designer = $_POST['designer'];
    $date = $_POST['date'];
    $tags = array_map('trim', explode(',', $_POST['tags']));
    $media_url = $cakeDesign['media']['image'];
    $cakeSize = $_POST['cake-size'];

    // Handle media file upload
    if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['media_file'];
        $upload_dir = 'uploads/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0775, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $extension;
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $media_url = $target_file;
        } else {
            echo '<p>Error uploading media file. Please try again.</p>';
            exit();
        }
    }

    // Prepare data for MongoDB update
    $updateData = [
        'name' => $name,
        'type' => $type,
        'occasion' => $occasion,
        'price' => $price,
        'description' => $description,
        'designer' => $designer,
        'date' => $date,
        'tags' => $tags,
        'media' => [
            'image' => $media_url
        ],
        'size' => $cakeSize
    ];

    // Update the cake design in MongoDB
    try {
        $db->cake_designs->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($cakeId)],
            ['$set' => $updateData]
        );

        echo '<script type="text/javascript">';
        echo 'alert("Design updated successfully. Click \'OK\' to redirect to the design page.");';
        echo 'window.location.href = "Designs.php";';
        echo '</script>';
        exit();
    } catch (Exception $e) {
        echo '<p>Error updating design: ' . $e->getMessage() . '</p>';
    }
}
?>

<section class="main-content">
    <div class="bcp-con">
        <div class="blog-top-container">
            <h2 class="header_label">EDIT CAKE DESIGN</h2>
            <button class="cancel_btn">x</button>
        </div>
        <div class="blog-new-post-con">
            <div class="new-post-form">
                <form id="designForm" method="post" enctype="multipart/form-data">
                    <div class="upload-image">
                        <div class="upload-image-icon">
                            <img id="media-preview" src="<?php echo $cakeDesign['media']['image']; ?>" alt="">
                            <h5 id="file-name-text">Browse Local Files</h5>
                        </div>
                        <div class="input-file-container">
                            <input type="file" name="media_file" id="media_file" accept="image/*">
                        </div>
                    </div>
                    <div class="post-details">
                        <div class="post-input-fields">
                            <input class="input-fields" type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($cakeDesign['name']); ?>" required>
                            <input class="input-fields" type="text" name="type" placeholder="Type" value="<?php echo htmlspecialchars($cakeDesign['type']); ?>" required>
                            <input class="input-fields" type="text" name="occasion" placeholder="Occasion" value="<?php echo htmlspecialchars($cakeDesign['occasion']); ?>" required>
                            <input class="input-fields" type="number" name="price" placeholder="Price" value="<?php echo htmlspecialchars($cakeDesign['price']); ?>" required>
                            <textarea class="input-fields" name="description" cols="30" rows="5" placeholder="Description" required><?php echo htmlspecialchars($cakeDesign['description']); ?></textarea>
                            <input class="input-fields" type="text" name="designer" placeholder="Designer" value="<?php echo htmlspecialchars($cakeDesign['designer']); ?>" required>
                            <input class="input-fields" type="date" name="date" value="<?php echo htmlspecialchars($cakeDesign['date']); ?>" required>
                            <textarea class="input-fields" name="tags" placeholder="Tags (comma-separated)" required><?php echo implode(', ', (array)$cakeDesign['tags']); ?></textarea>

                            <div class="cust-sel-opt" style="display: flex;justify-content: space-between;padding: 5px 0;margin: 0;"> 
                                <label for="cake-size">Size:</label>
                                <select style="width:100%; height: 40px;" name="cake-size" id="product-size-pricing">
                                    <optgroup label="Serves 8-12 people">
                                        <option value='4" x 4"' <?php echo $cakeDesign['size'] == '4" x 4"' ? 'selected' : ''; ?>>4" x 4"</option>
                                        <option value='6" x 4"' <?php echo $cakeDesign['size'] == '6" x 4"' ? 'selected' : ''; ?>>6" x 4"</option>
                                    </optgroup>
                                    <optgroup label="Serves 12-25 people">
                                        <option value='8" x 4"' <?php echo $cakeDesign['size'] == '8" x 4"' ? 'selected' : ''; ?>>8" x 4"</option>
                                        <option value='8" x 6"' <?php echo $cakeDesign['size'] == '8" x 6"' ? 'selected' : ''; ?>>8" x 6"</option>
                                        <option value='6" x 8"' <?php echo $cakeDesign['size'] == '6" x 8"' ? 'selected' : ''; ?>>6" x 8"</option>
                                    </optgroup>
                                    <optgroup label="Serves 25-30 people">
                                        <option value='8" x 11"' <?php echo $cakeDesign['size'] == '8" x 11"' ? 'selected' : ''; ?>>8" x 11"</option>
                                        <option value='10" x 14"' <?php echo $cakeDesign['size'] == '10" x 14"' ? 'selected' : ''; ?>>10" x 14"</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="post-buttons">
                            <button type="button" class="clear_btn">CLEAR</button>
                            <button type="button" class="preview_btn">PREVIEW</button>
                            <button type="submit" class="post_btn">UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>

            <div id="preview-field" class="new-post-preview" style="display:none;">
                <div class="wrapper">
                    <div class="product">
                        <div class="card product-card">
                            <div class="card-image">
                                <img src="<?php echo $cakeDesign['media']['image']; ?>" alt="Cake Design" class="design-image" style="width: auto; max-width: 100%; height: auto;">
                                <button id="dlbtn" class="DLBtn" onclick="downloadImage('<?php echo $cakeDesign['media']['image']; ?>', '<?php echo $cakeDesign['designer']; ?>')">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512" class="svgIcon">
                                        <path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path>
                                    </svg>
                                    <span class="icon2"></span>
                                </button>
                            </div>
                            <div class="category" id="preview-type"><?php echo htmlspecialchars($cakeDesign['type']); ?></div>
                            <div class="heading">
                                <div class="name" id="preview-name"><?php echo htmlspecialchars($cakeDesign['name']); ?></div>
                            </div>
                            <div class="product-card-con-bottom">
                                <div class="author"> By <span class="name" id="preview-designer"><?php echo htmlspecialchars($cakeDesign['designer']); ?></span> <span id="preview-date"><?php echo htmlspecialchars($cakeDesign['date']); ?></span> </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const previewField = document.getElementById('preview-field');
    const mediaFileInput = document.querySelector('input[name="media_file"]');
    const mediaPreviewContainer = document.getElementById('media-preview');
    const fileNameText = document.getElementById('file-name-text');
    const removeFileBtn = document.getElementById('remove-file-btn');
    const defaultPreviewSrc = '<?php echo $cakeDesign['media']['image']; ?>';

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

    removeFileBtn.addEventListener('click', function() {
        mediaFileInput.value = "";
        mediaPreviewContainer.src = defaultPreviewSrc;
        fileNameText.innerText = 'Browse Local Files';
        removeFileBtn.style.display = 'none';
    });

    document.querySelector('.clear_btn').addEventListener('click', function() {
        document.getElementById('designForm').reset();
        mediaPreviewContainer.src = defaultPreviewSrc;
        fileNameText.innerText = 'Browse Local Files';
        removeFileBtn.style.display = 'none';
        previewField.style.display = 'none';
    });

    document.querySelector('.preview_btn').addEventListener('click', function() {
        const name = document.querySelector('input[name="name"]').value;
        const type = document.querySelector('input[name="type"]').value;
        const designer = document.querySelector('input[name="designer"]').value;
        const date = document.querySelector('input[name="date"]').value;
        const image = mediaFileInput.files[0] ? URL.createObjectURL(mediaFileInput.files[0]) : defaultPreviewSrc;
        
        document.getElementById('preview-name').innerText = name;
        document.getElementById('preview-type').innerText = type;
        document.getElementById('preview-designer').innerText = designer;
        document.getElementById('preview-date').innerText = date;
        document.getElementById('preview-image').src = image;

        previewField.style.display = 'block';
        previewField.scrollIntoView({ behavior: 'smooth' });
    });

    document.querySelector('.cancel_btn').addEventListener('click', function() {
        window.location.href = 'Designs.php';
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
