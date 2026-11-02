<?php
// Q9: CSRF Validation
function validate_csrf(string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Q10: Login Session Management
function login_user(int $userId): void {
    session_regenerate_id(true); // Prevent session fixation
    $_SESSION['user_id'] = $userId;
    $_SESSION['logged_in_time'] = time();
}

// Q11: User Input Sanitization & Validation
function validate_and_sanitize_input(array $input): array {
    $cleanData = [];
    $errors = [];

    // Email validation
    $email = filter_var($input['email'] ?? '', FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email Address";
    } else {
        $cleanData['email'] = $email;
    }

    // Integer validation
    $age = filter_var($input['age'] ?? '', FILTER_VALIDATE_INT);
    if ($age === false || $age < 1) {
        $errors[] = "Invalid Age";
    } else {
        $cleanData['age'] = $age;
    }

    // URL validation
    $website = filter_var($input['website'] ?? '', FILTER_SANITIZE_URL);
    if (!empty($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
        $errors[] = "Invalid URL";
    } else {
        $cleanData['website'] = $website;
    }

    // String sanitization
    $cleanData['name'] = htmlspecialchars(trim($input['name'] ?? ''), ENT_QUOTES, 'UTF-8');

    return ['data' => $cleanData, 'errors' => $errors];
}

// Q12: Login Attempt Limiter (Lock account for 15 mins after 5 failed attempts)
function check_login_attempts(PDO $pdo, string $username): bool {
    $stmt = $pdo->prepare("SELECT failed_attempts, lockout_until FROM users WHERE username = :u");
    $stmt->execute(['u' => $username]);
    $user = $stmt->fetch();

    if ($user && $user['lockout_until'] && strtotime($user['lockout_until']) > time()) {
        return false; // Account locked
    }
    return true;
}

function record_failed_attempt(PDO $pdo, string $username): void {
    $stmt = $pdo->prepare("SELECT id, failed_attempts FROM users WHERE username = :u");
    $stmt->execute(['u' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        $attempts = $user['failed_attempts'] + 1;
        $lockout = null;
        if ($attempts >= 5) {
            $lockout = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        }
        $update = $pdo->prepare("UPDATE users SET failed_attempts = :a, lockout_until = :l WHERE id = :id");
        $update->execute(['a' => $attempts, 'l' => $lockout, 'id' => $user['id']]);
    }
}

// Q13: Forgot Password Feature Token Generator
function generate_password_reset_token(PDO $pdo, string $email): ?string {
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $stmt = $pdo->prepare("UPDATE users SET reset_token = :t, reset_expires = :e WHERE email = :email");
    $stmt->execute(['t' => $token, 'e' => $expires, 'email' => $email]);

    return $stmt->rowCount() > 0 ? $token : null;
}
