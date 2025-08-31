<?php
session_start();
// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: index1.php"); // Or your login page path
  exit;
}
;
require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php";

$statusMessage = "";

// Fetch all coupons with product names
$query = "
  SELECT c.id, c.cupon_title, c.cupon_code, c.cupon_price, c.max_uses, p.name AS product_name
  FROM coupons c
  LEFT JOIN products p ON c.product_id = p.id
  ORDER BY c.id DESC
";
$result = mysqli_query($con, $query);

if (!$result) {
  die("Query failed: " . mysqli_error($con));
}
?>

<main class="p-2">
  <div class="container mt-3">
    <div class="card shadow-sm">
      <div class="card-header bg-warning text-black text-center">
        <h3 class="mb-0">Manage Coupons</h3>
      </div>
      <div class="card-body">

        <?php if (mysqli_num_rows($result) > 0): ?>
          <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle text-center">
              <thead class="table-warning">
                <tr>
                  <th>#</th>
                  <th>Coupon Title</th>
                  <th>Coupon Code</th>
                  <th>Coupon Price</th>
                  <th>Max Uses</th>
                  <th>Product</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $counter = 1;
                while ($row = mysqli_fetch_assoc($result)):
                  ?>
                  <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo htmlspecialchars($row['cupon_title']); ?></td>
                    <td><?php echo htmlspecialchars($row['cupon_code']); ?></td>
                    <td><?php echo number_format($row['cupon_price'], 2); ?></td>
                    <td><?php echo (int) $row['max_uses']; ?></td>
                    <td><?php echo htmlspecialchars($row['product_name'] ?? 'N/A'); ?></td>
                    <td>
                      <a href="edit_coupon.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success"
                        data-bs-toggle="tooltip" title="Edit Coupon">
                        <i class="bi bi-pencil"></i> Edit
                      </a>
                      <a href="delete_coupon.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
                        data-bs-toggle="tooltip" title="Delete Coupon"
                        onclick="return confirm('Are you sure you want to delete this coupon?');">
                        <i class="bi bi-trash"></i> Delete
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="alert alert-warning text-center">No coupons found.</div>
        <?php endif; ?>

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