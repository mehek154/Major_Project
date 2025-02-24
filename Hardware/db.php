<?php
$servername = "localhost";  // Change if using a remote database
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$database = "krishna_shop"; // Your database name

// Create connection
$mysqli = new mysqli($servername, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database Connection Failed: ' . $mysqli->connect_error]));
}
?>