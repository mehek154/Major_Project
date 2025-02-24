const sliderTabs = document.querySelectorAll(".navigations");
/*const swiper = new Swiper(".slider", {
  effect: "slide",
  speed: 1000,
  /*autoplay:{delay:2000}
});*/
let searchForm = document.querySelector(".search-form");
document.querySelector("#fa-search").onclick = () => {
  searchForm.classList.toggle("active");
};
document.addEventListener("DOMContentLoaded", () => {
  let currentIndex = 0;
  const slides = document.querySelectorAll(".sliderContainer");
  const totalSlides = slides.length;

  if (!totalSlides) {
    console.error("No slides found! Check your selectors or HTML.");
    return;
  }

  // Hide all slides and show the current one
  function updateSlide(index) {
    slides.forEach((slide, i) => {
      slide.style.display = i === index ? "block" : "none";
    });
  }

  // Initialize first slide
  updateSlide(currentIndex);

  // Navigation Buttons
  document.getElementById("slide-prev").addEventListener("click", () => {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    updateSlide(currentIndex);
  });

  document.getElementById("slide-next").addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % totalSlides;
    updateSlide(currentIndex);
  });
});

document.addEventListener('DOMContentLoaded', () => {
  // Select the necessary elements
  const addReviewBtn = document.getElementById('add-review-btn');
  const reviewForm = document.getElementById('review-form');
  const ratingInput = document.getElementById('rating');
  const submitReviewBtn = document.getElementById('submit-review-btn');
  const reviewsContainer = document.getElementById('reviews-container'); // Container for review cards

  let selectedRating = 0;

  // Show the review form when "Add Review" is clicked
  addReviewBtn.addEventListener('click', () => {
    reviewForm.style.display = 'block';
    addReviewBtn.style.display = 'none'; // Hide the button
  });

  // Add click event listeners for the stars
const stars = document.querySelectorAll(".star"); // Select all stars
const output = document.getElementById("output"); // Select the output element

stars.forEach((star, index) => {
    star.addEventListener("click", function () {
        gfg(index + 1); // Call gfg with the star's index + 1
        document.getElementById("rating").value = index + 1; // Update hidden rating input
    });
});

function gfg(n) {
    remove(); // Remove previous active states
    for (let i = 0; i < n; i++) {
        stars[i].classList.add("active"); // Highlight stars up to n
    }
    output.innerText = "Rating is: " + n + "/5"; // Display rating
}

function remove() {
    stars.forEach(star => star.classList.remove("active")); // Clear previous highlights
}

  // Fetch and display all reviews on page load
  function fetchReviews() {
    fetch('reviews.php', {
      method: 'GET',
    })
      .then(response => response.json())
      .then(data => {
        reviewsContainer.innerHTML = ''; // Clear existing reviews
        data.forEach(review => {
          // Create and append each review card
          const reviewCard = document.createElement('div');
          reviewCard.classList.add('review-card');
          reviewCard.innerHTML = `
            <h3>${review.customer_name}</h3>
            <p>${review.review_text}</p>
            <p>Rating: ${'⭐'.repeat(review.rating)}</p>
            <small>Posted on: ${review.created_at}</small>
          `;
          reviewsContainer.appendChild(reviewCard);
        });
      })
      .catch(error => console.error('Error fetching reviews:', error));
  }

  // Submit the review
  submitReviewBtn.addEventListener('click', () => {
    const name = document.getElementById('name').value.trim();
    const reviewText = document.getElementById('review-text').value.trim();
    const rating = ratingInput.value;

    // Validate the form
    if (!name || !reviewText || rating === '0') {
      alert('Please fill out all fields and select a rating.');
      return;
    }

    // Send data to the backend
    fetch('reviews.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        name: name,
        review: reviewText,
        rating: parseInt(rating),
      }),
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Review submitted successfully!');
          fetchReviews(); // Refresh the reviews list
          reviewForm.style.display = 'none'; // Hide the form
          addReviewBtn.style.display = 'block'; // Show the button again
        } else {
          alert('Failed to submit the review. Please try again.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
      });
  });

  // Initial fetch to display reviews
  fetchReviews();
});

document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const scrollClass = urlParams.get("scroll");
  if (scrollClass) {
      let target = document.querySelector(`.${scrollClass}`);
      if (target) {
          target.scrollIntoView({ behavior: "smooth" });
      }
  }
});

document.addEventListener("DOMContentLoaded", function () {
  fetch("user.php")
  .then(response => response.json())
  .then(data => {
      if (data.username) {
          document.getElementById("usernameDisplay").textContent = data.username;
      } else {
          document.getElementById("usernameDisplay").textContent = "Guest";
      }
  })
  .catch(error => console.error("Error fetching username:", error));
});
function toggleAccountForm(event) {
  event.preventDefault(); // Prevent page refresh
  var dropdown = document.getElementById("accountDropdown");
  dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
}

// Close dropdown when clicking outside
window.onclick = function(event) {
  if (!event.target.closest('.account-container')) {
      document.getElementById("accountDropdown").style.display = "none";
  }
};
document.getElementById("usernameDisplay").innerText = sessionStorage.getItem("username") || "My Account";
document.getElementById("accountUsername").innerText = sessionStorage.getItem("username") || "User";
