<?php
session_start();
if (isset($_SESSION['username'])) {
    echo "Welcome back, " . htmlspecialchars($_SESSION['username']);
} else {
    echo "Please log in first.";
}
?>