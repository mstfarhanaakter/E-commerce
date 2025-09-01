<?php 
session_start();
require "../config/db.php";

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index1.php"); // Or your login page path
    exit;
};

require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";
?>

<main class="p-4">
    <h1>Admin Panel - Place Order</h1>

    <?php
    // Check if cart exists
    if (empty($_SESSION['cart'])) {
        echo "<div class='alert alert-warning'>No items in the cart to place an order.</div>";
    } else {
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

        if (mysqli_stmt_execute($stmt)) {
            // Optionally, insert items into order_items table if exists
            /*
            $order_id = mysqli_insert_id($con);
            foreach ($cart_items as $product_id => $item) {
                $stmt2 = mysqli_prepare($con, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt2, "iiid", $order_id, $product_id, $item['quantity'], $item['price']);
                mysqli_stmt_execute($stmt2);
            }
            */

            // Clear cart and coupon
            unset($_SESSION['cart']);
            unset($_SESSION['coupon_discount']);

            echo "<div class='alert alert-success'>Order has been placed successfully! Invoice: <strong>$invoice_no</strong></div>";
        } else {
            echo "<div class='alert alert-danger'>Error placing order: ".mysqli_error($con)."</div>";
        }
    }
    ?>
</main>

<?php 
require "inc/footer.php";
?>
