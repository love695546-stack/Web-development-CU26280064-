<?php
// Question 16: Write a PHP script to generate an invoice summary page after successful order placement.

$conn = new mysqli("localhost", "root", "CU26280064", "online_bookstore");
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 1;

$order_res = $conn->query("SELECT * FROM orders WHERE id = $order_id")->fetch_assoc();
$items_res = $conn->query("SELECT order_items.*, books.title FROM order_items JOIN books ON order_items.book_id = books.id WHERE order_id = $order_id");
?>
<h2>Invoice Summary - Order #<?php echo $order_id; ?></h2>
<p>Date: <?php echo $order_res['order_date']; ?></p>
<table border="1" cellpadding="8">
    <tr><th>Item Title</th><th>Quantity</th><th>Unit Price</th><th>Total</th></tr>
    <?php while($item = $items_res->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($item['title']); ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td>$<?php echo number_format($item['price'], 2); ?></td>
            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<h3>Grand Total: $<?php echo number_format($order_res['total_amount'], 2); ?></h3>
