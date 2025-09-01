<?php
session_start();
require "../config/db.php";

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);







// ---------------- Include header/nav ----------------
require "../includes/he.php";
if ($is_logged_in) {
    require "../includes/topbar_logged.php";
    require "../includes/navbar_logged.php";
} else {
    require "../includes/topbar.php";
    require "../includes/navbar.php";
}

require "../placeholder.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <!-- Payment Method Section -->
            <div class="col-lg-6 p-4">
                <form id="checkoutForm" onsubmit="return placeOrderAlert()">
                    <h4 class="text-center mb-3">Payment Method</h4>
                    <div class="border p-3 mb-3 bg-light rounded">
                        <!-- Paypal Option -->
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment" id="paypal" value="paypal"
                                required>
                            <label class="form-check-label fw-bold" for="paypal">
                                Paypal
                            </label>
                            <p class="text-muted small mb-0">Pay securely using your Paypal account.</p>
                        </div>

                        <!-- Direct Check Option -->
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment" id="directcheck"
                                value="directcheck">
                            <label class="form-check-label fw-bold" for="directcheck">
                                Direct Check
                            </label>
                            <p class="text-muted small mb-0">Send a check directly to our store address.</p>
                        </div>

                        <!-- Bank Transfer Option -->
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment" id="banktransfer"
                                value="banktransfer">
                            <label class="form-check-label fw-bold" for="banktransfer">
                                Bank Transfer
                            </label>
                            <p class="text-muted small mb-0">Transfer the money directly to our bank account.</p>
                        </div>

                        <!-- Cash on Delivery -->
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment" id="cod" value="cod">
                            <label class="form-check-label fw-bold" for="cod">
                                Cash on Delivery
                            </label>
                            <p class="text-muted small mb-0">Do transaction with delivery man.</p>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" class="btn btn-warning w-100 mt-2">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>




    <?php require "../includes/footer.php"; ?>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function placeOrderAlert() {
            alert("Your order has been placed!");
            window.location.href = "../main.php"; // change path to your home page
            return false; // prevent actual form submission for demo
        }
    </script>
</body>

</html>