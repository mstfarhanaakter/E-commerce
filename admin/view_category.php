<?php
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
    <h2 class="mb-4 text-center">View Categories</h2>

    <!-- Display categories in a table -->
    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered shadow-sm rounded">
        <thead class="thead-dark">
          <tr class="text-center">
            <th>Category Image</th>
            <th>Category Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr class="text-center">
              <td>
                <img src="<?php echo $row['file_path']; ?>" alt="Category Image" class="img-fluid rounded"
                  style="max-width: 100px; height: auto;">
              </td>
              <td><?php echo htmlspecialchars($row['name']); ?></td>
              <td>
                <!-- Edit and Delete Actions with Tooltips -->
                <a href="edit_category.php" id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"
                  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category">
                  <i class="fa fa-edit"></i> Edit
                </a>
                <a href="delete_category.php" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                  data-bs-target="#deleteModal<?php echo $row['id']; ?>" data-bs-placement="top" title="Delete Category">
                  <i class="fa fa-trash"></i> Delete
                </a>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1"
                  aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to delete this category?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="delete_category.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Yes, Delete</a>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
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