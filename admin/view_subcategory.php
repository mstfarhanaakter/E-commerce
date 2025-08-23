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
    <h2 class="mb-4 text-center">View Sub-Categories</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered shadow-sm rounded">
          <thead class="thead-dark">
            <tr class="text-center">
              <th>Sub-Category Name</th>
              <th>Category</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr class="text-center">
                <td><?php echo htmlspecialchars($row['sub_name']); ?></td>
                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                <td>
                  <a href="edit_sub_category.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Sub-Category">
                    <i class="fa fa-edit"></i> Edit
                  </a>

                  <!-- Delete Trigger -->
                  <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#deleteModal<?php echo $row['id']; ?>" title="Delete Sub-Category">
                    <i class="fa fa-trash"></i> Delete
                  </a>

                  <!-- Delete Modal -->
                  <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1"
                    aria-labelledby="deleteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalLabel<?php echo $row['id']; ?>">Confirm Deletion</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to delete the sub-category <strong><?php echo htmlspecialchars($row['sub_name']); ?></strong>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <a href="delete_sub_category.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Yes, Delete</a>
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
