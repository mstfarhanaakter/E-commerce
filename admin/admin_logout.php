<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: ./index1.php"); // Change to your login page if different
exit;
?>
