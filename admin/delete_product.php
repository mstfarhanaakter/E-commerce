<?php
require "../config/db.php";

// Get product ID from URL
$product_id = $_GET['id'];

// Delete product from the database
$delete_query = "DELETE FROM products WHERE id = $product_id";
if (mysqli_query($con, $delete_query)) {
    header("Location: view_product.php"); // Redirect back to the product management page
    exit();
} else {
    echo "Error deleting product: " . mysqli_error($con);
}
?>