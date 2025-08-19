<?php
require "../config/db.php"; // Your database connection

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $product_id = $_POST['product_id'];
    $image = $_FILES['image']['name'];
    $tmp_image = $_FILES['image']['tmp_name'];

    // Move uploaded image to assets folder
    move_uploaded_file($tmp_image, "assets/img/$image");

    // Insert category
    $sql = "INSERT INTO categories (name, image, product_id) VALUES ('$name', 'assets/img/$image', '$product_id')";
    mysqli_query($con, $sql);

    echo "<script>alert('Category added successfully!');</script>";
};
require "template.php";
?>

 <!-- Dashboard Part Starts Here -->
      
<main class="p-4">
   <!-- dashboard ends here  -->
<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Category Name" required>
    <input type="number" name="product_id" placeholder="Product Count" required>
    <input type="file" name="image" required>
    <button type="submit" name="submit">Add Category</button>
</form>
</main>


