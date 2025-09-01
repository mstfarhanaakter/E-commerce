<?php
session_start();
require "../config/db.php";

// ---------------- Login session ----------------
$is_logged_in = isset($_SESSION['user_id']);

// ---------------- Add to cart ----------------
if (isset($_GET['add'])) {
    $product_id = intval($_GET['add']);
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($con, $query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'images' => $product['images'],
                'quantity' => 1
            ];
        }
    }
    header("Location: cart.php");
    exit;
}

// ---------------- Update Quantity ----------------
if (isset($_GET['update'])) {
    $id = intval($_GET['update']);
    $action = $_GET['action'] ?? "";

    if (isset($_SESSION['cart'][$id])) {
        if ($action === "plus") {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } elseif ($action === "minus" && $_SESSION['cart'][$id]['quantity'] > 1) {
            $_SESSION['cart'][$id]['quantity'] -= 1;
        }
    }
    header("Location: cart.php");
    exit;
}

// ---------------- Remove item ----------------
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: cart.php");
    exit;
}

// ---------------- Calculate totals ----------------
$subtotal = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
}
$shipping = ($subtotal > 0) ? 50 : 0; // flat shipping fee
$total = $subtotal + $shipping;

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
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Cart Table -->
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                            <tr>
                                <td class="align-middle">
                                    <img src="../admin/<?= htmlspecialchars($item['images']); ?>" alt="<?= htmlspecialchars($item['name']); ?>" style="width:50px;">
                                    <?= htmlspecialchars($item['name']); ?>
                                </td>
                                <td class="align-middle">৳<?= number_format($item['price'],2); ?></td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 120px;">
                                        <a href="cart.php?update=<?= $id ?>&action=minus" class="btn btn-sm btn-primary">-</a>
                                        <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="<?= $item['quantity']; ?>" readonly>
                                        <a href="cart.php?update=<?= $id ?>&action=plus" class="btn btn-sm btn-primary">+</a>
                                    </div>
                                </td>
                                <td class="align-middle">৳<?= number_format($item['price'] * $item['quantity'],2); ?></td>
                                <td class="align-middle">
                                    <a href="cart.php?remove=<?= $id ?>" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">Your cart is empty</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Cart Summary -->
        <div class="col-lg-4">
            <form class="mb-30">
                <div class="input-group">
                    <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Apply Coupon</button>
                    </div>
                </div>
            </form>
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3">Cart Summary</span>
            </h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6>৳<?= number_format($subtotal,2); ?></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">৳<?= number_format($shipping,2); ?></h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5>৳<?= number_format($total,2); ?></h5>
                    </div>
                    <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->

<?php require "../includes/footer.php"; ?>
<script src="../assets/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
