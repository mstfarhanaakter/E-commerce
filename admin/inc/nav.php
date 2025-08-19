
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
          <img src="././media/profile.png" alt="Admin" class="profile-img" />
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