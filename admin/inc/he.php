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




   



 