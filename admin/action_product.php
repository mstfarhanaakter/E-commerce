<?php 
require "inc/he.php"; // Include header, sidebar, and navigation files.
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";

// Database connection
require "../config/db.php"; 

// Fetch products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($con, $query);
?>

<main class="p-4">
    <div class="container mt-5">
        <h2>Manage Products</h2>

        <!-- Display message if any -->
        <?php if (!empty($msg)): ?>
            <div class="alert alert-info"><?php echo $msg; ?></div>
        <?php endif; ?>

        <!-- Table to display products -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td>
                            <?php 
                            // Fetch the category name
                            $category_query = "SELECT name FROM categories WHERE id = " . $product['category_id'];
                            $category_result = mysqli_query($con, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                            echo $category['name'];
                            ?>
                        </td>
                        <td><?php echo $product['price']; ?></td>
                        <td>
                            <!-- Edit button -->
                            <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            
                            <!-- Delete button -->
                            <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require "inc/footer.php"; ?>
