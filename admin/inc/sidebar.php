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
        <a href="add_product.php" class="nav-link">Insert Product</a>
        <a href="action_product.php" class="nav-link">All Products</a>
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
        <a href="add_category.php" class="nav-link">Insert Category</a>
        <a href="view_category.php" class="nav-link">View Category</a>
        <a href="sub_category.php" class="nav-link">Add Sub-category</a>
        <a href="#" class="nav-link">All Categories</a>
        <a href="#" class="nav-link">All Sub-Categories</a>


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

    <!-- Summary -->
    <button class="btn btn-toggle align-items-center" data-bs-toggle="collapse" data-bs-target="#paymentsCollapse"
      aria-expanded="false" aria-controls="paymentsCollapse">
      <i class="fa fa-tachometer-alt"></i> Summary
      <i class="fa fa-chevron-down ms-auto"></i>
    </button>
    <div class="collapse" id="paymentsCollapse">
      <nav class="nav flex-column">
        <a href="#" class="nav-link">Income Summary</a>
      </nav>
    </div>

  </nav>
</nav>