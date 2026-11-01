<?php
require 'Question-4.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=students_export.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Name', 'Email', 'Enrollment Date']);

$stmt = $pdo->query("SELECT id, name, email, enrollment_date FROM students");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}
fclose($output);
exit;
?>