<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gadgets - Brand Bazaar</title>
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

      /* Gadgets Page Specific Styles */
      .category-hero {
        background: linear-gradient(135deg, #0a45a6 0%, #1a6dff 100%);
        color: white;
        padding: 3rem 1rem;
        text-align: center;
        margin-bottom: 2rem;
      }

      .category-hero h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
      }

      .category-hero p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto 1.5rem;
      }

      .category-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
      }

      .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 2rem 0 1.5rem;
      }

      .section-header h2 {
        color: var(--primary);
        font-size: 1.8rem;
        margin: 0;
      }

      .view-all {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .view-all:hover {
        text-decoration: underline;
      }

      .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
      }

      .product-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
      }

      .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      }

      .product-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: var(--danger);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        z-index: 2;
      }

      .product-image {
        width: 100%;
        height: 200px;
        object-fit: contain;
        background: #f9f9f9;
        padding: 1rem;
      }

      .product-info {
        padding: 1.5rem;
      }

      .product-title {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: var(--secondary);
      }

      .product-specs {
        font-size: 0.9rem;
        color: var(--text-light);
        margin-bottom: 1rem;
        line-height: 1.5;
      }

      .product-price {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 1rem;
      }

      .product-current {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary);
      }

      .product-original {
        font-size: 1rem;
        color: var(--text-light);
        text-decoration: line-through;
      }

      .product-discount {
        color: var(--danger);
        font-weight: 600;
        font-size: 0.9rem;
      }

      .product-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: var(--text-light);
        margin-top: 1rem;
      }

      .product-rating {
        color: #ffb400;
      }

      .product-actions {
        display: flex;
        gap: 0.8rem;
        margin-top: 1rem;
      }

      .btn {
        padding: 0.6rem 1.2rem;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.9rem;
        border: none;
        flex: 1;
        text-align: center;
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

      .filter-section {
        background: var(--light-bg);
        border-radius: var(--radius);
        padding: 1.5rem;
        margin-bottom: 2rem;
      }

      .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
      }

      .filter-header h3 {
        margin: 0;
        font-size: 1.2rem;
      }

      .filter-group {
        margin-bottom: 1.5rem;
      }

      .filter-group h4 {
        margin: 0 0 0.8rem 0;
        font-size: 1rem;
      }

      .filter-options {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
      }

      .filter-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .filter-option input {
        margin: 0;
      }

      .filter-option label {
        font-size: 0.9rem;
      }

      .filter-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
      }

      /* Responsive styles */
      @media (min-width: 768px) {
        .category-content {
          display: grid;
          grid-template-columns: 250px 1fr;
          gap: 2rem;
        }
      }

      @media (max-width: 768px) {
        .category-hero h1 {
          font-size: 2rem;
        }

        .category-hero p {
          font-size: 1rem;
        }

        .products-grid {
          grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        }
      }

      @media (max-width: 480px) {
        .products-grid {
          grid-template-columns: 1fr;
        }

        .section-header {
          flex-direction: column;
          align-items: flex-start;
          gap: 0.5rem;
        }
      }
    </style>
  </head>
  <body>
    <!-- Navigation (same as laptops.php) -->
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
              <a href="gadgets.php" class="category-link active">Gadgets</a>

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
      <!-- Gadgets Hero Section -->
      <section class="category-hero">
        <div class="category-container">
          <h1>Cutting-Edge Gadgets & Tech</h1>
          <p>
            Discover the latest innovative gadgets, smart devices, and tech
            accessories to enhance your digital lifestyle.
          </p>
        </div>
      </section>

      <div class="category-container">
        <div class="category-content">
          <!-- Filters Section -->
          <aside class="filter-section">
            <div class="filter-header">
              <h3>Filters</h3>
              <button class="btn btn-outline" style="padding: 0.3rem 0.6rem">
                Reset
              </button>
            </div>

            <div class="filter-group">
              <h4>Price Range</h4>
              <div class="filter-options">
                <div class="filter-option">
                  <input type="radio" id="price-all" name="price" checked />
                  <label for="price-all">All Prices</label>
                </div>
                <div class="filter-option">
                  <input type="radio" id="price-1" name="price" />
                  <label for="price-1">Under $100</label>
                </div>
                <div class="filter-option">
                  <input type="radio" id="price-2" name="price" />
                  <label for="price-2">$100 - $300</label>
                </div>
                <div class="filter-option">
                  <input type="radio" id="price-3" name="price" />
                  <label for="price-3">$300 - $500</label>
                </div>
                <div class="filter-option">
                  <input type="radio" id="price-4" name="price" />
                  <label for="price-4">Over $500</label>
                </div>
              </div>
            </div>

            <div class="filter-group">
              <h4>Category</h4>
              <div class="filter-options">
                <div class="filter-option">
                  <input type="checkbox" id="category-smart" checked />
                  <label for="category-smart">Smart Devices</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="category-wearables" checked />
                  <label for="category-wearables">Wearables</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="category-home" checked />
                  <label for="category-home">Smart Home</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="category-camera" checked />
                  <label for="category-camera">Camera Gear</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="category-gaming" checked />
                  <label for="category-gaming">Gaming</label>
                </div>
              </div>
            </div>

            <div class="filter-group">
              <h4>Brand</h4>
              <div class="filter-options">
                <div class="filter-option">
                  <input type="checkbox" id="brand-apple" checked />
                  <label for="brand-apple">Apple</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="brand-samsung" checked />
                  <label for="brand-samsung">Samsung</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="brand-sony" checked />
                  <label for="brand-sony">Sony</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="brand-goPro" checked />
                  <label for="brand-goPro">GoPro</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="brand-fitbit" checked />
                  <label for="brand-fitbit">Fitbit</label>
                </div>
              </div>
            </div>

            <div class="filter-group">
              <h4>Features</h4>
              <div class="filter-options">
                <div class="filter-option">
                  <input type="checkbox" id="feature-bluetooth" checked />
                  <label for="feature-bluetooth">Bluetooth</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="feature-waterproof" />
                  <label for="feature-waterproof">Waterproof</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="feature-wireless" checked />
                  <label for="feature-wireless">Wireless</label>
                </div>
                <div class="filter-option">
                  <input type="checkbox" id="feature-app" />
                  <label for="feature-app">Mobile App</label>
                </div>
              </div>
            </div>

            <div class="filter-buttons">
              <button class="btn btn-primary">Apply Filters</button>
              <button class="btn btn-outline">Clear All</button>
            </div>
          </aside>

          <!-- Products Section -->
          <section class="products-section">
            <div class="section-header">
              <h2><i class="fas fa-mobile-alt"></i> All Gadgets</h2>
              <div>
                <span style="margin-right: 1rem">Sort by:</span>
                <select style="padding: 0.5rem; border-radius: 6px">
                  <option>Featured</option>
                  <option>Price: Low to High</option>
                  <option>Price: High to Low</option>
                  <option>Customer Rating</option>
                  <option>Newest Arrivals</option>
                </select>
              </div>
            </div>

            <div class="products-grid">
              <!-- Product 1 -->
              <div class="product-card">
                <span class="product-badge">20% OFF</span>
                <img
                  src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YXBwbGUlMjB3YXRjaHxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60"
                  alt="Apple Watch Series 8"
                  class="product-image"
                />
                <div class="product-info">
                  <h3 class="product-title">Apple Watch Series 8</h3>
                  <p class="product-specs">
                    GPS + Cellular • 45mm • Midnight Aluminum Case • Fitness
                    Tracker
                  </p>
                  <div class="product-price">
                    <span class="product-current">$399.00</span>
                    <span class="product-original">$499.00</span>
                    <span class="product-discount">20% OFF</span>
                  </div>
                  <div class="product-meta">
                    <span class="product-rating">
                      <i class="fas fa-star"></i> 4.8 (342)
                    </span>
                    <span>Free Shipping</span>
                  </div>
                  <div class="product-actions">
                    <button class="btn btn-outline">Add to Wishlist</button>
                    <button class="btn btn-primary">Add to Cart</button>
                  </div>
                </div>
              </div>

              <!-- Product 2 -->
              <div class="product-card">
                <img
                  src="https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8ZHJvbmV8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                  alt="DJI Mavic Air 2"
                  class="product-image"
                />
                <div class="product-info">
                  <h3 class="product-title">DJI Mavic Air 2 Fly More Combo</h3>
                  <p class="product-specs">
                    4K Camera • 34min Flight Time • 10km Transmission • 3
                    Batteries
                  </p>
                  <div class="product-price">
                    <span class="product-current">$999.00</span>
                    <span class="product-original">$1,299.00</span>
                    <span class="product-discount">23% OFF</span>
                  </div>
                  <div class="product-meta">
                    <span class="product-rating">
                      <i class="fas fa-star"></i> 4.9 (287)
                    </span>
                    <span>Free Shipping</span>
                  </div>
                  <div class="product-actions">
                    <button class="btn btn-outline">Add to Wishlist</button>
                    <button class="btn btn-primary">Add to Cart</button>
                  </div>
                </div>
              </div>

              <!-- Product 3 -->
              <div class="product-card">
                <span class="product-badge">15% OFF</span>
                <img
                  src="https://images.unsplash.com/photo-1593784991095-a205069470b6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8Zml0Yml0fGVufDB8fDB8fHww&auto=format&fit=crop&w=500&q=60"
                  alt="Fitbit Charge 5"
                  class="product-image"
                />
                <div class="product-info">
                  <h3 class="product-title">Fitbit Charge 5</h3>
                  <p class="product-specs">
                    Advanced Health & Fitness Tracker • Built-in GPS • 7-Day
                    Battery
                  </p>
                  <div class="product-price">
                    <span class="product-current">$149.95</span>
                    <span class="product-original">$179.95</span>
                    <span class="product-discount">15% OFF</span>
                  </div>
                  <div class="product-meta">
                    <span class="product-rating">
                      <i class="fas fa-star"></i> 4.6 (198)
                    </span>
                    <span>Free Shipping</span>
                  </div>
                  <div class="product-actions">
                    <button class="btn btn-outline">Add to Wishlist</button>
                    <button class="btn btn-primary">Add to Cart</button>
                  </div>
                </div>
              </div>

              <!-- Product 4 -->
              <div class="product-card">
                <span class="product-badge">30% OFF</span>
                <img
                  src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8c21hcnQlMjBzcGVha2VyfGVufDB8fDB8fHww&auto=format&fit=crop&w=500&q=60"
                  alt="Amazon Echo Dot (4th Gen)"
                  class="product-image"
                />
                <div class="product-info">
                  <h3 class="product-title">Amazon Echo Dot (4th Gen)</h3>
                  <p class="product-specs">
                    Smart speaker with Alexa • Charcoal • Voice control your
                    music
                  </p>
                  <div class="product-price">
                    <span class="product-current">$34.99</span>
                    <span class="product-original">$49.99</span>
                    <span class="product-discount">30% OFF</span>
                  </div>
                  <div class="product-meta">
                    <span class="product-rating">
                      <i class="fas fa-star"></i> 4.5 (512)
                    </span>
                    <span>Free Shipping</span>
                  </div>
                  <div class="product-actions">
                    <button class="btn btn-outline">Add to Wishlist</button>
                    <button class="btn btn-primary">Add to Cart</button>
                  </div>
                </div>
              </div>

              <!-- Product 5 -->
              <div class="product-card">
                <img
                  src="https://images.unsplash.com/photo-1574944985070-8f3ebc6b79d2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8Z29wcm98ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                  alt="GoPro HERO10 Black"
                  class="product-image"
                />
                <div class="product-info">
                  <h3 class="product-title">GoPro HERO10 Black</h3>
                  <p class="product-specs">
                    5.3K Video • 23MP Photos • HyperSmooth 4.0 • Waterproof to
                    33ft
                  </p>
                  <div class="product-price">
                    <span class="product-current">$399.99</span>
                    <span class="product-original">$499.99</span>
                    <span class="product-discount">20% OFF</span>
                  </div>
                  <div class="product-meta">
                    <span class="product-rating">
                      <i class="fas fa-star"></i> 4.7 (421)
                    </span>
                    <span>Free Shipping</span>
                  </div>
                  <div class="product-actions">
                    <button class="btn btn-outline">Add to Wishlist</button>
                    <button class="btn btn-primary">Add to Cart</button>
                  </div>
                </div>
              </div>

              <!-- Product 6 -->
              <div class="product-card">
                <span class="product-badge">25% OFF</span>
                <img
                  src="https://images.unsplash.com/photo-1593784991095-a205069470b6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8Zml0Yml0fGVufDB8fDB8fHww&auto=format&fit=crop&w=500&q=60"
                  alt="Sony WH-1000XM5 Headphones"
                  class="product-image"
                />
                <div class="product-info">
                  <h3 class="product-title">Sony WH-1000XM5 Headphones</h3>
                  <p class="product-specs">
                    Industry Leading Noise Canceling • 30hr Battery • Multipoint
                    Connection
                  </p>
                  <div class="product-price">
                    <span class="product-current">$349.99</span>
                    <span class="product-original">$399.99</span>
                    <span class="product-discount">12% OFF</span>
                  </div>
                  <div class="product-meta">
                    <span class="product-rating">
                      <i class="fas fa-star"></i> 4.9 (678)
                    </span>
                    <span>Free Shipping</span>
                  </div>
                  <div class="product-actions">
                    <button class="btn btn-outline">Add to Wishlist</button>
                    <button class="btn btn-primary">Add to Cart</button>
                  </div>
                </div>
              </div>
            </div>
          </section>
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
      <a href="#" class="mbnav-item" id="mbnavSearch" aria-label="Search"
        ><i class="fas fa-search"></i><span>Search</span></a
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
      // Function to show a toast notification
      function showToast(msg) {
        const t = document.getElementById("toast");
        if (!t) return;
        t.textContent = msg;
        t.style.display = "block";
        setTimeout(() => (t.style.display = "none"), 1800);
      }

      // Function to update cart counter in the navigation
      function updateCartCounter() {
        let cart = [];
        try {
          cart = JSON.parse(localStorage.getItem("cart")) || [];
        } catch (e) {
          console.error("Error parsing cart from localStorage:", e);
        }
        let total = cart.reduce((sum, item) => sum + (item.qty || 1), 0);
        const cartCounters = document.querySelectorAll(".cart-count, #cartCounterMobile");
        cartCounters.forEach(countElement => {
            if (countElement) countElement.textContent = total;
        });
      }

      // Add to cart functionality
      document.addEventListener("click", function (e) {
        if (
          e.target.classList.contains("btn-primary") &&
          e.target.textContent.includes("Add to Cart")
        ) {
          const productCard = e.target.closest(".product-card");
          const productName =
            productCard.querySelector(".product-title").textContent;
          const productPrice = parseFloat(
            productCard
              .querySelector(".product-current")
              .textContent.replace("$", "")
              .replace(",", "")
          );
          const productId = productCard.dataset.productId || Date.now(); // Assuming a data-product-id attribute, or use a timestamp
          const productImage = productCard.querySelector(".product-image").src; // Assuming product image source

          let cart = JSON.parse(localStorage.getItem("cart")) || [];
          const existingProductIndex = cart.findIndex(item => item.id == productId);

          if (existingProductIndex > -1) {
            cart[existingProductIndex].qty += 1;
          } else {
            cart.push({
              id: productId,
              name: productName,
              price: productPrice,
              image: productImage,
              qty: 1
            });
          }

          localStorage.setItem("cart", JSON.stringify(cart));
          updateCartCounter();
          showToast(`${productName} added to cart!`);
        }
      });

      // Filter functionality would go here in a real implementation
      document.addEventListener("DOMContentLoaded", function () {
        // This would handle filter changes and product sorting
      });

      // Initialize cart counter on page load
      document.addEventListener("DOMContentLoaded", updateCartCounter);

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
