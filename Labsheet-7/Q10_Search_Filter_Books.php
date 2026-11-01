<?php
// Question 10: Incorporate a search and filter feature in PHP allowing users to search books by title, author, or category.

$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");

$search = isset($_GET['query']) ? trim($_GET['query']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

$sql = "SELECT * FROM books WHERE 1=1";
if ($search !== '') {
    $sql .= " AND (title LIKE '%" . $conn->real_escape_string($search) . "%' OR author LIKE '%" . $conn->real_escape_string($search) . "%')";
}
if ($category !== '') {
    $sql .= " AND category = '" . $conn->real_escape_string($category) . "'";
}

$result = $conn->query($sql);
?>
<h2>Search & Filter Books</h2>
<form method="GET">
    <input type="text" name="query" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search Title or Author">
    <select name="category">
        <option value="">All Categories</option>
        <option value="Fiction">Fiction</option>
        <option value="Technology">Technology</option>
    </select>
    <button type="submit">Filter</button>
</form>
