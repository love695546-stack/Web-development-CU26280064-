<?php
// Question 3: Develop a PHP script to fetch and display available books dynamically from the MySQL database in a grid layout.

$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM books WHERE stock > 0";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Books</title>
    <style>
        .grid-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem; padding: 2rem; }
        .book-item { border: 1px solid #ddd; padding: 1rem; border-radius: 8px; text-align: center; }
        .book-item img { max-width: 100%; height: 180px; object-fit: cover; }
    </style>
</head>
<body>
    <h2>Available Books Catalog</h2>
    <div class="grid-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="book-item">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Book Image">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p>Author: <?php echo htmlspecialchars($row['author']); ?></p>
                    <p>Price: $<?php echo number_format($row['price'], 2); ?></p>
                    <a href="book_detail.php?id=<?php echo $row['id']; ?>">View Details</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No books available currently.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>
