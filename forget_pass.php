<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
     .form-title {
            font-family: "MV Boli", cursive;
            color: #052A75;
            font-size:20px;
        }
</style>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <form action="" method="post" class="bg-white p-5 rounded-4 shadow" style="width: 100%; max-width: 400px;">
        <!-- Header -->
        <div class="text-center mb-4">
            <img src="assets/img/sad.png" alt="Logo" width="60">
            <h4 class="form-title text-center text-secondary fw-bold mb-3">Lost your password?</h4>
            <p class="medium"> No worries, reset it here.</p>
        </div>

        <!-- Alert -->
        <?php if (isset($msg)) echo "<div class='alert alert-info text-center'>$msg</div>"; ?>

        <!-- Email Input -->
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
        </div>

        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-warning fw-bold">Send Reset Link</button>
        </div>

        <div class="text-center mt-3">
            <a href="login.php" class="text-decoration-none">Back to Login</a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $users = file("auth.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $found = false;

    foreach ($users as $user) {
        $parts = explode("|", $user);
        if (count($parts) >= 3 && trim($parts[2]) === $email) {
            $found = true;
            break;
        }
    }

    // This message is intentionally vague for security
    $msg = "If the email is registered, a password reset link has been sent.";
}
?>
