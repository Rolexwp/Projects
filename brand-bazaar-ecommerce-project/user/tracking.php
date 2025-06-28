<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Tracking - Brand Bazaar</title>
    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <style>
      body {
        background: #f6f8fb;
        font-family: "Segoe UI", "Roboto", Arial, sans-serif;
        margin: 0;
        color: #222;
      }
      .container {
        max-width: 600px;
        margin: 90px auto 0 auto; /* Adjusted margin-top for fixed navbar */
        padding: 0 20px 60px 20px;
      }
      .tracking-title {
        font-size: 2rem;
        color: #0a45a6;
        font-weight: 800;
        text-align: center;
        margin-bottom: 16px;
        letter-spacing: 0.01em;
        animation: fadeInDown 0.6s ease-out;
      }
      .order-select-box {
        margin: 0 auto 32px auto;
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: center;
        animation: fadeIn 0.8s ease-out;
      }
      .order-select-box select {
        padding: 9px 16px;
        border-radius: 6px;
        border: 1.2px solid #c9e0fc;
        font-size: 1.1rem;
        color: #0a45a6;
        background: #fafdff;
        font-weight: 600;
        transition: all 0.3s ease;
        appearance: none; /* Remove default dropdown arrow */
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%20viewBox%3D%220%200%20292.4%20292.4%22%3E%3Cpath%20fill%3D%22%230a45a6%22%20d%3D%22M287%2069.9a14.4%2014.4%200%200%200-20.4%200L146.2%20190.1%2025.8%2069.9A14.4%2014.4%200%200%200%205.4%2090.3l120.8%20120.8a14.4%2014.4%200%200%200%2020.4%200L287%2090.3a14.4%2014.4%200%200%200%200-20.4z%22%2F%3E%3C%2Fsvg%3E');
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px;
        padding-right: 30px; /* Make space for the custom arrow */
      }
      .order-select-box select:hover {
        border-color: #0a45a6;
        box-shadow: 0 0 0 3px rgba(10, 69, 166, 0.1);
      }
      /* Style for selected option */
      .order-select-box select option:checked {
          background-color: #eaf1fb;
          color: #0a45a6;
          font-weight: 700;
      }

      .order-info {
        background: #fff;
        border-radius: 13px;
        box-shadow: 0 2px 16px -8px #0a45a61a;
        padding: 1.1rem 1.6rem 1.5rem 1.6rem;
        margin-bottom: 32px;
        animation: slideUp 0.5s ease-out;
        border-left: 5px solid #0a45a6; /* Unique style */
      }
      .order-details-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 1.08rem;
        color: #444;
        align-items: center; /* Align items in rows */
      }
      .order-details-row:last-of-type {
          margin-bottom: 0;
      }
      .order-details-row span i {
          margin-right: 8px;
          color: #0a45a6;
      }
      .order-info .product-list { /* New style for product list */
          margin-top: 10px;
          border-top: 1px dashed #e0e0e0;
          padding-top: 10px;
      }
      .order-info .product-item {
          display: flex;
          align-items: center;
          gap: 10px;
          margin-bottom: 8px;
          font-size: 0.95rem;
      }
      .order-info .product-item:last-child {
          margin-bottom: 0;
      }
      .order-info .product-item img {
          width: 40px;
          height: 40px;
          object-fit: contain;
          border-radius: 5px;
          border: 1px solid #eee;
      }
      .order-info .product-item-details {
          flex-grow: 1;
      }
      .order-info .product-item-details .product-name {
          font-weight: 600;
          color: #222;
      }
      .order-info .product-item-details .product-qty {
          font-size: 0.85rem;
          color: #777;
      }
      .order-info .product-item-price {
          font-weight: 700;
          color: #0a45a6;
          white-space: nowrap;
      }

      .tracking-steps {
        display: flex;
        flex-direction: column;
        gap: 35px;
        margin: 32px auto 18px auto;
        max-width: 480px;
      }
      .step {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        position: relative;
        min-height: 54px;
        opacity: 0;
        transform: translateX(-20px);
        animation: fadeInRight 0.5s ease-out forwards;
      }
      .step:nth-child(1) {
        animation-delay: 0.2s;
      }
      .step:nth-child(2) {
        animation-delay: 0.4s;
      }
      .step:nth-child(3) {
        animation-delay: 0.6s;
      }
      .step:nth-child(4) {
        animation-delay: 0.8s;
      }
      .step:nth-child(5) {
        animation-delay: 1s;
      }
      .step .icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #eaf3ff;
        border: 2.5px solid #0a45a6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #0a45a6;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
      }
      .step.completed .icon {
        background: #0a45a6;
        color: #fff;
        border-color: #0a45a6;
        animation: pulse 0.5s ease-out;
      }
      .step .line {
        position: absolute;
        left: 18px;
        top: 38px;
        width: 3px;
        height: 56px;
        background: #c9e0fc;
        z-index: 0;
        transform-origin: top;
        transform: scaleY(0);
        animation: growLine 0.5s ease-out forwards;
        animation-delay: 0.5s;
      }
      .step:last-child .line {
        display: none;
      }
      .step-details {
        flex: 1;
        margin-top: 3px;
      }
      .step-title {
        font-weight: 700;
        color: #0a45a6;
        font-size: 1.13rem;
      }
      .step-desc {
        color: #555;
        font-size: 1.01rem;
        margin-top: 2px;
      }
      .step-date {
        color: #888;
        font-size: 0.93rem;
        margin-top: 4px;
      }
      .no-orders {
        text-align: center;
        color: #888;
        font-size: 1.2rem;
        margin: 30px 0 60px 0;
        font-weight: 600;
        animation: fadeIn 0.6s ease-out;
      }

      /* Keyframe Animations */
      @keyframes fadeInDown {
        from {
          opacity: 0;
          transform: translateY(-20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      @keyframes fadeIn {
        from {
          opacity: 0;
        }
        to {
          opacity: 1;
        }
      }
      @keyframes slideUp {
        from {
          opacity: 0;
          transform: translateY(20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      @keyframes fadeInRight {
        from {
          opacity: 0;
          transform: translateX(-20px);
        }
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }
      @keyframes pulse {
        0% {
          transform: scale(1);
        }
        50% {
          transform: scale(1.1);
        }
        100% {
          transform: scale(1);
        }
      }
      @keyframes growLine {
        from {
          transform: scaleY(0);
        }
        to {
          transform: scaleY(1);
        }
      }

      @media (max-width: 700px) {
        .container {
          padding: 10px 2vw 40px 2vw;
        }
        .tracking-title {
          font-size: 1.25rem;
        }
        .order-info {
          padding: 1.1rem 0.5rem 1.3rem 0.9rem;
        }
        .tracking-steps {
          gap: 22px;
        }
        .step .icon {
          width: 27px;
          height: 27px;
          font-size: 1.07rem;
        }
        .step .line {
          left: 12px;
          top: 27px;
          height: 32px;
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
      <div class="tracking-title">
        <i class="fas fa-shipping-fast"></i> Track My Order
      </div>
      <div class="order-select-box">
        <label for="orderSelect"><b>Select Order:</b></label>
        <select id="orderSelect"></select>
      </div>
      <div id="orderInfo"></div>
      <div id="trackingSteps"></div>
      <div id="noOrders" class="no-orders" style="display: none">
        <i class="fas fa-box"></i> You have not placed any orders yet.
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
          <a href="logout.php" id="mbnavLogoutDropdown">Logout</a>
        </div>
      </div>
    </nav>

    <script>
      // Utility functions (moved to top for better organization)
      const utils = {
        // Format date
        formatDate: (dateStr) => {
          if (!dateStr) return "";
          const d = new Date(dateStr);
          return isNaN(d.getTime()) ? d.toLocaleDateString("en-GB") : dateStr; // Keep original if invalid date
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
      };

      // Dummy tracking status generator for demo
      function getTrackingSteps(order) {
        // Ensure order.time is a valid date string or Date object
        const created = new Date(order.time || Date.now());

        let steps = [
          {
            title: "Ordered",
            desc: "We have received your order.",
            icon: "fa-clipboard-check",
            done: true,
            date: created.toLocaleString(),
          },
          {
            title: "Packed",
            desc: "Your items have been packed and ready to ship.",
            icon: "fa-box-open",
            done:
              order.status &&
              ["Packed", "Shipped", "Out for Delivery", "Delivered"].includes(
                order.status
              ),
            date: order.packedTime
              ? new Date(order.packedTime).toLocaleString()
              : "",
          },
          {
            title: "Shipped",
            desc: "Order has been shipped from warehouse.",
            icon: "fa-truck",
            done:
              order.status &&
              ["Shipped", "Out for Delivery", "Delivered"].includes(
                order.status
              ),
            date: order.shippedTime
              ? new Date(order.shippedTime).toLocaleString()
              : "",
          },
          {
            title: "Out for Delivery",
            desc: "Courier is out to deliver your order.",
            icon: "fa-motorcycle",
            done:
              order.status &&
              ["Out for Delivery", "Delivered"].includes(order.status),
            date: order.outForDeliveryTime
              ? new Date(order.outForDeliveryTime).toLocaleString()
              : "",
          },
          {
            title: "Delivered",
            desc: "Order delivered successfully.",
            icon: "fa-check-circle",
            done: order.status && order.status === "Delivered",
            date: order.deliveredTime
              ? new Date(order.deliveredTime).toLocaleString()
              : "",
          },
        ];
        return steps;
      }

      function renderOrderSelect(orders) {
        const orderSelect = document.getElementById("orderSelect");
        orderSelect.innerHTML = "";
        // Render orders in reverse to show recent on top of the dropdown
        orders.slice().reverse().forEach((order, originalIdx) => {
          // Find the original index for the value
          const idx = orders.indexOf(order);
          let orderDate = "";
          if (order.time) {
            let d = new Date(order.time);
            orderDate = d.toLocaleDateString("en-GB");
          }
          orderSelect.innerHTML += `<option value="${idx}">Order #${
            order.id || idx + 1
          } (${orderDate})</option>`;
        });
      }

      function renderOrderInfo(order, orderDisplayId) {
        let orderDate = order.time ? new Date(order.time).toLocaleString() : "";
        let items = order.cart
          .map(
            (prod) =>
              `<div class="product-item">
                <img src="${prod.img || ''}" alt="${prod.name || 'Product'}" loading="lazy">
                <div class="product-item-details">
                    <div class="product-name">${prod.name || 'Unknown Product'}</div>
                    <div class="product-qty">Qty: ${prod.qty || 1}</div>
                </div>
                <div class="product-item-price">${utils.formatCurrency(prod.price * (prod.qty || 1))}</div>
            </div>`
          )
          .join("");
        document.getElementById("orderInfo").innerHTML = `
          <div class="order-info">
            <div class="order-details-row"><span><b>Order #${
              orderDisplayId // Use the consistent order ID
            }</b></span> <span>${orderDate}</span></div>
            <div class="order-details-row">
              <span><i class="fas fa-user"></i> <b>${
                order.address ? order.address.name : ""
              }</b></span>
              <span><i class="fas fa-phone"></i> ${
                order.address ? order.address.phone : ""
              }</span>
            </div>
            <div class="order-details-row"><i class="fas fa-map-marker-alt"></i> ${
              order.address ? order.address.address : ""
            }</div>
            <div class="order-details-row"><span>Status:</span> <span><b>${order.status || 'Placed'}</b></span></div>
            <div class="product-list">
                <div class="order-details-row" style="margin-bottom: 5px;"><span>Items:</span> <span></span></div>
                ${items}
            </div>
            <div class="order-details-row"><span>Total:</span> <span style="color:#0a45a6;font-weight:700;">${
              utils.formatCurrency(order.total)
            }</span></div>
            <div class="order-details-row"><span>Payment:</span>
              <span>${
                order.paymentMethod === "cod"
                  ? "Cash on Delivery (COD)"
                  : order.paymentMethod === "upi"
                  ? "UPI / Wallet / Net Banking"
                  : "Debit / Credit Card"
              }</span>
            </div>
          </div>
        `;
      }

      function renderTrackingSteps(order) {
        const steps = getTrackingSteps(order);
        let html = `<div class="tracking-steps">`;
        steps.forEach((step, i) => {
          const completed = step.done;
          html += `<div class="step${completed ? " completed" : ""}">
            <span class="icon"><i class="fas ${step.icon}"></i></span>
            ${i < steps.length - 1 ? `<span class="line"></span>` : ""}
            <div class="step-details">
              <div class="step-title">${step.title}</div>
              <div class="step-desc">${step.desc}</div>
              ${step.date ? `<div class="step-date">${step.date}</div>` : ""}
            </div>
          </div>`;
        });
        html += `</div>`;
        document.getElementById("trackingSteps").innerHTML = html;
      }

      function renderTracking() {
        const orders = utils.getOrders(); // Use utils.getOrders()
        if (!orders.length) {
          document.getElementById("noOrders").style.display = "";
          document.getElementById("orderSelect").style.display = "none";
          document.getElementById("orderInfo").innerHTML = "";
          document.getElementById("trackingSteps").innerHTML = "";
          return;
        }
        document.getElementById("noOrders").style.display = "none";
        document.getElementById("orderSelect").style.display = "";

        // Determine the initial selected order (most recent by default)
        const initialIdx = orders.length > 0 ? orders.length - 1 : 0;
        renderOrderSelect(orders);
        document.getElementById("orderSelect").value = initialIdx; // Set selected value

        let idx = +document.getElementById("orderSelect").value;
        const order = orders[idx];
        const orderDisplayId = order.id || idx + 1; // Use order.id or fallback to index + 1

        renderOrderInfo(order, orderDisplayId);
        renderTrackingSteps(order);

        document.getElementById("orderSelect").onchange = function () {
          let selectedIdx = +this.value;
          const selectedOrder = orders[selectedIdx];
          const selectedOrderDisplayId = selectedOrder.id || selectedIdx + 1;
          renderOrderInfo(selectedOrder, selectedOrderDisplayId);
          renderTrackingSteps(selectedOrder);
        };
      }

      renderTracking();
    </script>
    <script src="main.js"></script>
  </body>
</html>