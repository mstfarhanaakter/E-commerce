<?php
// ... (all your existing code above remains the same)

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

// Fetch categories (assuming your categories table has a 'status' column)
$query = "SELECT * FROM categories";
$result = mysqli_query($con, $query);

if (!$result) {
  die("Query failed: " . mysqli_error($con));
}
?>

<main class="p-4">
  <div class="container mt-5">
    <h2 class="mb-4 text-center">View Categories</h2>

    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered shadow-sm rounded">
        <thead class="thead-dark">
          <tr class="text-center">
            <th>#</th>
            <th>Category Name</th>
            <th>Status</th> <!-- New Status Column -->
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $counter = 1; // initialize the number
          while ($row = mysqli_fetch_assoc($result)): ?>
            <tr class="text-center">
              <td><?php echo $counter++; ?></td>
              <td><?php echo htmlspecialchars($row['name']); ?></td>

              <!-- Show status -->
              <td>
                <?php
                // Assuming 'status' is stored as 1 or 0 (or 'active'/'not active')
                if (isset($row['status'])) {
                  if ($row['status'] == 1 || strtolower($row['status']) == 'active') {
                    echo '<span class="badge bg-success">Active</span>';
                  } else {
                    echo '<span class="badge bg-danger">Not Active</span>';
                  }
                } else {
                  echo '<span class="badge bg-secondary">Unknown</span>';
                }
                ?>
              </td>

              <td>
                <a href="edit_category.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"
                  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category">
                  <i class="fa fa-edit"></i> Edit
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <?php if (mysqli_num_rows($result) == 0): ?>
      <div class="alert alert-warning text-center mt-4">No categories found.</div>
    <?php endif; ?>
  </div>
</main>