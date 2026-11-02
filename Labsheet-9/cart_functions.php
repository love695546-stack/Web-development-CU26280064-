<?php
// cart_functions.php - cart.php aur checkout.php dono me use hota hai
function cartItems(PDO $pdo): array {
    $items = [];
    if (empty($_SESSION['cart'])) { return $items; }

    $ids = array_keys($_SESSION['cart']);
    $in  = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id IN ($in)");
    $stmt->execute($ids);

    foreach ($stmt as $p) {
        $p['qty']      = $_SESSION['cart'][$p['id']];
        $p['subtotal'] = $p['price'] * $p['qty'];
        $items[] = $p;
    }
    return $items;
}
?>
