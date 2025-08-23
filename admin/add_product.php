<?php
session_start();

require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";
require "../config/db.php";

$statusMessage = "";

// Check DB connection
if (!$con) {
    die("<div class='alert alert-danger'>Database connection failed: " . mysqli_connect_error() . "</div>");
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'] ?? 1;
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $description = trim($_POST['description']);
    $category_id = $_POST['category'];
    $sub_category_id = $_POST['sub_category'];

    // Handle image
    $upload_dir = 'products/';
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($image_ext, $allowed_ext) && $image_size <= 2 * 1024 * 1024) {
        $new_image_name = uniqid("img_", true) . '.' . $image_ext;
        $image_path = $upload_dir . $new_image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
            // Insert product using prepared statement
            $stmt = mysqli_prepare($con, "INSERT INTO products (user_id, name, images, price, description, category_id, sub_category_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "issdsii", $user_id, $name, $image_path, $price, $description, $category_id, $sub_category_id);

            if (mysqli_stmt_execute($stmt)) {
                $statusMessage = "<div class='alert alert-success'>Product added successfully!</div>";
            } else {
                $statusMessage = "<div class='alert alert-danger'>Database error: " . htmlspecialchars(mysqli_error($con)) . "</div>";
            }

            mysqli_stmt_close($stmt);
        } else {
            $statusMessage = "<div class='alert alert-danger'>Failed to upload image.</div>";
        }
    } else {
        $statusMessage = "<div class='alert alert-danger'>Invalid image file. Only JPG, PNG, GIF under 2MB are allowed.</div>";
    }
}

// Fetch categories and sub-categories
$categories_result = mysqli_query($con, "SELECT * FROM categories");
$sub_categories_result = mysqli_query($con, "SELECT * FROM sub_category");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="p-4">
        <div class="container mt-5">
            <h2>Insert Product</h2>
            <?= $statusMessage ?>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
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
                    <input type="number" step="0.01" class="form-control" name="price" id="price" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-control" name="category" id="category" required>
                        <option value="" disabled selected>Select Category</option>
                        <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sub_category" class="form-label">Sub-Category</label>
                    <select class="form-control" name="sub_category" id="sub_category" required>
                        <option value="" disabled selected>Select Sub-Category</option>
                        <?php while ($sub_category = mysqli_fetch_assoc($sub_categories_result)): ?>
                            <option value="<?= $sub_category['id'] ?>"><?= htmlspecialchars($sub_category['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php require "inc/footer.php"; ?>
