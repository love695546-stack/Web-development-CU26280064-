<?php
// Question 14: Implement secure input sanitization and prepared statements across all bookstore database queries to prevent SQL injection.

$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");

// Secure Search Function Example using Prepared Statements
$user_input = $_POST['search_query'] ?? '';
$clean_input = filter_var($user_input, FILTER_SANITIZE_SPECIAL_CHARS);

$stmt = $conn->prepare("SELECT id, title, price FROM books WHERE title LIKE ?");
$search_param = "%" . $clean_input . "%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$result = $stmt->get_result();
?>
