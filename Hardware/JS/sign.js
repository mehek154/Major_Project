document.querySelector("form").addEventListener("submit", async function (event) {
    event.preventDefault(); // Prevent default form submission

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    try {
        const response = await fetch("server.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ name, email, password }),
        });

        const data = await response.json();
        
        if (data.success) {
            storeUser(name); // Store username in localStorage
            window.location.href = "index.html"; // Redirect to the homepage
        } else {
            alert("Signup failed: " + data.message);
        }
    } catch (error) {
        console.error("Error:", error);
    }
});
function storeUser(username) {
    localStorage.setItem("username", username);
}