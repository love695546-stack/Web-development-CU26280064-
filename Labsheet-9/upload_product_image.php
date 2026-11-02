<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
$errors  = [];
$saved   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price    = $_POST['price'] ?? '';
    $file     = $_FILES['image'] ?? null;

    if ($name === '' || $category === '' || !is_numeric($price)) {
        $errors[] = "Name, category and a numeric price are required.";
    }
    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Please choose an image (upload error).";
    } else {
        if ($file['size'] > 2 * 1024 * 1024) {                  // size <= 2 MB
            $errors[] = "Image must be 2 MB or smaller.";
        }
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);   // real type check
        if (!isset($allowed[$mime])) {
            $errors[] = "Only JPG, PNG and GIF images are allowed.";
        }
    }

    if (!$errors) {
        $dir = __DIR__ . '/uploads/';
        if (!is_dir($dir)) { mkdir($dir, 0755, true); }

        $newName = bin2hex(random_bytes(8)) . '.' . $allowed[$mime];   // unique file name
        if (move_uploaded_file($file['tmp_name'], $dir . $newName)) {
            $stmt = $pdo->prepare("INSERT INTO products (name, category, price, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $category, $price, $newName]);
            $saved = $newName;
        } else {
            $errors[] = "Could not save the uploaded file.";
        }
    }
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Upload Product Image</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Add Product with Photo</h2>
<?php foreach ($errors as $err): ?><p class="error"><?= e($err) ?></p><?php endforeach; ?>
<?php if ($saved): ?>
    <p class="success">Product saved.</p>
    <img src="uploads/<?= e($saved) ?>" alt="Product" width="150">
<?php endif; ?>
<form method="POST" enctype="multipart/form-data" class="box">
    Name: <input type="text" name="name" required>
    Category: <input type="text" name="category" required>
    Price: <input type="number" step="0.01" name="price" required>
    Photo (JPG/PNG/GIF, max 2 MB): <input type="file" name="image" accept="image/*" required>
    <button type="submit">Upload</button>
</form>
</body></html>
