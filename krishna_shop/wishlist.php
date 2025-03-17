<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch wishlist items
$query = "SELECT * FROM wishlist WHERE user_id='$username'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Wishlist</title>
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="CSS/hardware.css">
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="wishlistStyle">
        <h2 style="text-align:center;font-size:10mm;">Your Wishlist</h2>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="wishlist-item">
                <img src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="Product Image" width="100">
                <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                <p>Price: ₹<?php echo isset($row['product_price']) ? number_format($row['product_price'], 2) : "0.00"; ?></p>
                <div class="wishlistBtn">
                    <button class="btn btn-dark w-100 mt-2 add-to-cart-btn"
                        data-name="<?= $row['product_name']; ?>"
                        data-price="<?= $row['product_price']; ?>">ADD TO CART
                    </button>
                    <button id="wishlistRemove" data-id="<?= $row['id']; ?>">
                        <i class="ri-delete-bin-line" style="color:red;font-size:5mm;"></i>
                    </button>
                </div>
            </div>
        <?php endwhile; ?>
        <button class="go-back-btn" onclick="window.history.back()">⬅ Go Back</button>
    </div>
    <script src="JS/script.js"></script>  
   <script src="JS/cart.js"></script>
   <script src="JS/wishlist.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>
</html>
