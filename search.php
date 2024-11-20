<?php
include 'dbconnect.php';

if (isset($_POST['query'])) {
    // Sanitize the search query
    $searchQuery = htmlspecialchars(trim($_POST['query']));

    try {
        // Select the collection
        $collection = $db->cake_designs;

        // Check if the collection exists
        if (!$collection) {
            echo "Error: Cake designs collection not found.";
            exit;
        }

        // Use MongoDB's text search to find matches across multiple fields
        $searchCriteria = [
            '$or' => [
                ['name' => new MongoDB\BSON\Regex($searchQuery, 'i')],      // Case-insensitive search for name
                ['type' => new MongoDB\BSON\Regex($searchQuery, 'i')],      // Case-insensitive search for type
                ['occasion' => new MongoDB\BSON\Regex($searchQuery, 'i')],  // Case-insensitive search for occasion
                ['description' => new MongoDB\BSON\Regex($searchQuery, 'i')], // Case-insensitive search for description
                ['tags' => new MongoDB\BSON\Regex($searchQuery, 'i')] // Adding tags field to the search
            ]
        ];

        // Find matching cake designs
        $cursor = $collection->find($searchCriteria);
        $resultsFound = false; // Track if any results were found

        // Output matching designs as HTML
        foreach ($cursor as $design) {
            $resultsFound = true; // Set flag to true if we find any design
            echo '<div class="product" data-id="' . $design['_id']->__toString() . '"
                    data-name="' . htmlspecialchars($design['name']) . '"
                    data-image="ADMIN/' . $design['media']['image'] . '"
                    data-designer="' . htmlspecialchars($design['designer']) . '"
                    data-date="' . htmlspecialchars($design['date']) . '"
                    data-description="' . htmlspecialchars($design['description']) . '"
                    data-price="' . htmlspecialchars($design['price']) . '"
                    data-occasion="' . htmlspecialchars($design['occasion']) . '"
                    data-rating="' . (isset($design['rating']) ? htmlspecialchars($design['rating']) : 'no-rating') . '">';

            echo '<div class="card product-card">
                    <div class="card-image">
                        <img src="ADMIN/' . htmlspecialchars($design['media']['image']) . '" alt="Cake Design" class="design-image">
                    </div>';
            echo '<div class="category">' . htmlspecialchars($design['type']) . '</div>';
            echo '<div class="heading"><div class="name">' . htmlspecialchars($design['name']) . '</div></div>';
            echo '<div class="product-card-con-bottom">
                    <div class="author">By <span class="name">' . htmlspecialchars($design['designer']) . '</span> ' . htmlspecialchars($design['date']) . '</div>
                    <div class="buy-now"><p class="card__view__preview" onclick="showOverlay(this)">View↗️</p></div>
                </div>';
            echo '</div></div>';
        }

        // If no results were found, display a message
        if (!$resultsFound) {
            echo '<div class="no-results">No matching designs found.</div>';
        }
    } catch (Exception $e) {
        echo "Error fetching designs: " . $e->getMessage();
    }
}
?>
