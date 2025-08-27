<?php 
require "inc/he.php";
require "inc/sidebar.php";
require "inc/nav.php";
require "inc/mobile_sidebar.php";
?>

 <!-- Dashboard Part Starts Here -->
 <?php 
 $sql = "SELECT id, first_name, last_name, email FROM users WHERE role_id = 3 AND is_approved = 0";
 $result = mysqli_query($con, $sql);

 ?>
 


<main class="p-4">
  <h2>Pending Vendor List</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Approval</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
                <form action="approve_vendor.php" method="POST">
                    <input type="hidden" name="vendor_id" value="<?= $row['id'] ?>">
                    <button type="submit" name="approve">Approve</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No pending vendors found.</p>
<?php endif; ?>
</main>

 <!-- dashboard ends here  -->




<?php 
require "inc/footer.php";
?>