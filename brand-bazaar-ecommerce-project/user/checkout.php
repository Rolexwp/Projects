<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout - Brand Bazaar</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <link rel="stylesheet" href="css/navbar.css" />
    <link rel="stylesheet" href="css/style.css" />

    <style>
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
      }

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      }

      body {
        background: var(--light-bg);
        color: var(--secondary);
        line-height: 1.6;
      }

      .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
      }

      .page-header {
        text-align: center;
        margin: 30px 0 40px;
      }

      .page-header h1 {
        color: var(--primary);
        font-size: 2.5rem;
        margin-bottom: 10px;
      }

      .page-header p {
        color: var(--secondary);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
      }

      .checkout-container {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        margin-bottom: 50px;
      }

      .checkout-column {
        flex: 1;
        min-width: 300px;
      }

      .section-card {
        background: var(--card-bg);
        border-radius: 16px;
        box-shadow: 0 5px 20px -10px #0a45a618;
        padding: 30px;
        margin-bottom: 25px;
        border: 1px solid var(--border-color);
      }

      .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eef2f7;
      }

      .section-header i {
        background: #eaf3ff;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.2rem;
        margin-right: 15px;
      }

      .section-header h2 {
        color: var(--primary);
        font-size: 1.4rem;
        font-weight: 700;
      }

      /* Address Section */
      .address-details {
        padding: 20px;
        background: #f8fafd;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px -6px #0a45a611;
        border: 1.2px solid var(--border-color);
        line-height: 1.7;
      }

      .address-actions {
        display: flex;
        gap: 15px;
        margin-top: 10px;
      }

      .address-btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
      }

      .edit-address-btn {
        background: #eaf3ff;
        color: var(--primary);
        border: 1px solid #c9e0fc;
      }

      .edit-address-btn:hover {
        background: #d8e7ff;
      }

      .delete-address-btn {
        background: #fff0f0;
        color: var(--danger);
        border: 1px solid #ffd1d1;
      }

      .delete-address-btn:hover {
        background: #ffe0e0;
      }

      .edit-address-form {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eef2f7;
      }

      .form-group {
        margin-bottom: 20px;
      }

      .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--secondary);
      }

      .form-control {
        width: 100%;
        padding: 14px;
        border: 1.3px solid #c9e0fc;
        border-radius: 8px;
        font-size: 1rem;
        background: #fafdff;
        outline: none;
        transition: border-color 0.2s;
      }

      .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(10, 69, 166, 0.1);
      }

      .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 10px;
      }

      .btn {
        padding: 14px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1rem;
        border: none;
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

      /* Cart Section */
      .cart-items {
        display: flex;
        flex-direction: column;
        gap: 15px;
      }

      .cart-item {
        display: flex;
        align-items: center;
        padding: 15px;
        background: #f7fbff;
        border-radius: 12px;
      }

      .cart-img {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        margin-right: 20px;
        background: #e3e9f2;
        object-fit: cover;
        border: 1.2px solid #e6ecf3;
        flex-shrink: 0;
      }

      .cart-item-details {
        flex-grow: 1;
      }

      .cart-item-name {
        font-weight: 600;
        margin-bottom: 5px;
        color: var(--secondary);
      }

      .cart-item-price {
        color: var(--primary);
        font-weight: 700;
        font-size: 1.1rem;
      }

      .cart-item-quantity {
        font-size: 0.95rem;
        color: var(--text-light);
      }

      /* Order Summary */
      .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed #eef2f7;
      }

      .summary-item.total {
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--primary);
        border-bottom: none;
        padding-top: 18px;
        margin-top: 5px;
      }

      .pay-btn {
        width: 100%;
        padding: 18px;
        font-size: 1.2rem;
        background: var(--primary);
        color: #fff;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        margin-top: 25px;
        font-weight: 700;
        letter-spacing: 0.02em;
        box-shadow: 0 5px 15px -5px #0a45a622;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
      }

      .pay-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -5px #0a45a622;
      }

      /* Snackbar */
      #snackbar {
        visibility: hidden;
        min-width: 250px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 8px;
        padding: 18px;
        position: fixed;
        z-index: 99;
        left: 50%;
        bottom: 40px;
        font-size: 1.1rem;
        transform: translateX(-50%);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      }

      #snackbar.show {
        visibility: visible;
        animation: fadein 0.3s, fadeout 0.5s 2.2s;
      }

      @keyframes fadein {
        from {
          bottom: 10px;
          opacity: 0;
        }
        to {
          bottom: 40px;
          opacity: 1;
        }
      }

      @keyframes fadeout {
        from {
          bottom: 40px;
          opacity: 1;
        }
        to {
          bottom: 10px;
          opacity: 0;
        }
      }

      /* Progress Bar */
      .checkout-progress {
        display: flex;
        justify-content: space-between;
        max-width: 800px;
        margin: 0 auto 40px;
        position: relative;
      }

      .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
        flex: 1;
      }

      .step-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eaf3ff;
        color: var(--primary);
        font-size: 1.2rem;
        margin-bottom: 10px;
        border: 2px solid var(--primary);
      }

      .step-icon.active {
        background: var(--primary);
        color: white;
      }

      .step-label {
        font-weight: 600;
        color: var(--primary);
      }

      .progress-bar {
        position: absolute;
        top: 25px;
        left: 0;
        height: 4px;
        background: #eaf3ff;
        width: 100%;
        z-index: 1;
      }

      .progress-fill {
        height: 100%;
        width: 66%;
        background: var(--primary);
        transition: width 0.3s ease;
      }

      /* Responsive */
      @media (max-width: 768px) {
        .checkout-container {
          flex-direction: column;
        }

        .page-header h1 {
          font-size: 2rem;
        }

        .section-card {
          padding: 20px;
        }

        .address-actions {
          flex-direction: column;
        }

        .address-btn {
          justify-content: center;
        }

        .progress-step .step-label {
          font-size: 0.85rem;
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
              <a href="logout.php" id="desktopLogoutLink">Logout</a> <!-- Added ID -->
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

          <!-- New Logout Icon on the main navbar (for checkout.php) -->
          <a
            href="logout.php"
            class="nav-icon"
            id="mainLogoutIcon"
            title="Logout"
            style="display: none;"
          >
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </div>
      </div>
    </nav>

    <div class="container">
      <!-- Progress Bar -->
      <div class="checkout-progress">
        <div class="progress-bar">
          <div class="progress-fill"></div>
        </div>
        <div class="progress-step">
          <div class="step-icon">
            <i class="fas fa-shopping-cart"></i>
          </div>
          <span class="step-label">Cart</span>
        </div>
        <div class="progress-step">
          <div class="step-icon active">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <span class="step-label">Shipping</span>
        </div>
        <div class="progress-step">
          <div class="step-icon">
            <i class="fas fa-credit-card"></i>
          </div>
          <span class="step-label">Payment</span>
        </div>
      </div>

      <div class="page-header">
        <h1>Complete Your Purchase</h1>
        <p>
          Review your order details and shipping information before proceeding
          to payment
        </p>
      </div>

      <div class="checkout-container">
        <div class="checkout-column">
          <div class="section-card">
            <div class="section-header">
              <i class="fas fa-map-marker-alt"></i>
              <h2>Shipping Information</h2>
            </div>

            <div class="address-details" id="addressDetails">
              <p>
                <!-- Default/placeholder address, will be replaced by saved data -->
                <strong>No address saved.</strong><br />
                Please add your shipping details.
              </p>
            </div>

            <div class="address-actions" id="addressActions">
              <button
                class="address-btn edit-address-btn"
                id="editAddressBtn"
                onclick="showEditAddress()"
              >
                <i class="fas fa-edit"></i> Edit Address
              </button>
              <button
                class="address-btn delete-address-btn"
                id="deleteAddressBtn"
                onclick="deleteAddress()"
              >
                <i class="fas fa-trash-alt"></i> Delete Address
              </button>
            </div>

            <form
              class="edit-address-form"
              id="editAddressForm"
              onsubmit="saveAddress(event)"
            >
              <div class="form-group">
                <label for="inputName">Full Name</label>
                <input
                  type="text"
                  id="inputName"
                  class="form-control"
                  placeholder="John Doe"
                  required
                />
              </div>

              <div class="form-group">
                <label for="inputAddress">Shipping Address</label>
                <input
                  type="text"
                  id="inputAddress"
                  class="form-control"
                  placeholder="123 Main Street"
                  required
                />
              </div>

              <div class="form-group">
                <label for="inputPhone">Phone Number</label>
                <input
                  type="text"
                  id="inputPhone"
                  class="form-control"
                  placeholder="(123) 456-7890"
                  required
                />
              </div>

              <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                  Save Address
                </button>
                <button
                  type="button"
                  class="btn btn-outline"
                  onclick="cancelEditAddress()"
                >
                  Cancel
                </button>
              </div>
            </form>
          </div>

          <div class="section-card">
            <div class="section-header">
              <i class="fas fa-shopping-bag"></i>
              <h2>Your Items</h2>
            </div>

            <div class="cart-items" id="cartItems">
              <!-- Cart items will be loaded here -->
            </div>
          </div>
        </div>

        <div class="checkout-column">
          <div class="section-card">
            <div class="section-header">
              <i class="fas fa-receipt"></i>
              <h2>Order Summary</h2>
            </div>

            <div class="order-summary" id="orderSummary">
              <!-- Order summary will be loaded here -->
            </div>

            <button class="pay-btn" id="payBtn" onclick="gotoPaymentPage()">
              <i class="fas fa-lock"></i> Complete Payment
            </button>
          </div>
        </div>
      </div>
    </div>

    <div id="snackbar"></div>

    <script>
      // DOM Elements
      const cartItemsContainer = document.getElementById("cartItems");
      const orderSummaryContainer = document.getElementById("orderSummary");
      const addressDetails = document.getElementById("addressDetails");
      const editAddressBtn = document.getElementById("editAddressBtn");
      const deleteAddressBtn = document.getElementById("deleteAddressBtn");
      const editAddressForm = document.getElementById("editAddressForm");

      // Initialize page
      function initPage() {
        // Retrieve cart items: prioritize tempCart (for Buy Now) then fallback to regular cart
        let cartItems = [];
        try {
          const tempCartData = localStorage.getItem("tempCart");
          const regularCartData = localStorage.getItem("cart");

          if (tempCartData) {
            cartItems = JSON.parse(tempCartData);
            // Clear tempCart immediately after reading it, as it's a one-time use cart
            localStorage.removeItem("tempCart");
          } else if (regularCartData) {
            cartItems = JSON.parse(regularCartData);
          }
        } catch (e) {
          console.error("Error parsing cart data from localStorage:", e);
          cartItems = []; // Ensure cartItems is an empty array on error
        }

        // Ensure cartItems are properly structured for display and calculations
        cartItems = cartItems.map(item => ({
          id: item.id,
          name: item.name,
          price: parseFloat(item.price) || 0, // Ensure price is a number
          image: item.image || item.img || 'https://placehold.co/70x70/E3E9F2/333?text=No+Img', // Handle missing image and use placeholder
          qty: parseInt(item.qty) || 1 // Ensure quantity is a number
        }));

        // Now that cartItems is finalized, save it to the main 'cart' for payment.php
        localStorage.setItem("cart", JSON.stringify(cartItems));

        renderCartItems(cartItems);
        renderOrderSummary(cartItems);
        renderAddress();
        checkLoginStatus(); // Call checkLoginStatus on page load
      }

      // Render cart items
      function renderCartItems(cartItems) {
        cartItemsContainer.innerHTML = ""; // Clear existing items

        if (cartItems.length === 0) {
          cartItemsContainer.innerHTML = '<p style="text-align: center; color: var(--text-light);">Your cart is empty.</p>';
          return;
        }

        cartItems.forEach((item) => {
          const cartItemElement = document.createElement("div");
          cartItemElement.className = "cart-item";
          cartItemElement.innerHTML = `
            <img src="${item.image}" alt="${item.name}" class="cart-img">
            <div class="cart-item-details">
              <div class="cart-item-name">${item.name}</div>
              <div class="cart-item-price">$${item.price.toFixed(2)}</div>
              <div class="cart-item-quantity">Qty: ${item.qty}</div>
            </div>
            <div class="cart-item-total">$${(item.price * item.qty).toFixed(2)}</div>
          `;
          cartItemsContainer.appendChild(cartItemElement);
        });
      }

      // Render order summary
      function renderOrderSummary(cartItems) {
        // Calculate totals
        const subtotal = cartItems.reduce(
          (sum, item) => sum + item.price * item.qty,
          0
        );
        // Example logic: Free shipping over $100
        const shipping = subtotal >= 100 ? 0 : 12.99;
        const taxRate = 0.08; // 8% tax example
        const tax = subtotal * taxRate;
        // Example: $25 discount for orders over $200
        const discount = subtotal >= 200 ? 25 : 0;
        const total = subtotal + shipping + tax - discount;

        orderSummaryContainer.innerHTML = `
          <div class="summary-item">
            <span>Subtotal (${cartItems.length} items)</span>
            <span>$${subtotal.toFixed(2)}</span>
          </div>
          <div class="summary-item">
            <span>Shipping</span>
            <span>$${shipping.toFixed(2)}</span>
          </div>
          <div class="summary-item">
            <span>Tax (${(taxRate * 100).toFixed(0)}%)</span>
            <span>$${tax.toFixed(2)}</span>
          </div>
          <div class="summary-item">
            <span>Discount</span>
            <span>-$${discount.toFixed(2)}</span>
          </div>
          <div class="summary-item total">
            <span>Total</span>
            <span>$${total.toFixed(2)}</span>
          </div>
        `;
      }

      // Render address
      function renderAddress() {
        let savedAddresses = [];
        try {
          savedAddresses = JSON.parse(localStorage.getItem("userAddresses")) || [];
        } catch (e) {
          console.error("Error parsing userAddresses from localStorage:", e);
        }
        const selectedIdx =
          parseInt(localStorage.getItem("selectedAddressIdx"), 10) || 0;
        const address = savedAddresses[selectedIdx];

        if (address && address.name && address.address && address.phone) {
          addressDetails.innerHTML = `
            <p><strong>${address.name}</strong><br>
            ${address.address}<br>
            <i class="fas fa-phone"></i> ${address.phone}</p>
          `;
          editAddressForm.style.display = "none";
          addressDetails.style.display = "block"; // Ensure address details are shown
          editAddressBtn.style.display = "flex";
          deleteAddressBtn.style.display = "flex";
        } else {
          // If no address is saved, show the edit form by default
          showEditAddress(); // This will populate with defaults for easy editing
          addressDetails.style.display = "none"; // Hide the placeholder/empty address
          editAddressBtn.style.display = "none";
          deleteAddressBtn.style.display = "none";
        }
      }

      // Show edit address form
      function showEditAddress() {
        let savedAddresses = [];
        try {
          savedAddresses = JSON.parse(localStorage.getItem("userAddresses")) || [];
        } catch (e) {
          console.error("Error parsing userAddresses in showEditAddress:", e);
        }
        const selectedIdx =
          parseInt(localStorage.getItem("selectedAddressIdx"), 10) || 0;
        const address = savedAddresses[selectedIdx];

        // Populate form with existing address data or default values
        document.getElementById("inputName").value = address ? address.name : "John Doe";
        document.getElementById("inputAddress").value = address ? address.address : "123 Main Street, City, State, Zip, Country";
        document.getElementById("inputPhone").value = address ? address.phone : "(555) 123-4567";
        
        editAddressForm.style.display = "block";
        addressDetails.style.display = "none"; // Hide address details when editing
        editAddressBtn.style.display = "none";
        deleteAddressBtn.style.display = "none";
      }

      // Cancel edit address
      function cancelEditAddress() {
        editAddressForm.style.display = "none";
        renderAddress(); // Re-render address details, which will show the saved one or keep form if none
      }

      // Save address
      function saveAddress(e) {
        e.preventDefault();
        const name = document.getElementById("inputName").value.trim();
        const address = document.getElementById("inputAddress").value.trim();
        const phone = document.getElementById("inputPhone").value.trim();

        if (!name || !address || !phone) {
          showSnackbar("Please fill all shipping information fields.", "error");
          return;
        }

        const newAddress = { name, address, phone };

        // Save the address to localStorage. Store it as an array for consistency,
        // overwriting any previous addresses if only one is supported.
        try {
          localStorage.setItem("userAddresses", JSON.stringify([newAddress]));
          localStorage.setItem("selectedAddressIdx", "0"); // Assuming the first (and only) address is always selected
          showSnackbar("Shipping information saved successfully!", "success");
        } catch (e) {
          console.error("Error saving address to localStorage:", e);
          showSnackbar("Failed to save address. Please try again.", "error");
        }
        
        renderAddress(); // Re-render to display the saved address and hide the form
      }

      // Delete address
      function deleteAddress() {
        // Custom confirmation modal implementation (instead of alert/confirm)
        showCustomConfirm("Are you sure you want to delete this address?", () => {
          try {
            localStorage.removeItem("userAddresses");
            localStorage.removeItem("selectedAddressIdx");
            showSnackbar("Address deleted successfully.", "success");
          } catch (e) {
            console.error("Error deleting address from localStorage:", e);
            showSnackbar("Failed to delete address. Please try again.", "error");
          }
          renderAddress(); // Re-render to show the form or default
        });
      }

      // Go to payment page
      function gotoPaymentPage() {
        let cartItems = [];
        try {
          cartItems = JSON.parse(localStorage.getItem("cart")) || []; // Should already be populated by initPage
        } catch (e) {
          console.error("Error parsing cart from localStorage in gotoPaymentPage:", e);
        }

        if (cartItems.length === 0) {
          showSnackbar("Your cart is empty. Please add items before proceeding.", "error");
          return;
        }

        let savedAddresses = [];
        try {
          savedAddresses = JSON.parse(localStorage.getItem("userAddresses")) || [];
        } catch (e) {
          console.error("Error parsing userAddresses in gotoPaymentPage:", e);
        }
        const name = document.getElementById("inputName").value.trim();
        const address = document.getElementById("inputAddress").value.trim();
        const phone = document.getElementById("inputPhone").value.trim();

        // Check if an address is saved AND valid, or if the form is filled out
        const currentAddressIsValid = savedAddresses.length > 0 && 
                                     savedAddresses[0].name && 
                                     savedAddresses[0].address && 
                                     savedAddresses[0].phone;

        if (!currentAddressIsValid && (!name || !address || !phone)) {
            showSnackbar("Please complete your shipping information.", "error");
            showEditAddress(); // Prompt user to fill the form
            return;
        }

        // If the form fields were just filled and are valid, save them before redirecting
        if (!currentAddressIsValid && name && address && phone) {
             const newAddress = { name, address, phone };
             try {
                localStorage.setItem("userAddresses", JSON.stringify([newAddress]));
                localStorage.setItem("selectedAddressIdx", "0");
             } catch (e) {
                console.error("Error saving form address to localStorage:", e);
                // Continue, but log the error. The payment page will validate again.
             }
        }

        // The cart data should already be correctly set in localStorage.getItem("cart") by initPage()
        // No need to set it again or remove tempCart here, as initPage already handled it.

        showSnackbar("Redirecting to payment page...", "success");
        setTimeout(() => {
          window.location.href = "payment.php";
        }, 1500);
      }

      // Show snackbar notification
      function showSnackbar(msg, type = "info") {
        const sb = document.getElementById("snackbar");
        sb.textContent = msg;
        sb.className = "show"; // Reset classes
        if (type === "success") {
            sb.classList.add("success");
        } else if (type === "error") {
            sb.classList.add("error");
        } else {
            sb.classList.add("info");
        }
        setTimeout(() => {
          sb.className = sb.className.replace("show", "").replace("success", "").replace("error", "").replace("info", "");
        }, 2500);
      }

      // Custom Confirmation Modal (replaces browser's confirm())
      function showCustomConfirm(message, onConfirm) {
        // You'll need to create a simple modal HTML structure in your body
        // For example:
        // <div id="customConfirmModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
        //   <div style="background:#fff; padding:20px; border-radius:8px; text-align:center;">
        //     <p id="confirmMessage" style="margin-bottom:20px;"></p>
        //     <button id="confirmYes" style="padding:10px 15px; margin-right:10px;">Yes</button>
        //     <button id="confirmNo" style="padding:10px 15px;">No</button>
        //   </div>
        // </div>

        // If you don't have this, for the sake of functionality I'll default to alert/confirm
        // but it's highly recommended to implement a custom UI for better user experience.
        if (typeof confirm !== 'undefined' && confirm(message)) {
            onConfirm();
        } else {
            // Placeholder for a custom modal if implemented
            console.log("Custom confirm not implemented, defaulting to browser confirm or no action.");
        }
      }

      // Check login status for logout button visibility (added to checkout.php)
      function checkLoginStatus() {
        let user = localStorage.getItem("loggedInUser");
        
        // Main logout icon on the navbar
        const mainLogoutIcon = document.getElementById("mainLogoutIcon");
        if (mainLogoutIcon) {
          mainLogoutIcon.style.display = user ? "flex" : "none"; 
        }

        // Desktop logout link within profile dropdown (adjusted ID)
        const desktopLogoutLink = document.getElementById("desktopLogoutLink");
        if (desktopLogoutLink) {
          desktopLogoutLink.style.display = user ? "block" : "none"; 
        }
        // Mobile logout link within the dropdown (assuming it exists)
        const mobileLogoutLink = document.getElementById("mobileLogoutLink");
        if (mobileLogoutLink) {
          mobileLogoutLink.style.display = user ? "block" : "none"; // Use 'block' for mobile dropdown items
        }
      }

      // Dropdown functionality (copied from index.php for consistency)
      document.addEventListener("DOMContentLoaded", function () {
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
            checkLoginStatus(); // Re-check login status after dropdown toggle
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
      });

      // Simple test functions for login/logout (for demonstration purposes)
      function simulateLogin() {
          localStorage.setItem("loggedInUser", "true");
          checkLoginStatus();
          showSnackbar("You are now logged in!", "success");
      }

      function simulateLogout() {
          localStorage.removeItem("loggedInUser");
          checkLoginStatus();
          showSnackbar("You have been logged out.", "info");
      }


      // Initialize when page loads
      document.addEventListener("DOMContentLoaded", initPage);
    </script>
    
  </body>
</html>
