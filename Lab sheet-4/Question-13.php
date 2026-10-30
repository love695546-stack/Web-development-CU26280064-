<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $uploadDir = 'uploads/';
    
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($file['type'], $allowedTypes) && $file['size'] <= 2 * 1024 * 1024) {
            $filename = uniqid() . '_' . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                echo "File uploaded successfully: " . htmlspecialchars($filename);
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "Invalid file type or size exceeds 2MB limit.";
        }
    } else {
        echo "Upload error code: " . $file['error'];
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    Upload Image: <input type="file" name="image"><br><br>
    <button type="submit">Upload</button>
</form>