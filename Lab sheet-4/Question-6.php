<?php
require 'db.php';

$stmt = $pdo->prepare("INSERT INTO students (name, email, enrollment_date) VALUES (?, ?, ?)");
$name = "John Doe";
$email = "john.doe@example.com";
$date = date('Y-m-d');

if ($stmt->execute([$name, $email, $date])) {
    echo "New student record inserted successfully.";
} else {
    echo "Error inserting record.";
}
?>