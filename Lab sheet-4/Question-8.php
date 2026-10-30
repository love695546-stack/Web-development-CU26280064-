<?php
require 'db.php';

$id = 1; 
$newEmail = "updated.email@example.com";

$stmt = $pdo->prepare("UPDATE students SET email = ? WHERE id = ?");
if ($stmt->execute([$newEmail, $id])) {
    echo "Student email updated successfully.";
} else {
    echo "Failed to update email.";
}
?>