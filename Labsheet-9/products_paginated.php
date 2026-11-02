<?php
require_once 'config.php';

$perPage = 5;
$total   = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$pages   = max(1, (int)ceil($total / $perPage));
$page    = min(max(1, (int)($_GET['page'] ?? 1)), $pages);
$offset  = ($page - 1) * $perPage;

$stmt = $pdo->prepare("SELECT id, name, category, price FROM products ORDER BY id LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit',  $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset,  PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Products - Pagination</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Products (Page <?= $page ?> of <?= $pages ?>)</h2>
<table>
    <tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th></tr>
    <?php foreach ($products as $p): ?>
    <tr><td><?= e($p['id']) ?></td><td><?= e($p['name']) ?></td>
        <td><?= e($p['category']) ?></td><td><?= e($p['price']) ?></td></tr>
    <?php endforeach; ?>
</table>

<div class="pagination">
    <?php if ($page > 1): ?><a href="?page=<?= $page - 1 ?>">&laquo; Previous</a><?php endif; ?>
    <?php for ($i = 1; $i <= $pages; $i++): ?>
        <?php if ($i == $page): ?><span class="active"><?= $i ?></span>
        <?php else: ?><a href="?page=<?= $i ?>"><?= $i ?></a><?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $pages): ?><a href="?page=<?= $page + 1 ?>">Next &raquo;</a><?php endif; ?>
</div>
</body></html>
