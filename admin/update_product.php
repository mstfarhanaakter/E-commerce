<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $category_id = $_POST['category'];
    $sub_category_id = $_POST['sub_category'];

    // Image upload
    $image_path = '';
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $target_dir = 'products/';
        $image_path = $target_dir . basename($image_name);
        move_uploaded_file($tmp_name, $image_path);
    }

    // Update query
    $update_sql = "UPDATE products SET 
                    name='$name', 
                    price='$price', 
                    description='$description', 
                    category_id='$category_id', 
                    sub_category_id='$sub_category_id'";

    if (!empty($image_path)) {
        $update_sql .= ", images='$image_path'";
    }

    $update_sql .= " WHERE id='$id'";

    $run = mysqli_query($con, $update_sql);

    header("Location: view_products.php"); // redirect after update
}
?>
