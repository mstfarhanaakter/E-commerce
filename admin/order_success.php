<?php
session_start();

$order_success = $_SESSION['order_success'] ?? "No order was placed.";
unset($_SESSION['order_success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container text-center mt-5">
    <h2 class="text-success">Thank You!</h2>
    <p class="mt-3"><?= htmlspecialchars($order_success); ?></p>
    <a href="cart.php" class="btn btn-primary mt-4">Continue Shopping</a>
</div>
</body>
</html>
