<?php
// Question 9: Write a PHP script enabling administrators to view all customer orders and update order fulfillment status (Pending, Shipped, Delivered).

$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");

if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
}

$result = $conn->query("SELECT orders.*, users.name FROM orders JOIN users ON orders.user_id = users.id");
?>
<h2>Order Fulfillment Management</h2>
<table border="1" cellpadding="8">
    <tr><th>Order ID</th><th>Customer</th><th>Total Amount</th><th>Status</th><th>Update</th></tr>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td>$<?php echo number_format($row['total_amount'], 2); ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                    <select name="status">
                        <option value="Pending">Pending</option>
                        <option value="Shipped">Shipped</option>
                        <option value="Delivered">Delivered</option>
                    </select>
                    <button type="submit" name="update_status">Update</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
