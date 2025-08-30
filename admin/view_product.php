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

// Fetch products with category and sub-category names using JOIN
$query = "
    SELECT 
    products.*, 
    categories.name AS category_name, 
    sub_category.name AS sub_category_name
FROM 
    products
LEFT JOIN 
    categories ON products.category_id = categories.id
LEFT JOIN 
    sub_category ON products.sub_category_id = sub_category.id;

";
$result = mysqli_query($con, $query);

// Handle query error
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<main class="p-4">
    <div class="container mt-5">
        <h2 class="mb-4 text-center bg-warning p-1 rounded">Manage Products</h2>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered shadow-sm rounded">
                <thead class="text-center bg-info">
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Product Image</th>
                        <th>Price</th>
                        <th>Old Price</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Sub-Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php
                        $counter = 1;
                        while ($product = mysqli_fetch_assoc($result)): ?>
                            <tr class="text-center align-middle">
                                <td><?php echo $counter++; ?></td>
                                <td><?= htmlspecialchars($product['name']); ?></td>
                                <td>
                                    <?php if (!empty($product['images'])): ?>
                                        <img src="<?= htmlspecialchars($product['images']); ?>" alt="Product Image" width="80"
                                            class="img-thumbnail">
                                    <?php else: ?>
                                        <span class="text-muted">No image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($product['price']); ?></td>
                                <td><?= htmlspecialchars($product['old_price']); ?></td>
                                <td><?= htmlspecialchars($product['description']); ?></td>
                                <td><?= htmlspecialchars($product['category_name'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($product['sub_category_name'] ?? 'N/A'); ?></td>
                                <td>
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        <!-- View Button -->
                                        <a href="view_product.php?id=<?= $product['id']; ?>"
                                            class="btn btn-outline-success btn-sm d-flex align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View Product">
                                            <i class="bi bi-eye me-1"></i> View
                                        </a>
                                        <!-- Edit Button -->
                                        <a href="edit_product.php?id=<?= $product['id']; ?>"
                                            class="btn btn-outline-primary btn-sm d-flex align-items-center"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Product">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>

                                        <!-- Delete Button triggers modal -->
                                        <button class="btn btn-outline-danger btn-sm d-flex align-items-center"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal<?= $product['id']; ?>"
                                            title="Delete Product">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </div>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $product['id']; ?>" tabindex="-1"
                                        aria-labelledby="deleteModalLabel<?= $product['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel<?= $product['id']; ?>">Confirm
                                                        Deletion</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <p class="fs-5">
                                                        Are you sure you want to delete
                                                        <strong><?= htmlspecialchars($product['name']); ?></strong>?
                                                    </p>
                                                    <p class="text-muted small">This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-secondary px-4"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <a href="delete_product.php?del_id=<?= $product['id']; ?>"
                                                        class="btn btn-danger px-4">Yes, Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- Initialize Bootstrap Tooltips -->
<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(tooltipTriggerEl => {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>


<?php require "inc/footer.php"; ?>