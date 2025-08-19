<!-- php Heaader, topbar, navbar, banner, feature, category, products start -->
 <?php 
 session_start();

 require "config/db.php";
 require "includes/he.php";
 require "includes/topbar.php";
 require "includes/navbar.php";
 require "includes/banner.php"; 
 require "includes/feature.php";
 require "includes/category.php";
 require "includes/products.php";
 
 
  ?>

<!-- php Heaader, topbar, navbar, banner, feature, category, products end -->



    <!-- Offer Start -->
    <div class="container-fluid pt-5 pb-3">
        <div class="row px-xl-5">
            <div class="col-md-12">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="mw-100" src="assets/img/offer.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 70%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->


   <!-- Vendor Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col">
            <div class="d-flex flex-row flex-nowrap overflow-auto">
                <div class="bg-light p-3 flex-shrink-0 mx-2">
                    <img src="assets/img/vendor-1.jpg" alt="Vendor 1">
                </div>
                <div class="bg-light p-3 flex-shrink-0 mx-2">
                    <img src="assets/img/vendor-2.jpg" alt="Vendor 2">
                </div>
                <div class="bg-light p-3 flex-shrink-0 mx-2">
                    <img src="assets/img/vendor-3.jpg" alt="Vendor 3">
                </div>
                <div class="bg-light p-3 flex-shrink-0 mx-2">
                    <img src="assets/img/vendor-4.jpg" alt="Vendor 4">
                </div>
                <div class="bg-light p-3 flex-shrink-0 mx-2">
                    <img src="assets/img/vendor-5.jpg" alt="Vendor 5">
                </div>
                <div class="bg-light p-3 flex-shrink-0 mx-2">
                    <img src="assets/img/vendor-6.jpg" alt="Vendor 6">
                </div>
                <div class="bg-light p-3 flex-shrink-0 mx-2">
                    <img src="assets/img/vendor-7.jpg" alt="Vendor 7">
                </div>
                <div class="bg-light p-3 flex-shrink-0 mx-2">
                    <img src="assets/img/vendor-8.jpg" alt="Vendor 8">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vendor End -->


    <!-- footer start -->
     <?php require "includes/footer.php"; ?>
    <!-- footer end -->




    