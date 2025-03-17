<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;
include 'db.php';
session_start();

// Ensure User is Logged In
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$order_id = $_GET['order_id'] ?? '';

// Fetch Customer & Order Details
$query = "SELECT customer_name, customer_phone, customer_address, product_name, price, quantity, total_price, payment_method, payment_status 
          FROM orders 
          WHERE user_id='$username' AND id='$order_id'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    die("No orders found!");
}

// Fetch First Order Row for Customer Details
$order = mysqli_fetch_assoc($result);

// Start HTML for PDF
$html = '<h2 style="text-align:center;">Invoice Bill</h2>';
$html .= '<h3 style="text-align:center;color:rgb(0, 124, 128);font-family: zapfino;">KRISHNA Hardware Ply & Sanitary Furniture Center</h3>';
$html .= '<p><strong>Customer Name:</strong> ' . $order['customer_name'] . '</p>';
$html .= '<p><strong>Phone Number:</strong> ' . $order['customer_phone'] . '</p>';
$html .= '<p><strong>Delivery Address:</strong> ' . $order['customer_address'] . '</p>';
$html .= '<p><strong>Date:</strong> ' . date("d-m-Y") . '</p>';
$html .= '<hr>';
$html .= '<table border="1" width="100%" cellpadding="10" cellspacing="0">';
$html .= '<tr>
            <th>Product Name</th>
            <th>Price (Rs)</th>
            <th>Quantity</th>
            <th>Total Price (Rs)</th>
            <th>Payment Method</th>
            <th>Payment Status</th>
        </tr>';

// Reset result pointer and loop through all orders
mysqli_data_seek($result, 0);
$total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $productTotal = $row['price'] * $row['quantity'];
    $total += $productTotal;

    $html .= '<tr>
                <td>' . $row['product_name'] . '</td>
                <td>Rs.' . number_format($row['price'], 2) . '</td>
                <td>' . $row['quantity'] . '</td>
                <td>Rs.' . number_format($productTotal, 2) . '</td>
                <td>' . $row['payment_method'] . '</td>
                <td>' . $row['payment_status'] . '</td>
              </tr>';
}

// Total Price Row
$html .= '<tr>
            <td colspan="3" style="text-align:right;"><strong>Grand Total:</strong></td>
            <td><strong>Rs.' . number_format($total, 2) . '</strong></td>
          </tr>';
$html .= '</table>';

// Initialize Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Download Invoice as PDF
$dompdf->stream("invoice_$order_id.pdf", array("Attachment" => true));
?>
