<?php
require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php";

// Fetch products with category and sub-category names using JOIN
$query = "
    SELECT 
        p.*, 
        c.name AS category_name, 
        s.name AS sub_category_name 
    FROM 
        products p
    LEFT JOIN 
        categories c ON p.category_id = c.id
    LEFT JOIN 
        sub_category s ON p.sub_category_id = s.id
";
$result = mysqli_query($con, $query);

// Handle query error
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<main class="p-4">
    <div class="container mt-5">
        <h2 class="mb-4 text-center">View Products</h2>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered shadow-sm rounded">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Product Name</th>
                        <th>Product Image</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Sub-Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($product = mysqli_fetch_assoc($result)): ?>
                            <tr class="text-center">
                                <td><?= htmlspecialchars($product['name']); ?></td>
                                <td>
                                    <?php if (!empty($product['images'])): ?>
                                        <img src="<?= htmlspecialchars($product['images']); ?>" alt="Product Image" width="80">
                                    <?php else: ?>
                                        No image
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($product['price']); ?></td>
                                <td><?= htmlspecialchars($product['description']); ?></td>
                                <td><?= htmlspecialchars($product['category_name'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($product['sub_category_name'] ?? 'N/A'); ?></td>
                                <td>
                                    <!-- Edit Button -->
                                    <a href="edit_product.php?id=<?= $product['id']; ?>" 
                                       class="btn btn-primary btn-sm" 
                                       data-bs-toggle="tooltip" 
                                       data-bs-placement="top" 
                                       title="Edit Product">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>

                                    <!-- Delete Button triggers modal -->
                                    <button class="btn btn-danger btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal<?= $product['id']; ?>" 
                                            title="Delete Product">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal<?= $product['id']; ?>" tabindex="-1"
                                         aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this product?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="delete_product.php?id=<?= $product['id']; ?>" class="btn btn-danger">Yes, Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

<?php require "inc/footer.php"; ?>
