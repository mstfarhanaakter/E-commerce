<?php
// session_start();
// require "../config/db.php";

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null;

// Fetch cart and wishlist products
$user_cart_products = [];
$user_wishlist_products = [];

if ($is_logged_in) {
    // Cart
    $cartQuery = "SELECT product_id FROM carts WHERE user_id = $user_id";
    $cartResult = mysqli_query($con, $cartQuery);
    while ($row = mysqli_fetch_assoc($cartResult)) $user_cart_products[] = $row['product_id'];

    // Wishlist
    $wishlistQuery = "SELECT product_id FROM wishlist WHERE user_id = $user_id";
    $wishlistResult = mysqli_query($con, $wishlistQuery);
    while ($row = mysqli_fetch_assoc($wishlistResult)) $user_wishlist_products[] = $row['product_id'];
}

// Fetch products
$productQuery = "SELECT * FROM products ORDER BY id DESC";
$productResult = mysqli_query($con, $productQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Product Grid</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ---------- CSS ---------- */
body {
    font-family: "Inter", sans-serif;
    background: #f9f9f9;
    margin: 0;
}
.product-grid-wrapper {
    background: #f9f9f9;
    padding: 40px 0;
}
.product-grid-wrapper header .brand {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}
.product-grid-wrapper header .brand .logo {
    background: #ff9800;
    color: #fff;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    font-size: 18px;
}
/* Carousel */
.carousel-wrapper { overflow-x: auto; scrollbar-width: thin; scrollbar-color: #ccc transparent; }
.carousel { display: flex; gap: 20px; padding-bottom: 10px; }
.carousel::-webkit-scrollbar { height: 6px; }
.carousel::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
/* Card */
.card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.2s ease, box-shadow 0.2s ease; flex-shrink: 0; width: 250px; }
.card:hover { transform: translateY(-5px); box-shadow: 0 8px 18px rgba(0,0,0,0.12); }
.card .media { position: relative; aspect-ratio: 4/3; overflow: hidden; }
.card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
.card:hover img { transform: scale(1.05); }
/* Wishlist */
.icon-btn { background: rgba(255,255,255,0.8); border: none; padding: 6px 8px; border-radius: 50%; cursor: pointer; transition: background 0.2s; position: absolute; top: 10px; right: 10px; }
.icon-btn:hover { background: #ffefef; }
.icon-btn i { color: #e74c3c; font-size: 16px; }
/* Content */
.card .content { padding: 15px; }
.card .title { font-size: 16px; font-weight: 600; margin-bottom: 8px; }
.card .price { font-size: 14px; margin-bottom: 10px; display: flex; gap: 10px; }
.card .price .new { color: #2ecc71; font-weight: 700; }
.card .price .old { font-size: 13px; color: #999; text-decoration: line-through; }
/* Actions */
.card .actions { display: flex; gap: 10px; }
.card .btn { flex: 1; font-size: 14px; padding: 8px; border-radius: 8px; transition: 0.2s; }
/* .btn-warning { background: #ff9800; color: #fff; border: none; }
.btn-warning:hover { background: #e68900; }
.btn-secondary { background: #555; color: #fff; border: none; }
.btn-secondary:hover { background: #333; } */
/* Navbar badges */
#navbar-cart-badge, #navbar-wishlist-badge {
    background: #fff;
    color: #333;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 50%;
    position: absolute;
    top: -8px;
    right: -8px;
}

.p_btn { flex: 1; border: none; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 5px; font-size: 12px; border-radius: 12px; background: var(--primary); color: #0b1020; font-weight: bold; text-decoration: none; transition: 0.2s; }
.p_btn:hover { background: #FFE838; color: black; text-decoration: none; }

</style>
</head>
<body>

<div class="product-grid-wrapper">
    <div class="container">
        <header>
            <div class="brand">
                <div class="logo"><i class="fas fa-store"></i></div>
                <h1>Featured Products</h1>
            </div>
        </header>

        <div class="carousel-wrapper">
            <main class="carousel py-0">
                <?php while ($product = mysqli_fetch_assoc($productResult)): ?>
                    <div class="card">
                        <div class="media">
                            <img src="./admin/<?= htmlspecialchars($product['images']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            <button class="icon-btn add-to-wishlist" data-id="<?= $product['id'] ?>">
                                <i class="<?= in_array($product['id'], $user_wishlist_products) ? 'fas' : 'far' ?> fa-heart"></i>
                            </button>
                        </div>
                        <div class="content">
                            <div class="title"><?= htmlspecialchars($product['name']) ?></div>
                            <div class="price">
                                <div class="new text-black">৳<?= number_format($product['price'], 2) ?></div>
                                <div class="old">৳<?= number_format($product['old_price'], 2) ?></div>
                            </div>
                            <div class="rating text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                                <span class="count text-black">(<?= rand(50, 500) ?>)</span>
                            </div>
                            <div class="actions mt-4">
                                <button class="p_btn  add-to-cart" data-id="<?= $product['id'] ?>" <?= in_array($product['id'], $user_cart_products) ? 'disabled' : '' ?>>
                                    <i class="fas fa-cart-plus"></i> <?= in_array($product['id'], $user_cart_products) ? 'Added' : 'Add to Cart' ?>
                                </button>
                                <a href="pages/preview.php?id=<?= $product['id'] ?>" class="p_btn">
                                    <i class="fas fa-eye"></i> Preview
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </main>



             <!--  -->


                <!--  -->
                <!--  -->
        </div>
    </div>
</div>

<script>
const isLoggedIn = <?= $is_logged_in ? 'true' : 'false' ?>;
const navbarCartBadge = document.getElementById('navbar-cart-badge');
const navbarWishlistBadge = document.getElementById('navbar-wishlist-badge');

document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', () => {
        if (!isLoggedIn) return window.location.href = '../pages/signin.php';
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-cart-plus"></i> Added';
        if(navbarCartBadge) navbarCartBadge.textContent = parseInt(navbarCartBadge.textContent || 0) + 1;
    });
});

document.querySelectorAll('.add-to-wishlist').forEach(btn => {
    btn.addEventListener('click', () => {
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