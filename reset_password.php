<?php
session_start();
require "config/db.php";

$msg = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $query = "SELECT id, token_expire FROM users WHERE reset_token='$token' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (strtotime($row['token_expire']) < time()) {
            $msg = "Token expired. Please request a new password reset.";
            $token = ""; // disable form
        }
    } else {
        $msg = "Invalid token.";
        $token = ""; // disable form
    }
}

if (isset($_POST['reset'])) {
    $token = $_POST['token'];
    $password = $_POST['pass'];
    $repass   = $_POST['repass'];

    if ($password !== $repass) {
        $msg = "Passwords do not match!";
    } else {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $update = "UPDATE users SET password='$hashPassword', reset_token=NULL, token_expire=NULL WHERE reset_token='$token'";
        mysqli_query($conn, $update);

        $msg = "Password has been reset successfully! <a href='login.php'>Login Now</a>";
        $token = ""; // hide form
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .form-title {
        font-family: "MV Boli", cursive;
        color: #052A75;
        font-size: 20px;
    }
</style>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <form method="POST" class="bg-white p-5 rounded-4 shadow" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <img src="assets/img/sad.png" alt="Logo" width="60">
            <h4 class="form-title fw-bold mb-3">Reset Your Password</h4>
            <p class="medium">Enter your new password below.</p>
        </div>

        <!-- Alert -->
        <?php if (!empty($msg)) echo "<div class='alert alert-info text-center'>$msg</div>"; ?>

        <?php if (!empty($token)) { ?>
        <!-- Password Inputs -->
        <div class="mb-3">
            <input type="password" name="pass" class="form-control" placeholder="New Password" required>
        </div>
        <div class="mb-3">
            <input type="password" name="repass" class="form-control" placeholder="Confirm New Password" required>
        </div>
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

        <div class="d-grid">
            <button type="submit" name="reset" class="btn btn-warning fw-bold">Reset Password</button>
        </div>
        <?php } ?>

        <div class="text-center mt-3">
            <a href="login.php" class="text-decoration-none">Back to Login</a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
