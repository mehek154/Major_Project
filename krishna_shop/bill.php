<?php
include 'db.php';
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}
$username = $_SESSION['username'];

$query = "SELECT * FROM orders WHERE user_id='$username'";
$result = mysqli_query($conn, $query);

// Calculate Total Price
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Orders</title>
<link rel="stylesheet" href="style.css">
<style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      text-align: center;
    }
    h1 {
      margin-top: 20px;
    }
    table {
      width: 90%;
      margin: auto;
      border-collapse: collapse;
      background: white;
      box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }
    table, th, td {
      border: 1px solid black;
      padding: 10px;
      text-align: center;
    }
    a {
      text-decoration: none;
    }
    .back-btn {
      display: block;
      text-align: center;
      margin-top:5%;
      text-decoration: none;
      color: white;
      background:rgb(0, 124, 128);
      padding: 10px;
      width: 200px;
      margin: auto;
      border-radius: 5px;
    }
    .cancel-btn {
      color:red;
      padding: 5px 10px;
      border-radius: 3px;
    }
    .invoice-btn {
      background: blue;
      color: white;
      padding: 10px;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }
    table tr:last-child {
      background:rgb(0, 124, 128);
      color: white;
      font-size: 18px;
      font-weight: bold;
    }
</style>
</head>
<body>

<h1>Your Orders 📦</h1>
<table>
<tr>
  <th>Product Name</th>
  <th>Price (₹)</th>
  <th>Quantity</th>
  <th>Total Price (₹)</th>
  <th>Date</th>
  <th>Payment Method</th>
  <th>Payment Status</th>
  <th>Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)) { 
    $productTotal = $row['price'] * $row['quantity'];
    $total += $productTotal;
?>
<tr>
  <td><?php echo htmlspecialchars($row['product_name']); ?></td>
  <td>₹<?php echo number_format($row['price'], 2); ?></td>
  <td><?php echo $row['quantity']; ?></td>
  <td>₹<?php echo number_format($productTotal, 2); ?></td>
  <td><?php echo $row['order_date']; ?></td>
  <td><?php echo $row['payment_method']; ?></td>
  <td><?php echo $row['payment_status']; ?></td>
  <td>
    <a href="cancel_order.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are You Sure You Want to Cancel Order?')" class="cancel-btn">Cancel ❌</a>
  </td>
</tr>
<?php } ?>

<!-- Total Row -->
<tr>
  <td colspan="3" style="text-align: right;">Grand Total:</td>
  <td>₹<?php echo number_format($total, 2); ?></td>
  <td colspan="4">
    <a href="invoice.php?order_id=98765" target="_blank">
      <button class="invoice-btn">📄 Download Invoice</button>
    </a>
  </td>
</tr>
</table>

<a href="index.html" class="back-btn">⬅️ Back to Home</a>
</body>
</html>