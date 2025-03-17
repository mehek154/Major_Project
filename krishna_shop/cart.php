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

// Check if product already exists in cart
$checkQuery = "SELECT * FROM cart WHERE user_id='$username' AND product_name='$product_name'";
$checkResult = mysqli_query($conn, $checkQuery);

if (mysqli_num_rows($checkResult) > 0) {
    echo json_encode(["status" => "error", "message" => "Product already in cart"]);
} else {
    $insertQuery = "INSERT INTO cart (user_id, product_name, product_price, quantity) VALUES ('$username', '$product_name', '$product_price', 1)";
    
    if (mysqli_query($conn, $insertQuery)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}
?>
