<?php
require_once 'config.php';

$errors = [];
$success = '';
$username = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    // Server-side validation
    if (!preg_match('/^[A-Za-z0-9_]{3,50}$/', $username)) {
        $errors[] = "Username must be 3-50 characters (letters, digits, underscore).";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if (!$errors) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = "Username or email already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);   // secure hashing
            $ins  = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $ins->execute([$username, $email, $hash]);
            $success = "Registration successful! <a href='login.php'>Login here</a>";
        }
    }
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Register</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>User Registration</h2>
<?php foreach ($errors as $err): ?><p class="error"><?= e($err) ?></p><?php endforeach; ?>
<?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
<form method="POST" class="box">
    Username: <input type="text" name="username" value="<?= e($username) ?>" required>
    Email: <input type="email" name="email" value="<?= e($email) ?>" required>
    Password: <input type="password" name="password" required>
    Confirm Password: <input type="password" name="confirm" required>
    <button type="submit">Register</button>
</form>
</body></html>
