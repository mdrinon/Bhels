<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>
<?php require '../dbconnect.php'; ?>

<section class="main-content">
    <div class="navigation">
        <div class="menu-tab"><h6><b>Archived Designs</b></h6></div>
        <div class="nav-label"><h2>Archived Designs</h2></div>
    </div>

    <div class="design-container" style="display: block;">
        <div class="wrapper" style="justify-content: flex-start;">
            <!-- designs in card gallery -->
            <?php
            try {
                // Fetch all archived cake designs
                $cursor = $db->archives->find([], ['sort' => ['date' => -1]]);

                foreach ($cursor as $design): ?>
                    <div class="product" style="display: none;" 
                        data-id="<?php echo $design['_id']->__toString(); ?>" 
                        data-name="<?php echo htmlspecialchars($design['name']); ?>" 
                        data-image="<?php echo $design['media']['image']; ?>" 
                        data-designer="<?php echo $design['designer']; ?>" 
                        data-date="<?php echo $design['date']; ?>" 
                        data-description="<?php echo $design['description']; ?>" 
                        data-price="<?php echo $design['price']; ?>"
                        data-size="<?php echo htmlspecialchars($design['size']); ?>"
                        data-occasion="<?php echo $design['occasion']; ?>"
                        data-type="<?php echo $design['type']; ?>">

                        <div class="card product-card">
                            <div class="card-image">
                                <img src="<?php echo $design['media']['image']; ?>" alt="Cake Design" id="design-image" class="design-image">
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
                            <div class="category"> <?php echo $design['type']; ?> </div>
                            <div class="heading">
                                <div class="name"><?php echo htmlspecialchars($design['name']); ?></div>
                            </div>
                            <div class="product-card-con-bottom">
                                <div class="author"> By <span class="name"><?php echo $design['designer']; ?></span> <?php echo $design['date']; ?> </div>
                                <div class="buy-now">
                                    <button class="restore-btn" onclick="restoreDesign('<?php echo $design['_id']->__toString(); ?>')">Restore</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            } catch (Exception $e) {
                echo '<p>Error fetching archived designs: ' . $e->getMessage() . '</p>';
            }
            ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set all product containers to display block
    document.querySelectorAll('.product').forEach(function(product) {
        product.style.display = 'block';
    });
});

function restoreDesign(cakeId) {
    if (confirm('Are you sure you want to restore this cake design?')) {
        window.location.href = `restore_cake_design.php?id=${cakeId}`;
    }
}

function downloadImage(imageUrl, designerName) {
    const link = document.createElement('a');
    link.href = imageUrl;
    link.download = `${designerName}_cake_design`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

    <!-- ?php include('partials/chatbot.php'); ? -->
    
    
    <script defer src="javascript/tooltips.js"></script>
    <script defer src="javascript/sidebar.js"></script>
    <script defer src="javascript/notification.js"></script>
    <!-- <script defer src="javascript/product-catalogs.js"></script> -->
</body>
</html>