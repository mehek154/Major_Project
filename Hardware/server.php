<?php
header("Content-Type: application/json");
require "db.php"; // Ensure your database connection file is correct

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($data["name"], $data["email"], $data["password"])) {
        $name = $data["name"];
        $email = $data["email"];
        $password = password_hash($data["password"], PASSWORD_DEFAULT); // Secure password hashing

        // Check if email already exists
        $checkQuery = "SELECT * FROM users WHERE email = ?";
        $stmt = $mysqli->prepare($checkQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo json_encode(["success" => false, "message" => "Email already exists."]);
        } else {
            // Insert new user
            $insertQuery = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($insertQuery);
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Signup successful!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Database error."]);
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid input."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>