<?php
session_start();
require "../config/db.php";

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index1.php");
    exit;
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM orders WHERE id = $delete_id";
    if (mysqli_query($con, $delete_query)) {
        $_SESSION['msg'] = "Order deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete order.";
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order'])) {
    $order_id = intval($_POST['order_id']);
    $qty = intval($_POST['qty']);
    $due_amount = floatval($_POST['due_amount']);
    $order_status = mysqli_real_escape_string($con, $_POST['order_status']);

    $update_query = "
        UPDATE orders 
        SET qty = $qty, due_amount = $due_amount, order_status = '$order_status' 
        WHERE id = $order_id
    ";

    if (mysqli_query($con, $update_query)) {
        $_SESSION['msg'] = "Order updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update order.";
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";
?>

<main class="p-3">
    <h1 class="mb-4">Orders Management</h1>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-success"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

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
    ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-warning">
                    <tr>
                        <th>#</th>
                        <th>Invoice No</th>
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

                            <!-- Generate/display invoice number -->
                            <td>
                                <?php
                                $invoice = $order['invoice_no'];
                                if (empty($invoice)) {
                                    // Generate a random invoice number (e.g., INV-2025-XXXX)
                                    $invoice = 'INV-2025-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                                }
                                echo htmlspecialchars($invoice);
                                ?>
                            </td>

                            <td><?= htmlspecialchars($order['user_name']); ?></td>

                            <?php if (isset($_GET['edit_id']) && $_GET['edit_id'] == $order['order_id']): ?>
                                <!-- Edit form row -->
                                <form method="POST" action="">
                                    <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                                    <td><input type="number" name="qty" value="<?= $order['qty']; ?>" class="form-control" required></td>
                                    <td><input type="number" name="due_amount" step="0.01" value="<?= $order['due_amount']; ?>" class="form-control" required></td>
                                    <td><?= date("d M Y, h:i A", strtotime($order['order_date'])); ?></td>
                                    <td>
                                        <select name="order_status" class="form-select">
                                            <option value="Pending" <?= $order['order_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="Completed" <?= $order['order_status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                            <option value="Cancelled" <?= $order['order_status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" name="update_order" class="btn btn-sm btn-success">Save</button>
                                        <a href="<?= $_SERVER['PHP_SELF']; ?>" class="btn btn-sm btn-secondary">Cancel</a>
                                    </td>
                                </form>
                            <?php else: ?>
                                <!-- Normal display row -->
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
                                    <a href="?edit_id=<?= $order['order_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="?delete_id=<?= $order['order_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                                </td>
                            <?php endif; ?>
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
