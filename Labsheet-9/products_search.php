<?php
require_once 'config.php';

$q        = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');
$min      = $_GET['min'] ?? '';
$max      = $_GET['max'] ?? '';

$where  = [];
$params = [];

if ($q !== '') {                                   // name par LIKE
    $where[] = "name LIKE :q";
    $params[':q'] = "%$q%";
}
if ($category !== '') {                            // category filter
    $where[] = "category = :category";
    $params[':category'] = $category;
}
if (is_numeric($min) && is_numeric($max)) {        // price range par BETWEEN
    $where[] = "price BETWEEN :min AND :max";
    $params[':min'] = $min;
    $params[':max'] = $max;
} elseif (is_numeric($min)) {
    $where[] = "price >= :min";
    $params[':min'] = $min;
} elseif (is_numeric($max)) {
    $where[] = "price <= :max";
    $params[':max'] = $max;
}

$sql = "SELECT id, name, category, price FROM products";
if ($where) { $sql .= " WHERE " . implode(" AND ", $where); }
$sql .= " ORDER BY name";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products   = $stmt->fetchAll();
$categories = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Search Products</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Search &amp; Filter Products</h2>
<form method="GET">
    <input type="text" name="q" placeholder="Name" value="<?= e($q) ?>" style="width:160px">
    <select name="category" style="width:160px">
        <option value="">All Categories</option>
        <?php foreach ($categories as $c): ?>
        <option value="<?= e($c) ?>" <?= $c === $category ? 'selected' : '' ?>><?= e($c) ?></option>
        <?php endforeach; ?>
    </select>
    <input type="number" name="min" placeholder="Min price" value="<?= e($min) ?>" style="width:110px">
    <input type="number" name="max" placeholder="Max price" value="<?= e($max) ?>" style="width:110px">
    <button type="submit">Search</button>
</form>
<p><?= count($products) ?> product(s) found.</p>
<table>
    <tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th></tr>
    <?php foreach ($products as $p): ?>
    <tr><td><?= e($p['id']) ?></td><td><?= e($p['name']) ?></td>
        <td><?= e($p['category']) ?></td><td><?= e($p['price']) ?></td></tr>
    <?php endforeach; ?>
</table>
</body></html>
