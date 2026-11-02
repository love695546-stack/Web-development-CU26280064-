<?php
// Q15: Secure File Upload Handler
function handle_secure_upload(array $file): array {
    $uploadDir = __DIR__ . '/../storage/uploads/'; // Store outside public root
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'File upload error code: ' . $file['error']];
    }

    // Check size limit (e.g. 2MB max)
    if ($file['size'] > 2 * 1024 * 1024) {
        return ['success' => false, 'error' => 'File size exceeds 2MB limit.'];
    }

    // Check MIME type using finfo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowedMimes = ['image/jpeg', 'image/png', 'application/pdf'];
    if (!in_array($mimeType, $allowedMimes)) {
        return ['success' => false, 'error' => 'Invalid file MIME type. Only JPG, PNG, and PDF allowed.'];
    }

    // Rename file securely to prevent execution/overwriting
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFilename = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = $uploadDir . $newFilename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => true, 'filename' => $newFilename];
    }

    return ['success' => false, 'error' => 'Failed to save uploaded file.'];
}
