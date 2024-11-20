<?php
require '../dbconnect.php';

$cakeId = $_GET['id'];

try {
    // Fetch the cake design data based on the provided ID from the "archives" collection
    $cakeDesign = $db->archives->findOne(['_id' => new MongoDB\BSON\ObjectId($cakeId)]);

    if ($cakeDesign) {
        // Insert the cake design data back into the "cake_designs" collection
        $db->cake_designs->insertOne($cakeDesign);

        // Delete the cake design from the "archives" collection
        $db->archives->deleteOne(['_id' => new MongoDB\BSON\ObjectId($cakeId)]);

        echo '<script type="text/javascript">';
        echo 'alert("Design restored successfully. Click \'OK\' to redirect to the archived designs page.");';
        echo 'window.location.href = "view_archives.php";';
        echo '</script>';
        exit();
    } else {
        echo '<p>Error: Cake design not found in archives.</p>';
    }
} catch (Exception $e) {
    echo '<p>Error restoring design: ' . $e->getMessage() . '</p>';
}
?>
