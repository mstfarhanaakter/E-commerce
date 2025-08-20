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

// Check if an ID is passed via the URL for deletion
if (!isset($_GET['id'])) {
    die("Category ID is required.");
}

// Get the category ID from the URL
$categoryId = $_GET['id'];

// Delete the category from the database
$deleteQuery = "DELETE FROM categories WHERE id = '$categoryId'";

if (mysqli_query($con, $deleteQuery)) {
    echo "<script>alert('Category deleted successfully.'); window.location.href='view_categories.php';</script>";
} else {
    echo "<script>alert('Error deleting category.');</script>";
}

require "inc/footer.php"; ?>
