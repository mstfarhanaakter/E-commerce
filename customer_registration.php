<?php
session_start();
require "config/db.php"; // ডেটাবেস কানেকশন

$msg = "";

if (isset($_POST['submit'])) {
    // ইনপুট নিন ও ট্রিম করুন
    $first_name = trim($_POST['f_name']);
    $last_name  = trim($_POST['l_name']);
    $email      = trim($_POST['email']);
    $password   = $_POST['pass'];
    $repass     = $_POST['repass'];

    // Customer role_id ডিফল্ট ২
    $role_id = 2;

    // পাসওয়ার্ড মিলানো
    if ($password !== $repass) {
        $msg = "Passwords do not match!";
    } else {
        // ইমেইল আগে আছে কিনা চেক
        $check_sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $con->prepare($check_sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $msg = "Email already registered!";
            $stmt->close();
        } else {
            $stmt->close();

            // পাসওয়ার্ড হ্যাশ করুন
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            // ডেটাবেসে ইনসার্ট করুন
            $insert_sql = "INSERT INTO users (first_name, last_name, email, password, role_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $con->prepare($insert_sql);
            $stmt->bind_param("ssssi", $first_name, $last_name, $email, $hashPassword, $role_id);

            if ($stmt->execute()) {
                // সেশন সেট করুন
                $_SESSION['user_id'] = $con->insert_id;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['email'] = $email;

                // হোমপেজ বা যেকোনো পেজে রিডাইরেক্ট করুন
                header("Location: indexfile.php");
                exit;
            } else {
                $msg = "Database error: " . $stmt->error;
            }
            $stmt->close();
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
        /* Custom styles */
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <form action="" method="post" class="bg-white p-5 rounded-4 shadow" style="width: 100%; max-width: 400px;">
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
            Already with us? <a href="customer_login.php">Sign in to continue.</a>
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
