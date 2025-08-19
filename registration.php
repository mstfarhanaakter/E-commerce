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

        .form-subtext {
            font-family: "Lucida Handwriting", cursive;
        }

        .form-check-label {
            font-family: "MV Boli", cursive;
            font-weight: bold;
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
            /* color: #FFC800; */
        }
    </style>
</head>

<body>

    <?php
    echo isset($msg) ? "<div class='text-center text-danger'>$msg</div>" : "";
    ?>
    <div class="container d-flex justify-content-center align-items-center vh-100">
    <form action="#" method="post" class="bg-white p-5 rounded-4 shadow" style="width: 100%; max-width: 400px;">
        
        <!-- Logo + Tagline Side by Side -->
        <div class="d-flex align-items-center justify-content-center mb-4 gap-3">
            <img src="assets/img/chick.png" alt="Chick" width="50">
            <p class="form-title m-0 fw-bold text-secondary">Be bold. Be first. Sign up!</p>
        </div>

        <div class="mb-3">
            <input type="text" class="form-control" name="user" placeholder="Your Username" required>
        </div>

        <!-- Password Field with Eye Icon -->
        <div class="mb-3 position-relative">
            <input type="password" class="form-control" name="pass" id="pass" placeholder="Your Password" required>
            <i class="fa-solid fa-eye position-absolute top-50 end-0 translate-middle-y me-3" id="togglePass" style="cursor: pointer;"></i>
        </div>

        <!-- Confirm Password Field with Eye Icon -->
        <div class="mb-3 position-relative">
            <input type="password" class="form-control" name="repass" id="repass" placeholder="Confirm Your Password" required>
            <i class="fa-solid fa-eye position-absolute top-50 end-0 translate-middle-y me-3" id="toggleRepass" style="cursor: pointer;"></i>
        </div>

        <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Your Email" required>
        </div>

        <p class="text-center small">
            Already with us? <a href="login.php">Sign in to continue.</a>
        </p>

        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-warning fw-bold">SUBMIT</button>
        </div>
    </form>
</div>


    <!-- PHP Signup Logic -->
    <?php
    if (isset($_POST['submit'])) {
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $repass = $_POST['repass'];
        $email = $_POST['email'];

        // Check if passwords match
        if ($password !== $repass) {
            echo "<div class='text-center text-danger mt-3'>Passwords do not match!</div>";
            exit;
        }

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check for duplicate email
        $users = file("auth.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($users as $user) {
            list($stored_user, $stored_password, $stored_email) = explode("|", $user);
            if ($email === $stored_email) {
                echo "<div class='text-center text-danger mt-3'>Email already registered!</div>";
                exit;
            }
        }

        // Save user
        $data = "$username|$hashPassword|$email\n";
        file_put_contents("auth.txt", $data, FILE_APPEND);
        header("Location: login.php");
        exit;
    }
    ?>

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

    <!-- Bootstrap JS (Optional for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>