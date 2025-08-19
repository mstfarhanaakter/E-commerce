<!-- Navbar Start -->
<div class="container-fluid bg-dark mb-30 sticky-top">
    <div class="row px-xl-5">
        <!-- Vertical Categories -->
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100"
               data-bs-toggle="collapse" href="#navbar-vertical"
               style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars me-2"></i>Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
                 id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    <div class="nav-item dropdown dropend">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Dresses 
                            <i class="fa fa-angle-right float-end mt-1"></i>
                        </a>
                        <ul class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                            <li><a href="#" class="dropdown-item">Men's Dresses</a></li>
                            <li><a href="#" class="dropdown-item">Women's Dresses</a></li>
                            <li><a href="#" class="dropdown-item">Baby's Dresses</a></li>
                        </ul>
                    </div>
                    <a href="#" class="nav-item nav-link">Shirts</a>
                    <a href="#" class="nav-item nav-link">Jeans</a>
                    <a href="#" class="nav-item nav-link">Swimwear</a>
                    <a href="#" class="nav-item nav-link">Sleepwear</a>
                    <a href="#" class="nav-item nav-link">Sportswear</a>
                    <a href="#" class="nav-item nav-link">Jumpsuits</a>
                    <a href="#" class="nav-item nav-link">Blazers</a>
                    <a href="#" class="nav-item nav-link">Jackets</a>
                    <a href="#" class="nav-item nav-link">Shoes</a>
                </div>
            </nav>
        </div>

        <!-- Main Navbar -->
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="#" class="text-decoration-none d-block d-lg-none">
                    <span class="h1 text-uppercase text-dark bg-light px-2">Dora</span>
                    <span class="h1 text-uppercase text-light bg-primary px-2 ms-n1">Mart</span>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <!-- Left links -->
                    <div class="navbar-nav me-auto py-0">
                        <a href="index.html" class="nav-item nav-link active">Home</a>
                        <a href="shop.html" class="nav-item nav-link">Shop</a>
                        <a href="detail.html" class="nav-item nav-link">Shop Detail</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages 
                                <i class="fa fa-angle-down mt-1"></i>
                            </a>
                            <ul class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                <li><a href="cart.html" class="dropdown-item">Shopping Cart</a></li>
                                <li><a href="checkout.html" class="dropdown-item">Checkout</a></li>
                            </ul>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                    </div>

                    <!-- Right icons -->
                    <div class="d-flex align-items-center justify-content-evenly" style="gap: 1rem;">
                        <!-- Wishlist -->
                        <a href="wishlist.html" class="btn px-2 position-relative">
                            <i class="fas fa-heart text-warning fs-5"></i>
                            <span class="badge bg-light text-dark position-absolute top-0 start-100 translate-middle rounded-pill border border-secondary">0</span>
                        </a>

                        <!-- Cart -->
                        <a href="cart.html" class="btn px-2 position-relative">
                            <i class="fas fa-shopping-cart text-warning fs-5"></i>
                            <span class="badge bg-light text-dark position-absolute top-0 start-100 translate-middle rounded-pill border border-secondary">0</span>
                        </a>

                        <!-- Account Dropdown -->
                        <div class="navbar-nav me-auto py-0">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-id-card me-2"></i>My Account 
                                <i class="fa fa-angle-down mt-1"></i>
                            </a>
                            <ul class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                <li><a href="cart.html" class="dropdown-item">
                                    <i class="fas fa-id-card me-2"></i>Profile</a>
                                </li>
                                <li><a href="checkout.html" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    </div>
                    <!-- End Right icons -->
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->