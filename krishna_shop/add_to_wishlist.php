<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$username = $_SESSION['username'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_image = $_POST['product_image'];

$query = "INSERT INTO wishlist (user_id, product_name, product_price, product_image) 
          VALUES ('$username', '$product_name', '$product_price', '$product_image')";

if (mysqli_query($conn, $query)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
}
?>
