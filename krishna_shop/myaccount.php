<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
$sql = "SELECT * FROM orders WHERE user_id='$username'";
$result = mysqli_query($conn, $sql);
?>

<h1>Your Orders Bill</h1>
<table border="1">
    <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Order Date</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['product_name']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['order_date']; ?></td>
        </tr>
    <?php } ?>
</table>

<button onclick="window.location='download_bill.php'">Download Bill PDF 📄</button>
<script>
    function showOrders() {
    let username = localStorage.getItem("username");

    fetch("myorders.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `username=${username}`
    })
    .then(response => response.json())
    .then(data => {
        let orderList = document.querySelector(".orders");
        orderList.innerHTML = "";

        data.forEach(order => {
            orderList.innerHTML += `
                <div>
                    <p>${order.product_name}</p>
                    <p>₹${order.price}</p>
                    <p>${order.quantity}</p>
                    <p>${order.total}</p>
                </div>
                <hr>
            `;
        });
    });
}
</script>