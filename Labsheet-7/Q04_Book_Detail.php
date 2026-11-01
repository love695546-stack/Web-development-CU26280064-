<?php
// Question 4: Build a book detail page in PHP that retrieves a specific book's information using its ID passed via URL (GET).

$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");

$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Details</title>
</head>
<body>
    <?php if ($book): ?>
        <div style="padding: 2rem; max-width: 600px; margin: auto;">
            <h2><?php echo htmlspecialchars($book['title']); ?></h2>
            <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="Cover" width="200">
            <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($book['category']); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($book['price'], 2); ?></p>
            <p><strong>Stock Remaining:</strong> <?php echo $book['stock']; ?></p>
            <a href="cart.php?action=add&id=<?php echo $book['id']; ?>">Add to Cart</a>
        </div>
    <?php else: ?>
        <p>Book not found!</p>
    <?php endif; ?>
</body>
</html>
