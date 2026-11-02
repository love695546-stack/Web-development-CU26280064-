<?php
session_start();
require_once 'config.php';
require_once 'cart_functions.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$items = cartItems($pdo);
$msg   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $items) {
    try {
        $pdo->beginTransaction();                              // BEGIN

        $ins = $pdo->prepare(
            "INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)"
        );
        foreach ($items as $it) {
            $ins->execute([$_SESSION['user_id'], $it['id'], $it['qty'], $it['subtotal']]);
        }

        $pdo->commit();                                        // COMMIT: sab save
        $_SESSION['cart'] = [];
        $items = [];
        $msg = "<p class='success'>Order placed successfully!</p>";
    } catch (Exception $ex) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }       // ROLLBACK: kuch bhi save nahi
        error_log($ex->getMessage());
        $msg = "<p class='error'>Order failed. No changes were saved.</p>";
    }
}
$total = array_sum(array_column($items, 'subtotal'));
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Checkout</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Checkout</h2>
<?= $msg ?>
<?php if ($items): ?>
<table>
    <tr><th>Product</th><th>Qty</th><th>Subtotal</th></tr>
    <?php foreach ($items as $it): ?>
    <tr><td><?= e($it['name']) ?></td><td><?= (int)$it['qty'] ?></td>
        <td>Rs. <?= e(number_format($it['subtotal'], 2)) ?></td></tr>
    <?php endforeach; ?>
    <tr><td colspan="2"><strong>Total</strong></td><td><strong>Rs. <?= e(number_format($total, 2)) ?></strong></td></tr>
</table>
<form method="POST"><br><button type="submit">Place Order</button></form>
<?php elseif (!$msg): ?><p>Your cart is empty. <a href="cart.php">Go shopping</a></p><?php endif; ?>
</body></html>
