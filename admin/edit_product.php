<?php
require "inc/he.php"; // Include header, sidebar, and navigation files.
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php"; 

// Fetch product details
$product_id = $_GET['id']; // Get the product ID from the URL
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($con, $query);
$product = mysqli_fetch_assoc($result);

$msg = "";

// Handle form submission
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $category_id = $_POST['category'];

    // Update product in the database
    $update_query = "UPDATE products SET name = '$name', price = '$price', description = '$description', category_id = '$category_id' WHERE id = $product_id";

    if (mysqli_query($con, $update_query)) {
        $msg = "Product updated successfully!";
    } else {
        $msg = "Error updating product: " . mysqli_error($con);
    }
}

// Fetch categories for dropdown
$categories_query = "SELECT * FROM categories";
$categories_result = mysqli_query($con, $categories_query);
?>

<main class="p-4">
    <div class="container mt-5">
        <h2>Edit Product</h2>

        <!-- Display message if any -->
        <?php if (!empty($msg)): ?>
            <div class="alert alert-info"><?php echo $msg; ?></div>
        <?php endif; ?>

        <!-- Edit Product Form -->
        <form action="edit_product.php?id=<?php echo $product['id']; ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo $product['name']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" name="price" id="price" value="<?php echo $product['price']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="4" required><?php echo $product['description']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" name="category" id="category" required>
                    <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                        <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $product['category_id']) echo 'selected'; ?>>
                            <?php echo $category['name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</main>

<?php require "inc/footer.php"; ?>
