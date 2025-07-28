<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">🛒 Your Cart</h2>
    <a href="../index.php" class="btn btn-secondary mb-3">← Back to Shop</a>
    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Price (৳)</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php
            $grand_total = 0;
            foreach ($_SESSION['cart'] as $key => $item):
                $total = $item['price'] * $item['quantity'];
                $grand_total += $total;
            ?>
            <tr>
                <td><?= $item['name']; ?></td>
                <td><?= $item['price']; ?></td>
                <td><?= $item['quantity']; ?></td>
                <td><?= $total; ?></td>
                <td><a href="remove.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm">Remove</a></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Grand Total</strong></td>
                <td colspan="2"><strong>৳ <?= $grand_total; ?></strong></td>
            </tr>
        </table>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>
</body>
</html>
