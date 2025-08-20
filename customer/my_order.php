<?php
require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";
?>

<!-- Dashboard Part Starts Here -->

<main class="p-4">
    <?php
    // Include the database connection file
    include '../config/db.php'; // Ensure you have a db_connect.php for connecting to the database
    
    // Fetch orders from the database
    $query = "SELECT * FROM orders";
    $result = mysqli_query($con, $query);

    // Update order status if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
        $order_id = $_POST['order_id'];
        $new_status = $_POST['status'];

        $update_query = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
        if (mysqli_query($con, $update_query)) {
            echo "Order status updated successfully!";
        } else {
            echo "Error updating status: " . mysqli_error($con);
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Order Management</title>
        <!-- Include Bootstrap or custom CSS here for styling -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container mt-5">
            <h2>Order Management</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order Date</th>
                        <th>Total Price</th>
                        <th>User ID</th>
                        <th>Payment ID</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $order['order_date']; ?></td>
                            <td><?php echo "$" . number_format($order['total_price'], 2); ?></td>
                            <td><?php echo $order['user_id']; ?></td>
                            <td><?php echo $order['payment_id']; ?></td>
                            <td>
                                <?php echo ucfirst($order['status']); ?>
                            </td>
                            <td>
                                <form method="POST" action="admin_orders.php">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="form-control">
                                        <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="completed" <?php echo ($order['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                        <option value="canceled" <?php echo ($order['status'] == 'canceled') ? 'selected' : ''; ?>>Canceled</option>
                                        <option value="shipped" <?php echo ($order['status'] == 'shipped') ? 'selected' : ''; ?>>Shipped</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-primary mt-2">Update
                                        Status</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Include Bootstrap JS or custom scripts here -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

    </html>

</main>

<!-- dashboard ends here  -->




<?php

require "inc/footer.php";
?>