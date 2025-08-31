<?php
session_start();
// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index1.php"); // Or your login page path
    exit;
};

require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";
require "../config/db.php";

$statusMessage = "";

// ডাটাবেস কানেকশন চেক
if (!$con) {
    die("<div class='alert alert-danger'>Database connection failed: " . mysqli_connect_error() . "</div>");
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'] ?? 1;
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $old_price = trim($_POST['old_price']);
    $description = trim($_POST['description']);
    $category_id = $_POST['category'];
    $sub_category_id = $_POST['sub_category'];

    // ইমেজ হ্যান্ডলিং
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
            $stmt = $con->prepare("INSERT INTO products (user_id, name, images, price, old_price, description, category_id, sub_category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issddsii", $user_id, $name, $image_path, $price, $old_price, $description, $category_id, $sub_category_id);

            if ($stmt->execute()) {
                $statusMessage = "<div class='alert alert-success'>Product added successfully!</div>";
            } else {
                $statusMessage = "<div class='alert alert-danger'>Database error: " . htmlspecialchars($stmt->error) . "</div>";
            }

            $stmt->close();
        } else {
            $statusMessage = "<div class='alert alert-danger'>Failed to upload image.</div>";
        }
    } else {
        $statusMessage = "<div class='alert alert-danger'>Invalid image file. Only JPG, PNG, GIF under 2MB are allowed.</div>";
    }
}

// ক্যাটেগরি লোড
$categories_result = mysqli_query($con, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <main class="p-2 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-warning text-black">
                            <h4 class="mb-0 text-center">Add New Product</h4>
                        </div>
                        <div class="card-body">
                            <?= $statusMessage ?>

                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post"
                                enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="name" id="name" required />
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Product Image</label>
                                    <input type="file" class="form-control" name="image" id="image" required />
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" step="0.01" class="form-control" name="price" id="price"
                                            required />
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="old_price" class="form-label">Old Price</label>
                                        <input type="number" step="0.01" class="form-control" name="old_price"
                                            id="old_price" required />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="1"
                                        required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-select" name="category" id="category" required>
                                            <option value="" disabled selected>Select Category</option>
                                            <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                                                <option value="<?= $category['id'] ?>">
                                                    <?= htmlspecialchars($category['name']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="sub_category" class="form-label">Sub-Category</label>
                                        <select class="form-select" name="sub_category" id="sub_category" required>
                                            <option value="" disabled selected>Select Sub-Category</option>
                                            <!-- সাবক্যাটেগরি AJAX দিয়ে লোড হবে -->
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center align-middle gap-5">
                                    <button type="submit" name="submit" class="btn btn-warning">Add Product</button>
                                    <button type="reset" name="submit" class="btn btn-danger">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('category').addEventListener('change', function () {
            const categoryId = this.value;
            const subCategorySelect = document.getElementById('sub_category');

            subCategorySelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

            if (categoryId) {
                fetch('get_subcategories.php?category_id=' + categoryId)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="" disabled selected>Select Sub-Category</option>';
                        data.forEach(subcat => {
                            options += `<option value="${subcat.id}">${subcat.name}</option>`;
                        });
                        subCategorySelect.innerHTML = options;
                    })
                    .catch(() => {
                        subCategorySelect.innerHTML = '<option value="" disabled selected>Error loading sub-categories</option>';
                    });
            } else {
                subCategorySelect.innerHTML = '<option value="" disabled selected>Select Sub-Category</option>';
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php require "inc/footer.php"; ?>