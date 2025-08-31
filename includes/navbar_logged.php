<?php
// session_start();
// require "../config/db.php"; 

// Fetch categories
$catQuery = "SELECT * FROM categories ORDER BY name";
$catResult = mysqli_query($con, $catQuery);
$categories = [];
if ($catResult) {
    while ($row = mysqli_fetch_assoc($catResult)) {
        $categories[] = $row;
    }
}

// Fetch sub-categories
$subQuery = "SELECT * FROM sub_category ORDER BY category_id, name";
$subResult = mysqli_query($con, $subQuery);
$subcategories = [];
if ($subResult) {
    while ($row = mysqli_fetch_assoc($subResult)) {
        $subcategories[] = $row;
    }
}

// Group subcategories by category_id
$subCatByCat = [];
foreach ($subcategories as $subcat) {
    $subCatByCat[$subcat['category_id']][] = $subcat;
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null;

// Fetch cart and wishlist
$user_cart_products = [];
$user_cart_quantity = 0;
$user_wishlist_products = [];

if ($is_logged_in) {
    // Cart: sum quantity
    $cartQuery = "SELECT product_id, quantity FROM carts WHERE user_id = $user_id";
    $cartResult = mysqli_query($con, $cartQuery);
    while ($item = mysqli_fetch_assoc($cartResult)) {
        $user_cart_products[] = $item['product_id'];
        $user_cart_quantity += $item['quantity'];
    }

    // Wishlist
    $wishlistQuery = "SELECT product_id FROM wishlist WHERE user_id = $user_id";
    $wishlistResult = mysqli_query($con, $wishlistQuery);
    while ($item = mysqli_fetch_assoc($wishlistResult)) {
        $user_wishlist_products[] = $item['product_id'];
    }
}

// Fetch products
$productQuery = "SELECT * FROM products ORDER BY id DESC";
$productResult = mysqli_query($con, $productQuery);
?>

<!-- Navbar Start -->
<div class="container-fluid bg-dark mb-30 sticky-top">
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
                    <!-- Left links -->
                    <div class="navbar-nav me-auto py-0">
                        <a href="index1.php?page=2" class="nav-item nav-link active">Home</a>
                        <a href="shop.html" class="nav-item nav-link">Shop</a>
                        <a href="detail.html" class="nav-item nav-link">Shop Detail</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Pages
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
                                class="badge bg-light text-dark position-absolute top-0 start-100 translate-middle rounded-pill border border-secondary">
                                <?= count($user_wishlist_products) ?>
                            </span>
                        </button>

                        <!-- Cart -->
                        <button class="btn px-2 position-relative navbar-cart">
                            <i class="fas fa-shopping-cart text-warning fs-5"></i>
                            <span id="navbar-cart-badge"
                                class="badge bg-light text-dark position-absolute top-0 start-100 translate-middle rounded-pill border border-secondary">
                                <?= $user_cart_quantity ?>
                            </span>
                        </button>

                        <!-- Account Dropdown -->
                        <div class="navbar-nav me-auto py-0">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
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

<!-- Product Grid -->
<div class="product-grid-wrapper bg-light py-4">
    <div class="container">
        <header>
            <div class="brand">
                <div class="logo"><i class="fas fa-store"></i></div>
                <h1>Featured Products</h1>
            </div>
        </header>

        <div class="carousel-wrapper">
            <main class="carousel py-0 d-flex overflow-auto gap-3">
                <?php while ($product = mysqli_fetch_assoc($productResult)): ?>
                    <div class="card position-relative flex-shrink-0" style="width: 250px;">
                        <div class="media position-relative" style="aspect-ratio: 4/3; overflow:hidden;">
                            <img src="./admin/<?= htmlspecialchars($product['images']) ?>" class="w-100 h-100" style="object-fit: cover;" alt="<?= htmlspecialchars($product['name']) ?>">
                            <div class="wishlist position-absolute top-2 end-2">
                                <button class="icon-btn add-to-wishlist" data-id="<?= $product['id'] ?>">
                                    <i class="<?= in_array($product['id'], $user_wishlist_products) ? 'fas' : 'far' ?> fa-heart"></i>
                                </button>
                            </div>
                        </div>
                        <div class="content p-2">
                            <div class="title"><?= htmlspecialchars($product['name']) ?></div>
                            <div class="price d-flex gap-2">
                                <div class="new font-bold">৳<?= number_format($product['price'], 2) ?></div>
                                <div class="old text-muted text-decoration-line-through">৳<?= number_format($product['old_price'], 2) ?></div>
                            </div>
                            <div class="actions mt-2 d-flex gap-2">
                                <button class="btn btn-warning add-to-cart flex-grow-1" data-id="<?= $product['id'] ?>" <?= in_array($product['id'], $user_cart_products) ? 'disabled' : '' ?>>
                                    <i class="fas fa-cart-plus"></i> <?= in_array($product['id'], $user_cart_products) ? 'Added' : 'Add to Cart' ?>
                                </button>
                                <a href="pages/preview.php?id=<?= $product['id'] ?>" class="btn btn-secondary flex-grow-1">
                                    <i class="fas fa-eye"></i> Preview
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </main>
        </div>
    </div>
</div>

<!-- JS -->
<script>
const isLoggedIn = <?= $is_logged_in ? 'true' : 'false' ?>;
const navbarCartBadge = document.getElementById('navbar-cart-badge');
const navbarWishlistBadge = document.getElementById('navbar-wishlist-badge');

function updateCart(count) { navbarCartBadge.textContent = count; }
function updateWishlist(count) { navbarWishlistBadge.textContent = count; }

document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', () => {
        if (!isLoggedIn) return window.location.href = 'login.php';
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-cart-plus"></i> Added';
        let count = parseInt(navbarCartBadge.textContent) + 1;
        updateCart(count);
        // TODO: AJAX request to update cart DB
    });
});

document.querySelectorAll('.add-to-wishlist').forEach(btn => {
    btn.addEventListener('click', () => {
        if (!isLoggedIn) return window.location.href = 'login.php';
        const icon = btn.querySelector('i');
        icon.classList.toggle('far');
        icon.classList.toggle('fas');
        let count = parseInt(navbarWishlistBadge.textContent) + 1;
        updateWishlist(count);
        // TODO: AJAX request to update wishlist DB
    });
});
</script>
