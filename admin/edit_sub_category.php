<?php
session_start();
require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php";

// Check admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: access_denied.php");
    exit();
}

// Check if 'id' is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Sub-category ID is required.");
}

$subCatId = intval($_GET['id']);

// Fetch sub-category data
$query = "SELECT * FROM sub_category WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $subCatId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Sub-category not found.");
}

$subCategory = mysqli_fetch_assoc($result);

// Fetch all categories for dropdown
$categoriesQuery = "SELECT id, name FROM categories ORDER BY name";
$categoriesResult = mysqli_query($con, $categoriesQuery);
if (!$categoriesResult) {
    die("Could not fetch categories: " . mysqli_error($con));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category_id = intval($_POST['category_id']);

    if (empty($name)) {
        $error = "Sub-category name cannot be empty.";
    } elseif ($category_id <= 0) {
        $error = "Please select a valid category.";
    } else {
        // Update query
        $updateQuery = "UPDATE sub_category SET name = ?, category_id = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "sii", $name, $category_id, $subCatId);

        if (mysqli_stmt_execute($updateStmt)) {
            echo "<script>alert('Sub-category updated successfully.'); window.location.href='view_subcategory.php';</script>";
            exit();
        } else {
            $error = "Error updating sub-category: " . mysqli_error($con);
        }
    }
}
?>

<main class="p-4">
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Edit Sub-Category</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Sub-Category Name</label>
                <input type="text" name="name" id="name" class="form-control" required
                    value="<?php echo htmlspecialchars($subCategory['name']); ?>">
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    <?php while ($cat = mysqli_fetch_assoc($categoriesResult)): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if ($cat['id'] == $subCategory['category_id'])
                               echo 'selected'; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Sub-Category</button>
            <a href="view_subcategory.php" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</main>

<!-- Bootstrap JS (for tooltips or other components if needed) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require "inc/footer.php"; ?>