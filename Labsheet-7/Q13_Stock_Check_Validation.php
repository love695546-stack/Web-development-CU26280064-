<?php
// Question 13: Build an inventory stock check in PHP that prevents users from adding more books to the cart than available stock.

session_start();
$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");

function addToCartWithStockCheck($book_id, $requested_qty, $conn) {
    $stmt = $conn->prepare("SELECT stock FROM books WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $stock = $stmt->get_result()->fetch_assoc()['stock'] ?? 0;

    $current_cart_qty = $_SESSION['cart'][$book_id] ?? 0;
    
    if (($current_cart_qty + $requested_qty) > $stock) {
        return "Error: Requested quantity exceeds available stock ($stock)!";
    }

    $_SESSION['cart'][$book_id] = $current_cart_qty + $requested_qty;
    return "Book added to cart successfully!";
}
?>
