<?php
// Hash password for database storage during registration
$password = "SecretPass123";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed: " . $hashedPassword . "<br>";

// Verify user input password during login
$inputPassword = "SecretPass123";
if (password_verify($inputPassword, $hashedPassword)) {
    echo "Password verified successfully!";
} else {
    echo "Invalid password!";
}
?>