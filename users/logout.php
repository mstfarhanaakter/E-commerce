<?php
session_start();

// যদি তুমি নাম দেখাতে চাও, session থেকে নাও
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Guest';

// Destroy all session data
session_unset();
session_destroy(); // Destroy the session

echo "<script>
    alert('You are redirected to the home page " . htmlspecialchars($first_name) . "!');
    window.location.href = '../index1.php';
</script>";
exit;
?>
