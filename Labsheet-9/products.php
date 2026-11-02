<?php
require_once 'config.php';
$products = $pdo->query("SELECT id, name, category, price, created_at FROM products ORDER BY id")->fetchAll();
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Products</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Product List</h2>
<table>
    <tr><th>ID</th><th>Name</th><th>Category</th><th>Price (Rs.)</th><th>Added On</th><th>Action</th></tr>
    <?php foreach ($products as $p): ?>
    <tr>
        <td><?= e($p['id']) ?></td>
        <td><?= e($p['name']) ?></td>
        <td><?= e($p['category']) ?></td>
        <td><?= e(number_format($p['price'], 2)) ?></td>
        <td><?= e($p['created_at']) ?></td>
        <td><a href="edit_product.php?id=<?= (int)$p['id'] ?>">Edit</a></td>
    </tr>
    <?php endforeach; ?>
</table>
</body></html>
