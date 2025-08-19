<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> 
    .form-title {
            font-family: "MV Boli", cursive;
            color: #052A75;
        }
        </style>
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <form action="" method="post" class="bg-white p-5 rounded-4 shadow" style="width: 100%; max-width: 400px;">
        <!-- Logo and Image Side by Side -->
        <div class="d-flex align-items-center justify-content-center mb-3">
            <img src="media/user.png" alt="" width="50" class="me-2">
            <div class="text-center">
                <a href="" class="text-decoration-none">
                    <span class="h4 text-uppercase text-dark bg-warning px-2">Admin</span>
                    <span class="h4 text-uppercase text-warning bg-secondary px-2 ">Panel</span>
                </a>
            </div>
        </div>

        <!-- Welcome Message -->
        <p class="form-title text-center text-secondary fw-bold mb-3">
            Welcome back! Please log in.
           
            <?php echo isset($msg) ? "<span class='text-danger'>" . $msg . "</span>" : ""; ?>
        </p>

        <!-- Input Fields -->
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Your Username" name="user" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" placeholder="Your Password" name="pass" required>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-warning fw-bold">Log In</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>


<?php
session_start();

if (isset($_POST["submit"])) {
    $username = trim($_POST["user"]);
    $password = $_POST["pass"];

    $users = file("auth.txt", FILE_IGNORE_NEW_LINES);

    foreach ($users as $user) {
        $parts = explode("|", $user);
        if (count($parts) < 2) continue;

        $stored_user = trim($parts[0]);
        $stored_password = trim($parts[1]);

        if ($username === $stored_user && password_verify($password, $stored_password)) {
            $_SESSION["username"] = $stored_user;
            header("Location: index.php");
            exit;
        }
    }

    $msg = "Invalid username or password!";
}
?>
