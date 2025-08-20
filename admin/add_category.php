<?php 
require "inc/he.php";  // Include header, sidebar, and navigation files.
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php";

// Initialize a variable for status message
$statusMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = mysqli_real_escape_string($con, $_POST['name']);
    $category_image = $_FILES['image']['name'];
    $category_image_tmp = $_FILES['image']['tmp_name'];
    $upload_dir = 'uploads/';  // Directory to store uploaded images
    $image_path = $upload_dir . basename($category_image);

    // Check if an image is uploaded and move it to the server
    if (move_uploaded_file($category_image_tmp, $image_path)) {
        // Insert the category into the database
        $query = "INSERT INTO categories (name, file_path) VALUES ('$category_name', '$image_path')";
        $result = mysqli_query($con, $query);

        // Check if insertion is successful
        if ($result) {
            $statusMessage = "<div class='alert alert-success'>Category added successfully!</div>";
        } else {
            $statusMessage = "<div class='alert alert-danger'>Failed to add category: " . mysqli_error($con) . "</div>";
        }
    } else {
        $statusMessage = "<div class='alert alert-danger'>Failed to upload image.</div>";
    }
}
?>

<main class="p-4">
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Add New Category</h2>

    <!-- Display status message (success or error) -->
    <?php echo $statusMessage; ?>

    <!-- Category Form -->
    <form action="add_category.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>

      <div class="mb-3">
        <label for="image" class="form-label">Category Image</label>
        <input type="file" class="form-control" id="image" name="image" required>
      </div>

      <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
  </div>
</main>

<?php require "inc/footer.php"; ?>
