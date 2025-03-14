<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $total = $_POST['totalPrice'];
    $paymentMethod = $_POST['paymentMethod']; // ✅ Get Payment Method
    $cartData = json_decode($_POST['cartItems'], true);

    // ✅ Set Payment Status
    $paymentStatus = ($paymentMethod === "online") ? "Paid" : "Pending";

    if (!empty($cartData)) {
        foreach ($cartData as $item) {
            $name = $item['name'];
            $price = $item['price'];
            $quantity = $item['quantity'];

            // ✅ Insert Order into Database
            $query = "INSERT INTO orders (user_id, product_name, price, quantity, total_price, payment_method, payment_status)
                      VALUES ('$username', '$name', '$price', '$quantity', '$total', '$paymentMethod', '$paymentStatus')";

            mysqli_query($conn, $query);
        }
        echo "success";
    } else {
        echo "failed";
    }
} else {
    echo "failed";
}
?>