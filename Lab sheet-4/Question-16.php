<?php
if (isset($_POST['theme'])) {
    setcookie('theme', $_POST['theme'], time() + (86400 * 30), "/");
    header("Refresh:0");
}
$theme = $_COOKIE['theme'] ?? 'light';
?>
<body style="background-color: <?= $theme === 'dark' ? '#333' : '#fff' ?>; color: <?= $theme === 'dark' ? '#fff' : '#000' ?>;">
    <form method="POST">
        <button name="theme" value="light">Light Theme</button>
        <button name="theme" value="dark">Dark Theme</button>
    </form>
</body>