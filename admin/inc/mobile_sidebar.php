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