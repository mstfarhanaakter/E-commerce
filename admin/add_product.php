<?php
require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";
?>

<!-- Dashboard Part Starts Here -->

<main class="p-4">
    <!-- <h1>This is my admin Panel</h1> -->


    <!-- dashboard ends here  -->
    <?php
    // session_start();
    require "../config/db.php"; // Ensure $con variable exists
    
    $msg = "";

    // Fetch categories for the dropdown
    $categories_query = "SELECT * FROM categories";
    $categories_result = mysqli_query($con, $categories_query);

    // Handle form submission
    if (isset($_POST['submit'])) {
        $user_id = $_SESSION['user_id'];  // Assuming user is logged in
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $product_image = $_FILES['image']['name'];
        $product_image_tmp = $_FILES['image']['tmp_name'];
        $upload_dir = 'products/'; //Directory to store uploaded images
        $image_path = $upload_dir . basename($product_image);
        $price = mysqli_real_escape_string($con, $_POST['price']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $category_id = $_POST['category'];
        $sub_category_id = $_POST['sub_category'];

        // Insert product into database
        $query = "INSERT INTO products (user_id, name,images, price, description, category_id, sub_category_id) 
              VALUES ('$user_id', '$name', '$image', '$price', '$description', '$category_id', '$sub_category_id')";

        if (mysqli_query($con, $query)) {
            $msg = "Product added successfully!";
        } else {
            $msg = "Database error: " . mysqli_error($con);
        }

        // check if an image is uploaded and move it to the server
        if (move_uploaded_file($product_image_tmp, $image_path)) {
            //Insert the category into the database
            $query = "INSERT INTO products (name, images) VALUES ('$name', '$image_path')";
            $result = mysqli_query($con, $query);

            //Check if insertation is successful
    
            if ($result) {
                $statusMessage = "<div class='alert alert-success'>Product added successfully!</div>";
            } else {
                $statusMessage = "<div class='alert alert-danger'>Failed to add products: </div>";
            }

        } else {
            $statusMessage = "<div class='alert alert-danger'>Failed to upload image</div>";
        }
    }

    // Fetch sub-categories based on the selected category
    $sub_categories_query = "SELECT * FROM sub_category WHERE category_id = " . (isset($_POST['category']) ? $_POST['category'] : 0);
    $sub_categories_result = mysqli_query($con, $sub_categories_query);
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Add Product</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container mt-5">
            <h2>Add Product</h2>

            <?php if (!empty($msg)): ?>
                <div class="alert alert-info"><?php echo $msg; ?></div>
            <?php endif; ?>

            <form action="add_product.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" class="form-control" name="image" id="image" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" class="form-control" name="price" id="price" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
                </div>

                <!-- Category Dropdown -->
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-control" name="category" id="category" required onchange="this.form.submit()">
                        <option value="" disabled selected>Select Category</option>
                        <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Sub-Category Dropdown -->
                <div class="mb-3">
                    <label for="sub_category" class="form-label">Sub-Category</label>
                    <select class="form-control" name="sub_category" id="sub_category" required>
                        <option value="" disabled selected>Select Sub-Category</option>
                        <?php while ($sub_category = mysqli_fetch_assoc($sub_categories_result)): ?>
                            <option value="<?php echo $sub_category['id']; ?>"><?php echo $sub_category['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>


</main>

<?php
require "inc/footer.php";
?>