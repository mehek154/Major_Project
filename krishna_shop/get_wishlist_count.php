<?php
session_start();
include 'db.php';

$wishlist_count = 0;

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $wishlist_query = "SELECT COUNT(*) AS count FROM wishlist WHERE user_id='$username'";
    $wishlist_result = mysqli_query($conn, $wishlist_query);
    $wishlist_data = mysqli_fetch_assoc($wishlist_result);
    $wishlist_count = $wishlist_data['count'];
}

echo json_encode(["count" => $wishlist_count]);
?>
