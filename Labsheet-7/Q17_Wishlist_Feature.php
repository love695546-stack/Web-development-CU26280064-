<?php
// Question 17: Implement a wishlist feature allowing users to save books to a personal wishlist stored in the database.

session_start();
$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");

if (isset($_GET['add_wishlist'])) {
    $book_id = intval($_GET['add_wishlist']);
    $user_id = $_SESSION['user_id'] ?? 1;

    $stmt = $conn->prepare("INSERT INTO wishlist (user_id, book_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
    echo "<p>Book added to your wishlist!</p>";
}
?>
