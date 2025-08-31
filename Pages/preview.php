<?php
session_start();
require "../config/db.php";

// for login session 

$is_logged_in = isset($_SESSION['user_id']);
require "../includes/he.php";
if($is_logged_in){
    require "../includes/topbar_logged.php";  // for login users
    require "../includes/navbar_logged.php";
} else {
    require "../includes/topbar.php";        // for non-login users
    require "../includes/navbar.php";
};

require "../placeholder.php";
require "../includes/feature.php";





// Get product id from URL safely
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product info from database
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($con, $query);
$product = mysqli_fetch_assoc($result);



// Explode multiple images (comma-separated)
$images = explode(',', $product['images']);
?>

<?php
// Include header & navbar

// require "../includes/topbar.php";
// require "../includes/navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']); ?> | Product Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    
<!-- Shop Detail Start -->
<div class="container-fluid pt-3">
    <div class="row px-xl-5">
        <!-- Product Images -->
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner bg-light">
                    <?php foreach ($images as $index => $img): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img class="w-100 h-100" src="../admin/<?= htmlspecialchars(trim($img)); ?>" alt="Product Image <?= $index+1 ?>" style="width: 400px; height: 400px; object-fit: cover;" >
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Carousel controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#product-carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#product-carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-7 h-auto">
            <div class="h-100 bg-light p-30 ">
                <div class="ms-5 p-2">
                <h3><?= htmlspecialchars($product['name']); ?></h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">(<?= rand(50,200) ?> Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4">৳<?= number_format($product['price'], 2); ?></h3>
                <p class="mb-4"><?= htmlspecialchars($product['description']); ?></p>

                <!-- Sizes -->
                <div class="d-flex mb-3">
                    <strong class="text-dark mr-3">Sizes:</strong>
                    <form>
                        <?php foreach (['XS','S','M','L','XL'] as $size): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="size" id="size-<?= $size ?>" value="<?= $size ?>">
                            <label class="form-check-label" for="size-<?= $size ?>"><?= $size ?></label>
                        </div>
                        <?php endforeach; ?>
                    </form>
                </div>

                <!-- Colors -->
                <div class="d-flex mb-4">
                    <strong class="text-dark mr-3">Colors:</strong>
                    <form>
                        <?php foreach (['Black','White','Red','Blue','Green'] as $color): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="color" id="color-<?= $color ?>" value="<?= $color ?>">
                            <label class="form-check-label" for="color-<?= $color ?>"><?= $color ?></label>
                        </div>
                        <?php endforeach; ?>
                    </form>
                </div>

                <!-- Quantity + Add to Cart -->
                <div class="d-flex align-items-center mb-4 pt-2">
                    <input type="number" class="form-control w-25 me-2" value="1" min="1">
                    <a href="cart.php?add=<?= $product['id'] ?>" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</a>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->

<?php require "../includes/footer.php"; ?>
    <script src="../assets/js/main.js"></script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
