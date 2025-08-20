<?php
// Start the session to access session variables
session_start();

// Include necessary files
require "inc/he.php";  
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php"; 

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    // Redirect to the homepage or access denied page if not an admin
    header("Location: access_denied.php");
    exit();
}

// Check if an ID is passed via the URL for editing
if (!isset($_GET['id'])) {
    die("Category ID is required.");
}

// Get the category ID from the URL
$categoryId = $_GET['id'];

// Fetch category details based on the ID
$query = "SELECT * FROM categories WHERE id = '$categoryId'";
$result = mysqli_query($con, $query);

// Check if the category exists
if (mysqli_num_rows($result) == 0) {
    die("Category not found.");
}

$category = mysqli_fetch_assoc($result);

// Handle the form submission for editing the category
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated category data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $filePath = $_POST['file_path']; // You may want to handle file upload or use the existing image

    // Update the category in the database
    $updateQuery = "UPDATE categories SET name = '$name', file_path = '$filePath' WHERE id = '$categoryId'";
    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Category updated successfully.'); window.location.href='view_categories.php';</script>";
    } else {
        echo "<script>alert('Error updating category.');</script>";
    }
}
?>

<main class="p-4">
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Edit Category</h2>
    
    <form method="POST" action="edit_category.php?id=<?php echo $category['id']; ?>" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
      </div>
      
      <div class="mb-3">
        <label for="file_path" class="form-label">Category Image</label>
        <input type="text" class="form-control" id="file_path" name="file_path" value="<?php echo htmlspecialchars($category['file_path']); ?>" required>
        <small class="text-muted">You can update the image URL or upload a new one.</small>
      </div>
      
      <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
  </div>
</main>

<?php require "inc/footer.php"; ?>
