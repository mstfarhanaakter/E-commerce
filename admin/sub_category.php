<?php
require "inc/he.php"; // Include header, sidebar, and navigation files.
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php";

$msg = "";

// Fetch all categories to display in the dropdown
$categories_query = "SELECT * FROM categories";
$categories_result = mysqli_query($con, $categories_query);

// Handle form submission
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $category_id = $_POST['category_id'];  // Get the selected category ID

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
                    // Insert sub-category into the database
                    $query = "INSERT INTO sub_categories (name, category_id, file_path) 
                              VALUES ('$name', '$category_id', '$file_path')";

                    if (mysqli_query($con, $query)) {
                        $msg = "Sub-category added successfully!";
                        // Redirect to avoid resubmission on refresh
                        header("Location: add_sub_category.php");
                        exit();
                    } else {
                        $msg = "Error adding sub-category: " . mysqli_error($con);
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
        <title>Add Sub-Category</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container mt-5">
            <h2>Add Sub-Category</h2>

            <!-- Display message if any -->
            <?php if (!empty($msg)): ?>
                <div class="alert alert-info"><?php echo $msg; ?></div>
            <?php endif; ?>

            <!-- Sub-Category Add Form -->
            <form action="add_sub_category.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Sub-Category Name</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>

                <!-- Category Dropdown -->
                <div class="mb-3">
                    <label for="category_id" class="form-label">Select Category</label>
                    <select class="form-control" name="category_id" id="category_id" required>
                        <option value="" disabled selected>Select Category</option>
                        <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="file_path" class="form-label">Sub-Category Image</label>
                    <input type="file" class="form-control" name="file_path" id="file_path" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Add Sub-Category</button>
            </form>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</main>

<?php require "inc/footer.php"; ?>