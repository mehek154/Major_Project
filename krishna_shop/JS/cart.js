let cart = [];

// ✅ Add to Cart Function
function addToCart(button) {
    const card = button.closest('.card');
    const productName = card.querySelector('.card-title').innerText;
    const productPrice = parseFloat(card.querySelector('.price').innerText.replace('$', ''));
    const productImage = card.querySelector('.card-img-top').src;

    const existingProduct = cart.find(item => item.name === productName);

    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        const product = {
            name: productName,
            price: productPrice,
            image: productImage,
            quantity: 1
        };
        cart.push(product);
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCart();
}

// ✅ Update Cart Function
function updateCart() {
    const cartItems = document.getElementById('cartItems');
    const totalPrice = document.getElementById('totalPrice');
    const cartItemCount = document.querySelector('.cart-item-count');

    cartItems.innerHTML = '';
    let total = 0;
    let itemCount = 0;

    cart.forEach((item, index) => {
        total += item.price * item.quantity;
        itemCount += item.quantity;

        cartItems.innerHTML += `
            <div class="cart-item">
                <img src="${item.image}" width="50">
                <span>${item.name}</span>
                <span>$${item.price}</span>
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
    totalPrice.textContent = total.toFixed(2);
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

// ✅ Show Cart Modal
function showCart() {
    document.getElementById('cartModal').style.display = 'block';
}

// ✅ Close Cart Modal
function closeCart() {
    document.getElementById('cartModal').style.display = 'none';
}

// ✅ Order Now
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

    let cartItems = JSON.stringify(cart);
    let totalPrice = document.querySelector("#totalPrice").innerText;

    fetch("order.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `cartItems=${cartItems}&totalPrice=${totalPrice}&username=${username}`
    })
        .then(response => response.text())
        .then(data => {
            if (data === "success") {
                alert("Order Placed Successfully ✅");
                cart = [];
                localStorage.removeItem("cart");
                updateCart();
                location.reload();
            } else {
                alert("Order Failed 😔");
            }
        });
}

// ✅ Cart Sync on Every Page
document.addEventListener("DOMContentLoaded", () => {
    let savedCart = localStorage.getItem("cart");
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCart();
    }
});