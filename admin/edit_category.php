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
require "../config/db.php";

// Check admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
  header("Location: access_denied.php");
  exit();
}

// Check for category id
if (!isset($_GET['id']) && !isset($_POST['id'])) {
  die("Category ID is required.");
}

// Initialize variables
$categoryId = isset($_GET['id']) ? (int) $_GET['id'] : (int) $_POST['id'];
$error = '';
$name = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);

  if (empty($name)) {
    $error = "Category name cannot be empty.";
  } else {
    // Prepare update query
    $stmt = $con->prepare("UPDATE categories SET name = ? WHERE id = ?");
    if (!$stmt) {
      die("Prepare failed: " . $con->error);
    }
    $stmt->bind_param("si", $name, $categoryId);

    if ($stmt->execute()) {
      $stmt->close();
      echo "<script>alert('Category updated successfully.'); window.location.href='view_category.php';</script>";
      exit();
    } else {
      $error = "Error updating category: " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
  }
} else {
  // Fetch category data for the form
  $stmt = $con->prepare("SELECT name FROM categories WHERE id = ?");
  if (!$stmt) {
    die("Prepare failed: " . $con->error);
  }
  $stmt->bind_param("i", $categoryId);
  $stmt->execute();
  $stmt->bind_result($name);
  if (!$stmt->fetch()) {
    die("Category not found.");
  }
  $stmt->close();
}
?>

<main class="p-4">
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Edit Category</h2>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="edit_category.php">
      <input type="hidden" name="id" value="<?php echo $categoryId; ?>">
      <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" name="name" id="name" class="form-control" required
          value="<?php echo htmlspecialchars($name); ?>">
      </div>
      <button type="submit" class="btn btn-primary">Update Category</button>
      <a href="view_category.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
  </div>
</main>

<?php require "inc/footer.php"; ?>