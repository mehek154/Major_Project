<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $total = $_POST['totalPrice'];
    $cartData = json_decode($_POST['cartData'], true);

    if (!empty($cartData)) {
        foreach ($cartData as $item) {
            $name = $item['name'];
            $price = $item['price'];
            $quantity = $item['quantity'];

            $query = "INSERT INTO orders (user_id, product_name, price, quantity, total_price) 
                      VALUES ('$username', '$name', '$price', '$quantity', '$total')";
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