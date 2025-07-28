<?php 
session_start();
require_once("config/config.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Home</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Our Products</h2>
    <div class="row">
        <?php
        $sql = "SELECT * FROM products";
        $result = mysqli_query($link, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            echo '<img src="assets/images/' . $row['image'] . '" class="card-img-top" height="" style="object-fit: cover;">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $row['name'] . '</h5>';
            echo '<p class="card-text">৳ ' . $row['price'] . '</p>';
            echo '<a href="#" class="btn btn-primary">Add to Cart</a>';
            echo '</div></div></div>';
        }
        ?>
    </div>
</div>

</body>
</html>