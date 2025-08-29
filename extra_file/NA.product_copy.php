<?php
// require "../config/db.php"; 
// database connection include

// fetch all products
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($con, $query);
?>

<div>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" />

    <style>
        .product-grid-wrapper {
            --bg: #ffffff;
            --surface: #f1f5f9;
            --card: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --primary: #FFD333;
            --primary-600: #d97706;
            --primary-700: #b45309;
            --accent: #fb7185;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --ring: rgba(255, 255, 255, 0.4);
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
            --radius: 18px;
            background: radial-gradient(1200px 600px at 10% -10%, rgba(255, 255, 255, 0.06), transparent),
                radial-gradient(800px 400px at 90% 10%, rgba(255, 255, 255, 0.05), transparent),
                var(--bg);
            color: var(--text);
            font-family: "Inter", system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
        }

        .product-grid-wrapper * {
            box-sizing: border-box;
        }

        .product-grid-wrapper .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 20px 60px;
        }

        .product-grid-wrapper header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
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
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35);
        }

        .product-grid-wrapper .brand h1 {
            font-size: 20px;
            margin: 0;
            letter-spacing: 0.3px;
        }

        .product-grid-wrapper .grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        @media (max-width: 1100px) {
            .product-grid-wrapper .grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 800px) {
            .product-grid-wrapper .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 520px) {
            .product-grid-wrapper .grid {
                grid-template-columns: 1fr;
            }
        }

        .product-grid-wrapper .card {
            position: relative;
            overflow: hidden;
            border-radius: var(--radius);
            background: #fff;
            box-shadow: var(--shadow);
        }

        .product-grid-wrapper .media {
            position: relative;
            aspect-ratio: 4/3;
            overflow: hidden;
        }

        .product-grid-wrapper .media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .product-grid-wrapper .card:hover .media img {
            transform: scale(1.06);
        }

        .product-grid-wrapper .badges {
            position: absolute;
            top: 12px;
            left: 12px;
            display: flex;
            gap: 8px;
            z-index: 2;
        }

        .product-grid-wrapper .badge {
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            color: #0b1020;
            background: var(--accent);
        }

        .product-grid-wrapper .badge.secondary {
            background: var(--warning);
        }

        .product-grid-wrapper .wishlist {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 2;
        }

        .product-grid-wrapper .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: rgba(165, 165, 165, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            cursor: pointer;
            transition: 0.2s;
        }

        .product-grid-wrapper .icon-btn:hover {
            transform: translateY(-2px);
            color: red;
        }

        .product-grid-wrapper .content {
            padding: 14px 14px 16px;
        }

        .product-grid-wrapper .title {
            font-weight: 600;
            font-size: 16px;
            margin: 4px 0 8px;
        }

        .product-grid-wrapper .price {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 6px 0 10px;
        }

        .product-grid-wrapper .price .new {
            font-weight: 700;
        }

        .product-grid-wrapper .price .old {
            color: var(--muted);
            text-decoration: line-through;
            font-size: 14px;
        }

        .product-grid-wrapper .rating {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #facc15;
            font-size: 14px;
        }

        .product-grid-wrapper .rating .count {
            color: var(--muted);
            font-size: 12px;
        }

        .product-grid-wrapper .actions {
            display: flex;
            gap: 10px;
            margin-top: 12px;
        }

        .product-grid-wrapper .btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 12px;
            font-size: 12px;
            border-radius: 12px;
            background: #FFD333;
            color: #0b1020;
            font-weight: bold;
            cursor: pointer;
            border: 1px solid grey;
        }

        .product-grid-wrapper .btn:hover {
            filter: brightness(1.1);
        }
    </style>

    <div class="product-grid-wrapper" data-theme="indigo">
        <div class="container">
            <header>
                <div class="brand">
                    <div class="logo"><i class="fa-solid fa-store"></i></div>
                    <h1>Feature Product</h1>
                </div>
            </header>

            <main class="grid py-1">
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <div class="card">
                        <div class="media">
                            <img src="./admin/<?= htmlspecialchars($product['images']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>">
                            <!-- /admin/products/products/abc123.jpg ❌ (wrong!) -->
                            <!-- so it has to be ./admin/ -->
                            <div class="badges">
                                <div class="badge">New</div>
                                <div class="badge secondary">-30%</div>
                            </div>

                            <div class="wishlist">
                                <button class="icon-btn"><i class="fa-regular fa-heart"></i></button>
                            </div>
                        </div>

                        <div class="content">
                            <div class="title"><?= htmlspecialchars($product['name']) ?></div>

                            <div class="price">
                                <div class="new">$<?= number_format($product['price'], 2) ?></div>
                                <div class="old">$<?= number_format($product['old_price'], 2) ?></div>
                            </div>

                            <div class="rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half-stroke"></i>
                                <i class="fa-regular fa-star"></i>
                                <span class="count">(<?= rand(50, 500) ?>)</span>
                            </div>

                            <div class="actions">
                                <a href="cart.php?add=<?= $product['id'] ?>" class="btn">
                                    <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                </a>
                                <a href="shop_detail.php?id=<?= $product['id'] ?>" class="btn">
                                    <i class="fa-solid fa-eye"></i> Preview
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </main>
        </div>
    </div>
</div>