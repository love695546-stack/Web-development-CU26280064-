<?php
// Q6: View Template receiving data
require_once __DIR__ . '/../header.php';
require_once __DIR__ . '/../footer.php';

render_header("Products List");
?>
<h2>Product Catalog</h2>
<ul>
    <?php foreach ($products as $p): ?>
        <li><strong><?= htmlspecialchars($p['name']) ?></strong> - $<?= htmlspecialchars($p['price']) ?> (<?= htmlspecialchars($p['category'] ?? 'General') ?>)</li>
    <?php endforeach; ?>
</ul>

<!-- Q8: Frontend JavaScript fetching from API with Token -->
<script>
async function loadApiProducts() {
    try {
        const res = await fetch('/api/products', {
            headers: {
                'Authorization': 'Bearer SECURE_SECRET_API_TOKEN_12345'
            }
        });
        const data = await res.json();
        console.log("Fetched via API:", data);
    } catch(err) {
        console.error("API error:", err);
    }
}
loadApiProducts();
</script>
<?php render_footer(); ?>
