<?php
include 'db.php';
$username = $_POST['username'];

$sql = "SELECT * FROM orders WHERE username='$username'";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
?>