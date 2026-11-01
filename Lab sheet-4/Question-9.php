<?php
require 'Question-4.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo "Student record deleted successfully.";
    } else {
        echo "Error deleting record.";
    }
} else {
    echo "No student ID provided. Pass ?id=X in the URL.";
}
?>