<?php
session_start();
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    foreach ($cart as $product) {
        echo $product['name'] . ' - $' . $product['price'] . '<br>';
    }
} else {
    echo 'Cart is empty';
}
?>