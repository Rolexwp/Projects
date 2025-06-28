<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile - Brand Bazaar</title>
    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <style>
      :root {
        --primary: #0a45a6;
        --primary-dark: #07347a;
        --primary-light: #eaf1fb;
        --accent: #ff6b6b;
        --accent-dark: #d60000;
        --success: #2ecc71;
        --warning: #f39c12;
        --light-bg: #f6f8fb;
        --card-bg: #fff;
        --border-color: #e3e6ec;
        --text-dark: #333;
        --text-light: #666;
        --radius: 12px;
        --shadow: 0 4px 24px -6px rgba(10, 69, 166, 0.15);
      }

      /* Profile Container */
      .profile-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 20px;
      }

      /* Profile Header */
      .profile-header {
        text-align: center;
        margin-bottom: 2rem;
      }

      .profile-header h1 {
        color: var(--primary);
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
      }

      .profile-header p {
        color: var(--text-light);
        font-size: 1.1rem;
      }

      /* Profile Layout */
      .profile-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 2rem;
      }

      @media (max-width: 768px) {
        .profile-layout {
          grid-template-columns: 1fr;
        }
      }

      /* Profile Card */
      .profile-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 2rem;
        text-align: center;
      }

      /* Profile Picture */
      .profile-pic-wrap {
        position: relative;
        margin: 0 auto 1.5rem;
        width: 150px;
        height: 150px;
      }

      .profile-pic {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary);
        box-shadow: 0 4px 12px rgba(10, 69, 166, 0.15);
        background: var(--primary-light);
      }

      .profile-pic-overlay {
        position: absolute;
        bottom: 0;
        right: 0;
        background: var(--primary);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.2s;
      }

      .profile-pic-overlay:hover {
        background: var(--primary-dark);
        transform: scale(1.1);
      }

      .profile-pic-input {
        display: none;
      }

      /* Profile Info */
      .profile-info {
        margin-bottom: 1.5rem;
      }

      .profile-info h2 {
        color: var(--primary);
        margin-bottom: 0.5rem;
        font-size: 1.5rem;
      }

      .profile-info p {
        color: var(--text-light);
        margin-bottom: 0.5rem;
      }

      .profile-stats {
        display: flex;
        justify-content: space-around;
        margin: 1.5rem 0;
      }

      .stat-item {
        text-align: center;
      }

      .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--primary);
      }

      .stat-label {
        font-size: 0.9rem;
        color: var(--text-light);
      }

      /* Profile Actions */
      .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
      }

      .profile-btn {
        padding: 12px;
        border-radius: var(--radius);
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
      }

      .profile-btn-primary {
        background: var(--primary);
        color: white;
      }

      .profile-btn-primary:hover {
        background: var(--primary-dark);
      }

      .profile-btn-outline {
        background: transparent;
        border: 1px solid var(--primary);
        color: var(--primary);
      }

      .profile-btn-outline:hover {
        background: var(--primary-light);
      }

      .profile-btn-danger {
        background: var(--accent);
        color: white;
      }

      .profile-btn-danger:hover {
        background: var(--accent-dark);
      }

      /* Profile Content */
      .profile-content {
        display: flex;
        flex-direction: column;
        gap: 2rem;
      }

      /* Profile Section */
      .profile-section {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 1.5rem;
      }

      .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border-color);
      }

      .section-header h2 {
        color: var(--primary);
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 8px;
      }

      .section-header .edit-btn {
        background: none;
        border: none;
        color: var(--primary);
        font-weight: 600;
        cursor: pointer;
        transition: color 0.2s;
      }

      .section-header .edit-btn:hover {
        color: var(--primary-dark);
      }

      /* Profile Form */
      .profile-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
      }

      @media (max-width: 576px) {
        .profile-form {
          grid-template-columns: 1fr;
        }
      }

      .form-group {
        margin-bottom: 1rem;
      }

      .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-dark);
      }

      .form-control {
        width: 45%;
        padding: 12px;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        font-size: 1rem;
        transition: all 0.2s;
        background: var(--light-bg);
      }

      .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(10, 69, 166, 0.2);
      }

      .form-control[readonly] {
        background: #f5f5f5;
        color: var(--text-light);
      }

      .form-actions {
        grid-column: span 2;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 1rem;
      }

      @media (max-width: 576px) {
        .form-actions {
          grid-column: span 1;
        }
      }

      /* Orders Section */
      .orders-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
      }

      .order-card {
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 1rem;
        transition: all 0.2s;
      }

      .order-card:hover {
        border-color: var(--primary);
        box-shadow: 0 2px 8px rgba(10, 69, 166, 0.1);
      }

      .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
      }

      .order-id {
        font-weight: 600;
        color: var(--primary);
      }

      .order-date {
        color: var(--text-light);
        font-size: 0.9rem;
      }

      .order-status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
      }

      .status-processing {
        background: #fff3e0;
        color: #e65100;
      }

      .status-shipped {
        background: #e3f2fd;
        color: #1565c0;
      }

      .status-delivered {
        background: #e8f5e9;
        color: #2e7d32;
      }

      .status-cancelled {
        background: #ffebee;
        color: #c62828;
      }

      .order-details {
        display: grid;
        grid-template-columns: 80px 1fr auto;
        gap: 1rem;
        margin-top: 1rem;
      }

      @media (max-width: 576px) {
        .order-details {
          grid-template-columns: 1fr;
        }
      }

      .order-image {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
      }

      .order-info h4 {
        margin-bottom: 0.5rem;
        color: var(--text-dark);
      }

      .order-info p {
        color: var(--text-light);
        font-size: 0.9rem;
      }

      .order-price {
        font-weight: 600;
        color: var(--primary);
        text-align: right;
      }

      .order-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-top: 1rem;
      }

      .order-btn {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
      }

      .order-btn-primary {
        background: var(--primary);
        color: white;
        border: none;
      }

      .order-btn-primary:hover {
        background: var(--primary-dark);
      }

      .order-btn-outline {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-dark);
      }

      .order-btn-outline:hover {
        border-color: var(--primary);
        color: var(--primary);
      }

      /* Empty State */
      .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--text-light);
      }

      .empty-state i {
        font-size: 3rem;
        color: var(--border-color);
        margin-bottom: 1rem;
      }

      /* Responsive Adjustments */
      @media (max-width: 768px) {
        .profile-pic-wrap {
          width: 120px;
          height: 120px;
        }
      }

      @media (max-width: 576px) {
        .profile-header h1 {
          font-size: 1.8rem;
        }

        .profile-pic-wrap {
          width: 100px;
          height: 100px;
        }

        .profile-stats {
          flex-direction: column;
          gap: 1rem;
        }
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
            </div>
          </div>
          <a href="cart.php" class="nav-icon cart" id="cartIcon">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count" id="cartCounter">0</span>
          </a>
        </div>
      </div>
    </nav>

    <main>
      <div class="profile-container">
        <div class="profile-header">
          <h1><i class="fas fa-user-circle"></i> My Profile</h1>
          <p>Manage your account information and track your orders</p>
        </div>

        <div class="profile-layout">
          <!-- Profile Sidebar -->
          <div class="profile-card">
            <div class="profile-pic-wrap">
              <img
                id="profilePic"
                src="images/user-default.png"
                alt="Profile Photo"
                class="profile-pic"
              />
              <label for="profilePicInput" class="profile-pic-overlay">
                <i class="fas fa-camera"></i>
              </label>
              <input
                type="file"
                id="profilePicInput"
                accept="image/*"
                class="profile-pic-input"
              />
            </div>

            <div class="profile-info">
              <h2 id="profileNameDisplay">John Doe</h2>
              <p id="profileEmailDisplay">john.doe@example.com</p>
              <p id="profileMemberSince">Member since June 2023</p>
            </div>

            <div class="profile-stats">
              <div class="stat-item">
                <div class="stat-number" id="ordersCount">12</div>
                <div class="stat-label">Orders</div>
              </div>
              <div class="stat-item">
                <div class="stat-number" id="wishlistCount">5</div>
                <div class="stat-label">Wishlist</div>
              </div>
            </div>

            <div class="profile-actions">
              <button
                class="profile-btn profile-btn-primary"
                id="editProfileBtn"
              >
                <i class="fas fa-edit"></i> Edit Profile
              </button>
              <button
                class="profile-btn profile-btn-outline"
                id="changePasswordBtn"
              >
                <i class="fas fa-lock"></i> Change Password
              </button>
              <button
                class="profile-btn profile-btn-outline"
                id="addressBookBtn"
              >
                <i class="fas fa-address-book"></i> Address Book
              </button>
              <button class="profile-btn profile-btn-outline" id="wishlistBtn">
                <i class="fas fa-heart"></i> My Wishlist
              </button>
              <a href="logout.php" class="profile-btn profile-btn-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </div>

          <!-- Profile Content -->
          <div class="profile-content">
            <!-- Personal Information Section -->
            <div class="profile-section">
              <div class="section-header">
                <h2><i class="fas fa-user"></i> Personal Information</h2>
                <button class="edit-btn" id="editPersonalInfoBtn">
                  <i class="fas fa-edit"></i> Edit
                </button>
              </div>

              <form id="personalInfoForm">
                <div class="profile-form">
                  <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input
                      type="text"
                      id="firstName"
                      class="form-control"
                      value="John"
                      readonly
                    />
                  </div>
                  <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input
                      type="text"
                      id="lastName"
                      class="form-control"
                      value="Doe"
                      readonly
                    />
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input
                      type="email"
                      id="email"
                      class="form-control"
                      value="john.doe@example.com"
                      readonly
                    />
                  </div>
                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input
                      type="tel"
                      id="phone"
                      class="form-control"
                      value="+1 (555) 123-4567"
                      readonly
                    />
                  </div>
                  <div class="form-group">
                    <label for="birthdate">Birthdate</label>
                    <input
                      type="date"
                      id="birthdate"
                      class="form-control"
                      value="1990-01-15"
                      readonly
                    />
                  </div>
                  <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" class="form-control" disabled>
                      <option value="male" selected>Male</option>
                      <option value="female">Female</option>
                      <option value="other">Other</option>
                      <option value="prefer-not-to-say">
                        Prefer not to say
                      </option>
                    </select>
                  </div>
                  <div
                    class="form-actions"
                    id="personalInfoActions"
                    style="display: none"
                  >
                    <button
                      type="button"
                      class="profile-btn profile-btn-outline"
                      id="cancelPersonalInfoBtn"
                    >
                      Cancel
                    </button>
                    <button
                      type="submit"
                      class="profile-btn profile-btn-primary"
                    >
                      Save Changes
                    </button>
                  </div>
                </div>
              </form>
            </div>

            <!-- Recent Orders Section -->
            <div class="profile-section">
              <div class="section-header">
                <h2><i class="fas fa-shopping-bag"></i> Recent Orders</h2>
                <a href="myorders.php" class="edit-btn"> View All </a>
              </div>

              <div class="orders-list">
                <!-- Order 1 -->
                <div class="order-card">
                  <div class="order-header">
                    <div>
                      <span class="order-id">Order #BB-2023-45678</span>
                      <span class="order-date">June 15, 2023</span>
                    </div>
                    <span class="order-status status-delivered">Delivered</span>
                  </div>
                  <div class="order-details">
                    <img
                      src="https://via.placeholder.com/200x180?text=Laptop+Pro"
                      alt="Product"
                      class="order-image"
                    />
                    <div class="order-info">
                      <h4>Laptop Pro Max</h4>
                      <p>Qty: 1 • Color: Space Gray</p>
                    </div>
                    <div class="order-price">$1,299.99</div>
                  </div>
                  <div class="order-actions">
                    <button class="order-btn order-btn-outline">
                      <i class="fas fa-truck"></i> Track Order
                    </button>
                    <button class="order-btn order-btn-primary">
                      <i class="fas fa-shopping-bag"></i> Buy Again
                    </button>
                  </div>
                </div>

                <!-- Order 2 -->
                <div class="order-card">
                  <div class="order-header">
                    <div>
                      <span class="order-id">Order #BB-2023-45677</span>
                      <span class="order-date">June 10, 2023</span>
                    </div>
                    <span class="order-status status-shipped">Shipped</span>
                  </div>
                  <div class="order-details">
                    <img
                      src="https://via.placeholder.com/200x180?text=Smartphone+X"
                      alt="Product"
                      class="order-image"
                    />
                    <div class="order-info">
                      <h4>Smartphone X</h4>
                      <p>Qty: 1 • Color: Midnight Black</p>
                    </div>
                    <div class="order-price">$799.00</div>
                  </div>
                  <div class="order-actions">
                    <button class="order-btn order-btn-outline">
                      <i class="fas fa-truck"></i> Track Order
                    </button>
                    <button class="order-btn order-btn-primary">
                      <i class="fas fa-shopping-bag"></i> Buy Again
                    </button>
                  </div>
                </div>

                <!-- Empty State (for demo purposes, hidden by default) -->
                <div class="empty-state" style="display: none">
                  <i class="fas fa-shopping-bag"></i>
                  <h3>No Orders Yet</h3>
                  <p>Your recent orders will appear here</p>
                  <button
                    class="profile-btn profile-btn-primary"
                    style="margin-top: 1rem"
                  >
                    Start Shopping
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Newsletter & Social -->
    <section id="newsletterSocial">
      <div class="newsletter">
        <h3>Stay Updated With Our Latest Offers</h3>
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
          ><i class="fas fa-twitter"></i
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
      <a href="new-arrivals.php" class="mbnav-item" aria-label="New Arrivals"
        ><i class="fas fa-star"></i><span>New</span></a
      >
      <a href="contact.php" class="mbnav-item" aria-label="Contact"
        ><i class="fas fa-headset"></i><span>Contact</span></a
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
      // --- Profile logic ---
      document.addEventListener("DOMContentLoaded", function () {
        // Load user data
        const user = getLoggedInUserObj();
        if (!user) {
          window.location.href = "signin.php";
          return;
        }
        setProfileDetailsToForm(user);

        // Load custom photo if exists
        const email = localStorage.getItem("loggedInUser");
        const photo = email
          ? localStorage.getItem("profilePic_" + email)
          : null;
        if (photo) document.getElementById("profilePic").src = photo;

        // Update displayed name and email
        document.getElementById("profileNameDisplay").textContent =
          user.name || "User";
        document.getElementById("profileEmailDisplay").textContent =
          user.email || "";

        // Set member since date (demo - would come from user data in real app)
        const joinDate = new Date();
        joinDate.setMonth(joinDate.getMonth() - 3); // 3 months ago for demo
        const options = { year: "numeric", month: "long" };
        document.getElementById(
          "profileMemberSince"
        ).textContent = `Member since ${joinDate.toLocaleDateString(
          "en-US",
          options
        )}`;

        // Profile picture upload
        document
          .getElementById("profilePicInput")
          .addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (!file) return;

            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
              alert("Please select an image smaller than 2MB");
              return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
              const dataUrl = e.target.result;
              document.getElementById("profilePic").src = dataUrl;
              // Save photo to localStorage per user
              const email = localStorage.getItem("loggedInUser");
              if (email) {
                localStorage.setItem("profilePic_" + email, dataUrl);
                showToast("Profile picture updated successfully!");
              }
            };
            reader.readAsDataURL(file);
          });

        // Edit profile buttons
        const editProfileBtn = document.getElementById("editProfileBtn");
        const editPersonalInfoBtn = document.getElementById(
          "editPersonalInfoBtn"
        );
        const cancelPersonalInfoBtn = document.getElementById(
          "cancelPersonalInfoBtn"
        );
        const personalInfoForm = document.getElementById("personalInfoForm");
        const personalInfoActions = document.getElementById(
          "personalInfoActions"
        );

        editProfileBtn.addEventListener("click", function () {
          editPersonalInfoBtn.click();
        });

        editPersonalInfoBtn.addEventListener("click", function () {
          // Enable form fields
          const formControls = personalInfoForm.querySelectorAll(
            ".form-control, select"
          );
          formControls.forEach((control) => {
            if (control.tagName === "SELECT") {
              control.disabled = false;
            } else {
              control.readOnly = false;
            }
          });

          // Show action buttons
          personalInfoActions.style.display = "flex";
        });

        cancelPersonalInfoBtn.addEventListener("click", function () {
          // Disable form fields
          const formControls = personalInfoForm.querySelectorAll(
            ".form-control, select"
          );
          formControls.forEach((control) => {
            if (control.tagName === "SELECT") {
              control.disabled = true;
            } else {
              control.readOnly = true;
            }
          });

          // Hide action buttons
          personalInfoActions.style.display = "none";

          // Reset form to original values
          // In a real app, you might want to reload from server or stored data
        });

        personalInfoForm.addEventListener("submit", function (e) {
          e.preventDefault();

          // Get form values
          const firstName = document.getElementById("firstName").value;
          const lastName = document.getElementById("lastName").value;
          const phone = document.getElementById("phone").value;
          const birthdate = document.getElementById("birthdate").value;
          const gender = document.getElementById("gender").value;

          // Update user object
          const email = localStorage.getItem("loggedInUser");
          let users = [];
          try {
            users = JSON.parse(localStorage.getItem("users")) || [];
          } catch {}

          const idx = users.findIndex((u) => u.email === email);
          if (idx > -1) {
            users[idx].name = `${firstName} ${lastName}`.trim();
            users[idx].phone = phone;
            users[idx].birthdate = birthdate;
            users[idx].gender = gender;

            localStorage.setItem("users", JSON.stringify(users));

            // Update displayed name
            document.getElementById("profileNameDisplay").textContent =
              users[idx].name;
          }

          // Disable form fields
          const formControls = personalInfoForm.querySelectorAll(
            ".form-control, select"
          );
          formControls.forEach((control) => {
            if (control.tagName === "SELECT") {
              control.disabled = true;
            } else {
              control.readOnly = true;
            }
          });

          // Hide action buttons
          personalInfoActions.style.display = "none";

          showToast("Profile updated successfully!");
        });

        // Other action buttons
        document
          .getElementById("changePasswordBtn")
          .addEventListener("click", function () {
            // In a real app, this would open a change password modal or redirect
            alert("Change password functionality would open here");
          });

        document
          .getElementById("addressBookBtn")
          .addEventListener("click", function () {
            // In a real app, this would redirect to address book page
            alert("Address book would open here");
          });

        document
          .getElementById("wishlistBtn")
          .addEventListener("click", function () {
            // In a real app, this would redirect to wishlist page
            alert("Wishlist would open here");
          });
      });

      function getLoggedInUserObj() {
        const email = localStorage.getItem("loggedInUser");
        if (!email) return null;
        let users = [];
        try {
          users = JSON.parse(localStorage.getItem("users")) || [];
        } catch {}
        return users.find((u) => u.email === email) || null;
      }

      function setProfileDetailsToForm(user) {
        // Split name into first and last
        const nameParts = (user.name || "").split(" ");
        const firstName = nameParts[0] || "";
        const lastName = nameParts.slice(1).join(" ") || "";

        document.getElementById("firstName").value = firstName;
        document.getElementById("lastName").value = lastName;
        document.getElementById("email").value = user.email || "";
        document.getElementById("phone").value = user.phone || "";
        document.getElementById("birthdate").value = user.birthdate || "";
        document.getElementById("gender").value =
          user.gender || "prefer-not-to-say";
      }

      function showToast(message) {
        const toast = document.createElement("div");
        toast.className = "toast";
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
          toast.classList.add("show");
        }, 10);

        setTimeout(() => {
          toast.classList.remove("show");
          setTimeout(() => {
            document.body.removeChild(toast);
          }, 300);
        }, 3000);
      }
    </script>
  </body>
</html>
