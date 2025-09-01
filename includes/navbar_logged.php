<?php
// session_start();
// require "../config/db.php"; 

// ===============================
// Check login
// ===============================
$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? intval($_SESSION['user_id']) : 0;

// ===============================
// Fetch categories & subcategories
// ===============================
$categories = [];
$subCatByCat = [];

// Categories
$catResult = mysqli_query($con, "SELECT * FROM categories ORDER BY name");
if ($catResult && mysqli_num_rows($catResult) > 0) {
    while ($row = mysqli_fetch_assoc($catResult)) {
        $categories[] = $row;
    }
}

// Subcategories
$subResult = mysqli_query($con, "SELECT * FROM sub_category ORDER BY category_id, name");
if ($subResult && mysqli_num_rows($subResult) > 0) {
    while ($row = mysqli_fetch_assoc($subResult)) {
        $subCatByCat[$row['category_id']][] = $row;
    }
}

// ===============================
// Fetch cart & wishlist
// ===============================
$user_cart_quantity = 0;
$user_cart_products = [];
$user_wishlist_products = [];

if ($is_logged_in && $user_id > 0) {
    // Cart
    $cartResult = mysqli_query($con, "SELECT product_id, quantity FROM carts WHERE user_id = $user_id");
    if ($cartResult && mysqli_num_rows($cartResult) > 0) {
        while ($row = mysqli_fetch_assoc($cartResult)) {
            $user_cart_products[] = $row['product_id'];
            $user_cart_quantity += intval($row['quantity']);
        }
    }

    // Wishlist
    $wishlistResult = mysqli_query($con, "SELECT product_id FROM wishlist WHERE user_id = $user_id");
    if ($wishlistResult && mysqli_num_rows($wishlistResult) > 0) {
        while ($row = mysqli_fetch_assoc($wishlistResult)) {
            $user_wishlist_products[] = $row['product_id'];
        }
    }
}
?>

<!-- Navbar Start -->
<div class="container-fluid bg-dark mb-3 sticky-top">
    <div class="row px-xl-5">
        <!-- Vertical Categories -->
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-warning w-100" data-bs-toggle="collapse"
                href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars me-2"></i>Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
                id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    <?php foreach ($categories as $cat): ?>
                        <?php if (!empty($subCatByCat[$cat['id']])): ?>
                            <div class="nav-item dropdown dropend">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                    <?= htmlspecialchars($cat['name']) ?>
                                    <i class="fa fa-angle-right float-end mt-1"></i>
                                </a>
                                <ul class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                    <?php foreach ($subCatByCat[$cat['id']] as $subcat): ?>
                                        <li><a href="#" class="dropdown-item"><?= htmlspecialchars($subcat['name']) ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="#" class="nav-item nav-link"><?= htmlspecialchars($cat['name']) ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </nav>
        </div>

        <!-- Main Navbar -->
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="../index1.php?page=1" class="text-decoration-none d-block d-lg-none">
                    <span class="h1 text-uppercase text-dark bg-light px-2">Dora</span>
                    <span class="h1 text-uppercase text-light bg-warning px-2 ms-n1">Mart</span>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav me-auto py-0">
                        <a href="index1.php?page=2" class="nav-item nav-link active">Home</a>
                        <a href="shop.html" class="nav-item nav-link">Shop</a>
                        <a href="detail.html" class="nav-item nav-link">Shop Detail</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">Pages
                                <i class="fa fa-angle-down mt-1"></i>
                            </a>
                            <ul class="dropdown-menu bg-warning rounded-0 border-0 m-0">
                                <li><a href="#" class="dropdown-item">Shopping Cart</a></li>
                                <li><a href="#" class="dropdown-item">Checkout</a></li>
                            </ul>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                    </div>

                    <!-- Right icons -->
                    <div class="d-flex align-items-center justify-content-evenly" style="gap: 1rem;">
                        <!-- Wishlist -->
                        <button class="btn px-2 position-relative navbar-wishlist">
                            <i class="far fa-heart text-warning fs-5"></i>
                            <span id="navbar-wishlist-badge"
                                class="badge bg-light text-dark position-absolute top-0 start-100 translate-middle border border-secondary rounded-circle d-flex align-items-center justify-content-center"
                                style="width:18px; height:18px; font-size:12px;">
                                <?= count($user_wishlist_products) ?>
                            </span>
                        </button>

                        <!-- Cart -->
                        <button class="btn px-2 position-relative navbar-cart">
                            <i class="fas fa-shopping-cart text-warning fs-5"></i>
                            <span id="navbar-cart-badge"
                                class="badge bg-light text-dark position-absolute top-0 start-100 translate-middle border border-secondary rounded-circle d-flex align-items-center justify-content-center"
                                style="width:18px; height:18px; font-size:12px;">
                                <?= $user_cart_quantity ?>
                            </span>
                        </button>

                        <!-- Account Dropdown -->
                        <div class="navbar-nav me-auto py-0">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fas fa-id-card me-2"></i>My Account
                                    <i class="fa fa-angle-down mt-1"></i>
                                </a>
                                <ul class="dropdown-menu bg-warning rounded-0 border-0 m-0">
                                    <li><a href="#" class="dropdown-item"><i class="fas fa-id-card me-2"></i>Edit Profile</a></li>
                                    <li><a href="#" class="dropdown-item"><i class="fas fa-box me-2"></i>My Orders</a></li>
                                    <li><a href="#" class="dropdown-item"><i class="fas fa-heart me-2"></i>My Wishlist</a></li>
                                    <li><a href="#" class="dropdown-item"><i class="fas fa-times me-2"></i>My Returns & <br> Cancellations</a></li>
                                    <li><a href="users/logout.php?page=logout" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
