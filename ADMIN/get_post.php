<?php
require '../dbconnect.php'; // Ensure your dbconnect.php path is correct

// Fetch the post ID from the query parameter
$postId = $_GET['id'] ?? null;

if (!$postId) {
    echo json_encode(['error' => 'Invalid post ID.']);
    exit();
}

// Fetch the post data from the database
$collection = $db->blogposts;
$post = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($postId)]);

if (!$post) {
    echo json_encode(['error' => 'Post not found.']);
    exit();
}

// Fetch avatars from the 'blogposts' collection
$avatarsCursor = $collection->distinct('designer_avatar');

// Default avatars
$defaultAvatars = [
    ['value' => 'new', 'image' => '', 'label' => 'Upload New Avatar']
];

// Combine fetched avatars with default ones
$avatars = [];
foreach ($defaultAvatars as $defaultAvatar) {
    $avatars[$defaultAvatar['value']] = $defaultAvatar;
}

foreach ($avatarsCursor as $avatar) {
    if (!isset($avatars[$avatar])) {
        $avatars[$avatar] = [
            'value' => $avatar,
            'image' => 'uploads/avatars/' . $avatar, // Adjust path as necessary
            'label' => 'Avatar ' . (count($avatars) + 1) // Dynamic labeling; adjust as needed
        ];
    }
}

// Return the post data as JSON
echo json_encode([
    '_id' => (string) $post['_id'],
    'title' => $post['title'],
    'content' => $post['content'],
    'designer_name' => $post['designer_name'],
    'date' => $post['date'],
    'category' => $post['category'],
    'tags' => $post['tags'],
    'designer_avatar' => $post['designer_avatar'],
    'avatars' => array_values($avatars)
]);
?>
