<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Shopping Cart - Brand Bazaar</title>
    <meta
      name="description"
      content="Review and manage items in your shopping cart"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="css/style.css" />
    <style>
      /* Variables specific to this page or overrides not in style.css */
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
        --radius: 12px;
        --shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
        --accent: #ff6b6b; /* Consistent accent color */
      }

      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      body {
        background: var(--light-bg);
        font-family: "Segoe UI", "Roboto", Arial, sans-serif;
        color: var(--secondary);
        line-height: 1.6;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
      }

      /* Main Content */
      .container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 20px;
        flex: 1;
      }

      .cart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
      }

      .cart-title {
        font-size: clamp(1.5rem, 5vw, 2rem);
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 1rem;
      }

      .continue-shopping {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition);
      }

      .continue-shopping:hover {
        text-decoration: underline;
        color: var(--primary-dark);
      }

      /* Cart Content */
      .cart-content {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
      }

      .cart-empty {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        max-width: 600px;
        margin: 0 auto;
      }

      .cart-empty i {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 1rem;
      }

      .cart-empty h2 {
        color: var(--secondary);
        margin-bottom: 1rem;
        font-size: 1.5rem;
      }

      .cart-empty p {
        color: var(--text-light);
        margin-bottom: 1.5rem;
      }

      .btn {
        padding: 0.8rem 1.5rem;
        border-radius: var(--radius);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        font-size: 1rem;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        border: 2px solid transparent;
      }

      .btn-primary {
        background: var(--primary);
        color: white;
      }

      .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .btn-outline {
        background: transparent;
        color: var(--primary);
        border-color: var(--primary);
      }

      .btn-outline:hover {
        background: #eaf3ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      /* Cart Table */
      .cart-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 1rem;
      }

      .cart-table thead th {
        background: #eaf3ff;
        color: var(--primary);
        font-weight: 700;
        padding: 1rem;
        text-align: left;
      }

      .cart-table tbody tr {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
      }

      .cart-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      }

      .cart-table td {
        padding: 1rem;
        vertical-align: middle;
      }

      .cart-product {
        display: flex;
        align-items: center;
        gap: 1rem;
      }

      .cart-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        transition: var(--transition);
      }

      .cart-img:hover {
        transform: scale(1.05);
      }

      .product-name {
        font-weight: 600;
        margin-bottom: 0.3rem;
      }

      .product-sku {
        color: var(--text-light);
        font-size: 0.9rem;
      }

      .qty-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .qty-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background: #f7fbff;
        color: var(--primary);
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
        user-select: none;
      }

      .qty-btn:hover {
        background: #eaf3ff;
        transform: scale(1.1);
      }

      .qty-btn:active {
        transform: scale(0.95);
      }

      .qty-input {
        width: 50px;
        text-align: center;
        padding: 0.5rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 1rem;

        /* Cross-browser appearance reset */
        appearance: textfield;
        -webkit-appearance: none;
        -moz-appearance: textfield;
      }

      /* Optional: Remove spinners in number inputs for WebKit browsers */
      .qty-input::-webkit-outer-spin-button,
      .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      .qty-input::-webkit-outer-spin-button,
      .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      .remove-btn {
        color: var(--danger);
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: var(--transition);
      }

      .remove-btn:hover {
        background: #ffebee;
        transform: rotate(90deg);
      }

      .price {
        font-weight: 700;
        color: var(--primary);
      }

      /* Cart Summary */
      .cart-summary {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 1.5rem;
        margin-top: 2rem;
        transition: var(--transition);
      }

      .cart-summary:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      }

      .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.8rem 0;
        border-bottom: 1px dashed var(--border-color);
      }

      .summary-row:last-child {
        border-bottom: none;
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--primary);
      }

      .checkout-btn {
        width: 100%;
        padding: 1rem;
        font-size: 1.1rem;
        margin-top: 1.5rem;
      }

      /* Promo Code */
      .promo-code {
        display: flex;
        gap: 0.5rem;
        margin-top: 1.5rem;
      }

      .promo-input {
        flex: 1;
        padding: 0.8rem;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        font-size: 1rem;
        transition: var(--transition);
      }

      .promo-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(10, 69, 166, 0.2);
      }

      .apply-btn {
        padding: 0 1.5rem;
        white-space: nowrap;
      }

      /* Toast Notification */
      .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--primary);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        transform: translateY(100px);
        opacity: 0;
        transition: var(--transition);
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .toast.show {
        transform: translateY(0);
        opacity: 1;
      }

      .toast.error {
        background: var(--danger);
      }

      .toast.success {
        background: var(--success);
      }

      /* Loading overlay */
      .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 999;
        opacity: 0;
        pointer-events: none;
        transition: var(--transition);
      }

      .loading-overlay.active {
        opacity: 1;
        pointer-events: all;
      }

      .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid rgba(10, 69, 166, 0.2);
        border-radius: 50%;
        border-top-color: var(--primary);
        animation: spin 1s linear infinite;
      }

      @keyframes spin {
        to {
          transform: rotate(360deg);
        }
      }

      /* Responsive */
      @media (max-width: 768px) {
        .cart-table thead {
          display: none;
        }

        .cart-table tr {
          display: flex;
          flex-direction: column;
          padding: 1rem;
          position: relative;
        }

        .cart-table td {
          padding: 0.5rem 0;
          display: flex;
          justify-content: space-between;
        }

        .cart-table td::before {
          content: attr(data-label);
          font-weight: 600;
          color: var(--primary);
          margin-right: 1rem;
          flex: 1;
        }

        .cart-table td > * {
          flex: 1;
          text-align: right;
        }

        .remove-btn {
          position: absolute;
          top: 1rem;
          right: 1rem;
        }

        .cart-product {
          flex-direction: column;
          align-items: flex-start;
        }

        .qty-control {
          justify-content: flex-end;
        }
      }

      @media (max-width: 480px) {
        .cart-header {
          flex-direction: column;
          align-items: flex-start;
          gap: 1rem;
        }

        .promo-code {
          flex-direction: column;
        }

        .apply-btn {
          width: 100%;
        }
      }

      /* Accessibility improvements */
      [aria-hidden="true"] {
        pointer-events: none;
      }

      .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
      }
    </style>
  </head>
  <body>
    <!-- Navigation -->
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
          <a href="trending.php">Trending</a>
          <a href="contact.php">Contact</a>
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
              <a href="logout.php">Logout</a>
            </div>
          </div>

          <!-- Wishlist Icon -->
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

          <a
            href="logout.php"
            class="mbnav-item"
            id="mbnavLogout"
            aria-label="Logout"
            style="display: none"
          >
            <i class="fas fa-sign-out-alt"></i><span></span>
          </a>
        </div>
      </div>
    </nav>


    <main class="container">
      <div class="cart-header">
        <h1 class="cart-title">
          <i class="fas fa-shopping-cart" aria-hidden="true"></i>
          <span>Your Shopping Cart</span>
        </h1>
        <a href="index.php" class="continue-shopping">
          <i class="fas fa-arrow-left" aria-hidden="true"></i>
          <span>Continue Shopping</span>
        </a>
      </div>

      <div class="cart-content" id="cartContents">
        <!-- Cart items will be loaded here -->
      </div>

      <div class="cart-summary" id="cartSummary" style="display: none">
        <div class="summary-row">
          <span>Subtotal</span>
          <span id="subtotal">$0.00</span>
        </div>
        <div class="summary-row">
          <span>Shipping</span>
          <span id="shipping">$0.00</span>
        </div>
        <div class="summary-row">
          <span>Tax</span>
          <span id="tax">$0.00</span>
        </div>
        <div class="summary-row">
          <span>Discount</span>
          <span id="discount">-$0.00</span>
        </div>
        <div class="summary-row">
          <span>Total</span>
          <span id="total">$0.00</span>
        </div>

        <div class="promo-code">
          <input
            type="text"
            class="promo-input"
            placeholder="Enter promo code"
            id="promoCode"
            aria-label="Promo code"
          />
          <button class="btn btn-outline apply-btn" id="applyPromoBtn">
            Apply
          </button>
        </div>

        <button class="btn btn-primary checkout-btn" id="checkoutBtn">
          Proceed to Checkout
        </button>
      </div>
    </main>

    <!-- Loading overlay -->
    <div class="loading-overlay" id="loadingOverlay">
      <div class="spinner" aria-hidden="true"></div>
      <span class="sr-only">Loading...</span>
    </div>

    <!-- Toast notification -->
    <div
      class="toast"
      id="toastNotification"
      role="alert"
      aria-live="assertive"
    >
      <i class="fas fa-check-circle" aria-hidden="true"></i>
      <span id="toastMessage"></span>
    </div>

    <!-- Mobile Bottom Navigation (from Wishlist.php) -->
    <nav class="mobile-bottom-nav">
      <a href="index.php" class="mbnav-item" aria-label="Home"
        ><i class="fas fa-home"></i><span>Home</span></a
      >
      <a href="deals.php" class="mbnav-item" aria-label="Deals"
        ><i class="fas fa-tag"></i><span>Deals</span></a
      >
      <a href="wishlist.php" class="mbnav-item" aria-label="Wishlist"
        ><i class="fas fa-heart"></i><span>Wishlist</span></a
      >
      <a href="cart.php" class="mbnav-item active" id="mbnavCart" aria-label="Cart"
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
      // Cart functionality
      document.addEventListener("DOMContentLoaded", function () {
        // Initialize event listeners
        document
          .getElementById("applyPromoBtn")
          .addEventListener("click", applyPromo);
        document
          .getElementById("checkoutBtn")
          .addEventListener("click", goToCheckout);

        // Handle promo code input on Enter key
        document
          .getElementById("promoCode")
          .addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
              applyPromo();
            }
          });

        renderCart();
        updateCartCounter(); // Call updateCartCounter on page load
        updateWishlistCounter(); // Call updateWishlistCounter on page load

        // Dropdown functionality (copied from index.php/wishlist.php)
        const dropdownButtons = document.querySelectorAll(".dropdown .dropbtn");

        dropdownButtons.forEach((button) => {
          button.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            const dropdownContent = this.nextElementSibling;

            document
              .querySelectorAll(".dropdown-content.show")
              .forEach((openDropdown) => {
                if (openDropdown !== dropdownContent) {
                  openDropdown.classList.remove("show");
                }
              });

            dropdownContent.classList.toggle("show");
          });
        });

        document.addEventListener("click", function (event) {
          if (!event.target.closest(".dropdown")) {
            document
              .querySelectorAll(".dropdown-content.show")
              .forEach((openDropdown) => {
                openDropdown.classList.remove("show");
              });
          }
        });

        // Mobile nav toggle (copied from main.js/index.php)
        const navToggle = document.getElementById("navToggle");
        const navLinks = document.getElementById("navLinks");
        if (navToggle && navLinks) {
            navToggle.addEventListener("click", () => {
                navLinks.classList.toggle("active");
            });
        }
      });

      // New function to update the wishlist counter (copied from index.php)
      function updateWishlistCounter() {
          let wishlist = [];
          try {
              wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
          } catch (e) {
              console.error("Error parsing wishlist from localStorage:", e);
              wishlist = []; // Reset if parsing fails
          }
          const wishlistCounter = document.getElementById("wishlistCounter");
          if (wishlistCounter) {
              wishlistCounter.textContent = wishlist.length;
          }
      }

      function showToast(message, type = "success") {
        const toast = document.getElementById("toastNotification");
        const toastMessage = document.getElementById("toastMessage");

        // Create toast element if it doesn't exist (useful for pages without it pre-defined)
        if (!toast) {
            const newToast = document.createElement('div');
            newToast.id = "toastNotification";
            newToast.className = "toast";
            newToast.setAttribute('role', 'alert');
            newToast.setAttribute('aria-live', 'assertive');
            newToast.innerHTML = '<i class="fas fa-check-circle" aria-hidden="true"></i><span id="toastMessage"></span>';
            document.body.appendChild(newToast);
        }

        const currentToast = document.getElementById("toastNotification");
        const currentToastMessage = document.getElementById("toastMessage");

        currentToast.className = `toast ${type}`;
        currentToastMessage.textContent = message;
        currentToast.classList.add("show");

        setTimeout(() => {
          currentToast.classList.remove("show");
        }, 3000);
      }

      function showLoading(show) {
        const loadingOverlay = document.getElementById("loadingOverlay");
        if (show) {
          loadingOverlay.classList.add("active");
        } else {
          loadingOverlay.classList.remove("active");
        }
      }

      function renderCart() {
        showLoading(true);

        // Simulate loading delay for demo purposes
        setTimeout(() => {
          let cart = JSON.parse(localStorage.getItem("cart")) || [];
          const cartContainer = document.getElementById("cartContents");
          const cartSummary = document.getElementById("cartSummary");
          const cartCounter = document.getElementById("cartCounter");
          const cartCounterMobile = document.getElementById("cartCounterMobile");


          // Update cart counter (desktop)
          if (cartCounter) {
            const itemCount = cart.reduce((total, item) => total + item.qty, 0);
            cartCounter.textContent = itemCount;
            cartCounter.setAttribute(
              "aria-label",
              `${itemCount} items in cart`
            );
          }
          // Update cart counter (mobile)
          if (cartCounterMobile) {
            const itemCount = cart.reduce((total, item) => total + item.qty, 0);
            cartCounterMobile.textContent = itemCount;
            cartCounterMobile.setAttribute(
              "aria-label",
              `${itemCount} items in cart`
            );
          }


          if (cart.length === 0) {
            cartContainer.innerHTML = `
              <div class="cart-empty">
                <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added any items to your cart yet.</p>
                <a href="index.php" class="btn btn-primary">
                  <i class="fas fa-arrow-left" aria-hidden="true"></i> Continue Shopping
                </a>
              </div>
            `;
            cartSummary.style.display = "none";
            showLoading(false);
            return;
          }

          // Calculate totals
          const subtotal = cart.reduce(
            (sum, item) => sum + item.price * item.qty,
            0
          );
          const shipping = subtotal > 50 ? 0 : 5.99; // Free shipping over $50
          const tax = subtotal * 0.08; // 8% tax
          const discount = 0; // Will be updated if promo code applied
          const total = subtotal + shipping + tax - discount;

          // Render cart items
          cartContainer.innerHTML = `
            <table class="cart-table">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th><span class="sr-only">Actions</span></th>
                </tr>
              </thead>
              <tbody>
                ${cart
                  .map(
                    (item, index) => `
                  <tr>
                    <td data-label="Product">
                      <div class="cart-product">
                        <img src="${item.image}" alt="${
                      item.name
                    }" class="cart-img" loading="lazy">
                        <div>
                          <div class="product-name">${item.name}</div>
                          <div class="product-sku">SKU: ${
                            item.id || "N/A"
                          }</div>
                        </div>
                      </div>
                    </td>
                    <td data-label="Price" class="price">$${item.price.toFixed(
                      2
                    )}</td>
                    <td data-label="Quantity">
                      <div class="qty-control">
                        <button class="qty-btn" onclick="updateQty(${index}, -1)" aria-label="Decrease quantity">
                          <span aria-hidden="true">-</span>
                        </button>
                        <input 
                          type="number" 
                          class="qty-input" 
                          value="${item.qty}" 
                          min="1"
                          aria-label="Quantity"
                          onchange="updateQtyInput(${index}, this.value)"
                        >
                        <button class="qty-btn" onclick="updateQty(${index}, 1)" aria-label="Increase quantity">
                          <span aria-hidden="true">+</span>
                        </button>
                      </div>
                    </td>
                    <td data-label="Total" class="price">$${(
                      item.price * item.qty
                    ).toFixed(2)}</td>
                    <td>
                      <button class="remove-btn" onclick="removeFromCart(${index})" aria-label="Remove ${
                      item.name
                    } from cart">
                        <i class="fas fa-times" aria-hidden="true"></i>
                      </button>
                    </td>
                  </tr>
                `
                  )
                  .join("")}
              </tbody>
            </table>
          `;

          // Update summary
          document.getElementById(
            "subtotal"
          ).textContent = `$${subtotal.toFixed(2)}`;
          document.getElementById(
            "shipping"
          ).textContent = `$${shipping.toFixed(2)}`;
          document.getElementById("tax").textContent = `$${tax.toFixed(2)}`;
          document.getElementById(
            "discount"
          ).textContent = `-$${discount.toFixed(2)}`;
          document.getElementById("total").textContent = `$${total.toFixed(2)}`;

          cartSummary.style.display = "block";
          showLoading(false);
        }, 500); // Simulated loading delay
      }

      function updateQty(index, change) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        cart[index].qty += change;

        // Ensure quantity doesn't go below 1
        if (cart[index].qty < 1) cart[index].qty = 1;

        localStorage.setItem("cart", JSON.stringify(cart));
        renderCart();
        showToast(`Quantity updated for ${cart[index].name}`);
      }

      function updateQtyInput(index, value) {
        const newQty = parseInt(value) || 1;
        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        if (newQty < 1) {
          showToast("Quantity must be at least 1", "error");
          return;
        }

        cart[index].qty = newQty;
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCart();
        showToast(`Quantity updated for ${cart[index].name}`);
      }

      function removeFromCart(index) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        const itemName = cart[index].name;

        // Use a custom confirmation dialog instead of window.confirm
        showCustomConfirm(
            `Are you sure you want to remove ${itemName} from your cart?`,
            () => { // On confirm
                cart.splice(index, 1);
                localStorage.setItem("cart", JSON.stringify(cart));
                renderCart();
                showToast(`${itemName} removed from cart`);
            },
            () => { // On cancel
                // Do nothing or show a "cancel" toast
                showToast("Removal cancelled.", "info");
            }
        );
      }

      // Custom confirmation dialog function
      function showCustomConfirm(message, onConfirm, onCancel) {
          // Create overlay and dialog elements
          const overlay = document.createElement('div');
          overlay.style.cssText = `
              position: fixed; top: 0; left: 0; width: 100%; height: 100%;
              background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center;
              z-index: 1001;
          `;
          overlay.id = 'customConfirmOverlay';

          const dialog = document.createElement('div');
          dialog.style.cssText = `
              background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);
              text-align: center; max-width: 400px; width: 90%;
              transform: scale(0.9); opacity: 0; transition: all 0.2s ease-out;
          `;
          dialog.id = 'customConfirmDialog';

          const msgElement = document.createElement('p');
          msgElement.textContent = message;
          msgElement.style.cssText = `
              margin-bottom: 20px; font-size: 1.1rem; color: var(--secondary);
          `;

          const btnContainer = document.createElement('div');
          btnContainer.style.cssText = `
              display: flex; justify-content: center; gap: 10px;
          `;

          const confirmBtn = document.createElement('button');
          confirmBtn.textContent = 'Yes, Remove';
          confirmBtn.className = 'btn btn-primary';
          confirmBtn.style.backgroundColor = 'var(--danger)'; /* Make "Yes" red */
          confirmBtn.style.borderColor = 'var(--danger-dark)';

          const cancelBtn = document.createElement('button');
          cancelBtn.textContent = 'Cancel';
          cancelBtn.className = 'btn btn-outline';

          btnContainer.appendChild(confirmBtn);
          btnContainer.appendChild(cancelBtn);
          dialog.appendChild(msgElement);
          dialog.appendChild(btnContainer);
          overlay.appendChild(dialog);
          document.body.appendChild(overlay);

          // Animate in
          setTimeout(() => {
              dialog.style.transform = 'scale(1)';
              dialog.style.opacity = '1';
          }, 10);

          // Event listeners
          confirmBtn.addEventListener('click', () => {
              onConfirm();
              document.body.removeChild(overlay);
          });
          cancelBtn.addEventListener('click', () => {
              if (onCancel) onCancel();
              document.body.removeChild(overlay);
          });
          overlay.addEventListener('click', (e) => { // Close if click outside dialog
              if (e.target === overlay) {
                  if (onCancel) onCancel();
                  document.body.removeChild(overlay);
              }
          });
      }


      function applyPromo() {
        const promoCode = document.getElementById("promoCode").value.trim();
        if (!promoCode) {
          showToast("Please enter a promo code", "error");
          return;
        }

        // In a real implementation, you would validate the promo code here
        // For demo purposes, we'll accept any non-empty code
        showToast(`Promo code "${promoCode}" applied! (Demo)`);

        // Here you would typically calculate discount and update the summary
        // For now, we'll just show the toast
      }

      function goToCheckout() {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        if (cart.length === 0) {
          showToast(
            "Your cart is empty. Please add items before checkout.",
            "error"
          );
          return;
        }

        showLoading(true);
        // Simulate loading before redirect
        setTimeout(() => {
          window.location.href = "checkout.php";
        }, 1000);
      }

      // Expose functions to global scope for HTML onclick attributes
      // These are not ideal for production, consider using event listeners
      window.updateQty = updateQty;
      window.updateQtyInput = updateQtyInput;
      window.removeFromCart = removeFromCart;
      window.applyPromo = applyPromo;
      window.goToCheckout = goToCheckout;
    </script>
  </body>
</html>
