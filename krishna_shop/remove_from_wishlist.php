<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$username = $_SESSION['username'];
$product_name = $_POST['product_name']; // Get product name from request

$query = "DELETE FROM wishlist WHERE user_id='$username' AND product_name='$product_name'";

if (mysqli_query($conn, $query)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
}
?>
