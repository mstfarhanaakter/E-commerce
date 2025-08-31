<?php
// Ensure you have already connected $con to database
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($con, $query);
?>

<!-- Product Grid Start -->
<div class="product-grid-wrapper bg-light">
    <div class="container">
        <header>
            <div class="brand">
                <div class="logo"><i class="fas fa-store"></i></div>
                <h1>Featured Products</h1>
            </div>
        </header>

        <!-- Carousel Buttons -->
        <button class="carousel-btn prev-btn" aria-label="Previous">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="carousel-btn next-btn" aria-label="Next">
            <i class="fas fa-chevron-right"></i>
        </button>

        <div class="carousel-wrapper">
            <main class="carousel py-0">
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <div class="card">
                        <div class="media">
                            <img src="./admin/<?= htmlspecialchars($product['images']) ?>"
                                 alt="<?= htmlspecialchars($product['name']) ?>">
                            <div class="badges">
                                <div class="badge">New</div>
                                <!-- <div class="badge secondary">-30%</div> -->
                            </div>
                            <div class="wishlist">
                                <button class="icon-btn"><i class="far fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="content">
                            <div class="title"><?= htmlspecialchars($product['name']) ?></div>
                            <div class="price">
                                <div class="new font-bold">৳<?= number_format($product['price'], 2) ?></div>
                                <div class="old">৳<?= number_format($product['old_price'], 2) ?></div>
                            </div>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                                <span class="count">(<?= rand(50, 500) ?>)</span>
                            </div>
                            <div class="actions">
                                <a href="cart.php?add=<?= $product['id'] ?>" class="p_btn">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </a>
                                <a href="pages/preview.php?id=<?= $product['id'] ?>" class="p_btn">
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

<!-- Product Grid CSS -->
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

.product-grid-wrapper .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 32px 20px 60px;
    position: relative;
}
.product-grid-wrapper header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
}
.product-grid-wrapper .brand {
    display: flex;
    align-items: center;
    gap: 12px;
}
.product-grid-wrapper .logo {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: grid;
    place-items: center;
    background: linear-gradient(135deg, var(--primary), var(--accent));
}
.carousel-wrapper { position: relative; }
.carousel {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    gap: 18px;
    padding-bottom: 20px;
    scrollbar-width: none;
}
.carousel::-webkit-scrollbar { display: none; }
.card {
    flex: 0 0 calc((100% / 4) - 13.5px);
    scroll-snap-align: start;
    background: var(--card);
}
@media (max-width: 1100px) { .card { flex: 0 0 calc((100% / 3) - 12px); } }
@media (max-width: 800px) { .card { flex: 0 0 calc((100% / 2) - 9px); } }
@media (max-width: 520px) { .card { flex: 0 0 100%; } }

.media { position: relative; aspect-ratio: 4 / 3; overflow: hidden; }
.media img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
.card:hover .media img { transform: scale(1.06); }

.badges { position: absolute; top: 12px; left: 12px; display: flex; gap: 8px; z-index: 2; }
.badge { padding: 6px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; color: #0b1020; background: var(--accent); }
.badge.secondary { background: var(--primary); }

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

.carousel-btn {
    position: absolute; top: 50%; width: 46px; height: 46px; transform: translateY(-50%);
    background: var(--primary); border: none; border-radius: 50%; color: #0b1020; cursor: pointer; transition: background-color 0.3s, color 0.3s; z-index: 10;
}
.carousel-btn:hover { background: var(--primary-600); color: white; }
.prev-btn { left: -50px; }
.next-btn { right: -50px; }
@media (max-width: 768px) { .carousel-btn { display: none; } }
</style>

<!-- Product Grid JS -->
<script>
const carousel = document.querySelector('.product-grid-wrapper .carousel');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');

function scrollByCard(direction) {
    const card = carousel.querySelector('.card');
    if (!card) return;
    const gap = parseInt(getComputedStyle(carousel).gap || 18);
    const scrollAmt = card.getBoundingClientRect().width + gap;
    carousel.scrollBy({ left: direction * scrollAmt, behavior: 'smooth' });
}

prevBtn.addEventListener('click', () => scrollByCard(-1));
nextBtn.addEventListener('click', () => scrollByCard(1));
</script>
