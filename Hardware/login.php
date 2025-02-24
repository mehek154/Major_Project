<?php
session_start();
header("Content-Type: application/json");
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $mysqli->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $row["name"];
            echo json_encode(["success" => true, "username" => $row["name"]]);
        } else {
            echo json_encode(["success" => false, "error" => "Invalid password"]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "User not found"]);
    }
}
?>