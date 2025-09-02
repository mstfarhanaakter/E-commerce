<?php
session_start();
require "../config/db.php";

if (empty($_SESSION['cart'])) {
    $_SESSION['order_success'] = "Your cart is empty!";
    header("Location: cart.php");
    exit;
}

// Calculate total
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$shipping = 50;
$coupon_discount = $_SESSION['coupon_discount'] ?? 0;
$total = $subtotal + $shipping - $coupon_discount;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];

    // Mock order processing (you'd insert into DB here)
    unset($_SESSION['cart']);
    $_SESSION['coupon_discount'] = 0;
    $_SESSION['order_success'] = "Your order has been placed with payment method: " . htmlspecialchars($payment_method);

    header("Location: order_success.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Select Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2>Select Payment Method</h2>
    <form method="POST">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="cod" value="Cash on Delivery" required>
            <label class="form-check-label" for="cod">Cash on Delivery</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="bkash" value="Bkash">
            <label class="form-check-label" for="bkash">Bkash</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="card" value="Credit/Debit Card">
            <label class="form-check-label" for="card">Credit/Debit Card</label>
        </div>

        <hr>
        <h5>Total: ৳<?= number_format($total, 2); ?></h5>
        <button type="submit" class="btn btn-success mt-3">Confirm Order</button>
        <a href="cart.php" class="btn btn-secondary mt-3">Back to Cart</a>
    </form>
</div>
</body>
</html>
