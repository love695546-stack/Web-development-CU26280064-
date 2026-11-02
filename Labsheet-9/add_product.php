<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price    = $_POST['price'] ?? '';

    if ($name === '' || $category === '' || !is_numeric($price) || $price < 0) {
        $msg = "<p class='error'>Please fill all fields correctly.</p>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (name, category, price) VALUES (:name, :category, :price)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price);
        $stmt->execute();
        $msg = "<p class='success'>Product added successfully.</p>";
    }
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Add Product</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Add Product</h2>
<?= $msg ?>
<form method="POST" class="box">
    Name: <input type="text" name="name" required>
    Category: <input type="text" name="category" required>
    Price: <input type="number" step="0.01" name="price" required>
    <button type="submit">Add Product</button>
</form>
<p><a href="products.php">View all products</a></p>
</body></html>
