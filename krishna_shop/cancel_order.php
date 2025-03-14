<?php
include("db.php");
$id = $_GET['id'];

$query = "DELETE FROM orders WHERE id='$id'";
mysqli_query($conn, $query);
header("Location: bill.php");
?>