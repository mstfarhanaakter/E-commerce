<?php
require "../config/db.php";

if (isset($_GET['category_id'])) {
    $category_id = (int) $_GET['category_id'];

    $stmt = $con->prepare("SELECT id, name FROM sub_category WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $subcategories = [];
    while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($subcategories);
}
?>