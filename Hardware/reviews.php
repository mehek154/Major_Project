<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
error_log(print_r($data, true)); // Log to server error logs
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $mysqli->real_escape_string($data['name']);
    $review = $mysqli->real_escape_string($data['review']);
    $rating = (int)$data['rating'];

    $query = "INSERT INTO reviews (customer_name, review_text, rating) VALUES ('$name', '$review', $rating)";
    if ($mysqli->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $mysqli->error]);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $mysqli->query("SELECT * FROM reviews");
    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
    echo json_encode($reviews);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];
    $query = "DELETE FROM reviews WHERE id = $id";
    if ($mysqli->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $mysqli->error]);
    }
    // Example response
$response = ['status' => 'success', 'message' => 'Review added successfully'];
echo json_encode($response);
    exit();
}
$response[] = [
    "id" => $row['id'],
    "name" => $row['customer_name'], // Match frontend
    "review" => $row['review_text'], // Match frontend
    "rating" => $row['rating']
];
?>