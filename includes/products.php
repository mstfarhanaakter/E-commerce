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

        .product-grid-wrapper .themes {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .product-grid-wrapper .theme-btn {
            padding: 10px 14px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: var(--surface);
            color: var(--text);
            cursor: pointer;
        }

        .product-grid-wrapper .theme-btn.active {
            outline: 2px solid var(--ring);
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
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0));
            border: 1px solid rgba(255, 255, 255, 0.08);
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
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
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
            backdrop-filter: blur(8px);
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .product-grid-wrapper .icon-btn:hover {
            transform: translateY(-2px);
            background: rgba(214, 209, 209, 0.45);
            color: red;
        }

        .product-grid-wrapper .content {
            padding: 14px 14px 16px;
        }

        .product-grid-wrapper .title {
            font-weight: 600;
            font-size: 16px;
            margin: 4px 0 8px;
            letter-spacing: 0.2px;
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
            flex: 1 1 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid grey;
            gap: 8px;
            padding: 10px 12px;
            font-size: 12px;
            border-radius: 12px;
            background: #FFD333;
            color: #0b1020;
            font-weight: bold;
            cursor: pointer;
        }

        .product-grid-wrapper .btn:hover {
            filter: brightness(1.1);
        }

        .product-grid-wrapper .btn:disabled {
            opacity: 0.65;
            cursor: not-allowed;
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
                <!-- Cards -->
                <div class="card">
                    <div class="media">
                        <img src="https://images.unsplash.com/photo-1460353581641-37baddab0fa2?q=80&w=1200&auto=format&fit=crop"
                            alt="Chair" />
                        <div class="badges">
                            <div class="badge">New</div>
                            <div class="badge secondary">-30%</div>
                        </div>
                        <div class="wishlist"><button class="icon-btn"><i class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                    <div class="content">
                        <div class="title">Awesome Product</div>
                        <div class="price">
                            <div class="new">$49.99</div>
                            <div class="old">$79.99</div>
                        </div>
                        <div class="rating">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i><i class="fa-regular fa-star"></i>
                            <span class="count">(237)</span>
                        </div>
                        <div class="actions">
                            <button class="btn"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                            <button class="btn"><i class="fa-solid fa-eye"></i> Preview</button>
                        </div>
                    </div>
                </div>

                <!-- You can add more cards here (as in your original code) -->
                <!-- Card 2 -->
                <div class="card">
                    <div class="media">
                        <img src="https://images.unsplash.com/photo-1511988617509-a57c8a288659?q=80&w=1200&auto=format&fit=crop"
                            alt="Camera" />
                        <div class="badges">
                            <div class="badge secondary">Stock Out</div>
                        </div>
                        <div class="wishlist"><button class="icon-btn"><i class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                    <div class="content">
                        <div class="title">Another Product</div>
                        <div class="price">
                            <div class="new">$89.99</div>
                        </div>
                        <div class="rating">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                            <span class="count">(105)</span>
                        </div>
                        <div class="actions">
                            <button class="btn" disabled><i class="fa-solid fa-ban"></i> Unavailable</button>
                            <button class="btn"><i class="fa-solid fa-eye"></i><a href="./shop_detail.php" class="text-decoration-none text-black">Preview</a> </button>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="card">
                    <div class="media">
                        <img src="https://images.unsplash.com/photo-1511385348-a52b4a160dc2?q=80&w=1200&auto=format&fit=crop"
                            alt="Smartwatch" />
                        <div class="badges">
                            <div class="badge">Bestseller</div>
                        </div>
                        <div class="wishlist"><button class="icon-btn"><i class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                    <div class="content">
                        <div class="title">Cool Product</div>
                        <div class="price">
                            <div class="new">$39.99</div>
                            <div class="old">$59.99</div>
                        </div>
                        <div class="rating">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <span class="count">(542)</span>
                        </div>
                        <div class="actions">
                            <button class="btn"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                            <button class="btn"><i class="fa-solid fa-eye"></i> Preview</button>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="card">
                    <div class="media">
                        <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1200&auto=format&fit=crop"
                            alt="Backpack" />
                        <div class="badges">
                            <div class="badge secondary">Sale</div>
                        </div>
                        <div class="wishlist"><button class="icon-btn"><i class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                    <div class="content">
                        <div class="title">Last Product</div>
                        <div class="price">
                            <div class="new">$99.99</div>
                            <div class="old">$129.99</div>
                        </div>
                        <div class="rating">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                            <i class="fa-regular fa-star"></i>
                            <span class="count">(69)</span>
                        </div>
                        <div class="actions">
                            <button class="btn"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                            <button class="btn"><i class="fa-solid fa-eye"></i> Preview</button>
                        </div>
                    </div>
            </main>
        </div>
    </div>
</div>