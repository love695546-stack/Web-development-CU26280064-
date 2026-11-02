<?php
// Q6: Reusable Header Template
function render_header(string $title = "App") {
    // Q9: CSRF Token Generation
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        body { font-family: sans-serif; margin: 20px; line-height: 1.6; }
        nav { background: #f4f4f4; padding: 10px; margin-bottom: 20px; }
        .error { color: red; } .success { color: green; }
    </style>
</head>
<body>
<nav>
    <a href="/">Home</a> | 
    <a href="/products">Products</a> | 
    <a href="/login.php">Login</a>
</nav>
<?php } ?>
