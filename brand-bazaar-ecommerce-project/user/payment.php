<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Select Payment Method - Brand Bazaar</title>
    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <style>
      :root {
        --primary-color: #0a45a6;
        --primary-hover: #154c8e;
        --background: #f6f8fb;
        --card-bg: #fff;
        --border-color: #c9e0fc;
        --light-bg: #f7fbff;
        --input-bg: #fafdff;
        --shadow: 0 2px 12px -6px #0a45a618;
        --error-color: #d32f2f;
        --success-color: #388e3c;
        --warning-color: #ffa000;
      }

      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      body {
        background: var(--background);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
          Oxygen, Ubuntu, Cantarell, sans-serif;
        line-height: 1.5;
        color: #333;
      }

      /* Payment Section with Entrance Animation */
      .payment-section {
        background: var(--card-bg);
        box-shadow: var(--shadow);
        border-radius: 13px;
        padding: 2rem 1.5rem;
        max-width: 450px;
        margin: 60px auto;
        position: relative;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease-out forwards;
      }

      .payment-section h2 {
        color: var(--primary-color);
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        text-align: center;
        font-weight: 600;
      }

      /* Payment Methods with Hover Effects */
      .payment-methods {
        margin-bottom: 1rem;
      }

      .payment-method {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        cursor: pointer;
        gap: 12px;
        font-size: 1.09rem;
        padding: 0.8rem;
        border-radius: 8px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: 1px solid #e0e0e0;
        position: relative;
        overflow: hidden;
      }

      .payment-method:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(10, 69, 166, 0.1);
      }

      .payment-method.active {
        border-color: var(--primary-color);
        background: rgba(10, 69, 166, 0.05);
        box-shadow: 0 2px 8px rgba(10, 69, 166, 0.1);
      }

      .payment-method.active::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--primary-color);
        animation: borderGrow 0.3s ease-out;
      }

      .payment-method input[type="radio"] {
        accent-color: var(--primary-color);
        width: 18px;
        height: 18px;
        cursor: pointer;
        opacity: 0;
        position: absolute;
      }

      .payment-icon {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 1.2rem;
        transition: all 0.3s ease;
      }

      .payment-method.active .payment-icon {
        color: #fff;
        background: var(--primary-color);
        border-radius: 50%;
        transform: scale(1.1);
      }

      .payment-label {
        flex: 1;
      }

      /* Card Details with Smooth Expansion */
      .card-details {
        display: none;
        flex-direction: column;
        gap: 12px;
        margin: 1rem 0;
        padding: 1.2rem;
        background: var(--light-bg);
        border-radius: 8px;
        border: 1.2px solid var(--border-color);
        animation: fadeInExpand 0.4s ease-out forwards;
        transform-origin: top;
        overflow: hidden;
      }

      .card-details input {
        font-size: 1rem;
        padding: 10px;
        border-radius: 6px;
        border: 1.2px solid var(--border-color);
        background: var(--input-bg);
        outline: none;
        transition: all 0.3s ease;
        width: 100%;
      }

      .card-details input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(10, 69, 166, 0.2);
      }

      .card-details input.error {
        border-color: var(--error-color);
        animation: shake 0.5s ease;
      }

      .input-group {
        display: flex;
        gap: 12px;
      }

      .input-group > * {
        flex: 1;
      }

      .error-message {
        color: var(--error-color);
        font-size: 0.85rem;
        margin-top: -8px;
        margin-bottom: 8px;
        display: none;
        animation: fadeIn 0.3s ease-out;
      }

      .card-brand {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5rem;
        opacity: 0.8;
        display: none;
        transition: all 0.3s ease;
      }

      .input-wrapper {
        position: relative;
      }

      /* Order Summary Section */
      .order-summary {
        background: var(--light-bg);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-color);
        animation: fadeIn 0.5s ease-out;
      }

      .order-summary h3 {
        color: var(--primary-color);
        font-size: 1.1rem;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 8px;
      }

      .order-summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
      }

      .order-total {
        font-weight: 600;
        color: var(--primary-color);
        border-top: 1px dashed var(--border-color);
        padding-top: 0.5rem;
        margin-top: 0.5rem;
      }

      /* Place Order Button with Ripple Effect */
      .place-order-btn {
        width: 100%;
        padding: 14px;
        font-size: 1.15rem;
        background: var(--primary-color);
        color: #fff;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        margin-top: 1.5rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        box-shadow: 0 2px 12px -7px #0a45a622;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
      }

      .place-order-btn:hover {
        background: var(--primary-hover);
        box-shadow: 0 4px 16px -5px #0a45a640;
        transform: translateY(-2px);
      }

      .place-order-btn:active {
        transform: translateY(0);
      }

      .place-order-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
      }

      .place-order-btn .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
      }

      /* Snackbar Notifications */
      #snackbar {
        visibility: hidden;
        min-width: 250px;
        max-width: 90%;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 14px 20px;
        position: fixed;
        z-index: 99;
        left: 50%;
        bottom: 40px;
        font-size: 1rem;
        transform: translateX(-50%);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 10px;
      }

      #snackbar.show {
        visibility: visible;
        animation: fadeInUp 0.3s, fadeOut 0.5s 2.2s forwards;
      }

      #snackbar.success {
        background-color: var(--success-color);
      }

      #snackbar.error {
        background-color: var(--error-color);
      }

      #snackbar.warning {
        background-color: var(--warning-color);
      }

      /* Loading Overlay */
      .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        z-index: 10;
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease;
      }

      .loading-overlay.active {
        opacity: 1;
      }

      .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid rgba(10, 69, 166, 0.1);
        border-radius: 50%;
        border-top-color: var(--primary-color);
        animation: spin 1s ease-in-out infinite;
      }

      .loading-text {
        margin-top: 1rem;
        color: var(--primary-color);
        font-weight: 500;
      }

      /* UPI Payment Modal */
      .upi-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 100;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
      }

      .upi-modal.active {
        opacity: 1;
      }

      .upi-container {
        background: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        max-width: 350px;
        width: 90%;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        transform: translateY(20px);
        transition: transform 0.3s ease;
      }

      .upi-modal.active .upi-container {
        transform: translateY(0);
      }

      .upi-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
      }

      .upi-header h3 {
        color: var(--primary-color);
        font-size: 1.2rem;
      }

      .upi-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #666;
      }

      .upi-qr {
        text-align: center;
        margin: 1rem 0;
      }

      .upi-qr img {
        max-width: 200px;
        border: 1px solid #eee;
        padding: 10px;
        border-radius: 8px;
      }

      .upi-id {
        background: #f5f5f5;
        padding: 0.8rem;
        border-radius: 6px;
        text-align: center;
        font-family: monospace;
        font-size: 1.1rem;
        margin: 1rem 0;
        word-break: break-all;
      }

      .upi-buttons {
        display: flex;
        gap: 10px;
        margin-top: 1rem;
      }

      .upi-btn {
        flex: 1;
        padding: 10px;
        border-radius: 6px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
      }

      .upi-btn-primary {
        background: var(--primary-color);
        color: white;
      }

      .upi-btn-secondary {
        background: #f0f0f0;
        color: #333;
      }

      /* Keyframe Animations */
      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(20px);
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

      @keyframes fadeOut {
        from {
          opacity: 1;
        }
        to {
          opacity: 0;
        }
      }

      @keyframes spin {
        to {
          transform: rotate(360deg);
        }
      }

      @keyframes ripple {
        to {
          transform: scale(4);
          opacity: 0;
        }
      }

      @keyframes shake {
        0%,
        100% {
          transform: translateX(0);
        }
        20%,
        60% {
          transform: translateX(-5px);
        }
        40%,
        80% {
          transform: translateX(5px);
        }
      }

      @keyframes borderGrow {
        from {
          width: 0;
        }
        to {
          width: 100%;
        }
      }

      @keyframes fadeInExpand {
        from {
          opacity: 0;
          transform: scaleY(0.9);
        }
        to {
          opacity: 1;
          transform: scaleY(1);
        }
      }

      @media (max-width: 480px) {
        .payment-section {
          margin: 30px 15px;
          padding: 1.5rem 1rem;
          animation: fadeIn 0.6s ease-out forwards;
        }

        .card-details {
          padding: 1rem;
        }

        .payment-method {
          padding: 0.7rem;
        }

        .upi-container {
          width: 95%;
          padding: 1rem;
        }
      }
    </style>
  </head>
  <body>
    <div class="payment-section">
      <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <div class="loading-text">Processing your order...</div>
      </div>

      <h2><i class="fas fa-credit-card"></i> Select Payment Method</h2>

      <!-- Order Summary -->
      <div class="order-summary" id="orderSummary">
        <h3><i class="fas fa-receipt"></i> Order Summary</h3>
        <div id="orderSummaryContent"></div>
      </div>

      <form id="paymentForm">
        <div class="payment-methods">
          <label class="payment-method" for="cod">
            <input type="radio" id="cod" name="payment" value="cod" checked />
            <div class="payment-icon">
              <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="payment-label">Cash on Delivery (COD)</div>
          </label>

          <label class="payment-method" for="upi">
            <input type="radio" id="upi" name="payment" value="upi" />
            <div class="payment-icon">
              <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="payment-label">UPI / Wallet / Net Banking</div>
          </label>

          <label class="payment-method" for="card">
            <input type="radio" id="card" name="payment" value="card" />
            <div class="payment-icon">
              <i class="far fa-credit-card"></i>
            </div>
            <div class="payment-label">Debit / Credit Card</div>
          </label>
        </div>

        <div class="card-details" id="cardDetails">
          <div class="input-wrapper">
            <input
              type="text"
              id="cardNumber"
              maxlength="19"
              placeholder="Card Number (1234 5678 9012 3456)"
              autocomplete="cc-number"
              inputmode="numeric"
            />
            <div class="card-brand" id="cardBrand">
              <i class="fab fa-cc-visa" id="cardBrandIcon"></i>
            </div>
            <div class="error-message" id="cardNumberError"></div>
          </div>

          <input
            type="text"
            id="cardHolder"
            placeholder="Card Holder Name"
            autocomplete="cc-name"
          />
          <div class="error-message" id="cardHolderError"></div>

          <div class="input-group">
            <div>
              <input
                type="text"
                id="cardExpiry"
                maxlength="5"
                placeholder="MM/YY"
                autocomplete="cc-exp"
                inputmode="numeric"
              />
              <div class="error-message" id="cardExpiryError"></div>
            </div>

            <div>
              <div class="input-wrapper">
                <input
                  type="text"
                  id="cardCvv"
                  maxlength="4"
                  placeholder="CVV"
                  autocomplete="cc-csc"
                  inputmode="numeric"
                />
                <div class="card-brand">
                  <i class="fas fa-lock"></i>
                </div>
              </div>
              <div class="error-message" id="cardCvvError"></div>
            </div>
          </div>
        </div>

        <button type="button" class="place-order-btn" id="placeOrderBtn">
          <i class="fas fa-shopping-bag"></i> Place Order
        </button>
      </form>
    </div>

    <!-- UPI Payment Modal -->
    <div class="upi-modal" id="upiModal">
      <div class="upi-container">
        <div class="upi-header">
          <h3><i class="fas fa-mobile-alt"></i> UPI Payment</h3>
          <button class="upi-close" id="upiClose">&times;</button>
        </div>
        <p>Scan the QR code or use the UPI ID below to complete your payment</p>
        <div class="upi-qr">
          <img
            src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=upi://pay?pa=brandbazaar@upi&pn=Brand%20Bazaar&am=100"
            alt="UPI QR Code"
          />
        </div>
        <div class="upi-id" id="upiId">brandbazaar@upi</div>
        <p>After payment, click the button below to confirm</p>
        <div class="upi-buttons">
          <button class="upi-btn upi-btn-secondary" id="upiCancel">
            Cancel
          </button>
          <button class="upi-btn upi-btn-primary" id="upiConfirm">
            Payment Done
          </button>
        </div>
      </div>
    </div>

    <div id="snackbar"></div>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // DOM Elements
        const paymentForm = document.getElementById("paymentForm");
        const paymentRadios = document.querySelectorAll(
          'input[name="payment"]'
        );
        const paymentMethods = document.querySelectorAll(".payment-method");
        const cardDetailsDiv = document.getElementById("cardDetails");
        const placeOrderBtn = document.getElementById("placeOrderBtn");
        const loadingOverlay = document.getElementById("loadingOverlay");
        const snackbar = document.getElementById("snackbar");
        const upiModal = document.getElementById("upiModal");
        const upiClose = document.getElementById("upiClose");
        const upiCancel = document.getElementById("upiCancel");
        const upiConfirm = document.getElementById("upiConfirm");
        const orderSummary = document.getElementById("orderSummary");
        const orderSummaryContent = document.getElementById(
          "orderSummaryContent"
        );

        // Card input elements
        const cardNumberInput = document.getElementById("cardNumber");
        const cardHolderInput = document.getElementById("cardHolder");
        const cardExpiryInput = document.getElementById("cardExpiry");
        const cardCvvInput = document.getElementById("cardCvv");
        const cardBrand = document.getElementById("cardBrand");
        const cardBrandIcon = document.getElementById("cardBrandIcon");

        // Error message elements
        const cardNumberError = document.getElementById("cardNumberError");
        const cardHolderError = document.getElementById("cardHolderError");
        const cardExpiryError = document.getElementById("cardExpiryError");
        const cardCvvError = document.getElementById("cardCvvError");

        // Card brand detection patterns
        const cardPatterns = [
          { type: "visa", pattern: /^4/, icon: "fa-cc-visa" },
          { type: "mastercard", pattern: /^5[1-5]/, icon: "fa-cc-mastercard" },
          { type: "amex", pattern: /^3[47]/, icon: "fa-cc-amex" },
          { type: "discover", pattern: /^6(?:011|5)/, icon: "fa-cc-discover" },
          {
            type: "diners",
            pattern: /^3(?:0[0-5]|[68])/,
            icon: "fa-cc-diners-club",
          },
          { type: "jcb", pattern: /^(?:2131|1800|35)/, icon: "fa-cc-jcb" },
        ];

        // Initialize the page
        function init() {
          loadOrderSummary();
          initPaymentMethods();
          initEventListeners();
          toggleCardDetails();
        }

        // Load order summary from cart
        function loadOrderSummary() {
          const cart = getCart(); // Get cart items
          const addresses = getSavedAddresses();
          const selectedIdx = getSelectedAddressIdx();
          const address = addresses[selectedIdx];

          if (!cart.length) {
            orderSummary.style.display = "none";
            // Optionally redirect to checkout or display empty cart message
            showSnackbar("Your cart is empty. Redirecting to home.", "warning");
            setTimeout(() => {
                window.location.href = "index.php";
            }, 2000);
            return;
          }

          let itemsHtml = "";
          let subtotal = 0;
          
          cart.forEach((item) => {
            const itemPrice = parseFloat(item.price) || 0;
            const itemQty = parseInt(item.qty) || 1;
            const itemTotal = itemPrice * itemQty;
            subtotal += itemTotal;
            itemsHtml += `
              <div class="order-summary-item">
                <span>${item.name} x${itemQty}</span>
                <span>$${itemTotal.toFixed(2)}</span>
              </div>
            `;
          });

          // Recalculate shipping, tax, discount based on the actual subtotal
          const shipping = subtotal >= 100 ? 0 : 12.99; // Example: Free shipping over $100
          const taxRate = 0.08; // 8% tax example
          const tax = subtotal * taxRate;
          const discount = subtotal >= 200 ? 25 : 0; // Example: $25 discount for orders over $200
          const total = subtotal + shipping + tax - discount;


          orderSummaryContent.innerHTML = `
            ${itemsHtml}
            <div class="order-summary-item">
              <span>Subtotal</span>
              <span>$${subtotal.toFixed(2)}</span>
            </div>
            <div class="order-summary-item">
              <span>Shipping</span>
              <span>$${shipping.toFixed(2)}</span>
            </div>
            <div class="order-summary-item">
              <span>Tax (${(taxRate * 100).toFixed(0)}%)</span>
              <span>$${tax.toFixed(2)}</span>
            </div>
            <div class="order-summary-item">
              <span>Discount</span>
              <span>-$${discount.toFixed(2)}</span>
            </div>
            <div class="order-summary-item order-total">
              <span>Total</span>
              <span>$${total.toFixed(2)}</span>
            </div>
          `;

          if (address && isValidAddress(address)) {
            orderSummaryContent.innerHTML += `
              <div class="order-summary-item" style="margin-top: 1rem;">
                <span><i class="fas fa-map-marker-alt"></i> Deliver to:</span>
              </div>
              <div class="order-summary-item" style="font-size: 0.9rem;">
                <span>${address.name}, ${address.address}</span>
              </div>
            `;
          } else {
             // If no valid address, prompt user to go back to checkout
             orderSummaryContent.innerHTML += `
              <div class="order-summary-item" style="margin-top: 1rem; color: var(--error-color);">
                <span><i class="fas fa-exclamation-triangle"></i> No valid delivery address found.</span>
              </div>
              <div class="order-summary-item" style="font-size: 0.9rem; color: var(--error-color);">
                <span>Please go back to <a href="checkout.php" style="color: var(--error-color); text-decoration: underline;">Checkout</a> to add one.</span>
              </div>
            `;
            placeOrderBtn.disabled = true; // Disable place order button if no address
          }
        }

        // Initialize payment method selection
        function initPaymentMethods() {
          paymentMethods.forEach((method) => {
            const radio = method.querySelector('input[type="radio"]');

            if (radio.checked) {
              method.classList.add("active");
            }

            radio.addEventListener("change", function () {
              paymentMethods.forEach((m) => m.classList.remove("active"));
              if (this.checked) {
                method.classList.add("active");
              }
              toggleCardDetails();
            });

            // Add click handler for the entire label
            method.addEventListener("click", function (e) {
              if (e.target.tagName !== "INPUT") {
                radio.checked = true;
                paymentMethods.forEach((m) => m.classList.remove("active"));
                method.classList.add("active");
                toggleCardDetails();
              }
            });
          });
        }

        // Show/hide card details based on payment method
        function toggleCardDetails() {
          const selectedPayment = document.querySelector(
            'input[name="payment"]:checked'
          ).value;

          if (selectedPayment === "card") {
            cardDetailsDiv.style.display = "flex";
            setTimeout(() => {
              cardDetailsDiv.style.opacity = "1";
            }, 10);
          } else {
            cardDetailsDiv.style.opacity = "0";
            setTimeout(() => {
              cardDetailsDiv.style.display = "none";
            }, 300);
          }

          // Reset validation when switching payment methods
          if (selectedPayment !== "card") {
            clearCardErrors();
          }
        }

        // Detect card brand based on number
        function detectCardBrand(cardNumber) {
          const num = cardNumber.replace(/\s+/g, "");
          if (num.length < 1) {
            cardBrand.style.display = "none";
            return;
          }

          const matchedCard = cardPatterns.find((pattern) =>
            pattern.pattern.test(num)
          );

          if (matchedCard) {
            cardBrandIcon.className = "fab " + matchedCard.icon;
            cardBrand.style.display = "flex";
          } else {
            cardBrand.style.display = "none";
          }
        }

        // Format card number with spaces (e.g., 1234 5678 9012 3456)
        function formatCardNumber(value) {
          let formattedValue = value.replace(/\s+/g, "");
          if (/[^0-9]/.test(formattedValue)) {
            formattedValue = formattedValue.replace(/[^0-9]/g, "");
          }

          // Add space after every 4 digits
          formattedValue = formattedValue.replace(/(\d{4})(?=\d)/g, "$1 ");
          return formattedValue.substring(0, 19); // Limit to 16 digits + 3 spaces
        }

        // Format expiry date as MM/YY
        function formatExpiryDate(value) {
          let formattedValue = value.replace(/[^0-9]/g, "");

          if (formattedValue.length > 2) {
            formattedValue =
              formattedValue.substring(0, 2) +
              "/" +
              formattedValue.substring(2, 4);
          }

          return formattedValue.substring(0, 5); // Limit to MM/YY format
        }

        // Clear all card validation errors
        function clearCardErrors() {
          [
            cardNumberInput,
            cardHolderInput,
            cardExpiryInput,
            cardCvvInput,
          ].forEach((input) => {
            input.classList.remove("error");
          });

          [
            cardNumberError,
            cardHolderError,
            cardExpiryError,
            cardCvvError,
          ].forEach((error) => {
            error.textContent = "";
            error.style.display = "none";
          });
        }

        // Validate card details
        function validateCardDetails() {
          let isValid = true;
          clearCardErrors();

          // Validate card number (16-19 digits, ignoring spaces)
          const cardNumber = cardNumberInput.value.replace(/\s+/g, "");
          if (!cardNumber || !/^\d{16,19}$/.test(cardNumber)) {
            cardNumberInput.classList.add("error");
            cardNumberError.textContent =
              "Please enter a valid 16-digit card number";
            cardNumberError.style.display = "block";
            isValid = false;
          }

          // Validate card holder name
          const cardHolder = cardHolderInput.value.trim();
          if (!cardHolder || cardHolder.length < 3) {
            cardHolderInput.classList.add("error");
            cardHolderError.textContent = "Please enter card holder name";
            cardHolderError.style.display = "block";
            isValid = false;
          }

          // Validate expiry date (MM/YY format and not expired)
          const cardExpiry = cardExpiryInput.value;
          if (!/^\d{2}\/\d{2}$/.test(cardExpiry)) {
            cardExpiryInput.classList.add("error");
            cardExpiryError.textContent = "Please enter expiry in MM/YY format";
            cardExpiryError.style.display = "block";
            isValid = false;
          } else {
            const [month, year] = cardExpiry.split("/");
            const currentYear = new Date().getFullYear() % 100; // Get last two digits of current year
            const currentMonth = new Date().getMonth() + 1; // getMonth() is 0-indexed

            if (parseInt(month) < 1 || parseInt(month) > 12) {
              cardExpiryInput.classList.add("error");
              cardExpiryError.textContent = "Invalid month";
              cardExpiryError.style.display = "block";
              isValid = false;
            } else if (parseInt(year) < currentYear || 
                       (parseInt(year) === currentYear && parseInt(month) < currentMonth)) {
              cardExpiryInput.classList.add("error");
              cardExpiryError.textContent = "Card has expired";
              cardExpiryError.style.display = "block";
              isValid = false;
            }
          }

          // Validate CVV (3 or 4 digits)
          const cardCvv = cardCvvInput.value;
          if (!/^\d{3,4}$/.test(cardCvv)) {
            cardCvvInput.classList.add("error");
            cardCvvError.textContent = "CVV must be 3 or 4 digits";
            cardCvvError.style.display = "block";
            isValid = false;
          }

          return isValid;
        }

        // Show snackbar notification
        function showSnackbar(msg, type = "success") {
          snackbar.textContent = msg;
          snackbar.className = "show " + type;
          snackbar.innerHTML = `
            <i class="fas ${
              type === "success"
                ? "fa-check-circle"
                : type === "error"
                ? "fa-exclamation-circle"
                : "fa-info-circle"
            }"></i>
            ${msg}
          `;

          setTimeout(function () {
            snackbar.className = snackbar.className.replace("show", "");
          }, 3000);
        }

        // Create ripple effect on button click
        function createRipple(event) {
          const button = event.currentTarget;
          const circle = document.createElement("span");
          const diameter = Math.max(button.clientWidth, button.clientHeight);
          const radius = diameter / 2;

          circle.style.width = circle.style.height = `${diameter}px`;
          circle.style.left = `${
            event.clientX - button.getBoundingClientRect().left - radius
          }px`;
          circle.style.top = `${
            event.clientY - button.getBoundingClientRect().top - radius
          }px`;
          circle.classList.add("ripple");

          const ripple = button.getElementsByClassName("ripple")[0];
          if (ripple) {
            ripple.remove();
          }

          button.appendChild(circle);
        }

        // Get cart from localStorage (now only reads from 'cart' key)
        function getCart() {
            try {
                return JSON.parse(localStorage.getItem("cart")) || [];
            } catch (e) {
                console.error("Error parsing cart from localStorage:", e);
                return [];
            }
        }

        // Get saved addresses from localStorage
        function getSavedAddresses() {
          try {
            return JSON.parse(localStorage.getItem("userAddresses")) || [];
          } catch (e) {
            console.error("Error parsing userAddresses from localStorage:", e);
            return [];
          }
        }

        // Get selected address index
        function getSelectedAddressIdx() {
          const idx = parseInt(localStorage.getItem("selectedAddressIdx"), 10);
          return isNaN(idx) ? 0 : idx;
        }

        // Validate address (simple check for required fields)
        function isValidAddress(addr) {
          return !!(addr && addr.name && addr.address && addr.phone);
        }

        // Show loading overlay
        function showLoading(show) {
          if (show) {
            loadingOverlay.style.display = "flex";
            setTimeout(() => {
              loadingOverlay.classList.add("active");
            }, 10);
          } else {
            loadingOverlay.classList.remove("active");
            setTimeout(() => {
              loadingOverlay.style.display = "none";
            }, 300);
          }
        }

        // Show UPI payment modal
        function showUPIModal(show) {
          if (show) {
            upiModal.style.display = "flex";
            setTimeout(() => {
              upiModal.classList.add("active");
            }, 10);
          } else {
            upiModal.classList.remove("active");
            setTimeout(() => {
              upiModal.style.display = "none";
            }, 300);
          }
        }

        // Place order handler
        async function placeOrder() {
          const paymentMethod = document.querySelector(
            'input[name="payment"]:checked'
          ).value;

          // Validate card details if payment method is card
          if (paymentMethod === "card" && !validateCardDetails()) {
            showSnackbar("Please correct card details.", "error");
            return;
          }

          // Get cart items
          const cart = getCart();
          if (!cart.length) {
            showSnackbar("Your cart is empty. Please add items before proceeding.", "error");
            setTimeout(() => { window.location.href = "index.php"; }, 1500);
            return;
          }

          // Get selected address
          const addresses = getSavedAddresses();
          const selectedIdx = getSelectedAddressIdx();
          const address = addresses[selectedIdx];

          if (!addresses.length || !isValidAddress(address)) {
            showSnackbar("No valid delivery address found. Please go back to Checkout to add one.", "error");
            return;
          }

          // For UPI payment, show the modal instead of placing order directly
          if (paymentMethod === "upi") {
            showUPIModal(true);
            return;
          }

          // Show loading indicator
          showLoading(true);
          placeOrderBtn.disabled = true;

          // Simulate API call delay
          await new Promise((resolve) => setTimeout(resolve, 1000));

          try {
            // Create order object
            const total = cart.reduce(
              (sum, item) => sum + (parseFloat(item.price) || 0) * (parseInt(item.qty) || 1),
              0
            );
            let orders = [];
            try {
                orders = JSON.parse(localStorage.getItem("orders")) || [];
            } catch (e) {
                console.error("Error parsing orders from localStorage:", e);
                orders = [];
            }
            
            const newOrder = {
              id: Date.now(), // Use timestamp for unique ID
              cart: cart,
              total: total,
              address: address,
              paymentMethod: paymentMethod,
              status: "Placed",
              paymentStatus: paymentMethod === "cod" ? "Pending" : "Paid",
              date: new Date().toISOString(),
              lastFour:
                paymentMethod === "card"
                  ? cardNumberInput.value.replace(/\s+/g, "").slice(-4)
                  : null,
              cardBrand:
                paymentMethod === "card"
                  ? cardBrandIcon.className.replace("fab ", "")
                  : null,
            };

            // Save order to localStorage
            orders.push(newOrder);
            localStorage.setItem("orders", JSON.stringify(orders));

            // Clear cart after successful order
            localStorage.removeItem("cart");

            // Show success message
            showSnackbar("Order placed successfully!", "success");

            // Redirect to orders page after delay
            setTimeout(() => {
              window.location.href = "myorders.php";
            }, 1500);
          } catch (error) {
            showSnackbar("Error placing order. Please try again.", "error");
            console.error("Order error:", error);
          } finally {
            showLoading(false);
            placeOrderBtn.disabled = false;
          }
        }

        // Confirm UPI payment
        async function confirmUPIPayment() {
          showUPIModal(false);
          showLoading(true);

          // Simulate UPI payment verification delay
          await new Promise((resolve) => setTimeout(resolve, 2000));

          try {
            // Create order object
            const cart = getCart();
            const total = cart.reduce(
              (sum, item) => sum + (parseFloat(item.price) || 0) * (parseInt(item.qty) || 1),
              0
            );
            const addresses = getSavedAddresses();
            const selectedIdx = getSelectedAddressIdx();
            const address = addresses[selectedIdx];
            let orders = [];
            try {
                orders = JSON.parse(localStorage.getItem("orders")) || [];
            } catch (e) {
                console.error("Error parsing orders from localStorage (UPI confirm):", e);
                orders = [];
            }
            

            const newOrder = {
              id: Date.now(),
              cart: cart,
              total: total,
              address: address,
              paymentMethod: "upi",
              status: "Placed",
              paymentStatus: "Paid",
              date: new Date().toISOString(),
            };

            // Save order to localStorage
            orders.push(newOrder);
            localStorage.setItem("orders", JSON.stringify(orders));

            // Clear cart
            localStorage.removeItem("cart");

            // Show success message
            showSnackbar("UPI payment successful! Order placed.", "success");

            // Redirect to orders page after delay
            setTimeout(() => {
              window.location.href = "myorders.php";
            }, 1500);
          } catch (error) {
            showSnackbar(
              "Error verifying UPI payment. Please check your payment status.",
              "error"
            );
            console.error("UPI payment error:", error);
          } finally {
            showLoading(false);
          }
        }

        // Initialize event listeners
        function initEventListeners() {
          // Card number input formatting and brand detection
          cardNumberInput.addEventListener("input", function (e) {
            this.value = formatCardNumber(this.value);
            detectCardBrand(this.value);
          });

          // Expiry date formatting
          cardExpiryInput.addEventListener("input", function (e) {
            this.value = formatExpiryDate(this.value);
          });

          // Only allow numbers in CVV field
          cardCvvInput.addEventListener("input", function (e) {
            this.value = this.value.replace(/[^0-9]/g, "");
          });

          // Place order button click with ripple effect
          placeOrderBtn.addEventListener("click", function (e) {
            createRipple(e);
            placeOrder();
          });

          // Form submission on Enter key
          paymentForm.addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
              e.preventDefault();
              placeOrder();
            }
          });

          // UPI modal controls
          upiClose.addEventListener("click", () => showUPIModal(false));
          upiCancel.addEventListener("click", () => showUPIModal(false));
          upiConfirm.addEventListener("click", confirmUPIPayment);
        }

        init();
      });
      // Removed the duplicated `gotoPaymentPage` function as it's handled in checkout.php
    </script>
  </body>
</html>
