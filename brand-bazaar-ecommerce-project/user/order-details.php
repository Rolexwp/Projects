<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Details - Brand Bazaar</title>
    <meta
      name="description"
      content="View your order history and details with Brand Bazaar"
    />

    <link rel="preload" href="css/style.css" as="style" />
    <link
      rel="preload"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      as="style"
    />

    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />

    <style>
      :root {
        --primary-color: #0a45a6;
        --primary-light: #eaf1fb;
        --text-color: #222;
        --text-light: #555;
        --text-lighter: #777;
        --bg-gradient: linear-gradient(135deg, #e6f0ff 0%, #fff 100%);
        --card-shadow: 0 4px 24px -8px #0a45a62a;
        --border-radius: 18px;
        --mobile-breakpoint: 700px;
      }

      body {
        background: var(--bg-gradient);
        font-family: "Segoe UI", "Roboto", Arial, sans-serif;
        margin: 0;
        color: var(--text-color);
        line-height: 1.5;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
      }

      main {
        flex: 1;
      }

      .section {
        max-width: 900px;
        margin: 36px auto 0 auto;
        padding: 0 2vw;
        box-sizing: border-box;
      }

      h2 {
        color: var(--primary-color);
        font-size: clamp(1.5rem, 5vw, 2rem);
        font-weight: 800;
        margin-bottom: 28px;
        letter-spacing: 0.01em;
        text-align: center;
      }

      .order-card { /* Styles for a single order card */
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 13px;
        border-left: 6px solid var(--primary-color);
        position: relative;
      }

      .order-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
      }

      .order-id {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.08rem;
        letter-spacing: 0.01em;
      }

      .order-date {
        color: var(--text-light);
        font-size: 0.98rem;
      }

      .order-status {
        padding: 5px 16px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1rem;
        background: var(--primary-light);
        color: var(--primary-color);
        border: 1.5px solid var(--primary-color);
        margin-left: 10px;
      }

      .order-products {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 6px;
      }

      .product-row {
        display: flex;
        align-items: center;
        gap: 18px;
        background: #f7f9fc;
        border-radius: 10px;
        padding: 10px;
      }

      .product-img {
        width: 54px;
        height: 54px;
        object-fit: contain;
        border-radius: 8px;
        background: #fff;
        border: 1px solid #e0e0e0;
      }

      .product-info {
        flex: 1;
        min-width: 0; /* Prevent flex item overflow */
      }

      .product-title {
        font-size: 1.07rem;
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .product-qty {
        color: var(--text-lighter);
        font-size: 0.97rem;
      }

      .product-price {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.04rem;
        margin-left: 10px;
        white-space: nowrap;
      }

      .order-total {
        text-align: right;
        font-size: 1.12rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-top: 8px;
      }

      .order-address {
        color: var(--text-light);
        font-size: 1rem;
        margin-top: 6px;
        margin-bottom: 2px;
      }

      .order-payment {
        color: var(--text-lighter);
        font-size: 0.98rem;
        margin-top: 0;
        margin-bottom: 0;
      }

      .no-order-found {
        text-align: center;
        color: #888;
        font-size: clamp(1.1rem, 4vw, 1.3rem);
        margin: 90px 0 60px;
        font-weight: 600;
      }

      .no-order-found a {
        color: var(--primary-color);
        text-decoration: underline;
        font-weight: 500;
        display: inline-block;
        margin-top: 10px;
        transition: color 0.2s ease;
      }

      .no-order-found a:hover {
        color: #082b6b;
      }

      .icon {
        margin-right: 6px;
      }

      /* Loading state */
      .loading {
        display: flex;
        justify-content: center;
        padding: 40px;
      }

      .loading-spinner {
        border: 4px solid rgba(10, 69, 166, 0.1);
        border-radius: 50%;
        border-top: 4px solid var(--primary-color);
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
      }

      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }

      /* Responsive styles */
      @media (max-width: 700px) {
        .section {
          padding: 0 4vw;
        }

        .order-card {
          padding: 1.1rem 0.9rem;
        }

        .product-row {
          flex-direction: column;
          align-items: flex-start;
          gap: 8px;
        }

        .order-header {
          flex-direction: column;
          align-items: flex-start;
          gap: 4px;
        }

        .order-status {
          margin-left: 0;
          margin-top: 4px;
        }

        .order-total {
          text-align: left;
        }

        .product-price {
          margin-left: 0;
          align-self: flex-end;
        }
      }
    </style>
  </head>
  <body>
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

          <!-- Logout Icon -->
<a href="logout.php" class="nav-icon" id="logoutIcon" title="Logout">
    <i class="fas fa-sign-out-alt"></i>
</a>
        </div>
      </div>
    </nav>
    <main>
      <section class="section">
        <h2>Order Details</h2>
        <div id="orderDetails">
          <div class="loading">
            <div class="loading-spinner"></div>
          </div>
        </div>
      </section>
    </main>
    <footer>
      <p>
        © 2025 Brand Bazaar. All rights reserved. |
        <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a> |
        <a href="#">Shipping Policy</a>
      </p>
    </footer>

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
          <a href="logout.php" id="mbnavLogoutDropdown">Logout</a>
        </div>
      </div>
    </nav>

    <script>
      // Utility functions (consistent with myorders.php and tracking.php)
      const utils = {
        // Format date
        formatDate: (dateStr) => {
          if (!dateStr) return "";
          const d = new Date(dateStr);
          return isNaN(d.getTime()) ? dateStr : d.toLocaleDateString("en-GB");
        },

        // Format currency
        formatCurrency: (val) => {
          return "₹" + Number(val).toLocaleString("en-IN");
        },

        // Get orders from localStorage with error handling
        getOrders: () => {
          try {
            return JSON.parse(localStorage.getItem("orders")) || [];
          } catch (error) {
            console.error("Error reading orders from localStorage:", error);
            return [];
          }
        },

        // Safe HTML escaping for user-generated content
        escapeHtml: (unsafe) => {
          if (typeof unsafe !== 'string') return unsafe;
          return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
        },
        // Get payment method text
        getPaymentMethodText: (method) => {
          switch (method) {
            case "cod":
              return "Cash on Delivery (COD)";
            case "upi":
              return "UPI / Wallet / Net Banking";
            case "card":
              return "Debit / Credit Card";
            default:
              return "N/A";
          }
        },
      };

      // Function to render a single order's details
      function renderSingleOrderDetails(order) {
        if (!order) {
          return `
            <div class="no-order-found">
              <i class="fas fa-exclamation-circle"></i> Order not found.<br>
              <a href="myorders.php">View all orders</a>
            </div>
          `;
        }

        const orderDate = utils.formatDate(order.time);
        const paymentMethod = utils.getPaymentMethodText(order.paymentMethod);

        return `
          <div class="order-card">
            <div class="order-header">
              <span class="order-id">
                <i class="fas fa-receipt icon"></i> Order #${utils.escapeHtml(order.id || 'N/A')}
              </span>
              <span class="order-status">
                <i class="fas fa-check-circle icon"></i> ${utils.escapeHtml(order.status || 'Placed')}
              </span>
              <span class="order-date">
                <i class="fas fa-calendar-day icon"></i> ${orderDate}
              </span>
            </div>
            <div class="order-products">
              ${(order.cart && order.cart.length > 0)
                ? order.cart
                    .map(
                      (prod) => `
                <div class="product-row">
                  <img src="${utils.escapeHtml(prod.img || '')}" class="product-img" alt="${utils.escapeHtml(prod.name || 'Product Image')}" onerror="this.onerror=null;this.src='https://placehold.co/54x54/E3E9F2/333333?text=N/A';">
                  <div class="product-info">
                    <div class="product-title">${utils.escapeHtml(prod.name || 'Unknown Product')}</div>
                    <div class="product-qty">Qty: ${prod.qty || 1}</div>
                  </div>
                  <div class="product-price">${utils.formatCurrency((prod.price || 0) * (prod.qty || 1))}</div>
                </div>
              `
                    )
                    .join("")
                : '<div style="text-align:center;color:#888;padding:10px;">No items in this order.</div>'}
            </div>
            <div class="order-total">
              Total: ${utils.formatCurrency(order.total || 0)}
            </div>
            <div class="order-address">
              <span class="icon fas fa-map-marker-alt"></span> Deliver to: <br>
              ${
                order.address
                  ? `<b>${utils.escapeHtml(order.address.name || '')}</b><br>${utils.escapeHtml(order.address.address || '')}<br>${utils.escapeHtml(order.address.phone || '')}`
                  : "Address not available"
              }
            </div>
            <div class="order-payment">
              <span class="icon fas fa-credit-card"></span> Payment Method: ${paymentMethod}
            </div>
          </div>
        `;
      }

      // Main application logic for order-details.php
      document.addEventListener("DOMContentLoaded", () => {
        const orderDetailsEl = document.getElementById("orderDetails");
        orderDetailsEl.innerHTML = `
          <div class="loading">
            <div class="loading-spinner"></div>
          </div>
        `; // Show loading spinner initially

        // Simulate a small delay for content loading
        setTimeout(() => {
          const urlParams = new URLSearchParams(window.location.search);
          const orderId = urlParams.get('id'); // Get order ID from URL parameter
          const orders = utils.getOrders();
          let targetOrder = null;

          if (orderId) {
            // Find the order by its 'id' or fallback to index if 'id' is not a perfect match
            targetOrder = orders.find(order => String(order.id) === orderId) || orders[parseInt(orderId) -1]; // Fallback to index if order.id isn't strict match
          } else if (orders.length > 0) {
            // If no ID is specified, default to the most recent order for demonstration
            targetOrder = orders[orders.length - 1];
            console.warn("No order ID provided. Displaying the most recent order. Use ?id=<orderId> to specify.");
          }

          orderDetailsEl.innerHTML = renderSingleOrderDetails(targetOrder);
        }, 300); // Simulate network delay
      });
    </script>
    <script src="main.js"></script>
  </body>
</html>