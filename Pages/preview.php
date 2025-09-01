<?php
session_start();
require "../config/db.php";

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null;

// Fetch cart and wishlist products
$user_cart_products = [];
$user_wishlist_products = [];
if ($is_logged_in) {
    $cartResult = mysqli_query($con, "SELECT product_id FROM carts WHERE user_id = $user_id");
    while ($row = mysqli_fetch_assoc($cartResult)) $user_cart_products[] = $row['product_id'];

    $wishlistResult = mysqli_query($con, "SELECT product_id FROM wishlist WHERE user_id = $user_id");
    while ($row = mysqli_fetch_assoc($wishlistResult)) $user_wishlist_products[] = $row['product_id'];
}

// Get product id safely
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($con, $query);
$product = mysqli_fetch_assoc($result);

// Explode images
$images = !empty($product['images']) ? explode(',', $product['images']) : [];

require "../includes/he.php";
if($is_logged_in){
    require "../includes/topbar_logged.php";  
    require "../includes/navbar_logged.php";
} else {
    require "../includes/topbar.php";        
    require "../includes/navbar.php";
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($product['name']); ?> | Product Details</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- Shop Detail Start -->
<div class="container-fluid pt-3">
    <div class="row px-xl-5">
        <!-- Product Images -->
        <div class="col-lg-5 mb-3">
            <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner bg-light">
                    <?php foreach ($images as $index => $img): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img class="d-block w-100" src="../admin/<?= htmlspecialchars(trim($img)); ?>" alt="Product Image <?= $index+1 ?>" style="height:400px; object-fit:cover;">
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#product-carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#product-carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-7">
            <div class="bg-light p-4 h-100">
                <h3><?= htmlspecialchars($product['name']); ?></h3>
                <div class="d-flex mb-3">
                    <div class="text-primary me-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <small class="pt-1">(<?= rand(50,200) ?> Reviews)</small>
                </div>
                <h4 class="text-success mb-3">৳<?= number_format($product['price'],2); ?></h4>
                <p><?= htmlspecialchars($product['description']); ?></p>

                <!-- Sizes -->
                <div class="mb-3">
                    <strong>Sizes:</strong>
                    <?php foreach (['XS','S','M','L','XL'] as $size): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="size" id="size-<?= $size ?>" value="<?= $size ?>">
                            <label class="form-check-label" for="size-<?= $size ?>"><?= $size ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Colors -->
                <div class="mb-3">
                    <strong>Colors:</strong>
                    <?php foreach (['Black','White','Red','Blue','Green'] as $color): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="color" id="color-<?= $color ?>" value="<?= $color ?>">
                            <label class="form-check-label" for="color-<?= $color ?>"><?= $color ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Quantity + Add to Cart -->
                <div class="d-flex align-items-center gap-2 mt-3">
                    <input type="number" class="form-control w-25" value="1" min="1">
                    <a href="cart.php?add=<?= $product['id'] ?>" class="btn btn-primary">
                        <i class="fa fa-shopping-cart me-1"></i> Add To Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->

<?php require "../includes/footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js"></script>
<script>
const isLoggedIn = <?= $is_logged_in ? 'true' : 'false' ?>;
const navbarCartBadge = document.getElementById('navbar-cart-badge');
const navbarWishlistBadge = document.getElementById('navbar-wishlist-badge');

document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault()
        if (!isLoggedIn) return window.location.href = '../pages/signin.php';
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-cart-plus"></i> Added';
        if(navbarCartBadge) navbarCartBadge.textContent = parseInt(navbarCartBadge.textContent || 0) + 1;
    });
});

document.querySelectorAll('.add-to-wishlist').forEach(btn => {
    btn.addEventListener('click', () => {
        e.preventDefault()
        if (!isLoggedIn) return window.location.href = '../pages/signin.php';
        const icon = btn.querySelector('i');
        icon.classList.toggle('far');
        icon.classList.toggle('fas');
        if(navbarWishlistBadge) navbarWishlistBadge.textContent = parseInt(navbarWishlistBadge.textContent || 0) + 1;
    });
});
</script>
</body>
</html>
