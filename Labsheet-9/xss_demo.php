<?php
session_start();
require_once 'config.php';          // e() function = htmlspecialchars() wrapper

if (!isset($_SESSION['comments'])) { $_SESSION['comments'] = []; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    if ($name !== '' && $comment !== '') {
        $_SESSION['comments'][] = ['name' => $name, 'comment' => $comment];
    }
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>XSS Prevention</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>Comments (XSS safe)</h2>
<form method="POST" class="box">
    Name: <input type="text" name="name" required>
    Comment: <input type="text" name="comment" required>
    <button type="submit">Post</button>
</form>
<p>Try posting: <code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code></p>

<?php foreach ($_SESSION['comments'] as $c): ?>
    <!-- UNSAFE:  <?php /* echo $c['comment']; */ ?>  -->
    <!-- SAFE: htmlspecialchars() script tag ko plain text bana deta hai -->
    <p><strong><?= htmlspecialchars($c['name'], ENT_QUOTES, 'UTF-8') ?>:</strong>
       <?= htmlspecialchars($c['comment'], ENT_QUOTES, 'UTF-8') ?></p>
<?php endforeach; ?>
</body></html>
