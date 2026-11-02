<?php
session_start();
require_once 'config.php';

$cookieName = 'remember_me';

// 1. Cookie se auto-login
if (!isset($_SESSION['user_id']) && !empty($_COOKIE[$cookieName])) {
    $parts = explode(':', $_COOKIE[$cookieName], 2);
    if (count($parts) === 2) {
        $stmt = $pdo->prepare("SELECT id, username, remember_token FROM users WHERE id = ?");
        $stmt->execute([(int)$parts[0]]);
        $u = $stmt->fetch();
        if ($u && $u['remember_token'] && hash_equals($u['remember_token'], hash('sha256', $parts[1]))) {
            session_regenerate_id(true);
            $_SESSION['user_id']  = $u['id'];
            $_SESSION['username'] = $u['username'];
        }
    }
}

// 2. Login form submit
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->execute([trim($_POST['username'] ?? '')]);
    $u = $stmt->fetch();

    if ($u && password_verify($_POST['password'] ?? '', $u['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id']  = $u['id'];
        $_SESSION['username'] = $u['username'];

        if (!empty($_POST['remember'])) {                 // "Remember Me" checked
            $token = bin2hex(random_bytes(32));
            $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?")
                ->execute([hash('sha256', $token), $u['id']]);   // DB me sirf hash
            setcookie($cookieName, $u['id'] . ':' . $token, [
                'expires'  => time() + 86400 * 30,        // 30 din
                'path'     => '/',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        }
        header("Location: login_remember.php");
        exit;
    }
    $error = "Invalid username or password.";
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Login with Remember Me</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<?php if (isset($_SESSION['user_id'])): ?>
    <h2>Welcome back, <?= e($_SESSION['username']) ?>!</h2>
    <p><a class="btn danger" href="logout.php">Logout</a></p>
<?php else: ?>
    <h2>Login</h2>
    <?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
    <form method="POST" class="box">
        Username: <input type="text" name="username" required>
        Password: <input type="password" name="password" required>
        <label><input type="checkbox" name="remember" value="1"> Remember me for 30 days</label><br><br>
        <button type="submit">Login</button>
    </form>
<?php endif; ?>
</body></html>
