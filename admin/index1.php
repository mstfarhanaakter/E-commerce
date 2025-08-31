<?php
session_start();
require "../config/db.php";

$msg = "";

if (isset($_POST["submit"])) {
    $email    = mysqli_real_escape_string($con, $_POST["email"]);
    $password = $_POST["pass"];

    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"]    = $row["id"];
            $_SESSION["first_name"] = $row["first_name"];
            $_SESSION["email"]      = $row["email"];

            // Login successful: JS alert + redirect
            echo "<script>
                alert('Welcome, " . htmlspecialchars($row['first_name']) . "!');
                window.location.href = 'main.php';
            </script>";
            exit();
        } else {
            $msg = "Invalid email or password!";
        }
    } else {
        $msg = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .form-title { font-family: "MV Boli", cursive; color: #052A75; }
    </style>
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center vh-100">
    <form method="post" class="bg-white p-5 rounded-4 shadow" style="max-width:400px;">
        <div class="text-center mb-4">
            <img src="media/user.png" width="50" class="mb-2">
            <h4 class="form-title">Admin Panel Login</h4>
        </div>

        <?php if ($msg): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>

        <div class="mb-3 position-relative">
            <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" required>
            <i class="fa-solid fa-eye position-absolute top-50 end-0 translate-middle-y me-3" 
               id="togglePass" style="cursor: pointer;"></i>
        </div>

        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-warning fw-bold">Log In</button>
        </div>
    </form>
</div>

<script>
const togglePass = document.getElementById("togglePass");
const passField = document.getElementById("pass");
togglePass.addEventListener("click", () => {
    const isPwd = passField.type === "password";
    passField.type = isPwd ? "text" : "password";
    togglePass.classList.toggle("fa-eye");
    togglePass.classList.toggle("fa-eye-slash");
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
