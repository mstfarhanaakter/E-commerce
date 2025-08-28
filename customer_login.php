<?php
session_start();
require "config/db.php";

$msg = "";

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['pass'];

    // ইউজার ডেটা নিন, শুধু Customer role_id=2 এর জন্য
    $sql = "SELECT id, first_name, password FROM users WHERE email = ? AND role_id = 2";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $first_name, $hashed_password);
        $stmt->fetch();

        // পাসওয়ার্ড মিলান
        if (password_verify($password, $hashed_password)) {
            // লগইন সফল
            $_SESSION['user_id'] = $user_id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['email'] = $email;

            // রিডাইরেক্ট করুন হোমপেজ বা ড্যাশবোর্ডে
            header("Location: main.php");
            exit;
        } else {
            $msg = "Invalid password!";
        }
    } else {
        $msg = "User not found or not a customer!";
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
            <img src="assets/img/chick.png" alt="" width="50" class="me-2">
            <div class="text-center">
                <a href="" class="text-decoration-none">
                    <span class="h4 text-uppercase text-warning bg-secondary px-2">Dora</span>
                    <span class="h4 text-uppercase text-dark bg-warning px-2 ">Mart</span>
                </a>
            </div>
        </div>

        <!-- Welcome Message -->
        <p class="form-title text-center text-secondary fw-bold mb-3">
            Welcome back! Please log in.
            <?php if (!empty($msg)) echo "<br><span class='text-danger'>$msg</span>"; ?>
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
