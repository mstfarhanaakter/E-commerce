<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cancelled or returned orders
$query = "SELECT * FROM orders 
          WHERE user_id = ? AND (order_status='Cancelled' OR order_status='Returned')
          ORDER BY order_date DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

require "../includes/he.php";
require "../includes/topbar_logged.php";
require "../includes/navbar_logged.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Returns & Cancellations</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">My Returns & Cancellations</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-warning">
                <tr>
                    <th>Invoice No</th>
                    <th>Due Amount</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['invoice_no']); ?></td>
                        <td><b>৳</b><?= number_format($row['due_amount'], 2); ?></td>
                        <td><?= $row['qty']; ?></td>
                        <td><?= date("d M Y, h:i A", strtotime($row['order_date'])); ?></td>
                        <td>
                            <?php if ($row['order_status'] == 'Cancelled'): ?>
                                <span class="badge bg-danger">Cancelled</span>
                            <?php elseif ($row['order_status'] == 'Returned'): ?>
                                <span class="badge bg-info text-dark">Returned</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['order_status'] == 'Returned'): ?>
                                <span class="text-success">Return Processed</span>
                            <?php else: ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">You have no cancelled or returned orders.</div>
    <?php endif; ?>
</div>

<?php require "../includes/footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
