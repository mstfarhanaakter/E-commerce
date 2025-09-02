<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$subtotal = 0;
$cart_items = $_SESSION['cart'];
foreach ($cart_items as $item) $subtotal += $item['price'] * $item['quantity'];

$shipping = ($subtotal > 0) ? 50 : 0;
$coupon_discount = $_SESSION['coupon_discount'] ?? 0;
$total = $subtotal + $shipping - $coupon_discount;

// Generate invoice number
$invoice_no = 'INV'.rand(1000,9999);

// Insert order
$order_sql = "INSERT INTO orders (user_id, due_amount, invoice_no, qty, order_date, order_status) 
              VALUES (?, ?, ?, ?, NOW(), 'Pending')";
$stmt = mysqli_prepare($con, $order_sql);
$total_qty = array_sum(array_column($cart_items, 'quantity'));
mysqli_stmt_bind_param($stmt, "idsi", $user_id, $total, $invoice_no, $total_qty);
mysqli_stmt_execute($stmt);
$order_id = mysqli_insert_id($con);

// Optional: insert order items
foreach ($cart_items as $pid => $item) {
    $item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt2 = mysqli_prepare($con, $item_sql);
    mysqli_stmt_bind_param($stmt2, "iiid", $order_id, $pid, $item['quantity'], $item['price']);
    mysqli_stmt_execute($stmt2);
}

// Clear cart
unset($_SESSION['cart']);
unset($_SESSION['coupon_discount']);

// Alert and redirect
echo "<script>
    alert('Your order has been placed!');
    window.location.href='../main.php';
</script>";
?>
