<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index1.php");
    exit;
}

require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";
require "../config/db.php";

// Fetch orders with user full name
$query = "
    SELECT 
        o.id AS order_id,
        o.order_date,
        o.total_price,
        CONCAT(u.first_name, ' ', u.last_name) AS user_name,
        o.payment_id,
        o.status,
        IFNULL(SUM(oi.quantity), 0) AS total_qty,
        IFNULL(COUNT(oi.product_id), 0) AS total_products
    FROM orders o
    LEFT JOIN order_items oi ON oi.order_id = o.id
    LEFT JOIN users u ON u.id = o.user_id
    GROUP BY o.id
    ORDER BY o.order_date DESC
";

$result = mysqli_query($con, $query);
if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}
?>

<main class="p-2">
    <div class="container-fluid pt-3">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-black text-center">
                <h2 class="mb-0">Orders</h2>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered align-middle text-center">
                    <thead class="table-warning">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>User Name</th>
                            <th>Payment ID</th>
                            <th>Total Products</th>
                            <th>Total Quantity</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php $count = 1; ?>
                            <?php while ($order = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= $order['order_id'] ?></td>
                                    <td><?= $order['order_date'] ?></td>
                                    <td><?= htmlspecialchars($order['user_name']) ?></td>
                                    <td><?= $order['payment_id'] ?></td>
                                    <td><?= $order['total_products'] ?></td>
                                    <td><?= $order['total_qty'] ?></td>
                                    <td>৳<?= number_format($order['total_price'], 2) ?></td>
                                    <td><?= ucfirst($order['status']) ?></td>
                                    <td>
                                        <!-- Action Buttons -->
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#viewOrderModal<?= $order['order_id'] ?>">View</button>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editOrderModal<?= $order['order_id'] ?>">Edit</button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteOrderModal<?= $order['order_id'] ?>">Delete</button>
                                    </td>
                                </tr>

                                <!-- View Modal -->
                                <div class="modal fade" id="viewOrderModal<?= $order['order_id'] ?>" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Order Details - #<?= $order['order_id'] ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>User Name:</strong> <?= htmlspecialchars($order['user_name']) ?></p>
                                                <p><strong>Order Date:</strong> <?= $order['order_date'] ?></p>
                                                <p><strong>Total Products:</strong> <?= $order['total_products'] ?></p>
                                                <p><strong>Total Quantity:</strong> <?= $order['total_qty'] ?></p>
                                                <p><strong>Total Price:</strong> ৳<?= number_format($order['total_price'], 2) ?>
                                                </p>
                                                <p><strong>Status:</strong> <?= ucfirst($order['status']) ?></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editOrderModal<?= $order['order_id'] ?>" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="edit_order.php" method="POST">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Order - #<?= $order['order_id'] ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                                    <div class="mb-3">
                                                        <label>Status</label>
                                                        <select name="status" class="form-control">
                                                            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                            <option value="processing"
                                                                <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing
                                                            </option>
                                                            <option value="completed"
                                                                <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Completed
                                                            </option>
                                                            <option value="cancelled"
                                                                <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" type="submit">Save Changes</button>
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteOrderModal<?= $order['order_id'] ?>" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Order - #<?= $order['order_id'] ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this order?
                                            </div>
                                            <div class="modal-footer">
                                                <a href="delete_order.php?id=<?= $order['order_id'] ?>"
                                                    class="btn btn-danger">Delete</a>
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>



<?php require "inc/footer.php"; ?>