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

<div class="product-grid-wrapper py-4">
    <div class="container">
        <header>
            <div class="brand">
                <div class="logo"><i class="fas fa-store"></i></div>
                <h1>Featured Products</h1>
            </div>
        </header>

        <div class="carousel-wrapper">
            <main class="carousel d-flex gap-3 overflow-auto">
                <?php while($product = mysqli_fetch_assoc($productResult)): ?>
                    <div class="card" style="width: 250px;">
                        <div class="media position-relative" style="aspect-ratio:4/3;">
                            <img src="./admin/<?= htmlspecialchars($product['images']) ?>" class="w-100 h-100" style="object-fit: cover;" alt="<?= htmlspecialchars($product['name']) ?>">
                            <div class="wishlist position-absolute top-2 end-2">
                                <button class="icon-btn add-to-wishlist" data-id="<?= $product['id'] ?>">
                                    <i class="<?= in_array($product['id'], $user_wishlist_products)?'fas':'far' ?> fa-heart"></i>
                                </button>
                            </div>
                        </div>
                        <div class="content p-2">
                            <div class="title"><?= htmlspecialchars($product['name']) ?></div>
                            <div class="price d-flex gap-2">
                                <div class="new font-bold">৳<?= number_format($product['price'],2) ?></div>
                                <div class="old text-muted text-decoration-line-through">৳<?= number_format($product['old_price'],2) ?></div>
                            </div>
                            <div class="actions d-flex gap-2 mt-2">
                                <button class="btn btn-warning add-to-cart flex-grow-1" data-id="<?= $product['id'] ?>" <?= in_array($product['id'],$user_cart_products)?'disabled':'' ?>>
                                    <i class="fas fa-cart-plus"></i> <?= in_array($product['id'],$user_cart_products)?'Added':'Add to Cart' ?>
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



<style>
.product-grid-wrapper {
    --bg: #ffffff;
    --card: #ffffff;
    --text: #111827;
    --muted: #6b7280;
    --primary: #FFD333;
    --primary-600: #d97706;
    --accent: #fb7185;
    font-family: "Inter", sans-serif;
    color: var(--text);
}
.product-grid-wrapper * { box-sizing: border-box; }
.product-grid-wrapper .container { max-width: 1200px; margin: 0 auto; padding: 32px 20px 60px; position: relative; }
.product-grid-wrapper header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; }
.product-grid-wrapper .brand { display: flex; align-items: center; gap: 12px; }
.product-grid-wrapper .logo { width: 42px; height: 42px; border-radius: 12px; display: grid; place-items: center; background: linear-gradient(135deg, var(--primary), var(--accent)); }
.carousel-wrapper { position: relative; }
.carousel { display: flex; overflow-x: auto; scroll-snap-type: x mandatory; gap: 18px; padding-bottom: 20px; scrollbar-width: none; }
.carousel::-webkit-scrollbar { display: none; }
.card { flex: 0 0 calc((100% / 4) - 13.5px); scroll-snap-align: start; background: var(--card); }
@media (max-width: 1100px) { .card { flex: 0 0 calc((100% / 3) - 12px); } }
@media (max-width: 800px) { .card { flex: 0 0 calc((100% / 2) - 9px); } }
@media (max-width: 520px) { .card { flex: 0 0 100%; } }
.media { position: relative; aspect-ratio: 4 / 3; overflow: hidden; }
.media img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
.card:hover .media img { transform: scale(1.06); }
.badges { position: absolute; top: 12px; left: 12px; display: flex; gap: 8px; z-index: 2; }
.badge { padding: 6px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; color: #0b1020; background: var(--accent); }
.wishlist { position: absolute; top: 10px; right: 10px; z-index: 2; }
.icon-btn { width: 40px; height: 40px; border-radius: 12px; display: grid; place-items: center; background: rgba(165, 165, 165, 0.35); border: 1px solid rgba(255,255,255,0.15); color: white; cursor: pointer; transition: 0.2s; }
.icon-btn:hover { transform: translateY(-2px); color: red; }
.content { padding: 14px; }
.title { font-weight: 600; font-size: 16px; margin: 4px 0 8px; }
.price { display: flex; gap: 8px; margin-bottom: 10px; }
.price .new { font-weight: 700; }
.price .old { color: var(--muted); text-decoration: line-through; font-size: 14px; }
.rating { display: flex; align-items: center; gap: 6px; color: #facc15; font-size: 14px; }
.rating .count { color: var(--muted); font-size: 12px; }
.actions { display: flex; gap: 10px; margin-top: 12px; }
.p_btn { flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 12px; font-size: 12px; border-radius: 12px; background: var(--primary); color: #0b1020; font-weight: bold; text-decoration: none; transition: 0.2s; }
.p_btn:hover { background: #FFE838; color: black; text-decoration: none; }
.carousel-btn { position: absolute; top: 50%; width: 46px; height: 46px; transform: translateY(-50%); background: var(--primary); border: none; border-radius: 50%; color: #0b1020; cursor: pointer; transition: background-color 0.3s, color 0.3s; z-index: 10; }
.carousel-btn:hover { background: var(--primary-600); color: white; }
.prev-btn { left: -50px; }
.next-btn { right: -50px; }
@media (max-width: 768px) { .carousel-btn { display: none; } }
</style>



<!-- JS -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const isLoggedIn = <?= $is_logged_in?'true':'false' ?>;
    const cartBadge = document.getElementById('navbar-cart-badge');
    const wishlistBadge = document.getElementById('navbar-wishlist-badge');

    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', () => {
            if(!isLoggedIn) return window.location.href='login.php';
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-cart-plus"></i> Added';
            if(cartBadge) cartBadge.textContent = parseInt(cartBadge.textContent)+1;
            // TODO: AJAX to update DB
        });
    });

    document.querySelectorAll('.add-to-wishlist').forEach(btn => {
        btn.addEventListener('click', () => {
            if(!isLoggedIn) return window.location.href='login.php';
            const icon = btn.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            if(wishlistBadge) wishlistBadge.textContent = parseInt(wishlistBadge.textContent)+1;
            // TODO: AJAX to update DB
        });
    });
});
</script>



<!-- style sheet  -->
 
<!-- JS -->


