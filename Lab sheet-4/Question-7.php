<?php
require 'db.php';
$stmt = $pdo->query("SELECT id, name, email, enrollment_date FROM students");
$students = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <style>
    </style>
</head>
<body>
    <h2 style="text-align: center;">Student List</h2>
    <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Enrollment Date</th></tr>
        <?php foreach ($students as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['enrollment_date']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>