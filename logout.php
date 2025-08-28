<?php
session_start();

if (!isset($_SESSION['user_id'])) {


    // Destroy all session data
    session_destroy(); // Destroy the session
    header("Location: hello.php");
    exit;
}

?>