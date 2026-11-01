<?php
require 'Question-4.php';

try {
    $pdo->beginTransaction();
    
    // Step 1: Insert student record
    $stmt1 = $pdo->prepare("INSERT INTO students (name, email, enrollment_date) VALUES (?, ?, ?)");
    $stmt1->execute(['Jane Doe', 'jane.doe@example.com', date('Y-m-d')]);
    
    // Step 2: Log transaction / secondary table action
    $stmt2 = $pdo->prepare("INSERT INTO activity_log (action) VALUES (?)");
    $stmt2->execute(['Registered new student Jane Doe']);
    
    $pdo->commit();
    echo "Transaction committed successfully.";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Transaction failed and rolled back: " . $e->getMessage();
}
?>