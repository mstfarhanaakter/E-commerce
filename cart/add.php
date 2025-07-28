<?php
session_start();
require "config/config.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];


    //find out the product 
    $sql = "SELECT * FROM products WHERE id = $id";
    $resutl = mysqli_query($link, $result);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        $item = [
            "id" => $product["id"],
            "name" => $product["name"],
            "price" => $product["price"],
            "quantity" => 1
        ];
        // If session not exist then create it. 

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // if item already exists then increase quantity

        $found = false;
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['id'] == $id) {
                $cart_item['quantity']++;
                $found = true;
                break;
            }
        }

        // if item don't exist then create it 

        if (!$found) {
            $_SESSION['cart'][] = $item;

        }

    }
}
header('location:view.php')
?>