<?php 
require "inc/he.php"; // Include header, sidebar, and navigation files.
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php"; 

$msg = "";

// Handle form submission
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    
    // Handle the image upload
    if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] === 0) {
        $file_name = $_FILES['file_path']['name'];
        $file_tmp = $_FILES['file_path']['tmp_name'];
        $file_size = $_FILES['file_path']['size'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        // Validate file extension (only allow images)
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($file_ext), $allowed_ext)) {
            
            // Validate file size (5MB limit)
            if ($file_size <= 5 * 1024 * 1024) { // 5MB limit
                // Create a unique name for the file
                $new_file_name = uniqid('', true) . '.' . $file_ext;
                $upload_dir = 'uploads/images/'; // Path to save the uploaded images

                // Check if directory exists, if not, create it
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $file_path = $upload_dir . $new_file_name;

                // Move the uploaded file to the desired directory
                if (move_uploaded_file($file_tmp, $file_path)) {
                    // Insert category into the database
                    $query = "INSERT INTO categories (name, file_path) VALUES ('$name', '$file_path')";

                    if (mysqli_query($con, $query)) {
                        $msg = "Category added successfully!";
                        // Redirect to avoid resubmission on refresh
                        header("Location: add_category.php");
                        exit();
                    } else {
                        $msg = "Error adding category: " . mysqli_error($con);
                    }
                } else {
                    $msg = "Error uploading file.";
                }
            } else {
                $msg = "File size exceeds the 5MB limit.";
            }
        } else {
            $msg = "Invalid file type. Only JPG, JPEG, PNG, GIF are allowed.";
        }
    } else {
        $msg = "Please upload an image.";
    }
}
?>

<main class="p-4">
  <!-- <h1>This is my admin Panel</h1> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add Category</h2>
    
    <!-- Display message if any -->
    <?php if (!empty($msg)): ?>
        <div class="alert alert-info"><?php echo $msg; ?></div>
    <?php endif; ?>

    <!-- Category Add Form -->
    <form action="add_category.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="mb-3">
            <label for="file_path" class="form-label">Category Image</label>
            <input type="file" class="form-control" name="file_path" id="file_path" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add Category</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</main>

<?php require "inc/footer.php"; ?>
