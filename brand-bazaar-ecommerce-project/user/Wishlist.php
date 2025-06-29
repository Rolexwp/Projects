<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Wishlist - Brand Bazaar</title>
    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <style>
      /* Inherit variables from main CSS */
      :root {
        --primary: #0a45a6;
        --primary-dark: #093b8b;
        --secondary: #233e61;
        --light-bg: #f6f8fb;
        --card-bg: #fff;
        --border-color: #e3e6ec;
        --success: #2ecc71;
        --danger: #d60000;
        --danger-dark: #a40000;
        --text-light: #888;
        --accent: #ff6b6b;
        --radius: 12px;
        --shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      }

      /* General styling for all navigation icons for consistent size and alignment */
      .nav-icons .nav-icon {
        color: #fff; /* White icon color */
        font-size: 1.23rem; /* Consistent icon size */
        display: flex; /* To center the icon */
        align-items: center;
        justify-content: center;
        height: 32px; /* Increased clickable area and visual consistency */
        width: 32px;
        border-radius: 50%; /* Circular shape for hover effect */
        transition: background 0.15s, color 0.15s;
        text-decoration: none; /* Remove underline for links */
        position: relative; /* For cart/wishlist count positioning */
      }

      .nav-icons .nav-icon:hover {
        background: var(--primary-dark); /* Darken on hover */
        color: #fff;
      }

      /* Specific styling for the profile dropdown button to align with other nav-icons */
      .nav-icons .dropdown .dropbtn {
        background: transparent;
        border: none;
        color: #fff;
        font-size: unset; /* Remove specific font-size here, let .nav-icons .nav-icon i handle it */
        padding: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 32px; /* Consistent clickable area and visual consistency */
        width: 32px;
        border-radius: 50%;
        transition: background 0.15s, color 0.15s;
        position: relative;
        z-index: 1;
      }

      .nav-icons .dropdown .dropbtn:hover {
        background: var(--primary-dark); /* Darken on hover like other icons */
        color: #fff;
      }

      /* Ensure the icon itself within the button/link has the consistent size */
      .nav-icons .nav-icon i,
      .nav-icons .dropdown .dropbtn i {
        font-size: 1.23rem; /* Apply the desired icon size directly to the i tag */
      }

      /* Adjust search input and button alignment if needed */
      .nav-search {
        display: flex;
        align-items: center; /* Align search input and button vertically */
        gap: 5px; /* Small gap between search input and button */
      }

      .nav-search input {
        height: 32px; /* Match height of icons for better alignment */
        padding: 0 10px;
        border-radius: 16px; /* Rounded corners */
        border: 1px solid rgba(255, 255, 255, 0.5); /* Light border */
        background: rgba(
          255,
          255,
          255,
          0.2
        ); /* Slightly transparent background */
        color: #fff;
        font-size: 0.9rem; /* Match other text sizes */
      }

      .nav-search input::placeholder {
        color: rgba(255, 255, 255, 0.7);
      }

      .nav-search-btn {
        background: transparent;
        border: none;
        color: #fff;
        font-size: 1.23rem; /* Match icon size */
        cursor: pointer;
        height: 32px;
        width: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.15s;
      }

      .nav-search-btn:hover {
        background: var(--primary-dark);
      }

      /* Cart and Wishlist count alignment */
      .nav-icon .cart-count,
      .nav-icon .wishlist-count {
        position: absolute;
        top: -8px; /* Adjusted to visually center */
        right: -8px; /* Adjusted to visually center */
        background-color: var(--accent); /* Example: accent color */
        color: white;
        border-radius: 50%;
        padding: 2px 6px; /* Adjusted padding */
        font-size: 0.75rem; /* Adjusted font size */
        min-width: 18px; /* Ensure circular shape for single digits */
        text-align: center;
        line-height: 1.5; /* For vertical centering of text */
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2); /* Small shadow for pop effect */
      }

      /* Adjustments for the mobile logout button in desktop view, as it's part of nav-icons */
      .nav-icons #mbnavLogout {
        display: none !important; /* Keep it hidden on desktop nav, as it's specifically for mobile bottom nav */
      }

      /* Inherit variables from main CSS */
      :root {
        --primary: #0a45a6;
        --primary-dark: #093b8b;
        --secondary: #233e61;
        --light-bg: #f6f8fb;
        --card-bg: #fff;
        --border-color: #e3e6ec;
        --success: #2ecc71;
        --danger: #d60000;
        --danger-dark: #a40000;
        --text-light: #888;
        --accent: #ff6b6b;
        --radius: 12px;
        --shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      }

      /* Wishlist Page Specific Styles */
      .wishlist-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 20px;
      }

      .page-header {
        text-align: center;
        margin-bottom: 2.5rem;
      }

      .page-header h1 {
        color: var(--primary);
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
      }

      .page-header p {
        color: var(--secondary);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
      }

      .wishlist-empty {
        text-align: center;
        padding: 4rem 0;
        background: var(--light-bg);
        border-radius: var(--radius);
        margin: 2rem 0;
      }

      .wishlist-empty i {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 1.5rem;
        display: block;
      }

      .wishlist-empty h2 {
        color: var(--secondary);
        margin-bottom: 1rem;
      }

      .wishlist-empty p {
        color: var(--text-light);
        margin-bottom: 1.5rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
      }

      .btn {
        padding: 0.8rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1rem;
        border: none;
        text-align: center;
        display: inline-block;
        text-decoration: none;
      }

      .btn-primary {
        background: var(--primary);
        color: #fff;
      }

      .btn-primary:hover {
        background: var(--primary-dark);
      }

      .btn-outline {
        background: transparent;
        color: var(--primary);
        border: 1px solid var(--primary);
      }

      .btn-outline:hover {
        background: #eaf3ff;
      }

      .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
      }

      .wishlist-item {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
      }

      .wishlist-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      }

      .wishlist-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
      }

      .wishlist-details {
        padding: 1.5rem;
      }

      .wishlist-title {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: var(--secondary);
      }

      .wishlist-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
      }

      .wishlist-actions {
        display: flex;
        gap: 0.8rem;
        margin-top: 1rem;
      }

      .wishlist-actions .btn {
        flex: 1;
      }

      .remove-wishlist {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--danger);
        border: none;
        font-size: 1rem;
        transition: all 0.2s;
      }

      .remove-wishlist:hover {
        background: var(--danger);
        color: white;
      }

      .wishlist-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: var(--text-light);
        margin-bottom: 0.5rem;
      }

      .wishlist-rating {
        color: #ffb400;
      }

      .wishlist-status {
        font-size: 0.8rem;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        background: #e8f5e9;
        color: #2e7d32;
        display: inline-block;
      }

      .wishlist-status.out-of-stock {
        background: #ffebee;
        color: #c62828;
      }

      /* Filter and Sort */
      .wishlist-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
      }

      .wishlist-filter {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
      }

      .filter-btn {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background: #f0f4ff;
        color: var(--primary);
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        transition: all 0.2s;
      }

      .filter-btn.active {
        background: var(--primary);
        color: white;
      }

      .filter-btn:hover:not(.active) {
        background: #d9e3ff;
      }

      .sort-select {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        background: white;
        font-size: 0.9rem;
      }

      /* Responsive styles */
      @media (max-width: 768px) {
        .wishlist-grid {
          grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        }

        .wishlist-toolbar {
          flex-direction: column;
          align-items: flex-start;
        }
      }

      @media (max-width: 480px) {
        .wishlist-grid {
          grid-template-columns: 1fr;
        }

        .wishlist-actions {
          flex-direction: column;
        }

        .wishlist-actions .btn {
          width: 100%;
        }
      }
    </style>
  </head>
  <body>
    <!-- Navigation (same as index.php) -->
    <nav class="navbar" id="navbar">
      <div class="nav-container">
        <a href="index.php" class="brand"
          ><i class="fas fa-gem"></i> Brand Bazaar</a
        >
        <button class="nav-toggle" id="navToggle" aria-label="Open Menu">
          <i class="fas fa-bars"></i>
        </button>
        <div class="nav-links" id="navLinks">
          <a href="index.php">Home</a>
          <a href="deals.php">Deals</a>

          <a href="#trending">Trending</a>
          <a href="#contact">Contact</a>
          <div class="dropdown">
            <button class="dropbtn" aria-haspopup="true">
              <i class="fas fa-th-large"></i> Categories
              <i class="fas fa-angle-down"></i>
            </button>
            <div class="dropdown-content">
              <a href="laptops.php" class="category-link">Laptops</a>
              <a href="mobiles.php" class="category-link">Mobiles</a>
              <a href="gadgets.php" class="category-link">Gadgets</a>
              
              <a href="shoes.php" class="category-link">Shoes</a>
            </div>
          </div>
        </div>
        <div class="nav-icons">
          <form class="nav-search" id="navSearchForm" autocomplete="off">
            <input
              type="text"
              id="navSearchInput"
              placeholder="Search..."
              aria-label="Search products, categories"
            />
            <button type="submit" class="nav-search-btn" title="Search">
              <i class="fas fa-search"></i>
            </button>
          </form>

          <div class="dropdown">
            <button
              class="nav-icon dropbtn"
              id="profileIcon"
              aria-haspopup="true"
              title="Profile"
            >
              <i class="fas fa-user"></i>
            </button>
            <div class="dropdown-content">
              <a href="profile.php">My Profile</a>
              <a href="myorders.php">My Orders</a>
              <a href="order-details.php">Order Details</a>
              <a href="purchase.php">Purchase History</a>
              <a href="tracking.php">Track Order</a>
              <a href="checkout.php">Checkout</a>
            </div>
          </div>
          <a
            href="wishlist.php"
            class="nav-icon"
            id="wishlistIcon"
            title="Wishlist"
          >
            <i class="fas fa-heart"></i>
            <span class="wishlist-count" id="wishlistCounter">0</span>
          </a>
          <a href="cart.php" class="nav-icon cart" id="cartIcon" title="Cart">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count" id="cartCounter">0</span>
          </a>
        </div>
      </div>
    </nav>

    <main>
      <div class="wishlist-container">
        <div class="page-header">
          <h1><i class="fas fa-heart"></i> My Wishlist</h1>
          <p>
            Your saved items are waiting for you. Don't miss out on these
            favorites!
          </p>
        </div>

        <!-- Filter and Sort Toolbar -->
        <div class="wishlist-toolbar">
          <div class="wishlist-filter">
            <button class="filter-btn active">All Items</button>
            <button class="filter-btn">In Stock</button>
            <button class="filter-btn">On Sale</button>
            <button class="filter-btn">Recently Added</button>
          </div>
          <div>
            <select class="sort-select">
              <option value="recent">Recently Added</option>
              <option value="price-low">Price: Low to High</option>
              <option value="price-high">Price: High to Low</option>
              <option value="rating">Highest Rated</option>
              <option value="name">Product Name</option>
            </select>
          </div>
        </div>

        <!-- Wishlist Items Grid -->
        <div class="wishlist-grid" id="wishlistItems">
          <!-- Wishlist items will be loaded here dynamically -->
        </div>

        <!-- Empty Wishlist State (hidden by default) -->
        <div class="wishlist-empty" id="emptyWishlist" style="display: none">
          <i class="fas fa-heart"></i>
          <h2>Your Wishlist is Empty</h2>
          <p>
            You haven't saved any items yet. Start shopping and add your
            favorite products to your wishlist!
          </p>
          <a href="index.php" class="btn btn-primary">Start Shopping</a>
        </div>
      </div>
    </main>

    <!-- Newsletter & Social -->
    <section id="newsletterSocial">
      <div class="newsletter">
        <h3>Subscribe for Exclusive Offers</h3>
        <form>
          <input type="email" placeholder="Enter your email" required />
          <button type="submit" class="btn">Subscribe</button>
        </form>
      </div>
      <div class="social-links">
        <a
          href="https://facebook.com"
          class="social facebook"
          target="_blank"
          rel="noopener noreferrer"
          ><i class="fab fa-facebook-f"></i
        ></a>
        <a
          href="https://twitter.com"
          class="social twitter"
          target="_blank"
          rel="noopener noreferrer"
          ><i class="fab fa-twitter"></i
        ></a>
        <a
          href="https://instagram.com"
          class="social instagram"
          target="_blank"
          rel="noopener noreferrer"
          ><i class="fab fa-instagram"></i
        ></a>
        <a
          href="https://youtube.com"
          class="social youtube"
          target="_blank"
          rel="noopener noreferrer"
          ><i class="fab fa-youtube"></i
        ></a>
      </div>
    </section>

    <!-- Footer -->
    <footer id="footer">
      <p>
        © 2025 Brand Bazaar. All rights reserved. |
        <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a> |
        <a href="#">Shipping Policy</a>
      </p>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav">
      <a href="index.php" class="mbnav-item" aria-label="Home"
        ><i class="fas fa-home"></i><span>Home</span></a
      >
      <a href="deals.php" class="mbnav-item" aria-label="Deals"
        ><i class="fas fa-tag"></i><span>Deals</span></a
      >
      <a href="wishlist.php" class="mbnav-item active" aria-label="Wishlist"
        ><i class="fas fa-heart"></i><span>Wishlist</span></a
      >
      <a href="cart.php" class="mbnav-item" id="mbnavCart" aria-label="Cart"
        ><i class="fas fa-shopping-cart"></i><span>Cart</span
        ><span class="cart-count" id="cartCounterMobile">0</span></a
      >
      <div class="dropdown mbnav-item" id="mbnavProfileContainer">
        <button class="dropbtn" id="mbnavProfile" aria-label="Profile">
          <i class="fas fa-user"></i><span>Profile</span>
        </button>
        <div class="dropdown-content">
          <a href="profile.php">My Profile</a>
          <a href="myorders.php">My Orders</a>
          <a href="order-details.php">Order Details</a>
          <a href="purchase.php">Purchase History</a>
          <a href="tracking.php">Track Order</a>
          <a href="checkout.php">Checkout</a>
        </div>
      </div>
    </nav>

    <script>
      // Wishlist functionality
      document.addEventListener("DOMContentLoaded", function () {
        // Load wishlist from localStorage or initialize empty array
        let wishlist = [];
        try {
            wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
        } catch (e) {
            console.error("Error parsing wishlist from localStorage:", e);
            wishlist = []; // Reset if parsing fails
        }

        // Filter out "ProCam X Smartphone" specifically
        wishlist = wishlist.filter(item => item.name !== "ProCam X Smartphone");
        // Save the filtered wishlist back to localStorage to persist the removal
        localStorage.setItem("wishlist", JSON.stringify(wishlist));


        // Render wishlist items
        function renderWishlist() {
          const wishlistContainer = document.getElementById("wishlistItems");
          const emptyWishlist = document.getElementById("emptyWishlist");

          if (wishlist.length === 0) {
            wishlistContainer.style.display = "none";
            emptyWishlist.style.display = "block";
            updateWishlistCount(0);
            return;
          }

          wishlistContainer.style.display = "grid";
          emptyWishlist.style.display = "none";

          wishlistContainer.innerHTML = "";

          wishlist.forEach((item) => {
            const itemElement = document.createElement("div");
            itemElement.className = "wishlist-item";
            itemElement.innerHTML = `
              <button class="remove-wishlist" title="Remove from wishlist" data-id="${
                item.id
              }">
                <i class="fas fa-times"></i>
              </button>
              <img src="${item.image}" alt="${
              item.name
            }" class="wishlist-image">
              <div class="wishlist-details">
                <div class="wishlist-meta">
                  <span class="wishlist-rating">
                    <i class="fas fa-star"></i> ${item.rating} (${item.reviews})
                  </span>
                  <span class="wishlist-status ${
                    item.inStock ? "" : "out-of-stock"
                  }">
                    ${item.inStock ? "In Stock" : "Out of Stock"}
                  </span>
                </div>
                <h3 class="wishlist-title">${item.name}</h3>
                <div class="wishlist-price">$${item.price.toFixed(2)}</div>
                <div class="wishlist-actions">
                  <button class="btn btn-outline">View Details</button>
                  <button class="btn btn-primary add-to-cart-from-wishlist" 
                          data-id="${item.id}"
                          data-name="${item.name}"
                          data-price="${item.price}"
                          data-image="${item.image}"
                          ${item.inStock ? "" : "disabled"}>
                    ${item.inStock ? "Buy Now" : "Notify Me"}
                  </button>
                </div>
              </div>
            `;

            wishlistContainer.appendChild(itemElement);
          });

          updateWishlistCount(wishlist.length);
        }

        // Update wishlist count in header
        function updateWishlistCount(count) {
          const counters = document.querySelectorAll(
            ".wishlist-count, #wishlistCounter"
          );
          counters.forEach((counter) => {
            counter.textContent = count;
          });
        }

        // Function to handle buying directly from wishlist (redirects to checkout)
        function buyNowFromWishlist(product) {
            const tempCart = [{
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                qty: 1
            }];
            localStorage.setItem('tempCart', JSON.stringify(tempCart));
            window.location.href = 'checkout.php';
        }

        // Remove item from wishlist and add to cart from wishlist
        document.addEventListener("click", function (e) {
          if (e.target.closest(".remove-wishlist")) {
            const itemId = parseInt(
              e.target.closest(".remove-wishlist").dataset.id
            );
            wishlist = wishlist.filter((item) => item.id !== itemId);
            localStorage.setItem("wishlist", JSON.stringify(wishlist));
            renderWishlist();

            // Show confirmation toast instead of alert
            showToast("Item removed from your wishlist!");
          }

          // Handle "Buy Now" (which was "Add to Cart") from wishlist
          if (
            e.target.classList.contains("add-to-cart-from-wishlist") &&
            !e.target.disabled
          ) {
            const itemId = parseInt(e.target.dataset.id);
            const itemName = e.target.dataset.name;
            const itemPrice = parseFloat(e.target.dataset.price);
            const itemImage = e.target.dataset.image;

            buyNowFromWishlist({
                id: itemId,
                name: itemName,
                price: itemPrice,
                image: itemImage
            });
          }
        });

        // Filter buttons
        const filterButtons = document.querySelectorAll(".filter-btn");
        filterButtons.forEach((button) => {
          button.addEventListener("click", function () {
            filterButtons.forEach((btn) => btn.classList.remove("active"));
            this.classList.add("active");

            // In a real implementation, you would filter the wishlist here
            // For now, this is just a visual active state
          });
        });

        // Sort select
        const sortSelect = document.querySelector(".sort-select");
        sortSelect.addEventListener("change", function () {
          // In a real implementation, you would sort the wishlist here
          console.log("Sort by:", this.value);
        });

        // Function to show toast messages (copied from index.php for consistency)
        function showToast(msg) {
            const t = document.getElementById("toast") || document.createElement('div');
            if (!document.getElementById("toast")) { // Create toast element if it doesn't exist
                t.id = "toast";
                document.body.appendChild(t);
                // Add basic toast styling
                t.style.position = 'fixed';
                t.style.bottom = '20px';
                t.style.left = '50%';
                t.style.transform = 'translateX(-50%)';
                t.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
                t.style.color = 'white';
                t.style.padding = '10px 20px';
                t.style.borderRadius = '5px';
                t.style.zIndex = '1000';
                t.style.display = 'none';
                t.style.textAlign = 'center';
            }
            t.textContent = msg;
            t.style.display = "block";
            setTimeout(() => (t.style.display = "none"), 1800);
        }

        // Update cart counter (copied from index.php for consistency)
        function updateCartCounter() {
            let cart = [];
            try {
                cart = JSON.parse(localStorage.getItem("cart")) || [];
            } catch (e) {
                console.error("Error parsing cart from localStorage:", e);
                cart = [];
            }
            let total = cart.reduce((sum, item) => sum + (item.qty || 1), 0);
            const cartCounter = document.getElementById("cartCounter");
            if (cartCounter) cartCounter.textContent = total;
            const cartMobile = document.getElementById("cartCounterMobile");
            if (cartMobile) cartMobile.textContent = total;
        }

        // Initial render
        renderWishlist();
        updateCartCounter(); // Also update cart counter on wishlist page load
        updateWishlistCount(wishlist.length); // Ensure wishlist count is updated on load

      });

      // Check login status for logout button
      function checkLoginStatus() {
        let user = localStorage.getItem("loggedInUser");
        const logoutBtn = document.getElementById("mbnavLogout");
        if (logoutBtn) {
          logoutBtn.style.display = user ? "" : "none";
        }
      }
      checkLoginStatus();
    </script>
  </body>
</html>
