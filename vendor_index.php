<!-- php Header, topbar, navbar, banner, feature, category, products start -->
<?php
session_start();
require "config/db.php";
require "includes/he.php";
require "includes/topbar.php";
require "includes/navbar.php";
?>
<!-- php Header, topbar, navbar, banner, feature, category, products end -->

<!-- Carousel Start -->
<div class="container-fluid mb-3">
  <div class="row">
    <div class="col-lg-12">
      <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item position-relative active" style="height: 430px;">
            <img class="position-absolute w-100 h-100" src="assets/img/seller.jpg" style="object-fit: cover;">
            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
              <div class="p-3" style="max-width: 700px;">
                <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Sell, Grow, Succeed.</h1>
                <p class="mx-md-5 px-5 animate__animated animate__bounceIn text-white">
                  Your store, your rules—start selling online today!
                </p>
                <a href="vendor_signup.php"
                  class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp">Sign Up</a>
                <!-- <a href="vendor_signin.php"
                  class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp">Sign In</a> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- New Seller Benefits -->
<section class="py-5 bg-light container-fluid">
  <div class="container">
    <h2 class="text-center mb-4">New Seller Benefits</h2>
    <div class="row g-3">
      <!-- 0% Commission -->
      <div class="col-md-4 col-sm-6">
        <div class="benefit-card text-center p-3 rounded shadow-sm">
          <i class="bi bi-currency-dollar fs-2 mb-2 icon-commission"></i>
          <h5>0% Commission</h5>
          <p class="small">0% platform commission fee for 30 Days</p>
        </div>
      </div>

      <!-- Free Shipping -->
      <div class="col-md-4 col-sm-6">
        <div class="benefit-card text-center p-3 rounded shadow-sm">
          <i class="bi bi-truck fs-2 mb-2 icon-shipping"></i>
          <h5>Free Shipping</h5>
          <p class="small">Offer Free Shipping via programs like FSM</p>
        </div>
      </div>

      <!-- Nationwide Reach -->
      <div class="col-md-4 col-sm-6">
        <div class="benefit-card text-center p-3 rounded shadow-sm">
          <i class="bi bi-globe fs-2 mb-2 icon-globe"></i>
          <h5>Nationwide Reach</h5>
          <p class="small">Deliver your product anywhere in the country</p>
        </div>
      </div>

      <!-- Dedicated Support & Training -->
      <div class="col-md-4 col-sm-6">
        <div class="benefit-card text-center p-3 rounded shadow-sm">
          <i class="bi bi-headset fs-2 mb-2 icon-support"></i>
          <h5>Dedicated Support & Training</h5>
          <p class="small">Incubation specialist support for 90 days</p>
        </div>
      </div>

      <!-- Marketing Tools -->
      <div class="col-md-4 col-sm-6">
        <div class="benefit-card text-center p-3 rounded shadow-sm">
          <i class="bi bi-megaphone fs-2 mb-2 icon-marketing"></i>
          <h5>Marketing Tools</h5>
          <p class="small">Create Product Ads to increase visibility</p>
        </div>
      </div>

      <!-- Timely Payments -->
      <div class="col-md-4 col-sm-6">
        <div class="benefit-card text-center p-3 rounded shadow-sm">
          <i class="bi bi-wallet2 fs-2 mb-2 icon-payment"></i>
          <h5>Timely Payments</h5>
          <p class="small">Weekly payment cycles with icons</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Steps to Start Selling -->
<div class="bg-secondary text-center p-4">
  <h3 class="mb-4 text-dark">Steps to Start Selling</h3>
  <div class="container">
    <div class="row text-start">
      <!-- Left Column -->
      <div class="col-md-6 mb-3">
        <p class="text-dark text-justify">
          Sign up now to be a DoraMart Seller! DoraMart offers great opportunities and support for you to dive into the
          market and grow your customer base with ease. As a DoraMart Seller, you will get access to various resources
          to help you drive your business on our platform.
        </p>
      </div>
      <!-- Right Column -->
      <div class="col-md-6 mb-3">
        <p class="text-dark fw-bold">Steps:</p>
        <p class="card-body bg-white fw-semibold mb-2">1. Sign up with a phone number</p>
        <p class="card-body bg-white fw-semibold mb-2">2. Fill in contact email & address details</p>
        <p class="card-body bg-white fw-semibold mb-2">3. Submit ID and Bank Account details</p>
        <p class="card-body bg-white fw-semibold mb-2">4. Upload products and get orders!</p>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Custom CSS -->
<style>
  .benefit-card {
    border: 2px solid transparent;
    transition: all 0.3s ease;
    background: #fed333;
    cursor: pointer;
    height: 150px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 15px;
  }

  .benefit-card i {
    font-size: 2rem;
    transition: all 0.3s ease;
  }

  /* Individual icon colors */
  .icon-commission {
    color: #0d6efd;
  }

  .icon-shipping {
    color: #198754;
  }

  .icon-globe {
    color: #201901ff;
  }

  .icon-support {
    color: #0094b1;
  }

  .icon-marketing {
    color: #dc3545;
  }

  .icon-payment {
    color: #ff03c4;
  }

  .benefit-card:hover {
    border-color: #000;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
    background: #f8f9fa;
  }

  .benefit-card:hover i {
    transform: scale(1.2) rotate(8deg);
  }

  .benefit-card h5 {
    margin: 5px 0;
    font-weight: 600;
  }

  .benefit-card p {
    font-size: 0.8rem;
    color: #6c757d;
  }
</style>

<!-- footer start -->
<?php require "includes/footer.php"; ?>
<!-- footer end -->