<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) { die("Product not found."); }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price    = $_POST['price'] ?? '';

    if ($name === '' || $category === '' || !is_numeric($price) || $price < 0) {
        $error = "Please fill all fields correctly.";
    } else {
        $upd = $pdo->prepare("UPDATE products SET name = ?, category = ?, price = ? WHERE id = ?");
        $upd->execute([$name, $category, $price, $id]);
        header("Location: products.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Edit Product</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Edit Product #<?= (int)$product['id'] ?></h2>
<?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="POST" class="box">
    Name: <input type="text" name="name" value="<?= e($product['name']) ?>" required>
    Category: <input type="text" name="category" value="<?= e($product['category']) ?>" required>
    Price: <input type="number" step="0.01" name="price" value="<?= e($product['price']) ?>" required>
    <button type="submit">Update</button>
</form>
</body></html>
