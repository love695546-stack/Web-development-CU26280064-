<?php
session_start();
require_once 'config.php';

// Remember-me token database se hatao
if (isset($_SESSION['user_id'])) {
    $pdo->prepare("UPDATE users SET remember_token = NULL WHERE id = ?")
        ->execute([$_SESSION['user_id']]);
}

$_SESSION = [];                                   // 1. session variables clear

if (ini_get("session.use_cookies")) {             // 2. session cookie delete
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
              $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
setcookie('remember_me', '', time() - 3600, '/'); // remember-me cookie delete

session_destroy();                                // 3. session destroy
header("Location: login.php");
exit;
