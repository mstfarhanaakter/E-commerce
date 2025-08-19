<?php
session_start();
require "config/db.php"; // Database connection

$msg = "";

// Handle form submission
if (isset($_POST['submit'])) {
    $first_name = mysqli_real_escape_string($con, $_POST['f_name']);
    $last_name  = mysqli_real_escape_string($con, $_POST['l_name']);
    $email      = mysqli_real_escape_string($con, $_POST['email']);
    $password   = $_POST['pass'];
    $repass     = $_POST['repass'];

    // 1. Check if passwords match
    if ($password !== $repass) {
        $msg = "Passwords do not match!";
    } else {
        // 2. Check if email already exists
        $check = "SELECT id FROM users WHERE email='$email'";
        $result = mysqli_query($con, $check);

        if (mysqli_num_rows($result) > 0) {
            $msg = "Email already registered!";
        } else {
            // 3. Hash password
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            // 4. Insert new user
            $query = "INSERT INTO users (first_name, last_name, email, password) 
                      VALUES ('$first_name', '$last_name', '$email', '$hashPassword')";

            if (mysqli_query($con, $query)) {
                // Set session variables
                $user_id = mysqli_insert_id($con);
                $_SESSION['user_id'] = $user_id;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['email'] = $email;

                // Redirect to homepage after signup
                header("Location: indexfile.php");
                exit;
            } else {
                $msg = "Database error: " . mysqli_error($con);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Eye Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f9f9f9;
        }

        .form-container {
            max-width: 500px;
            margin: 50px auto;
            border: 2px solid black;
            border-radius: 50px 5px 50px 5px;
            padding: 30px;
            background-color: white;
        }

        .form-title {
            font-family: "MV Boli", cursive;
            color: #052A75;
        }

        .btn-custom {
            background-color: #C99BF7;
            color: black;
            font-weight: bold;
            font-family: Courier;
            letter-spacing: 2px;
        }

        .btn-custom:hover {
            background-color: #6864F7;
            color: white;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <form action="" method="post" class="bg-white p-5 rounded-4 shadow" style="width: 100%; max-width: 400px;">
        <!-- Logo + Tagline -->
        <div class="d-flex align-items-center justify-content-center mb-4 gap-3">
            <img src="assets/img/chick.png" alt="Chick" width="50">
            <p class="form-title m-0 fw-bold text-secondary">Be bold. Be first. Sign up!</p>
        </div>

        <!-- Display message -->
        <?php if(!empty($msg)): ?>
            <div class="text-center text-danger mb-3"><?php echo $msg; ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <input type="text" class="form-control" name="f_name" placeholder="First Name" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="l_name" placeholder="Last Name" required>
        </div>
        <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Your Email" required>
        </div>

        <!-- Password Field -->
        <div class="mb-3 position-relative">
            <input type="password" class="form-control" name="pass" id="pass" placeholder="Your Password" required>
            <i class="fa-solid fa-eye position-absolute top-50 end-0 translate-middle-y me-3" id="togglePass"></i>
        </div>
        <!-- Confirm Password Field -->
        <div class="mb-3 position-relative">
            <input type="password" class="form-control" name="repass" id="repass" placeholder="Confirm Password" required>
            <i class="fa-solid fa-eye position-absolute top-50 end-0 translate-middle-y me-3" id="toggleRepass"></i>
        </div>

        <p class="text-center small">
            Already with us? <a href="login.php">Sign in to continue.</a>
        </p>

        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-warning fw-bold">SUBMIT</button>
        </div>
    </form>
</div>

<!-- Toggle Password Script -->
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        icon.addEventListener("click", () => {
            const isPassword = input.type === "password";
            input.type = isPassword ? "text" : "password";

            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        });
    }

    togglePassword("pass", "togglePass");
    togglePassword("repass", "toggleRepass");
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
