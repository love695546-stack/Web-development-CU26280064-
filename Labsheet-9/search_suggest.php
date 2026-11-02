<?php
require_once 'config.php';
header('Content-Type: application/json; charset=utf-8');

$term = trim($_GET['term'] ?? '');
if ($term === '') {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT name, price FROM products WHERE name LIKE ? ORDER BY name LIMIT 5");
$stmt->execute(["%$term%"]);
echo json_encode($stmt->fetchAll());
