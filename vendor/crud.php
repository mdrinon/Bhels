<?php 

    // Add Product
    if(isset($_POST['add_product'])) {
        $product_name = $_POST['product_name'];
        $product_category = $_POST['product_category'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $description = $_POST['description'];
        $image_filename = $_POST['image_filename'];

        // Insert the product into the database
        $collection->insertOne([
            'product_name' => $product_name,
            'product_category' => $product_category,
            'price' => $price,
            'quantity' => $quantity,
            'description' => $description,
            'image_filename' => $image_filename
        ]);

        // Redirect to the shop page
        header('Location: ui-shop.php');
        exit();
    }

    // Update Product
    if(isset($_POST['update_product'])) {
        $product_id = $_POST['product_id'];
        $new_price = $_POST['new_price'];
        $new_quantity = $_POST['new_quantity'];

        // Update the product in the database
        $collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectID($product_id)],
            ['$set' => ['price' => $new_price, 'quantity' => $new_quantity]]
        );

        // Redirect to the shop page
        header('Location: shop.php');
        exit();
    }

    // Delete Product
    if(isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];

        // Delete the product from the database
        $deleteResult = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectID($product_id)]);

        // Check if deletion was successful
        if ($deleteResult->getDeletedCount() > 0) {
            // Redirect to the shop page
            header('Location: shop.php');
            exit();
        } else {
            // Display error message
            echo "Failed to delete product.";
        }
    }
?>

