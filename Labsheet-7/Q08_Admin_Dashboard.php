<?php
// Question 8: Implement an admin dashboard in PHP allowing administrators to add new books, update prices, and manage inventory levels.

$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");

if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $stmt = $conn->prepare("INSERT INTO books (title, author, price, stock) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $title, $author, $price, $stock);
    $stmt->execute();
    echo "<p>Book added successfully!</p>";
}
?>
<h2>Admin Dashboard - Inventory Management</h2>
<form method="POST">
    <input type="text" name="title" placeholder="Book Title" required><br>
    <input type="text" name="author" placeholder="Author" required><br>
    <input type="number" step="0.01" name="price" placeholder="Price ($)" required><br>
    <input type="number" name="stock" placeholder="Stock Quantity" required><br>
    <button type="submit" name="add_book">Add New Book</button>
</form>
