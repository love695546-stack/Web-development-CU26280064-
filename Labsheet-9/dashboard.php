<?php
session_start();
require_once 'config.php';

// Protected page: login nahi hai to login page par bhejo
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Dashboard</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Dashboard</h2>
<p>Welcome, <strong><?= e($_SESSION['username']) ?></strong>!</p>
<p>
    <a class="btn" href="products.php">View Products</a>
    <a class="btn" href="add_product.php">Add Product</a>
    <a class="btn" href="cart.php">My Cart</a>
    <a class="btn danger" href="logout.php">Logout</a>
</p>
</body></html>
