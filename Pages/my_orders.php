<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle order cancellation
if (isset($_GET['cancel_order'])) {
    $order_id = intval($_GET['cancel_order']);
    // Only allow cancelling pending orders for this user
    $stmt = $con->prepare("UPDATE orders SET order_status='Cancelled' WHERE id=? AND user_id=? AND order_status='Pending'");
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    header("Location: my_orders.php");
    exit;
}

// Fetch all orders of this user
$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
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
<title>My Orders</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">My Orders</h2>
    
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
                        <td>৳<?= number_format($row['due_amount'], 2); ?></td>
                        <td><?= $row['qty']; ?></td>
                        <td><?= date("d M Y, h:i A", strtotime($row['order_date'])); ?></td>
                        <td>
                            <?php if ($row['order_status'] == 'Pending'): ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php elseif ($row['order_status'] == 'Completed'): ?>
                                <span class="badge bg-success">Completed</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Cancelled</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['order_status'] == 'Pending'): ?>
                                <a href="my_orders.php?cancel_order=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this order?');">Cancel</a>
                            <?php else: ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">You haven’t placed any orders yet.</div>
    <?php endif; ?>
</div>

<?php require "../includes/footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
