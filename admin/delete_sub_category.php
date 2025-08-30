<?php
session_start();
// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index1.php"); // Or your login page path
    exit;
};
require "../config/db.php";

// Get sub-category ID from URL
$sub_category_id = $_GET['id'];

// Delete sub-category from the database
$delete_query = "DELETE FROM sub_category WHERE id = $sub_category_id";
if (mysqli_query($con, $delete_query)) {
    header("Location: view_subcategory.php"); // Redirect back to the sub-category management page
    exit();
} else {
    echo "Error deleting sub-category: " . mysqli_error($con);
}
?>