<?php
session_start();
require "../config/db.php";

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index1.php");
    exit;
}

require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";
?>

<main class="p-3">
    <h1 class="mb-4">Orders Management</h1>

    <?php
    // Fetch all orders
    $query = "
        SELECT 
            o.id AS order_id,
            o.invoice_no,
            o.order_date,
            o.due_amount,
            o.qty,
            o.order_status,
            CONCAT(u.first_name, ' ', u.last_name) AS user_name
        FROM orders o
        LEFT JOIN users u ON u.id = o.user_id
        ORDER BY o.order_date DESC
    ";

    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "<div class='alert alert-danger'>Query Failed: " . mysqli_error($con) . "</div>";
    }
    ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-warning">
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Quantity</th>
                        <th>Due Amount</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    <?php while ($order = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= htmlspecialchars($order['user_name']); ?></td>
                            <td><?= $order['qty']; ?></td>
                            <td><b>৳</b><?= number_format($order['due_amount'], 2); ?></td>
                            <td><?= date("d M Y, h:i A", strtotime($order['order_date'])); ?></td>
                            <td>
                                <?php
                                $status = $order['order_status'];
                                if ($status == 'Pending') echo "<span class='badge bg-warning text-dark'>Pending</span>";
                                elseif ($status == 'Completed') echo "<span class='badge bg-success'>Completed</span>";
                                else echo "<span class='badge bg-danger'>Cancelled</span>";
                                ?>
                            </td>
                            <td>
                                <!-- Admin Actions -->
                                <a href="edit_order.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="delete_order.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No orders found.</div>
    <?php endif; ?>
</main>

<?php require "inc/footer.php"; ?>
