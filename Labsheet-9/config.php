<?php
// config.php - database connection (PDO) used by every page via require_once
$host    = 'localhost';
$db      = 'webapp_db';
$user    = 'root';
$pass    = 'CU26280064';            // apna MySQL password yahan likho
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    error_log($e->getMessage());               // real error log me jayega
    die("Database connection failed. Please try again later.");
}

// Helper: escape output to prevent XSS (Q16)
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
