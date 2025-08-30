<?php
session_start();
// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index1.php"); // Or your login page path
    exit;
};
require "inc/he.php";  // Include header, sidebar, and navigation files.
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php";

// Fetch categories from the database
$query = "SELECT * FROM categories";
$result = mysqli_query($con, $query);

// Handle any error if database query fails
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<main class="p-4">
    <div class="container mt-5">
        <h2 class="mb-4 text-center">All Categories</h2>

        <!-- Display categories in a table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered shadow-sm rounded">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Category Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="text-center">
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- If there are no categories -->
        <?php if (mysqli_num_rows($result) == 0): ?>
            <div class="alert alert-warning text-center">No categories found.</div>
        <?php endif; ?>
    </div>
</main>

<!-- Bootstrap JS and Icons for Tooltips -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script>
    // Initialize tooltips for all elements
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

<?php require "inc/footer.php"; ?>