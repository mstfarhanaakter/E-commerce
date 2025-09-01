<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_items = $_SESSION['cart'];

// Calculate totals
$subtotal = 0;
$total_qty = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
    $total_qty += $item['quantity'];
}

$shipping = ($subtotal > 0) ? 50 : 0;
$coupon_discount = $_SESSION['coupon_discount'] ?? 0;
$total = $subtotal + $shipping - $coupon_discount;

// Generate invoice number
$invoice_no = 'INV'.rand(1000,9999);

// Insert into orders table
$stmt = mysqli_prepare($con, "INSERT INTO orders (user_id, due_amount, invoice_no, qty, order_date, order_status) VALUES (?, ?, ?, ?, NOW(), 'Pending')");
mysqli_stmt_bind_param($stmt, "idsi", $user_id, $total, $invoice_no, $total_qty);
mysqli_stmt_execute($stmt);

// Optional: insert each item into order_items table (if you have one)
// $order_id = mysqli_insert_id($con);
// foreach ($cart_items as $product_id => $item) {
//     $stmt2 = mysqli_prepare($con, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
//     mysqli_stmt_bind_param($stmt2, "iiid", $order_id, $product_id, $item['quantity'], $item['price']);
//     mysqli_stmt_execute($stmt2);
// }

// Clear cart and coupon
unset($_SESSION['cart']);
unset($_SESSION['coupon_discount']);

// Alert and redirect to home
echo "<script>
        alert('Your order has been placed successfully!');
        window.location.href='index1.php';
      </script>";
?>
