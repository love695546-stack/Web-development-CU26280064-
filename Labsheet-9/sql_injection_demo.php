<?php
require_once 'config.php';

$cat = $_GET['category'] ?? '';
$vulnRows = $safeRows = [];
$vulnSql = '';
$vulnError = '';

if ($cat !== '') {
    // VULNERABLE: user input seedha query me jod diya gaya (kabhi aisa mat karo)
    $vulnSql = "SELECT id, name, category, price FROM products WHERE category = '$cat'";
    try {
        $vulnRows = $pdo->query($vulnSql)->fetchAll();
    } catch (PDOException $ex) {
        $vulnError = $ex->getMessage();
    }

    // SAFE: prepared statement, input hamesha data hota hai, SQL code nahi
    $stmt = $pdo->prepare("SELECT id, name, category, price FROM products WHERE category = ?");
    $stmt->execute([$cat]);
    $safeRows = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>SQL Injection Demo</title>
<link rel="stylesheet" href="style.css"></head>
<body>
<h2>SQL Injection: Vulnerable vs Prepared Statement</h2>
<form method="GET">
    Category: <input type="text" name="category" value="<?= e($cat) ?>" style="width:260px">
    <button type="submit">Search</button>
</form>
<p>Try: <code>Electronics</code> and then <code>' OR '1'='1</code></p>

<?php if ($cat !== ''): ?>
<h3 class="error">1. Vulnerable query: <?= count($vulnRows) ?> row(s)</h3>
<p>Query executed: <code><?= e($vulnSql) ?></code></p>
<?php if ($vulnError): ?><p class="error">Error: <?= e($vulnError) ?></p><?php endif; ?>
<ul><?php foreach ($vulnRows as $r): ?><li><?= e($r['name']) ?> (<?= e($r['category']) ?>)</li><?php endforeach; ?></ul>

<h3 class="success">2. Prepared statement: <?= count($safeRows) ?> row(s)</h3>
<p>Query executed: <code>SELECT ... WHERE category = ?</code> with value <code><?= e($cat) ?></code></p>
<ul><?php foreach ($safeRows as $r): ?><li><?= e($r['name']) ?> (<?= e($r['category']) ?>)</li><?php endforeach; ?></ul>
<?php endif; ?>
</body></html>
