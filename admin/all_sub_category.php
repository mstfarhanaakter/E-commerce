<?php
require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php";

// Fetch sub-categories with their category names
$query = "
  SELECT sc.id, sc.name AS sub_name, c.name AS category_name 
  FROM sub_category sc
  JOIN categories c ON sc.category_id = c.id
";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<main class="p-4">
    <div class="container mt-5">
        <h2 class="mb-4 text-center">All Sub-Categories Name</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered shadow-sm rounded">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>Sub-Category Name</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr class="text-center">
                                <td><?php echo htmlspecialchars($row['sub_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">No sub-categories found.</div>
        <?php endif; ?>
    </div>
</main>

<!-- Bootstrap JS and Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

<?php require "inc/footer.php"; ?>