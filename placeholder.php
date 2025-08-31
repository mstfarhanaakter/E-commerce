<?php 
// URL থেকে page parameter নেওয়া
$page = isset($_GET['page']) ? $_GET['page'] : '';

$pages = [
    "1"       => "index1.php",
    "2"        => "index1.php",
    "vendor_index"=> "vendor_index.php",
    "signIn"      => "users/signin.php",
    "signUp"      => "users/signup.php",
    "logout"      => "users/logout.php",
    // "page" => "pages/preview.php",




    
];


?>
