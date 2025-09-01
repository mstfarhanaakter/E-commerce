<?php
session_start();
require "../config/db.php";

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$user = null;
if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];
    $res = mysqli_query($con, "SELECT first_name,last_name,email,address,phone_number FROM users WHERE id=$user_id LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);
    }
}

// Cart items
$cart_items = $_SESSION['cart'] ?? [];
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$shipping = ($subtotal > 0) ? 50 : 0;
$total = $subtotal + $shipping;

// Coupon (optional)
$coupon_discount = $_SESSION['coupon_discount'] ?? 0;
$total -= $coupon_discount;

// Handle Place Order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order']) && $is_logged_in) {
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($con, $_POST['last_name']);
    $email      = mysqli_real_escape_string($con, $_POST['email']);
    $phone      = mysqli_real_escape_string($con, $_POST['phone']);
    $address    = mysqli_real_escape_string($con, $_POST['address']);

    mysqli_query($con, "INSERT INTO orders (user_id, first_name, last_name, email, phone, address, total)
                        VALUES ('$user_id','$first_name','$last_name','$email','$phone','$address','$total')");
    $order_id = mysqli_insert_id($con);

    foreach ($cart_items as $product_id => $item) {
        mysqli_query($con, "INSERT INTO order_items (order_id, product_id, quantity, price)
                            VALUES ('$order_id','$product_id','{$item['quantity']}','{$item['price']}')");
    }

    unset($_SESSION['cart'], $_SESSION['coupon_discount']);
    header("Location: thank_you.php?order_id=$order_id");
    exit;
}


// ---------------- Include header/nav ----------------
require "../includes/he.php";
if($is_logged_in){
    require "../includes/topbar_logged.php";
    require "../includes/navbar_logged.php";
} else {
    require "../includes/topbar.php";
    require "../includes/navbar.php";
}

require "../placeholder.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-2 bg-white">
    <form method="POST">
        <div class="row">
            <!-- Billing & Shipping -->
            <div class="col-lg-8 p-4">
                <h4>Billing & Shipping</h4>
                <div class="mb-3">
                    <label>First Name</label>
                    <input class="form-control" type="text" name="first_name" required
                           value="<?= htmlspecialchars($user['first_name'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label>Last Name</label>
                    <input class="form-control" type="text" name="last_name" required
                           value="<?= htmlspecialchars($user['last_name'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email" required
                           value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label>Phone</label>
                    <input class="form-control" type="text" name="phone" required
                           value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label>Address</label>
                    <input class="form-control" type="text" name="address" required
                           value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                </div>
            </div>

            <!-- Order Summary & Payment -->
            <div class="col-lg-4 p-4">
                <h4>Order Summary</h4>
                <div class="border p-3 mb-3">
                    <?php foreach($cart_items as $item): ?>
                        <div class="d-flex justify-content-between">
                            <span><?= htmlspecialchars($item['name']); ?> x <?= $item['quantity']; ?></span>
                            <span>৳<?= number_format($item['price'] * $item['quantity'],2); ?></span>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Subtotal</strong>
                        <strong>৳<?= number_format($subtotal,2); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <strong>Shipping</strong>
                        <strong>৳<?= number_format($shipping,2); ?></strong>
                    </div>
                    <?php if($coupon_discount>0): ?>
                        <div class="d-flex justify-content-between text-success">
                            <strong>Coupon Discount</strong>
                            <strong>-৳<?= number_format($coupon_discount,2); ?></strong>
                        </div>
                    <?php endif; ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong>৳<?= number_format($total,2); ?></strong>
                    </div>
                </div>

                <!-- Payment Method -->
                <h4>Payment Method</h4>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" id="paypal" required>
                        <label class="form-check-label" for="paypal">Paypal</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" id="directcheck">
                        <label class="form-check-label" for="directcheck">Direct Check</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment" id="banktransfer">
                        <label class="form-check-label" for="banktransfer">Bank Transfer</label>
                    </div>
                </div>

                <!-- Place Order Button -->
                <button type="submit" name="place_order" class="btn btn-warning w-100">Place Order</button>
            </div>
        </div>
    </form>
</div>

<?php require "../includes/footer.php"; ?>
<script src="../assets/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
