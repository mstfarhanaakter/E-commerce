<?php
session_start();

    // Destroy all session data
    session_destroy(); // Destroy the session
    header("Location: indexfile.php");
    exit;

?>