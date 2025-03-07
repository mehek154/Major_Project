<?php
session_start();
header("Content-Type: application/json");

// Check if user is logged in
if (isset($_SESSION['username'])) {
    echo json_encode(["username" => $_SESSION['username']]);
} else {
    echo json_encode(["username" => null]); // No user logged in
}
?>