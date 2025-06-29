<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Purchases - Brand Bazaar</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <link rel="stylesheet" href="css/style.css" />
    <style>
      body {
        background: #f6f8fb;
        font-family: "Segoe UI", "Roboto", Arial, sans-serif;
        margin: 0;
        color: #222;
      }
      .container {
        max-width: 900px; /* Adjusted for consistency with myorders.php */
        margin: 40px auto 0 auto; /* Adjusted for consistency */
        padding: 0 2vw; /* Adjusted for consistency */
      }
      .page-title {
        font-size: clamp(1.5rem, 5vw, 2rem); /* Adjusted for consistency */
        color: #0a45a6;
        font-weight: 800;
        text-align: center;
        margin: 0 0 28px 0; /* Adjusted for consistency */
        letter-spacing: 0.01em;
      }
      .purchases-list {
        display: flex;
        flex-direction: column;
        gap: 28px;
        margin-top: 20px; /* Added margin-top */
      }
      .purchase-card { /* Renamed from .order-card for clarity, kept similar styles */
        background: #fff;
        border-radius: 18px; /* Consistent border-radius */
        box-shadow: 0 4px 24px -8px rgba(10, 69, 166, 0.16); /* Consistent shadow */
        padding: 1.5rem; /* Consistent padding */
        display: flex;
        flex-direction: column;
        gap: 13px;
        border-left: 6px solid #0a45a6; /* Consistent border-left */
        position: relative;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
      }

      .purchase-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 28px -8px rgba(10, 69, 166, 0.29);
      }

      .purchase-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
      }

      .purchase-id {
        font-weight: 700;
        color: #0a45a6;
        font-size: 1.08rem;
        letter-spacing: 0.01em;
      }

      .purchase-date {
        color: #555;
        font-size: 0.98rem;
      }

      .purchase-status {
        padding: 5px 16px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1rem;
        background: #eaf1fb;
        color: #0a45a6;
        border: 1.5px solid #0a45a6;
        margin-left: 10px;
      }

      .purchase-products-summary { /* New style for product summary */
        font-size: 0.98rem;
        color: #555;
        margin-top: -5px;
      }

      .purchase-summary { /* Renamed for clarity */
        text-align: right;
        font-size: 1.12rem;
        font-weight: 700;
        color: #0a45a6;
        margin-top: 8px;
      }

      .purchase-actions { /* New action container */
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
      }

      .purchase-actions .btn {
        padding: 8px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.2s ease;
        background-color: #0a45a6;
        color: #fff;
      }

      .purchase-actions .btn:hover {
        background-color: #083c92;
      }

      .no-purchases {
        text-align: center;
        color: #888;
        font-size: clamp(1.1rem, 4vw, 1.3rem);
        margin: 90px 0 60px;
        font-weight: 600;
      }

      .no-purchases a {
        color: #0a45a6;
        text-decoration: underline;
        font-weight: 500;
        display: inline-block;
        margin-top: 10px;
        transition: color 0.2s ease;
      }

      .no-purchases a:hover {
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
        border-top: 4px solid #0a45a6;
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
        .container {
          padding: 0 4vw;
        }

        .purchase-card {
          padding: 1.1rem 0.9rem;
        }

        .purchase-header {
          flex-direction: column;
          align-items: flex-start;
          gap: 4px;
        }

        .purchase-status {
          margin-left: 0;
          margin-top: 4px;
        }

        .purchase-summary {
          text-align: left;
        }

        .purchase-actions {
          justify-content: flex-start;
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

    <div class="container">
      <h2 class="page-title">My Purchases</h2>
      <button
        id="clearPurchasesBtn"
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
        Clear All Purchases
      </button>
      <div id="purchaseList">
        <div class="loading">
          <div class="loading-spinner"></div>
        </div>
      </div>
    </div>

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
        </div>
      </div>
    </nav>

    <script>
      // Utility functions (consistent across pages)
      const utils = {
        formatDate: (dateStr) => {
          if (!dateStr) return "";
          const d = new Date(dateStr);
          return isNaN(d.getTime()) ? dateStr : d.toLocaleDateString("en-GB");
        },
        formatCurrency: (val) => {
          return "₹" + Number(val).toLocaleString("en-IN");
        },
        getPurchases: () => {
          try {
            // Assuming purchases are stored under the 'orders' key for now
            return JSON.parse(localStorage.getItem("orders")) || [];
          } catch (error) {
            console.error("Error reading purchases from localStorage:", error);
            return [];
          }
        },
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

      // Purchase rendering component
      const purchaseRenderer = {
        renderLoading: () => {
          return `<div class="loading"><div class="loading-spinner"></div></div>`;
        },
        renderEmpty: () => {
          return `
            <div class="no-purchases">
              <i class="fas fa-box"></i> You have not made any purchases yet.<br>
              <a href="index.php">Shop now</a>
            </div>
          `;
        },
        renderPurchases: (purchases) => {
          if (!purchases.length) return purchaseRenderer.renderEmpty();

          return `
            <div class="purchases-list">
              ${purchases
                .map((purchase, idx) => purchaseRenderer.renderPurchase(purchase, idx))
                .join("")}
            </div>
          `;
        },
        renderPurchase: (purchase, idx) => {
          const purchaseDate = purchase.time ? utils.formatDate(purchase.time) : "";
          const productSummary = (purchase.cart && purchase.cart.length > 0)
            ? purchase.cart.map(p => utils.escapeHtml(p.name || 'Product')).join(', ')
            : 'No items';
          const purchaseId = utils.escapeHtml(purchase.id || idx + 1);

          return `
            <div class="purchase-card">
              <div class="purchase-header">
                <span class="purchase-id">
                  <i class="fas fa-receipt icon"></i>
                  Purchase #${purchaseId}
                </span>
                <span class="purchase-status">
                  <i class="fas fa-check-circle icon"></i>
                  ${utils.escapeHtml(purchase.status || 'Completed')}
                </span>
                <span class="purchase-date">
                  <i class="fas fa-calendar-day icon"></i>
                  ${purchaseDate}
                </span>
              </div>

              <div class="purchase-products-summary">
                Items: ${productSummary}
              </div>

              <div class="purchase-summary">
                Total: ${utils.formatCurrency(purchase.total || 0)}
              </div>

              <div class="purchase-actions">
                <a href="order-details.php?id=${purchaseId}" class="btn">
                  View Details <i class="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          `;
        },
      };

      // Main application logic for purchase.php
      document.addEventListener("DOMContentLoaded", () => {
        const purchaseListEl = document.getElementById("purchaseList");
        const clearPurchasesBtn = document.getElementById("clearPurchasesBtn");

        purchaseListEl.innerHTML = purchaseRenderer.renderLoading();

        setTimeout(() => {
          try {
            const purchases = utils.getPurchases();
            const reversedPurchases = [...purchases].reverse();
            purchaseListEl.innerHTML = purchaseRenderer.renderPurchases(reversedPurchases);
          } catch (error) {
            console.error("Error rendering purchases:", error);
            purchaseListEl.innerHTML = `
              <div class="no-purchases">
                <i class="fas fa-exclamation-triangle"></i>
                Failed to load purchases. Please try again later.
              </div>
            `;
          }
        }, 500);

        if (clearPurchasesBtn) {
          clearPurchasesBtn.addEventListener("click", () => {
            if (confirm("Are you sure you want to clear all your purchase history? This action cannot be undone.")) {
              localStorage.removeItem("orders"); // Assuming 'orders' key is used for purchases
              window.location.reload();
            }
          });
        }
      });
    </script>
  </body>
</html>