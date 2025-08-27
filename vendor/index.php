<?php
session_start();
require "config/db.php"; // ডেটাবেস কানেকশন

$msg = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Vendor role_id = 3 এবং অনুমোদিত (is_approved = 1) এমন ইউজার খুঁজুন
    $sql = "SELECT id, first_name, password, is_approved FROM users WHERE email = ? AND role_id = 3";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // যদি ইউজার থাকে
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $first_name, $hashed_password, $is_approved);
        $stmt->fetch();

        if (!password_verify($password, $hashed_password)) {
            $msg = "Invalid password!";
        } elseif ($is_approved == 0) {
            $msg = "Your account is pending approval.";
        } else {
            // সব ঠিক থাকলে লগইন করুন
            $_SESSION['user_id'] = $user_id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['email'] = $email;

            // Vendor ড্যাশবোর্ডে পাঠান
            header("Location: vendor_dashboard.php");
            exit;
        }
    } else {
        $msg = "Vendor not found!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        .form-title {
            font-family: "MV Boli", cursive;
            color: #052A75;
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

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <form action="" method="post" class="bg-white p-5 rounded-4 shadow" style="width: 100%; max-width: 400px;">
            <!-- Logo and Image Side by Side -->
            <div class="d-flex align-items-center justify-content-center mb-3">
                <img src="../assets/img/user-data.png" alt="" width="75">
            </div>

            <!-- Welcome Message -->
            <p class="form-title text-center text-secondary fw-bold mb-3">
                Vendor Panel! Please log in.
                <?php if (!empty($msg))
                    echo "<br><span class='text-danger'>$msg</span>"; ?>
            </p>

            <!-- Input Fields -->
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Your Email" name="email" required>
            </div>
            <!-- Password Field with Eye Icon -->
            <div class="mb-3 position-relative">
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Your Password" required>
                <i class="fa-solid fa-eye position-absolute top-50 end-0 translate-middle-y me-3" id="togglePass"></i>
            </div>

            <!-- Forgot Password -->
            <p class="text-center mb-3">
                Need a new password? <a href="forget_pass.php">Click here.</a>
            </p>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" name="submit" class="btn btn-warning fw-bold">SUBMIT</button>
            </div>
        </form>
    </div>

    <!-- Toggle Password Script -->
    <script>
        const togglePass = document.getElementById("togglePass");
        const passField = document.getElementById("pass");

        togglePass.addEventListener("click", () => {
            const isPassword = passField.type === "password";
            passField.type = isPassword ? "text" : "password";

            togglePass.classList.toggle("fa-eye");
            togglePass.classList.toggle("fa-eye-slash");
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>