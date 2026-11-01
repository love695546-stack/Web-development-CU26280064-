<?php
// Question 11: Implement pagination in PHP to display a limited number of books per page with page number links.

$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");

$limit = 5; // Books per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

$total_results = $conn->query("SELECT COUNT(*) AS count FROM books")->fetch_assoc()['count'];
$total_pages = ceil($total_results / $limit);

$result = $conn->query("SELECT * FROM books LIMIT $start, $limit");
?>
<h2>Books (Page <?php echo $page; ?>)</h2>
<ul>
    <?php while($row = $result->fetch_assoc()): ?>
        <li><?php echo htmlspecialchars($row['title']); ?> - $<?php echo $row['price']; ?></li>
    <?php endwhile; ?>
</ul>

<div>
    <?php for($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>
