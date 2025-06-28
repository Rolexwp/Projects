<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Orders - Brand Bazaar</title>
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

      .order-list {
        display: flex;
        flex-direction: column;
        gap: 28px;
      }

      .order-card {
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 13px;
        border-left: 6px solid var(--primary-color);
        position: relative;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
      }

      .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 28px -8px #0a45a64a;
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

      .order-products-summary { /* New style for product summary */
        font-size: 0.98rem;
        color: var(--text-light);
        margin-top: -5px;
      }

      .order-total {
        text-align: right;
        font-size: 1.12rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-top: 8px;
      }

      .order-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
      }

      .order-actions .btn {
        padding: 8px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.2s ease;
      }

      .order-actions .btn-primary {
        background-color: var(--primary-color);
        color: #fff;
      }

      .order-actions .btn-primary:hover {
        background-color: #083c92;
      }

      .no-orders {
        text-align: center;
        color: #888;
        font-size: clamp(1.1rem, 4vw, 1.3rem);
        margin: 90px 0 60px;
        font-weight: 600;
      }

      .no-orders a {
        color: var(--primary-color);
        text-decoration: underline;
        font-weight: 500;
        display: inline-block;
        margin-top: 10px;
        transition: color 0.2s ease;
      }

      .no-orders a:hover {
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
              <a href="logout.php">Logout</a>
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

    <main>
      <section class="section">
        <h2>My Orders</h2>
        <button
          id="clearOrdersBtn"
          style="
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
          "
        >
          Clear All Orders
        </button>
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
      // Utility functions (consistent with other pages)
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
      };

      // Order rendering component
      const orderRenderer = {
        // Render loading state
        renderLoading: () => {
          return `<div class="loading"><div class="loading-spinner"></div></div>`;
        },

        // Render empty state
        renderEmpty: () => {
          return `
            <div class="no-orders">
              <i class="fas fa-box"></i> You have not placed any orders yet.<br>
              <a href="index.php">Shop now</a>
            </div>
          `;
        },

        // Render order list
        renderOrders: (orders) => {
          if (!orders.length) return orderRenderer.renderEmpty();

          return `
            <div class="order-list">
              ${orders
                .map((order, idx) => orderRenderer.renderOrder(order, idx))
                .join("")}
            </div>
          `;
        },

        // Render single order summary for the list
        renderOrder: (order, idx) => {
          const orderDate = order.time ? utils.formatDate(order.time) : "";
          const productSummary = (order.cart && order.cart.length > 0)
            ? order.cart.map(p => utils.escapeHtml(p.name || 'Product')).join(', ')
            : 'No items';

          return `
            <div class="order-card">
              <div class="order-header">
                <span class="order-id">
                  <i class="fas fa-receipt icon"></i>
                  Order #${utils.escapeHtml(order.id || idx + 1)}
                </span>
                <span class="order-status">
                  <i class="fas fa-check-circle icon"></i>
                  ${utils.escapeHtml(order.status || 'Placed')}
                </span>
                <span class="order-date">
                  <i class="fas fa-calendar-day icon"></i>
                  ${orderDate}
                </span>
              </div>

              <div class="order-products-summary">
                Items: ${productSummary}
              </div>

              <div class="order-total">
                Order Total: ${utils.formatCurrency(order.total || 0)}
              </div>

              <div class="order-actions">
                <a href="order-details.php?id=${utils.escapeHtml(order.id || idx + 1)}" class="btn btn-primary">
                  View Details <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          `;
        },
      };

      // Main application
      document.addEventListener("DOMContentLoaded", () => {
        const orderDetailsEl = document.getElementById("orderDetails");
        const clearOrdersBtn = document.getElementById("clearOrdersBtn");

        // Initial loading state
        orderDetailsEl.innerHTML = orderRenderer.renderLoading();

        // Simulate loading delay (remove in production)
        setTimeout(() => {
          try {
            const orders = utils.getOrders();
            // Reverse the orders array to show most recent first
            const reversedOrders = [...orders].reverse();
            orderDetailsEl.innerHTML = orderRenderer.renderOrders(reversedOrders);
          } catch (error) {
            console.error("Error rendering orders:", error);
            orderDetailsEl.innerHTML = `
              <div class="no-orders">
                <i class="fas fa-exclamation-triangle"></i>
                Failed to load orders. Please try again later.
              </div>
            `;
          }
        }, 500); // Simulate network delay

        // Add event listener for the clear orders button
        if (clearOrdersBtn) {
          clearOrdersBtn.addEventListener("click", () => {
            if (confirm("Are you sure you want to clear all your order history? This action cannot be undone.")) {
              localStorage.removeItem("orders");
              window.location.reload();
            }
          });
        }
      });
    </script>
    <script src="main.js"></script>
  </body>
</html>