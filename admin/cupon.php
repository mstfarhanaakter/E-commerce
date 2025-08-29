<?php
require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php";

$statusMessage = "";

// Fetch all products for dropdown
$product_query = "SELECT id, name FROM products";
$product_result = mysqli_query($con, $product_query);

// Handle form submission
if (isset($_POST['submit'])) {
    $cupon_title = trim($_POST['cupon_title']);
    $cupon_code = trim($_POST['cupon_code']);
    $cupon_price = trim($_POST['cupon_price']);
    $max_uses = intval($_POST['max_uses']);
    $product_id = intval($_POST['product_id']);

    // Basic validation
    if ($cupon_title === "" || $cupon_code === "" || $cupon_price === "" || $max_uses <= 0 || $product_id <= 0) {
        $statusMessage = "<div class='alert alert-danger'>Please fill all fields correctly.</div>";
    } else {
        // Prepare insert query
        $stmt = mysqli_prepare($con, "INSERT INTO coupons (cupon_title, cupon_code, cupon_price, max_uses, product_id) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssdii", $cupon_title, $cupon_code, $cupon_price, $max_uses, $product_id);

        if (mysqli_stmt_execute($stmt)) {
            $statusMessage = "<div class='alert alert-success'>Coupon added successfully!</div>";
        } else {
            $statusMessage = "<div class='alert alert-danger'>Failed to add coupon. Please try again.</div>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<main class="">
  <div class="container mt-2" style="max-width: 600px;">
    <div class="card shadow-sm">
      <div class="card-header bg-warning text-black text-center">
        <h3 class="mb-0">Add New Coupon</h3>
      </div>
      <div class="card-body">
        <?php if (!empty($statusMessage)) echo $statusMessage; ?>

        <form method="post" action="">
          <div class="mb-3">
            <label for="cupon_title" class="form-label">Coupon Title</label>
            <input type="text" class="form-control" name="cupon_title" id="cupon_title" required>
          </div>

          <div class="mb-3">
            <label for="cupon_code" class="form-label">Coupon Code</label>
            <input type="text" class="form-control" name="cupon_code" id="cupon_code" required>
          </div>

          <div class="mb-3">
            <label for="cupon_price" class="form-label">Coupon Price</label>
            <input type="number" step="0.01" class="form-control" name="cupon_price" id="cupon_price" required>
          </div>

          <div class="mb-3">
            <label for="max_uses" class="form-label">Max Uses</label>
            <input type="number" class="form-control" name="max_uses" id="max_uses" min="1" required>
          </div>

          <div class="mb-3">
            <label for="product_id" class="form-label">Select Product</label>
            <select class="form-select" name="product_id" id="product_id" required>
              <option value="" disabled selected>Select a product</option>
              <?php while ($product = mysqli_fetch_assoc($product_result)): ?>
                <option value="<?php echo htmlspecialchars($product['id']); ?>">
                  <?php echo htmlspecialchars($product['name']); ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>

          <button type="submit" name="submit" class="btn btn-warning w-100">Add Coupon</button>
        </form>
      </div>
    </div>
  </div>
</main>


<!-- Bootstrap JS and Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

<?php require "inc/footer.php"; ?>
