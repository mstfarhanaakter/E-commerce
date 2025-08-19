<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>DoraMart Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <style>
    :root {
      --sidebar-bg: #6c757d;
      --highlight: #ffc107;
      --text-light: #f8f9fa;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
      overflow-x: hidden;
    }

    /* Sidebar styles */
    .sidebar-lg {
      width: 250px;
      background: var(--sidebar-bg);
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 1rem;
      transition: transform 0.3s ease;
      z-index: 1050;
      overflow-y: auto;
    }

    .sidebar-lg.collapsed {
      transform: translateX(-100%);
    }

    .sidebar-lg .nav-link,
    .sidebar-lg .btn-toggle {
      color: var(--text-light);
      padding: 10px 20px;
      font-size: 15px;
      text-align: left;
      width: 100%;
      border: none;
      background: none;
    }

    .sidebar-lg .nav-link:hover,
    .sidebar-lg .btn-toggle:hover,
    .sidebar-lg .nav-link.active {
      background: rgba(255, 255, 255, 0.1);
      color: var(--highlight);
    }

    .sidebar-lg .nav-link i,
    .sidebar-lg .btn-toggle i {
      width: 20px;
      margin-right: 10px;
    }

    /* Submenu */
    .sidebar-lg .collapse .nav-link {
      padding-left: 3rem;
      font-size: 14px;
      color: #ddd;
    }

    .sidebar-lg .collapse .nav-link:hover {
      background: rgba(255, 255, 255, 0.15);
      color: var(--highlight);
    }

    /* Content wrapper */
    .content-wrapper {
      margin-left: 0;
      transition: margin-left 0.3s ease;
      min-height: 100vh;
    }

    @media (min-width: 768px) {
      .content-wrapper {
        margin-left: 250px;
      }

      .content-wrapper.shifted {
        margin-left: 0;
      }
    }

    /* Top Navbar */
    .top-navbar {
      background: #fff;
      padding: 10px 1rem;
      border-bottom: 1px solid #dee2e6;
      position: sticky;
      top: 0;
      z-index: 1100;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    /* Admin Profile Image */
    .profile-img {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border-radius: 50%;
    }
   @media (min-width: 768px) {
  .col-md-2-4 {
    flex: 0 0 20%;
    max-width: 20%;
  }
}

  </style>
</head>

<body>

  <!-- Desktop Sidebar -->
  <nav class="sidebar-lg d-none d-md-block" id="sidebarDesktop">
    <h5 class="text-center text-warning">Admin Panel</h5>
    <nav class="nav flex-column mt-3">

      <a href="#" class="nav-link active"><i class="fa fa-home"></i> Dashboard</a>

      <!-- Products dropdown -->
      <button class="btn btn-toggle align-items-center" data-bs-toggle="collapse" data-bs-target="#productsCollapse"
        aria-expanded="false" aria-controls="productsCollapse">
        <i class="fa fa-box"></i> Products
        <i class="fa fa-chevron-down ms-auto"></i>
      </button>
      <div class="collapse" id="productsCollapse">
        <nav class="nav flex-column">
          <a href="#" class="nav-link">All Products</a>
          <a href="#" class="nav-link">Add New</a>
          <a href="#" class="nav-link">Manage Inventory</a>
        </nav>
      </div>

      <!-- Categories dropdown -->
      <button class="btn btn-toggle align-items-center" data-bs-toggle="collapse" data-bs-target="#categoriesCollapse"
        aria-expanded="false" aria-controls="categoriesCollapse">
        <i class="fa fa-list"></i> Categories
        <i class="fa fa-chevron-down ms-auto"></i>
      </button>
      <div class="collapse" id="categoriesCollapse">
        <nav class="nav flex-column">
          <a href="#" class="nav-link">All Categories</a>
          <a href="#" class="nav-link">Add Category</a>
        </nav>
      </div>

      <!-- Sub-categories dropdown -->
      <button class="btn btn-toggle align-items-center" data-bs-toggle="collapse" data-bs-target="#subcategoriesCollapse"
        aria-expanded="false" aria-controls="subcategoriesCollapse">
        <i class="fa fa-tags"></i> Sub-categories
        <i class="fa fa-chevron-down ms-auto"></i>
      </button>
      <div class="collapse" id="subcategoriesCollapse">
        <nav class="nav flex-column">
          <a href="#" class="nav-link">All Sub-categories</a>
          <a href="#" class="nav-link">Add Sub-category</a>
        </nav>
      </div>

      <!-- Orders dropdown -->
      <button class="btn btn-toggle align-items-center" data-bs-toggle="collapse" data-bs-target="#ordersCollapse"
        aria-expanded="false" aria-controls="ordersCollapse">
        <i class="fa fa-shopping-cart"></i> Orders
        <i class="fa fa-chevron-down ms-auto"></i>
      </button>
      <div class="collapse" id="ordersCollapse">
        <nav class="nav flex-column">
          <a href="#" class="nav-link">All Orders</a>
          <a href="#" class="nav-link">Pending</a>
          <a href="#" class="nav-link">Completed</a>
        </nav>
      </div>

      <!-- Returns dropdown -->
      <button class="btn btn-toggle align-items-center" data-bs-toggle="collapse" data-bs-target="#returnsCollapse"
        aria-expanded="false" aria-controls="returnsCollapse">
        <i class="fa fa-undo"></i> Returns
        <i class="fa fa-chevron-down ms-auto"></i>
      </button>
      <div class="collapse" id="returnsCollapse">
        <nav class="nav flex-column">
          <a href="#" class="nav-link">Return Requests</a>
          <a href="#" class="nav-link">Processed Returns</a>
        </nav>
      </div>

      <!-- Payments dropdown -->
      <button class="btn btn-toggle align-items-center" data-bs-toggle="collapse" data-bs-target="#paymentsCollapse"
        aria-expanded="false" aria-controls="paymentsCollapse">
        <i class="fa fa-credit-card"></i> Payments
        <i class="fa fa-chevron-down ms-auto"></i>
      </button>
      <div class="collapse" id="paymentsCollapse">
        <nav class="nav flex-column">
          <a href="#" class="nav-link">All Payments</a>
          <a href="#" class="nav-link">Pending Payments</a>
          <a href="#" class="nav-link">Refunds</a>
        </nav>
      </div>

    </nav>
  </nav>

  <!-- Main Content Area -->
  <div class="content-wrapper">
    <header class="top-navbar">
      <div class="d-flex align-items-center">
        <!-- Mobile toggle button (offcanvas) -->
        <button class="btn btn-outline-secondary d-md-none me-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar"
          aria-controls="offcanvasSidebar">
          <i class="fa fa-bars"></i>
        </button>
        <!-- Desktop toggle button -->
        <button class="btn btn-outline-secondary d-none d-md-inline me-2" id="desktopToggle" aria-label="Toggle sidebar">
          <i class="fa fa-bars"></i>
        </button>
        <h4 class="m-0">Dashboard</h4>
      </div>

      <!-- Profile dropdown -->
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="adminMenuLink"
          data-bs-toggle="dropdown" aria-expanded="false" role="button">
          <img src="../media/profile.png" alt="Admin" class="profile-img" />
          <span class="ms-2">Admin</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminMenuLink">
          <li><a class="dropdown-item" href="#"><i class="fa fa-user me-2"></i> Edit Profile</a></li>
          <li><a class="dropdown-item" href="#"><i class="fa fa-users me-2"></i> Customers</a></li>
          <li><hr class="dropdown-divider" /></li>
          <li><a class="dropdown-item" href="#"><i class="fa fa-sign-out-alt me-2"></i> Logout</a></li>
        </ul>
      </div>
    </header>

    <!-- Dashboard Part Starts Here -->
      
<main class="p-4">
  <div class="row g-4 mt-3">

    <div class="col-6 col-md-4 col-lg-3">
      <a href="products.html" class="text-decoration-none text-dark">
        <div class="card border-secondary shadow-sm h-100 position-relative">
          <div class="card-body text-center">
            <div class="mb-3 text-warning">
              <i class="fa fa-box fa-3x"></i>
            </div>
            <h5 class="card-title fw-semibold">Products</h5>
            <p class="card-text fs-3 fw-bold">512</p>
            <i class="fa fa-arrow-right position-absolute" style="top: 15px; right: 15px; color: #ffc107;"></i>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <a href="customers.html" class="text-decoration-none text-dark">
        <div class="card border-secondary shadow-sm h-100 position-relative">
          <div class="card-body text-center">
            <div class="mb-3 text-primary">
              <i class="fa fa-users fa-3x"></i>
            </div>
            <h5 class="card-title fw-semibold">Customers</h5>
            <p class="card-text fs-3 fw-bold">1,234</p>
            <i class="fa fa-arrow-right position-absolute" style="top: 15px; right: 15px; color: #0d6efd;"></i>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <a href="categories.html" class="text-decoration-none text-dark">
        <div class="card border-secondary shadow-sm h-100 position-relative">
          <div class="card-body text-center">
            <div class="mb-3 text-info">
              <i class="fa fa-list fa-3x"></i>
            </div>
            <h5 class="card-title fw-semibold">Product Categories</h5>
            <p class="card-text fs-3 fw-bold">35</p>
            <i class="fa fa-arrow-right position-absolute" style="top: 15px; right: 15px; color: #0dcaf0;"></i>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <a href="orders.html" class="text-decoration-none text-dark">
        <div class="card border-secondary shadow-sm h-100 position-relative">
          <div class="card-body text-center">
            <div class="mb-3 text-warning">
              <i class="fa fa-shopping-cart fa-3x"></i>
            </div>
            <h5 class="card-title fw-semibold">Orders</h5>
            <p class="card-text fs-3 fw-bold">1,234</p>
            <i class="fa fa-arrow-right position-absolute" style="top: 15px; right: 15px; color: #ffc107;"></i>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <a href="earnings.html" class="text-decoration-none text-dark">
        <div class="card border-secondary shadow-sm h-100 position-relative">
          <div class="card-body text-center">
            <div class="mb-3 text-success">
              <i class="fa fa-dollar-sign fa-3x"></i>
            </div>
            <h5 class="card-title fw-semibold">Earnings</h5>
            <p class="card-text fs-3 fw-bold">$48,900</p>
            <i class="fa fa-arrow-right position-absolute" style="top: 15px; right: 15px; color: #198754;"></i>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <a href="pending-orders.html" class="text-decoration-none text-dark">
        <div class="card border-secondary shadow-sm h-100 position-relative">
          <div class="card-body text-center">
            <div class="mb-3 text-danger">
              <i class="fa fa-clock fa-3x"></i>
            </div>
            <h5 class="card-title fw-semibold">Pending Orders</h5>
            <p class="card-text fs-3 fw-bold">120</p>
            <i class="fa fa-arrow-right position-absolute" style="top: 15px; right: 15px; color: #dc3545;"></i>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <a href="completed-orders.html" class="text-decoration-none text-dark">
        <div class="card border-secondary shadow-sm h-100 position-relative">
          <div class="card-body text-center">
            <div class="mb-3 text-success">
              <i class="fa fa-check-circle fa-3x"></i>
            </div>
            <h5 class="card-title fw-semibold">Completed Orders</h5>
            <p class="card-text fs-3 fw-bold">1,114</p>
            <i class="fa fa-arrow-right position-absolute" style="top: 15px; right: 15px; color: #198754;"></i>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <a href="coupons.html" class="text-decoration-none text-dark">
        <div class="card border-secondary shadow-sm h-100 position-relative">
          <div class="card-body text-center">
            <div class="mb-3 text-info">
              <i class="fa fa-ticket-alt fa-3x"></i>
            </div>
            <h5 class="card-title fw-semibold">Total Coupons</h5>
            <p class="card-text fs-3 fw-bold">78</p>
            <i class="fa fa-arrow-right position-absolute" style="top: 15px; right: 15px; color: #0dcaf0;"></i>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <a href="sales.html" class="text-decoration-none text-dark">
        <div class="card border-secondary shadow-sm h-100 position-relative">
          <div class="card-body text-center">
            <div class="mb-3 text-primary">
              <i class="fa fa-chart-line fa-3x"></i>
            </div>
            <h5 class="card-title fw-semibold">Sales</h5>
            <p class="card-text fs-3 fw-bold">$120,000</p>
            <i class="fa fa-arrow-right position-absolute" style="top: 15px; right: 15px; color: #0d6efd;"></i>
          </div>
        </div>
      </a>
    </div>

    <div class="col-6 col-md-4 col-lg-3">
      <a href="invoices.html" class="text-decoration-none text-dark">
        <div class="card border-secondary shadow-sm h-100 position-relative">
          <div class="card-body text-center">
            <div class="mb-3 text-warning">
              <i class="fa fa-file-invoice-dollar fa-3x"></i>
            </div>
            <h5 class="card-title fw-semibold">Invoice</h5>
            <p class="card-text fs-3 fw-bold">350</p>
            <i class="fa fa-arrow-right position-absolute" style="top: 15px; right: 15px; color: #ffc107;"></i>
          </div>
        </div>
      </a>
    </div>

  </div>
  <!-- Example for one more card -->
    <!-- <div class="col-6 col-md-3 col-lg-2">
      <a href="categories.html" class="text-decoration-none text-dark">
        <div class="card border-secondary shadow-sm h-100 position-relative">
          <div class="card-body text-center py-2 px-2">
            <div class="mb-2 text-info">
              <i class="fa fa-list fa-2x"></i>
            </div>
            <h6 class="card-title fw-semibold mb-1">Product Categories</h6>
            <p class="card-text fs-5 fw-bold mb-2">35</p>
            <i class="fa fa-arrow-right position-absolute" style="top: 12px; right: 12px; color: #0dcaf0;"></i>
          </div>
        </div>
      </a>
    </div> -->
</main>

 <!-- dashboard ends here  -->

  <!-- Mobile offcanvas sidebar -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title text-warning" id="offcanvasSidebarLabel">DoraMart Admin</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
      <nav class="nav flex-column">

        <a href="#" class="nav-link active px-3"><i class="fa fa-home"></i> Dashboard</a>

        <!-- Products dropdown -->
        <button class="btn btn-toggle align-items-center w-100 text-start px-3" data-bs-toggle="collapse"
          data-bs-target="#offcanvasProductsCollapse" aria-expanded="false" aria-controls="offcanvasProductsCollapse">
          <i class="fa fa-box"></i> Products
          <i class="fa fa-chevron-down ms-auto"></i>
        </button>
        <div class="collapse" id="offcanvasProductsCollapse">
          <nav class="nav flex-column px-4">
            <a href="#" class="nav-link">All Products</a>
            <a href="#" class="nav-link">Add New</a>
            <a href="#" class="nav-link">Manage Inventory</a>
          </nav>
        </div>

        <!-- Categories dropdown -->
        <button class="btn btn-toggle align-items-center w-100 text-start px-3" data-bs-toggle="collapse"
          data-bs-target="#offcanvasCategoriesCollapse" aria-expanded="false" aria-controls="offcanvasCategoriesCollapse">
          <i class="fa fa-list"></i> Categories
          <i class="fa fa-chevron-down ms-auto"></i>
        </button>
        <div class="collapse" id="offcanvasCategoriesCollapse">
          <nav class="nav flex-column px-4">
            <a href="#" class="nav-link">All Categories</a>
            <a href="#" class="nav-link">Add Category</a>
          </nav>
        </div>

        <!-- Sub-categories dropdown -->
        <button class="btn btn-toggle align-items-center w-100 text-start px-3" data-bs-toggle="collapse"
          data-bs-target="#offcanvasSubcategoriesCollapse" aria-expanded="false"
          aria-controls="offcanvasSubcategoriesCollapse">
          <i class="fa fa-tags"></i> Sub-categories
          <i class="fa fa-chevron-down ms-auto"></i>
        </button>
        <div class="collapse" id="offcanvasSubcategoriesCollapse">
          <nav class="nav flex-column px-4">
            <a href="#" class="nav-link">All Sub-categories</a>
            <a href="#" class="nav-link">Add Sub-category</a>
          </nav>
        </div>

        <!-- Orders dropdown -->
        <button class="btn btn-toggle align-items-center w-100 text-start px-3" data-bs-toggle="collapse"
          data-bs-target="#offcanvasOrdersCollapse" aria-expanded="false" aria-controls="offcanvasOrdersCollapse">
          <i class="fa fa-shopping-cart"></i> Orders
          <i class="fa fa-chevron-down ms-auto"></i>
        </button>
        <div class="collapse" id="offcanvasOrdersCollapse">
          <nav class="nav flex-column px-4">
            <a href="#" class="nav-link">All Orders</a>
            <a href="#" class="nav-link">Pending</a>
            <a href="#" class="nav-link">Completed</a>
          </nav>
        </div>

        <!-- Returns dropdown -->
        <button class="btn btn-toggle align-items-center w-100 text-start px-3" data-bs-toggle="collapse"
          data-bs-target="#offcanvasReturnsCollapse" aria-expanded="false" aria-controls="offcanvasReturnsCollapse">
          <i class="fa fa-undo"></i> Returns
          <i class="fa fa-chevron-down ms-auto"></i>
        </button>
        <div class="collapse" id="offcanvasReturnsCollapse">
          <nav class="nav flex-column px-4">
            <a href="#" class="nav-link">Return Requests</a>
            <a href="#" class="nav-link">Processed Returns</a>
          </nav>
        </div>

        <!-- Payments dropdown -->
        <button class="btn btn-toggle align-items-center w-100 text-start px-3" data-bs-toggle="collapse"
          data-bs-target="#offcanvasPaymentsCollapse" aria-expanded="false" aria-controls="offcanvasPaymentsCollapse">
          <i class="fa fa-credit-card"></i> Payments
          <i class="fa fa-chevron-down ms-auto"></i>
        </button>
        <div class="collapse" id="offcanvasPaymentsCollapse">
          <nav class="nav flex-column px-4">
            <a href="#" class="nav-link">All Payments</a>
            <a href="#" class="nav-link">Pending Payments</a>
            <a href="#" class="nav-link">Refunds</a>
          </nav>
        </div>

      </nav>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Sidebar toggle for desktop
    const desktopToggleBtn = document.getElementById('desktopToggle');
    const sidebar = document.getElementById('sidebarDesktop');
    const contentWrapper = document.querySelector('.content-wrapper');

    desktopToggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      contentWrapper.classList.toggle('shifted');
    });
  </script>

</body>

</html>
