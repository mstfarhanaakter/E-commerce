<?php
require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php";

$statusMessage = "";
$categoryStatus = "";

// Fetch all categories for dropdown
$categories_query = "SELECT * FROM categories";
$categories_result = mysqli_query($con, $categories_query);

// Handle Sub-Category Form submission
if (isset($_POST['submit_sub_category'])) {
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'];

    $stmt = mysqli_prepare($con, "INSERT INTO sub_category (name, category_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "si", $name, $category_id);
    $result = mysqli_stmt_execute($stmt);

    $statusMessage = $result
        ? "<div class='alert alert-success'>Sub-Category added successfully!</div>"
        : "<div class='alert alert-danger'>Failed to add Sub-Category.</div>";

    mysqli_stmt_close($stmt);
}

// Handle Category Form submission
if (isset($_POST['submit_category'])) {
    $cat_name = trim($_POST['cat_name']);

    $stmt = mysqli_prepare($con, "INSERT INTO categories (name) VALUES (?)");
    mysqli_stmt_bind_param($stmt, "s", $cat_name);
    $result = mysqli_stmt_execute($stmt);

    $categoryStatus = $result
        ? "<div class='alert alert-success'>Category added successfully!</div>"
        : "<div class='alert alert-danger'>Failed to add Category.</div>";

    mysqli_stmt_close($stmt);
}
?>

<main class="p-4">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm mx-auto" style="max-width: 600px;">
                    <!-- Card Header -->
                    <div class="card-header bg-warning text-black text-center">
                        <h4 class="mb-0 fw-bold">Add New Sub-Category</h4>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <?php if (!empty($statusMessage)) echo $statusMessage; ?>

                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Sub-Category Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter sub-category" required>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label fw-semibold">Select Category</label>
                                <select class="form-select" name="category_id" id="category_id" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <button type="submit" name="submit_sub_category" class="btn btn-warning w-100 mt-3">
                                <i class="bi bi-plus-circle me-1"></i> Add Sub-Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


            

<!-- Bootstrap JS and Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

<?php require "inc/footer.php"; ?>
