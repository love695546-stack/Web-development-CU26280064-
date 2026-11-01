<?php
// Question 21: Write a PHP script for administrators to view sales summary reports and total revenue generated.

$conn = new mysqli("localhost", "root", "", "online_bookstore");

$revenue = $conn->query("SELECT SUM(total_amount) AS total_revenue FROM orders WHERE status = 'Delivered'")->fetch_assoc()['total_revenue'];
$total_orders = $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'];
?>
<h2>Sales & Revenue Report</h2>
<div style="display: flex; gap: 2rem;">
    <div style="border:1px solid #ccc; padding: 1.5rem; border-radius: 8px;">
        <h3>Total Revenue</h3>
        <p style="font-size: 2rem; color: #16a34a;">$<?php echo number_format($revenue, 2); ?></p>
    </div>
    <div style="border:1px solid #ccc; padding: 1.5rem; border-radius: 8px;">
        <h3>Total Orders</h3>
        <p style="font-size: 2rem; color: #2563eb;"><?php echo $total_orders; ?></p>
    </div>
</div>
