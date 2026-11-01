<?php
// Question 6: Create a shopping cart system using PHP sessions ($_SESSION['cart']) allowing users to add books, update quantities, and remove items.

session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Action: Add Book
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $book_id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id]++;
    } else {
        $_SESSION['cart'][$book_id] = 1;
    }
    header("Location: Q06_Shopping_Cart.php");
    exit;
}

// Action: Remove Item
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $book_id = intval($_GET['id']);
    unset($_SESSION['cart'][$book_id]);
}

// Action: Update Quantity
if (isset($_POST['update_cart'])) {
    foreach ($_POST['qty'] as $id => $quantity) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id] = intval($quantity);
        }
    }
}
?>
<h2>Your Shopping Cart</h2>
<form method="POST">
    <table border="1" cellpadding="8">
        <tr><th>Book ID</th><th>Quantity</th><th>Action</th></tr>
        <?php foreach ($_SESSION['cart'] as $id => $qty): ?>
            <tr>
                <td><?php echo $id; ?></td>
                <td><input type="number" name="qty[<?php echo $id; ?>]" value="<?php echo $qty; ?>"></td>
                <td><a href="?action=remove&id=<?php echo $id; ?>">Remove</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <button type="submit" name="update_cart">Update Quantities</button>
</form>
