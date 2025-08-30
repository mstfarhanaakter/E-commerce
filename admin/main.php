<?php 
session_start();
// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index1.php"); // Or your login page path
    exit;
}
require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";
require "inc/dashboard.php";
require "inc/footer.php";


?>