<?php
require_once 'config.php';

// Whitelist: sirf allowed columns hi ORDER BY me jayenge
$allowed = ['id', 'name', 'category', 'price'];
$sort = in_array($_GET['sort'] ?? '', $allowed, true) ? $_GET['sort'] : 'id';
$dir  = (($_GET['dir'] ?? 'asc') === 'desc') ? 'DESC' : 'ASC';

$products = $pdo->query("SELECT id, name, category, price FROM products ORDER BY $sort $dir")->fetchAll();

// Header click par direction toggle karne wala link
function sortLink($col, $label, $sort, $dir) {
    $newDir = ($sort === $col && $dir === 'ASC') ? 'desc' : 'asc';
    $arrow  = ($sort === $col) ? ($dir === 'ASC' ? ' &#9650;' : ' &#9660;') : '';
    return "<a href='?sort=$col&dir=$newDir'>$label$arrow</a>";
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Sort Products</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Sortable Product Table</h2>
<table>
    <tr>
        <th><?= sortLink('id', 'ID', $sort, $dir) ?></th>
        <th><?= sortLink('name', 'Name', $sort, $dir) ?></th>
        <th><?= sortLink('category', 'Category', $sort, $dir) ?></th>
        <th><?= sortLink('price', 'Price', $sort, $dir) ?></th>
    </tr>
    <?php foreach ($products as $p): ?>
    <tr><td><?= e($p['id']) ?></td><td><?= e($p['name']) ?></td>
        <td><?= e($p['category']) ?></td><td><?= e($p['price']) ?></td></tr>
    <?php endforeach; ?>
</table>
</body></html>
