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

// Database connection
require "../config/db.php";

// Optional: Start session if not already started (for redirect-based messages)
// session_start();

$statusMessage = "";

// Fetch all categories
$categories_query = "SELECT * FROM categories";
$categories_result = mysqli_query($con, $categories_query);

// Handle form submission
if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'];

    // Prepared statement for safety
    $stmt = mysqli_prepare($con, "INSERT INTO sub_category (name, category_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "si", $name, $category_id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $statusMessage = "<div class='alert alert-success'>Sub-Category added successfully!</div>";
    } else {
        $statusMessage = "<div class='alert alert-danger'>Failed to add Sub-Category. Please try again.</div>";
    }

    mysqli_stmt_close($stmt);
}
?>

<main class="p-4">
    <div class="container mt-5">
        <h2>Insert Sub-Category</h2>

        <!-- Status message -->
        <?php if (!empty($statusMessage))
            echo $statusMessage; ?>

        <!-- Sub-Category Add Form -->
        <form action="sub_category.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Sub-Category Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>

            <!-- Category Dropdown -->
            <div class="mb-3">
                <label for="category_id" class="form-label">Select Category</label>
                <select class="form-control" name="category_id" id="category_id" required>
                    <option value="" disabled selected>Select Category</option>
                    <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Add Sub-Category</button>
        </form>
    </div>
</main>

<?php require "inc/footer.php"; ?>