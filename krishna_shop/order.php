<?php
include 'db.php'; // Ensure this file correctly connects to your database

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "failed: Invalid request method";
    exit;
}

// Retrieve Data from POST Request
$username = $_POST['username'] ?? '';
$total = $_POST['totalPrice'] ?? '';
$paymentMethod = $_POST['paymentMethod'] ?? '';
$cartData = json_decode($_POST['cartItems'], true);
$customerName = $_POST['customerName'] ?? '';
$customerPhone = $_POST['customerPhone'] ?? '';
$customerAddress = $_POST['customerAddress'] ?? '';

if (empty($username) || empty($total) || empty($paymentMethod) || empty($cartData) || empty($customerName) || empty($customerPhone) || empty($customerAddress)) {
    echo "failed: Empty entry";
    exit;
}

// Set Payment Status
$paidMethods = ["visa", "mastercard", "paypal", "stripe", "gpay", "paytm"];
$paymentStatus = in_array($paymentMethod, $paidMethods) ? "Paid" : "Pending";

// Store Customer Order Details
foreach ($cartData as $item) {
    $name = mysqli_real_escape_string($conn, $item['name']);
    $price = floatval($item['price']);
    $quantity = intval($item['quantity']);
    $total_price = $price * $quantity;

    $query = "INSERT INTO orders (user_id, product_name, price, quantity, total_price, payment_method, payment_status, customer_name, customer_phone, customer_address) 
              VALUES ('$username', '$name', '$price', '$quantity', '$total_price', '$paymentMethod', '$paymentStatus', '$customerName', '$customerPhone', '$customerAddress')";

    if (!mysqli_query($conn, $query)) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
}

echo "success";
?>
