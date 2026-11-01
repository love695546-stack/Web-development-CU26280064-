<?php
// Question 7: Develop a checkout page in PHP where users enter shipping details and place an order, recording transaction data into MySQL database.

session_start();
$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");

if (isset($_POST['place_order']) && !empty($_SESSION['cart'])) {
    $user_id = $_SESSION['user_id'] ?? 1; // Default fallback ID
    $address = trim($_POST['address']);
    $total_amount = floatval($_POST['total_amount']);

    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, shipping_address) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $user_id, $total_amount, $address);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Insert Order Items
    $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($_SESSION['cart'] as $book_id => $qty) {
        $price = 20.00; // Sample fixed/retrieved price
        $item_stmt->bind_param("iiid", $order_id, $book_id, $qty, $price);
        $item_stmt->execute();
    }

    unset($_SESSION['cart']);
    echo "<h3>Order Placed Successfully! Order ID: #$order_id</h3>";
}
?>
<form method="POST">
    <h3>Checkout</h3>
    <textarea name="address" placeholder="Shipping Address" required></textarea><br>
    <input type="hidden" name="total_amount" value="50.00">
    <button type="submit" name="place_order">Place Order</button>
</form>
