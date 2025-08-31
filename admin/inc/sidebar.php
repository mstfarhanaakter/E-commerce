<!-- Desktop Sidebar -->
<nav class="sidebar-lg d-none d-md-block" id="sidebarDesktop">
  <h5 class="text-center text-warning"><a href="./main.php" class="text-decoration-none text-warning">Admin Panel</a></h5>
  <nav class="nav flex-column mt-3">

    <a href="#" class="nav-link active d-flex align-items-center">
      <i class="fa fa-home me-2"></i> Dashboard
    </a>

    <!-- Users dropdown -->
    <button class="btn btn-toggle align-items-center mt-3 d-flex w-100" 
            data-bs-toggle="collapse" 
            data-bs-target="#usersCollapse"
            aria-expanded="false" 
            aria-controls="usersCollapse">
      <i class="fa fa-users me-2"></i> Users
      <i class="fa fa-chevron-down ms-auto"></i>
    </button>
    <div class="collapse" id="usersCollapse">
      <nav class="nav flex-column ms-4 mt-2">

        <!-- Customer Toggle -->
        <button class="btn btn-sm btn-toggle d-flex align-items-center w-100 mb-1"
                data-bs-toggle="collapse" 
                data-bs-target="#customerSubMenu"
                aria-expanded="false" 
                aria-controls="customerSubMenu">
          <i class="fa fa-user me-2"></i> Customer
          <i class="fa fa-chevron-down ms-auto"></i>
        </button>
        <div class="collapse" id="customerSubMenu">
          <nav class="nav flex-column ms-4">
            <a href="customer-list.php" class="nav-link d-flex align-items-center">
              <i class="fa fa-list me-2"></i> Customer List
            </a>
            <a href="add-customer.php" class="nav-link d-flex align-items-center">
              <i class="fa fa-user-plus me-2"></i> Add Customer
            </a>
            <a href="customer-reports.php" class="nav-link d-flex align-items-center">
              <i class="fa fa-chart-line me-2"></i> Reports
            </a>
          </nav>
        </div>

        <!-- Vendor Toggle -->
        <button class="btn btn-sm btn-toggle d-flex align-items-center w-100 mt-2 mb-1"
                data-bs-toggle="collapse" 
                data-bs-target="#vendorSubMenu"
                aria-expanded="false" 
                aria-controls="vendorSubMenu">
          <i class="fa fa-store me-2"></i> Vendor
          <i class="fa fa-chevron-down ms-auto"></i>
        </button>
        <div class="collapse" id="vendorSubMenu">
          <nav class="nav flex-column ms-4">
            <a href="vendor-list.php" class="nav-link d-flex align-items-center">
              <i class="fa fa-list me-2"></i> Vendor List
            </a>
            <a href="add-vendor.php" class="nav-link d-flex align-items-center">
              <i class="fa fa-user-plus me-2"></i> Add Vendor
            </a>
            <a href="vendor-reports.php" class="nav-link d-flex align-items-center">
              <i class="fa fa-chart-bar me-2"></i> Reports
            </a>
          </nav>
        </div>

      </nav>
    </div>

    <!-- Categories dropdown -->
    <button class="btn btn-toggle align-items-center mt-3 d-flex w-100" 
            data-bs-toggle="collapse" 
            data-bs-target="#categoriesCollapse"
            aria-expanded="false" 
            aria-controls="categoriesCollapse">
      <i class="fa fa-list me-2"></i> Categories
      <i class="fa fa-chevron-down ms-auto"></i>
    </button>
    <div class="collapse" id="categoriesCollapse">
      <nav class="nav flex-column ms-4 mt-2">
        <a href="add_category.php" class="nav-link d-flex align-items-center"><i class="fa fa-plus me-2"></i> Insert Category</a>
        <a href="view_category.php" class="nav-link d-flex align-items-center"><i class="fa fa-eye me-2"></i> View Status</a>
        <a href="view_subcategory.php" class="nav-link d-flex align-items-center"><i class="fa fa-eye me-2"></i>Manage Categories</a>
        
      </nav>
    </div>

    <!-- Products dropdown -->
    <button class="btn btn-toggle align-items-center mt-3 d-flex w-100"
            data-bs-toggle="collapse" 
            data-bs-target="#productsCollapse"
            aria-expanded="false" 
            aria-controls="productsCollapse">
      <i class="fa fa-box me-2"></i> Products
      <i class="fa fa-chevron-down ms-auto"></i>
    </button>
    <div class="collapse" id="productsCollapse">
      <nav class="nav flex-column ms-4 mt-2">
        <a href="add_product.php" class="nav-link d-flex align-items-center"><i class="fa fa-plus me-2"></i> Insert Product</a>
        <a href="view_product.php" class="nav-link d-flex align-items-center"><i class="fa fa-eye me-2"></i> Manage Products</a>
        <a href="#" class="nav-link d-flex align-items-center"><i class="fa fa-cubes me-2"></i> Manage Inventory</a>
      </nav>
    </div>
<!-- Coupon dropdown -->
<button class="btn btn-toggle align-items-center mt-3 d-flex w-100"
        data-bs-toggle="collapse"
        data-bs-target="#couponsCollapse"
        aria-expanded="false"
        aria-controls="couponsCollapse">
  <i class="fas fa-ticket-alt me-2"></i> Coupon
  <i class="fas fa-chevron-down ms-auto"></i>
</button>
<div class="collapse" id="couponsCollapse">
  <nav class="nav flex-column ms-4 mt-2">
    <a href="cupon.php" class="nav-link d-flex align-items-center">
      <i class="fas fa-plus-circle me-2"></i> Insert Coupon
    </a>
    <a href="manage_cupon.php" class="nav-link d-flex align-items-center">
      <i class="fas fa-edit me-2"></i> Manage Coupon
    </a>
  </nav>
</div>

    <!-- Orders dropdown -->
    <button class="btn btn-toggle align-items-center mt-3 d-flex w-100"
            data-bs-toggle="collapse" 
            data-bs-target="#ordersCollapse"
            aria-expanded="false" 
            aria-controls="ordersCollapse">
      <i class="fa fa-shopping-cart me-2"></i> Orders
      <i class="fa fa-chevron-down ms-auto"></i>
    </button>
    <div class="collapse" id="ordersCollapse">
      <nav class="nav flex-column ms-4 mt-2">
        <a href="order.php" class="nav-link d-flex align-items-center"><i class="fa fa-list me-2"></i> All Orders</a>
        <a href="#" class="nav-link d-flex align-items-center"><i class="fa fa-hourglass-half me-2"></i> Pending</a>
        <a href="#" class="nav-link d-flex align-items-center"><i class="fa fa-check me-2"></i> Completed</a>
      </nav>
    </div>

    <!-- Returns dropdown -->
    <button class="btn btn-toggle align-items-center mt-3 d-flex w-100"
            data-bs-toggle="collapse" 
            data-bs-target="#returnsCollapse"
            aria-expanded="false" 
            aria-controls="returnsCollapse">
      <i class="fa fa-undo me-2"></i> Returns
      <i class="fa fa-chevron-down ms-auto"></i>
    </button>
    <div class="collapse" id="returnsCollapse">
      <nav class="nav flex-column ms-4 mt-2">
        <a href="#" class="nav-link d-flex align-items-center"><i class="fa fa-arrow-circle-left me-2"></i> Return Requests</a>
        <a href="#" class="nav-link d-flex align-items-center"><i class="fa fa-check-circle me-2"></i> Processed Returns</a>
      </nav>
    </div>

    <!-- Payments dropdown -->
    <button class="btn btn-toggle align-items-center mt-3 d-flex w-100"
            data-bs-toggle="collapse" 
            data-bs-target="#paymentsCollapse"
            aria-expanded="false" 
            aria-controls="paymentsCollapse">
      <i class="fa fa-credit-card me-2"></i> Payments
      <i class="fa fa-chevron-down ms-auto"></i>
    </button>
    <div class="collapse" id="paymentsCollapse">
      <nav class="nav flex-column ms-4 mt-2">
        <a href="#" class="nav-link d-flex align-items-center"><i class="fa fa-list me-2"></i> All Payments</a>
        <a href="#" class="nav-link d-flex align-items-center"><i class="fa fa-clock me-2"></i> Pending Payments</a>
        <a href="#" class="nav-link d-flex align-items-center"><i class="fa fa-undo me-2"></i> Refunds</a>
      </nav>
    </div>

    <!-- Summary dropdown -->
    <button class="btn btn-toggle align-items-center mt-3 d-flex w-100"
            data-bs-toggle="collapse" 
            data-bs-target="#summaryCollapse"
            aria-expanded="false" 
            aria-controls="summaryCollapse">
      <i class="fa fa-tachometer-alt me-2"></i> Summary
      <i class="fa fa-chevron-down ms-auto"></i>
    </button>
    <div class="collapse" id="summaryCollapse">
      <nav class="nav flex-column ms-4 mt-2">
        <a href="#" class="nav-link d-flex align-items-center"><i class="fa fa-chart-line me-2"></i> Income Summary</a>
      </nav>
    </div>

  </nav>
</nav>
