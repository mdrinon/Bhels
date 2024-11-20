<?php
require '../dbconnect.php'; // Ensure your dbconnect.php path is correct

// Fetch the post ID and media URL from the query parameters
$postId = $_GET['id'] ?? null;
$mediaUrl = $_GET['media_url'] ?? null;

if (!$postId) {
    echo json_encode(['error' => 'Invalid post ID.']);
    exit();
}

// Delete the post from the database
$collection = $db->blogposts;
$result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($postId)]);

if ($result->getDeletedCount() === 1) {
    // Delete the media file if it exists
    if ($mediaUrl && file_exists($mediaUrl)) {
        unlink($mediaUrl);
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Failed to delete post.']);
}
?>
