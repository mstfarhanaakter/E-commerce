<?php
session_start();
// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index1.php"); // Or your login page path
    exit;
};
require "inc/he.php"; // Include header, sidebar, and navigation files.
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php";

$msg = "";

// Validate and cast product_id
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($product_id <= 0) {
    die("Invalid product ID.");
}

// Fetch product details safely
$stmt = $con->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Get and sanitize inputs
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $old_price = $_POST['old_price'];
    $description = trim($_POST['description']);
    $category_id = (int)$_POST['category'];

    // Handle image upload
    $images = $product['images']; // Default to existing image
    if (!empty($_FILES['images']['name'])) {
        $target_dir = "products/";
        $target_file = $target_dir . basename($_FILES["images"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["images"]["tmp_name"]);

        if ($check !== false) {
            if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
                $images = $target_file;
            } else {
                $msg = "Error uploading image.";
            }
        } else {
            $msg = "File is not a valid image.";
        }
    }

    // Basic validation
    if (empty($name) || empty($images) || !is_numeric($price) || !is_numeric($old_price) || empty($description) || $category_id <= 0) {
        $msg = "Please fill in all fields correctly.";
    } else {
        // Update product with prepared statement
        $update_stmt = $con->prepare("UPDATE products SET name = ?, images = ?, price = ?, old_price = ?, description = ?, category_id = ? WHERE id = ?");
        $update_stmt->bind_param("ssddsii", $name, $images, $price, $old_price, $description, $category_id, $product_id);

        if ($update_stmt->execute()) {
            $msg = "Product updated successfully!";
            // Refresh product data
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();
        } else {
            $msg = "Error updating product: " . $con->error;
        }
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
            <div class="alert alert-info"><?php echo htmlspecialchars($msg); ?></div>
        <?php endif; ?>

        <!-- Edit Product Form -->
        <form action="edit_product.php?id=<?php echo htmlspecialchars($product['id']); ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Product Image</label>
                <input type="file" class="form-control" name="images" id="images" accept="image/*">
                <?php if (!empty($product['images'])): ?>
                    <div class="mt-2">
                        <p>Current Image:</p>
                        <img src="<?php echo htmlspecialchars($product['images']); ?>" alt="Product Image" style="max-height: 120px;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="old_price" class="form-label">Old Price</label>
                <input type="text" class="form-control" name="old_price" id="old_price" value="<?php echo htmlspecialchars($product['old_price']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" name="category" id="category" required>
                    <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                        <option value="<?php echo $category['id']; ?>" 
                        <?php if ($category['id'] == $product['category_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</main>

<?php require "inc/footer.php"; ?>
