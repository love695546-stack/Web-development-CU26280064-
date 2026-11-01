<?php
// Question 12: Create a customer order history page where logged-in users can view their past purchases and status.

session_start();
$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");

$user_id = $_SESSION['user_id'] ?? 1;
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<h2>My Order History</h2>
<table border="1" cellpadding="8">
    <tr><th>Order #</th><th>Date</th><th>Total Amount</th><th>Status</th></tr>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo $row['order_date']; ?></td>
            <td>$<?php echo number_format($row['total_amount'], 2); ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
