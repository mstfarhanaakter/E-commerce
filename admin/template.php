<?php 

session_start();
// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index1.php"); // Or your login page path
    exit;
};
require "../config/db.php";
require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";
?>

 <!-- Dashboard Part Starts Here -->
      
<main class="p-4">
  <h1>This is my admin Panel</h1>
</main>

 <!-- dashboard ends here  -->




<?php 
require "inc/footer.php";
?>