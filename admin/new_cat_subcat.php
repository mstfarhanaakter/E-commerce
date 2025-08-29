<?php
require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";
require "../config/db.php";

// Status messages
$categoryStatus = "";
$subCategoryStatus = "";

// CATEGORY FORM SUBMISSION
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_category'])) {
    $category_name = mysqli_real_escape_string($con, $_POST['name']);
    $query = "INSERT INTO categories(name) VALUES ('$category_name')";
    $result = mysqli_query($con, $query);

    $categoryStatus = $result 
        ? "<div class='alert alert-success'>Category added successfully!</div>"
        : "<div class='alert alert-danger'>Failed to add category: " . mysqli_error($con) . "</div>";
}

// SUB-CATEGORY FORM SUBMISSION
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_subcategory'])) {
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'];

    $stmt = mysqli_prepare($con, "INSERT INTO sub_category (name, category_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "si", $name, $category_id);
    $result = mysqli_stmt_execute($stmt);

    $subCategoryStatus = $result
        ? "<div class='alert alert-success'>Sub-Category added successfully!</div>"
        : "<div class='alert alert-danger'>Failed to add Sub-Category. Please try again.</div>";

    mysqli_stmt_close($stmt);
}

// Fetch all categories for sub-category dropdown
$categories_query = "SELECT * FROM categories";
$categories_result = mysqli_query($con, $categories_query);
?>

<main class="p-4">
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Manage Categories</h2>

    <div class="row">
      <!-- Add Category Form -->
      <div class="col-md-6">
        <div class="card shadow-sm mb-4">
          <div class="card-body">
            <h5 class="card-title mb-3">Insert New Category</h5>
            <?php echo $categoryStatus; ?>
            <form action="" method="POST">
              <div class="mb-3">
                <label for="categoryName" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="categoryName" name="name" required>
              </div>
              <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Add Sub-Category Form -->
      <div class="col-md-6">
        <div class="card shadow-sm mb-4">
          <div class="card-body">
            <h5 class="card-title mb-3">Insert Sub-Category</h5>
            <?php echo $subCategoryStatus; ?>
            <form action="" method="POST">
              <div class="mb-3">
                <label for="subCategoryName" class="form-label">Sub-Category Name</label>
                <input type="text" class="form-control" name="name" id="subCategoryName" required>
              </div>

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

              <button type="submit" name="add_subcategory" class="btn btn-primary">Add Sub-Category</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php require "inc/footer.php"; ?>
