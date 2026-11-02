<?php
session_start();
require_once 'config.php';
require_once 'cart_functions.php';

if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = []; }   // [product_id => quantity]

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id     = (int)($_POST['id'] ?? 0);

    if ($action === 'add') {
        $chk = $pdo->prepare("SELECT id FROM products WHERE id = ?");
        $chk->execute([$id]);
        if ($chk->fetch()) {
            $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
        }
    } elseif ($action === 'update' && isset($_SESSION['cart'][$id])) {
        $qty = (int)($_POST['qty'] ?? 1);
        if ($qty > 0) { $_SESSION['cart'][$id] = $qty; }
        else          { unset($_SESSION['cart'][$id]); }
    } elseif ($action === 'remove') {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: cart.php");     // refresh par dobara submit na ho
    exit;
}

$products = $pdo->query("SELECT id, name, price FROM products ORDER BY name")->fetchAll();
$items    = cartItems($pdo);
$total    = array_sum(array_column($items, 'subtotal'));
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Shopping Cart</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Products</h2>
<table>
    <tr><th>Name</th><th>Price</th><th></th></tr>
    <?php foreach ($products as $p): ?>
    <tr><td><?= e($p['name']) ?></td><td>Rs. <?= e($p['price']) ?></td>
        <td><form method="POST">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
            <button type="submit">Add to Cart</button></form></td></tr>
    <?php endforeach; ?>
</table>

<h2>Your Cart</h2>
<?php if (!$items): ?><p>Cart is empty.</p><?php else: ?>
<table>
    <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th></th></tr>
    <?php foreach ($items as $it): ?>
    <tr>
        <td><?= e($it['name']) ?></td>
        <td>Rs. <?= e($it['price']) ?></td>
        <td><form method="POST">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
            <input type="number" name="qty" value="<?= (int)$it['qty'] ?>" min="0" style="width:70px">
            <button type="submit">Update</button></form></td>
        <td>Rs. <?= e(number_format($it['subtotal'], 2)) ?></td>
        <td><form method="POST">
            <input type="hidden" name="action" value="remove">
            <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
            <button type="submit" class="danger">Remove</button></form></td>
    </tr>
    <?php endforeach; ?>
    <tr><td colspan="3"><strong>Total</strong></td><td colspan="2"><strong>Rs. <?= e(number_format($total, 2)) ?></strong></td></tr>
</table>
<p><a class="btn" href="checkout.php">Proceed to Checkout</a></p>
<?php endif; ?>
</body></html>
