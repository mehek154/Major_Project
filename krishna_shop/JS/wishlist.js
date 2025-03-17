// ✅ Load Wishlist Count on Page Load
document.addEventListener("DOMContentLoaded", function () {
    updateWishlistCount();
});

// ✅ Function to Update Wishlist Count in Navbar
function updateWishlistCount() {
    fetch("get_wishlist_count.php")
        .then(response => response.json())
        .then(data => {
            document.getElementById("wishlist-count").innerText = `(${data.count})`;
        })
        .catch(error => console.error("Error fetching wishlist count:", error));
}

// ✅ Function to Add to Wishlist
function addToWishlist(button) {
    const card = button.closest('.product-card'); // Find the nearest product card
    const productName = card.querySelector('.card-title').innerText;
    const productPrice = card.querySelector('.price').innerText.replace('₹', '').trim();
    const productImage = card.querySelector('.card-img-top').src;

    if (!productName || !productPrice || !productImage) {
        alert("⚠ Error: Missing product details!");
        return;
    }

    let formData = new FormData();
    formData.append("product_name", productName);
    formData.append("product_price", productPrice);
    formData.append("product_image", productImage);

    fetch("add_to_wishlist.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("✅ Added to Wishlist!");
            updateWishlistCount();
        } else {
            alert("⚠ " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
}

// ✅ Function to Remove from Wishlist
function removeFromWishlist(button) {
    const card = button.closest('.wishlist-item');
    const productName = card.querySelector('h3').innerText; // Get product name

    let formData = new FormData();
    formData.append("product_name", productName); // Send product name instead of ID

    fetch("remove_from_wishlist.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("❌ Removed from Wishlist");
            location.reload(); // Refresh to reflect changes
        } else {
            alert("⚠ " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
}
document.addEventListener("DOMContentLoaded", function () {
    // Attach event listener to all "Add to Cart" buttons
    document.querySelectorAll(".add-to-cart-btn").forEach(button => {
        button.addEventListener("click", function () {
            const productName = this.getAttribute("data-name");
            const productPrice = this.getAttribute("data-price");

            let formData = new FormData();
            formData.append("product_name", productName);
            formData.append("product_price", productPrice);

            fetch("cart.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert("✅ Added to Cart!");
                } else {
                    alert("⚠ " + data.message);
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});

