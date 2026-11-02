<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}

$msg = '';
// Secure DELETE handler: sirf POST + CSRF token + prepared statement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
        die("Invalid request.");
    }
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([(int)$_POST['delete_id']]);
    $msg = $stmt->rowCount() ? "Product deleted." : "Product not found.";
}

$products = $pdo->query("SELECT id, name, category, price FROM products ORDER BY id")->fetchAll();
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Manage Products</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Manage Products</h2>
<?php if ($msg): ?><p class="success"><?= e($msg) ?></p><?php endif; ?>
<table>
    <tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Delete</th></tr>
    <?php foreach ($products as $p): ?>
    <tr>
        <td><?= (int)$p['id'] ?></td>
        <td><?= e($p['name']) ?></td>
        <td><?= e($p['category']) ?></td>
        <td><?= e($p['price']) ?></td>
        <td>
            <!-- JavaScript confirmation prompt -->
            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                <input type="hidden" name="delete_id" value="<?= (int)$p['id'] ?>">
                <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
                <button type="submit" class="danger">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body></html>
