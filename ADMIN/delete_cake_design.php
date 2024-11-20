<?php
require '../dbconnect.php';

$cakeId = $_GET['id'];

try {
    // Fetch the cake design data based on the provided ID
    $cakeDesign = $db->cake_designs->findOne(['_id' => new MongoDB\BSON\ObjectId($cakeId)]);

    if ($cakeDesign) {
        // Insert the cake design data into the "archives" collection
        $db->archives->insertOne($cakeDesign);

        // Delete the cake design from the "cake_designs" collection
        $db->cake_designs->deleteOne(['_id' => new MongoDB\BSON\ObjectId($cakeId)]);

        echo '<script type="text/javascript">';
        echo 'alert("Design moved to archives successfully. Click \'OK\' to redirect to the design page.");';
        echo 'window.location.href = "Designs.php";';
        echo '</script>';
        exit();
    } else {
        echo '<p>Error: Cake design not found.</p>';
    }
} catch (Exception $e) {
    echo '<p>Error moving design to archives: ' . $e->getMessage() . '</p>';
}
?>
