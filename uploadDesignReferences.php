<?php
$response = ['success' => false, 'errors' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'ADMIN/uploads/uploadedDesignReferences/';
    $allowedFileTypes = ['image/jpeg', 'image/png'];
    $maxFileSize = 10 * 1024 * 1024; // 10MB

    foreach ($_FILES['designFiles']['name'] as $key => $name) {
        $tmpName = $_FILES['designFiles']['tmp_name'][$key];
        $fileSize = $_FILES['designFiles']['size'][$key];
        $fileType = $_FILES['designFiles']['type'][$key];
        $fileExtension = pathinfo($name, PATHINFO_EXTENSION);

        // Validate file type
        if (!in_array($fileType, $allowedFileTypes)) {
            $response['errors'][] = "Invalid file type for file: $name";
            continue;
        }

        // Validate file size
        if ($fileSize > $maxFileSize) {
            $response['errors'][] = "File size exceeds 10MB for file: $name";
            continue;
        }

        // Ensure the filename is in the correct format
        $filename = basename($name, ".$fileExtension");
        $filename = preg_replace('/[^a-zA-Z0-9_\-]/', '', $filename); // Sanitize filename
        $newFilename = "$filename.$fileExtension";

        // Move the uploaded file to the designated directory
        if (move_uploaded_file($tmpName, $uploadDir . $newFilename)) {
            $response['success'] = true;
        } else {
            $response['errors'][] = "Failed to upload file: $name";
        }
    }
}

echo json_encode($response);
?>
