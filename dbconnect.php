<?php
require 'vendor/autoload.php'; // Ensure Composer's autoload is included

try {
    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");

    // Select the database
    $db = $client->bheldb;

} catch (Exception $e) {
    // Handle connection errors
    echo "Unable to connect to the database: ", $e->getMessage();
    exit();
}
?>
