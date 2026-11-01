<?php
// Question 15: Design a user review and rating system where registered users can leave star ratings and comments on book detail pages.

session_start();
$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");

if (isset($_POST['submit_review'])) {
    $book_id = intval($_POST['book_id']);
    $user_id = $_SESSION['user_id'] ?? 1;
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    $stmt = $conn->prepare("INSERT INTO reviews (book_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $book_id, $user_id, $rating, $comment);
    $stmt->execute();
}
?>
<form method="POST">
    <h3>Leave a Review</h3>
    <input type="hidden" name="book_id" value="1">
    <label>Rating (1-5 Stars):</label>
    <select name="rating">
        <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
        <option value="4">⭐⭐⭐⭐ (4/5)</option>
        <option value="3">⭐⭐⭐ (3/5)</option>
    </select><br>
    <textarea name="comment" placeholder="Write your review..."></textarea><br>
    <button type="submit" name="submit_review">Submit Review</button>
</form>
