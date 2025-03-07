<?php
session_start();
include 'db.php';
require('tcpdf/tcpdf.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
$sql = "SELECT * FROM orders WHERE user_id='$user'";
$result = mysqli_query($conn, $sql);

// Create PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->Image( <i><h3>KR<span style="color:rgb(0, 124, 128);font-family: zapfino;">IS</span><span style="color: rgb(0, 128, 79);font-family: zapfino;">HN</span><span style="color: rgb(0, 128, 17);font-family: zapfino;">A</span></h3></i>
<p>Hardware Plywood & Sanitary Furniture Center</p>
</div>);
$pdf->SetAuthor('Hardware Shop');
$pdf->SetTitle('Order Bill');
$pdf->SetHeaderData('', 0, 'Krishna Plywood And Sanitary 🛠️', 'Order Bill');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

$html = '<h1 style="text-align:center;">Krishna Plywood And Sanitary 🛠️</h1>';
$html .= '<h2>Customer: ' . $user . '</h2>';
$html .= '<table border="1" cellpadding="5">
<tr>
<th>Product Name</th>
<th>Price</th>
<th>Order Date</th>
</tr>';

$total = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $html .= '
    <tr>
    <td>' . $row['product_name'] . '</td>
    <td>$' . $row['price'] . '</td>
    <td>' . $row['order_date'] . '</td>
    </tr>';
    $total += $row['price'];
}

$html .= '
<tr>
<td colspan="2"><b>Total Amount</b></td>
<td><b>$' . $total . '</b></td>
</tr>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Order_Bill.pdf', 'D');
?>