let cart = [];

// ✅ Open and Close Modals
function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

// ✅ Add to Cart
function addToCart(button) {
    const card = button.closest('.card');
    const productName = card.querySelector('.card-title').innerText;
    const productPrice = parseFloat(card.querySelector('.price').innerText.replace('₹', ''));
    const productImage = card.querySelector('.card-img-top').src;

    const existingProduct = cart.find(item => item.name === productName);

    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({ name: productName, price: productPrice, image: productImage, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCart();
}

// ✅ Update Cart
function updateCart() {
    const cartItems = document.getElementById('cartItems');
    const totalPrice = document.getElementById('totalPrice');
    const cartItemCount = document.querySelector('.cart-item-count');

    cartItems.innerHTML = '';
    let total = 0, itemCount = 0;

    cart.forEach((item, index) => {
        total += item.price * item.quantity;
        itemCount += item.quantity;

        cartItems.innerHTML += `
            <div class="cart-item">
                <img src="${item.image}" width="50">
                <span>${item.name}</span>
                <span>₹${item.price}</span>
                <div class="btn-cart">
                    <div class="quantity">
                        <button onclick="decrement(${index})">➖</button>
                        <span>${item.quantity}</span>
                        <button onclick="increment(${index})">➕</button>
                    </div>
                    <button onclick="removeFromCart(${index})" class="delete"><i class="ri-delete-bin-line"></i></button>
                </div>    
            </div>
        `;
    });

    cartItemCount.textContent = itemCount;
    totalPrice.textContent = `₹${total.toFixed(2)}`;
}

// ✅ Increment Quantity
function increment(index) {
    cart[index].quantity++;
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCart();
}

// ✅ Decrement Quantity
function decrement(index) {
    if (cart[index].quantity > 1) {
        cart[index].quantity--;
    } else {
        cart.splice(index, 1);
    }
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCart();
}

// ✅ Remove from Cart
function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCart();
}

// ✅ Order Now → Open Payment Modal
function orderNow() {
    let username = localStorage.getItem("username");

    if (!username) {
        alert("Please Login First 😏");
        window.location.href = "login.php";
        return;
    }

    if (cart.length === 0) {
        alert("Cart is Empty!");
        return;
    }

    openModal("paymentModal");
}

// ✅ Continue to Customer Details
function continueToCustomerDetails() {
    let selectedPayment = document.querySelector('input[name="paymentMethod"]:checked');

    if (!selectedPayment) {
        alert("Please select a payment method.");
        return;
    }

    localStorage.setItem("selectedPayment", selectedPayment.value);
    closeModal("paymentModal");
    openModal("customerDetailsModal");
}

// ✅ Continue to Final Step
function continueToFinal() {
    let name = document.getElementById("customerName").value.trim();
    let phone = document.getElementById("customerPhone").value.trim();
    let address = document.getElementById("customerAddress").value.trim();

    if (!name || !phone || !address) {
        alert("Please fill in all delivery details.");
        return;
    }

    localStorage.setItem("customerDetails", JSON.stringify({ name, phone, address }));
    closeModal("customerDetailsModal");
    openModal("finalStepModal");

    // Update final step modal with user details
    document.getElementById("selectedPaymentText").innerText = localStorage.getItem("selectedPayment");
    document.getElementById("finalCustomerDetails").innerHTML = `
        <p><strong>Name:</strong> ${name}</p>
        <p><strong>Phone:</strong> ${phone}</p>
        <p><strong>Address:</strong> ${address}</p>
    `;

    let cartSummary = document.getElementById("cartSummary");
    cartSummary.innerHTML = cart.map(item => `<p>${item.name} - ₹${item.price} x ${item.quantity}</p>`).join("");
    document.getElementById("finalTotalPrice").innerText = document.getElementById("totalPrice").innerText;
}

// ✅ Final Order Submission
function finalOrder() {
    let username = localStorage.getItem("username");
    let totalPrice = document.getElementById("finalTotalPrice").innerText.replace("₹", "").trim();
    let paymentMethod = localStorage.getItem("selectedPayment");
    let customerDetails = JSON.parse(localStorage.getItem("customerDetails"));
    let cartData = JSON.parse(localStorage.getItem("cart")) || [];

    if (!paymentMethod || !customerDetails || cartData.length === 0) {
        alert("Missing details. Please try again.");
        return;
    }

    let orderData = new FormData();
    orderData.append("username", username);
    orderData.append("totalPrice", totalPrice);
    orderData.append("paymentMethod", paymentMethod);
    orderData.append("customerName", customerDetails.name);
    orderData.append("customerPhone", customerDetails.phone);
    orderData.append("customerAddress", customerDetails.address);
    orderData.append("cartItems", JSON.stringify(cartData));

    fetch("order.php", { method: "POST", body: orderData })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === "success") {
            alert("Order Placed Successfully ✅");
            localStorage.removeItem("cart");
            localStorage.removeItem("selectedPayment");
            localStorage.removeItem("customerDetails");
            updateCart();
            window.location.href = "order-confirmation.php";
        } else {
            alert("Order Failed 😔 " + data);
        }
    });
}

// ✅ Sync Cart on Page Load
document.addEventListener("DOMContentLoaded", () => {
    let savedCart = localStorage.getItem("cart");
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCart();
    }
});

// ✅ Event Listeners for Modals
document.getElementById("continueToPayment").addEventListener("click", function() {
    openModal("paymentModal");
});

document.getElementById("continueToCustomerDetails").addEventListener("click", function() {
    openModal("customerDetailsModal");
});

document.getElementById("continueToFinalStep").addEventListener("click", function() {
    openModal("finalStepModal");
});
// ✅ Open Cart Modal
function showCart() {
    const cartModal = document.getElementById("cartModal");
    cartModal.style.display = "flex";  // Use "flex" to center the modal
}

// ✅ Close Cart Modal
function closeCart() {
    const cartModal = document.getElementById("cartModal");
    cartModal.style.display = "none";
}

// ✅ Automatically Sync Cart on Page Load
document.addEventListener("DOMContentLoaded", () => {
    let savedCart = localStorage.getItem("cart");
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCart();
    }
});

function addToCartFromWishlist(button) {
    let productName = button.getAttribute("data-name");
    let productPrice = button.getAttribute("data-price");

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Check if the product is already in the cart
    let existingProduct = cart.find(item => item.name === productName);
    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({ name: productName, price: parseFloat(productPrice), quantity: 1 });
    }

    // Save to localStorage
    localStorage.setItem("cart", JSON.stringify(cart));

    // Debugging: Check if cart updates correctly
    console.log("Cart after adding:", cart);

    alert("Product added to cart from wishlist!");
    updateCartUI();  // Ensure UI updates
}
document.querySelectorAll(".add-to-cart-btn").forEach(button => {
    button.addEventListener("click", function () {
        let productName = this.getAttribute("data-name");
        let productPrice = this.getAttribute("data-price");

        fetch("wishlist.php", {
            method: "POST",
            body: new URLSearchParams({
                "add_to_cart": true,
                "name": productName,
                "price": productPrice
            }),
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                updateCartUI();
            }
        });
    });
});
