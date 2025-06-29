<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hot Deals - Brand Bazaar</title>
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

      /* Deals Page Specific Styles */
      .deals-hero {
        background: linear-gradient(135deg, #0a45a6 0%, #1a6dff 100%);
        color: white;
        padding: 3rem 1rem;
        text-align: center;
        margin-bottom: 2rem;
      }

      .deals-hero h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
      }

      .deals-hero p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto 1.5rem;
      }

      .countdown {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin: 1.5rem 0;
      }

      .countdown-item {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        padding: 0.8rem 1.2rem;
        min-width: 70px;
      }

      .countdown-value {
        font-size: 1.8rem;
        font-weight: 700;
        display: block;
      }

      .countdown-label {
        font-size: 0.8rem;
        opacity: 0.9;
      }

      .deals-container {
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

      .deals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
      }

      .deal-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
      }

      .deal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      }

      .deal-badge {
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

      .deal-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
      }

      .deal-info {
        padding: 1.5rem;
      }

      .deal-title {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: var(--secondary);
      }

      .deal-price {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 1rem;
      }

      .deal-current {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary);
      }

      .deal-original {
        font-size: 1rem;
        color: var(--text-light);
        text-decoration: line-through;
      }

      .deal-discount {
        color: var(--danger);
        font-weight: 600;
        font-size: 0.9rem;
      }

      .deal-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: var(--text-light);
        margin-top: 1rem;
      }

      .deal-rating {
        color: #ffb400;
      }

      .deal-actions {
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

      .flash-deals {
        background: #fff8f8;
        border-radius: var(--radius);
        padding: 2rem;
        margin: 3rem 0;
      }

      .flash-deals .section-header h2 {
        color: var(--danger);
      }

      .category-deals {
        margin: 3rem 0;
      }

      .category-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
      }

      .category-tab {
        padding: 0.6rem 1.2rem;
        background: #f0f4ff;
        border-radius: 20px;
        cursor: pointer;
        font-weight: 600;
        white-space: nowrap;
        transition: all 0.2s;
      }

      .category-tab.active {
        background: var(--primary);
        color: white;
      }

      .category-tab:hover:not(.active) {
        background: #d9e3ff;
      }

      /* Responsive styles */
      @media (max-width: 768px) {
        .deals-hero h1 {
          font-size: 2rem;
        }

        .deals-hero p {
          font-size: 1rem;
        }

        .countdown {
          gap: 0.5rem;
        }

        .countdown-item {
          min-width: 60px;
          padding: 0.6rem;
        }

        .countdown-value {
          font-size: 1.5rem;
        }

        .deals-grid {
          grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        }
      }

      @media (max-width: 480px) {
        .deals-grid {
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
          <a href="deals.php" class="active">Deals</a>

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
      <!-- Deals Hero Section -->
      <section class="deals-hero">
        <div class="deals-container">
          <h1>Hot Deals & Discounts</h1>
          <p>
            Limited time offers on your favorite products. Don't miss out on
            these exclusive savings!
          </p>

          <div class="countdown">
            <div class="countdown-item">
              <span class="countdown-value" id="days">02</span>
              <span class="countdown-label">Days</span>
            </div>
            <div class="countdown-item">
              <span class="countdown-value" id="hours">12</span>
              <span class="countdown-label">Hours</span>
            </div>
            <div class="countdown-item">
              <span class="countdown-value" id="minutes">45</span>
              <span class="countdown-label">Minutes</span>
            </div>
            <div class="countdown-item">
              <span class="countdown-value" id="seconds">30</span>
              <span class="countdown-label">Seconds</span>
            </div>
          </div>
        </div>
      </section>

      <div class="deals-container">
        <!-- Flash Deals Section -->
        <section class="flash-deals">
          <div class="section-header">
            <h2><i class="fas fa-bolt"></i> Flash Deals</h2>
            <a href="#" class="view-all"
              >View All <i class="fas fa-chevron-right"></i
            ></a>
          </div>

          <div class="deals-grid">
            <!-- Deal 1 -->
            <div class="deal-card">
              <span class="deal-badge">60% OFF</span>
              <img
                src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8c21hcnR3YXRjaHxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60"
                alt="Smart Watch Pro"
                class="deal-image"
              />
              <div class="deal-info">
                <h3 class="deal-title">Smart Watch Pro Series 3</h3>
                <div class="deal-price">
                  <span class="deal-current">$129.99</span>
                  <span class="deal-original">$299.99</span>
                  <span class="deal-discount">60% OFF</span>
                </div>
                <div class="deal-meta">
                  <span class="deal-rating">
                    <i class="fas fa-star"></i> 4.8 (124)
                  </span>
                  <span>32 sold</span>
                </div>
                <div class="deal-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Deal 2 -->
            <div class="deal-card">
              <span class="deal-badge">55% OFF</span>
              <img
                src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8aGVhZHBob25lc3xlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60"
                alt="Wireless Headphones"
                class="deal-image"
              />
              <div class="deal-info">
                <h3 class="deal-title">Premium Wireless Headphones</h3>
                <div class="deal-price">
                  <span class="deal-current">$89.99</span>
                  <span class="deal-original">$199.99</span>
                  <span class="deal-discount">55% OFF</span>
                </div>
                <div class="deal-meta">
                  <span class="deal-rating">
                    <i class="fas fa-star"></i> 4.7 (89)
                  </span>
                  <span>45 sold</span>
                </div>
                <div class="deal-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Deal 3 -->
            <div class="deal-card">
              <span class="deal-badge">70% OFF</span>
              <img
                src="https://images.unsplash.com/photo-1546435770-a3e426bf472b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8c3BlYWtlcnxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60"
                alt="Bluetooth Speaker"
                class="deal-image"
              />
              <div class="deal-info">
                <h3 class="deal-title">Portable Bluetooth Speaker</h3>
                <div class="deal-price">
                  <span class="deal-current">$39.99</span>
                  <span class="deal-original">$129.99</span>
                  <span class="deal-discount">70% OFF</span>
                </div>
                <div class="deal-meta">
                  <span class="deal-rating">
                    <i class="fas fa-star"></i> 4.5 (67)
                  </span>
                  <span>28 sold</span>
                </div>
                <div class="deal-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Category Deals Section -->
        <section class="category-deals">
          <div class="section-header">
            <h2><i class="fas fa-tags"></i> Category Deals</h2>
            <a href="#" class="view-all"
              >View All <i class="fas fa-chevron-right"></i
            ></a>
          </div>

          <div class="category-tabs">
            <div class="category-tab active">All Categories</div>
            <div class="category-tab">Electronics</div>
            <div class="category-tab">Fashion</div>
            <div class="category-tab">Home & Kitchen</div>
            <div class="category-tab">Beauty</div>
            <div class="category-tab">Sports</div>
          </div>

          <div class="deals-grid">
            <!-- Deal 1 -->
            <div class="deal-card">
              <span class="deal-badge">40% OFF</span>
              <img
                src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cHJvZHVjdHxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60"
                alt="Smart Watch"
                class="deal-image"
              />
              <div class="deal-info">
                <h3 class="deal-title">Smart Watch Fitness Tracker</h3>
                <div class="deal-price">
                  <span class="deal-current">$59.99</span>
                  <span class="deal-original">$99.99</span>
                  <span class="deal-discount">40% OFF</span>
                </div>
                <div class="deal-meta">
                  <span class="deal-rating">
                    <i class="fas fa-star"></i> 4.3 (56)
                  </span>
                  <span>18 sold</span>
                </div>
                <div class="deal-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Deal 2 -->
            <div class="deal-card">
              <span class="deal-badge">50% OFF</span>
              <img
                src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8c2hvZXN8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                alt="Running Shoes"
                class="deal-image"
              />
              <div class="deal-info">
                <h3 class="deal-title">Men's Running Shoes</h3>
                <div class="deal-price">
                  <span class="deal-current">$49.99</span>
                  <span class="deal-original">$99.99</span>
                  <span class="deal-discount">50% OFF</span>
                </div>
                <div class="deal-meta">
                  <span class="deal-rating">
                    <i class="fas fa-star"></i> 4.6 (112)
                  </span>
                  <span>42 sold</span>
                </div>
                <div class="deal-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Deal 3 -->
            <div class="deal-card">
              <span class="deal-badge">35% OFF</span>
              <img
                src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2FtZXJhfGVufDB8fDB8fHww&auto=format&fit=crop&w=500&q=60"
                alt="Digital Camera"
                class="deal-image"
              />
              <div class="deal-info">
                <h3 class="deal-title">Digital Camera 20MP</h3>
                <div class="deal-price">
                  <span class="deal-current">$129.99</span>
                  <span class="deal-original">$199.99</span>
                  <span class="deal-discount">35% OFF</span>
                </div>
                <div class="deal-meta">
                  <span class="deal-rating">
                    <i class="fas fa-star"></i> 4.4 (78)
                  </span>
                  <span>25 sold</span>
                </div>
                <div class="deal-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Deal 4 -->
            <div class="deal-card">
              <span class="deal-badge">45% OFF</span>
              <img
                src="https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8c2hpcHxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60"
                alt="Backpack"
                class="deal-image"
              />
              <div class="deal-info">
                <h3 class="deal-title">Travel Backpack 40L</h3>
                <div class="deal-price">
                  <span class="deal-current">$44.99</span>
                  <span class="deal-original">$81.99</span>
                  <span class="deal-discount">45% OFF</span>
                </div>
                <div class="deal-meta">
                  <span class="deal-rating">
                    <i class="fas fa-star"></i> 4.7 (93)
                  </span>
                  <span>36 sold</span>
                </div>
                <div class="deal-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Daily Deals Section -->
        <section class="daily-deals">
          <div class="section-header">
            <h2><i class="fas fa-calendar-day"></i> Daily Deals</h2>
            <a href="#" class="view-all"
              >View All <i class="fas fa-chevron-right"></i
            ></a>
          </div>

          <div class="deals-grid">
            <!-- Deal 1 -->
            <div class="deal-card">
              <span class="deal-badge">Today Only</span>
              <img
                src="https://images.unsplash.com/photo-1546054454-aa26e2b734c7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8a2V5Ym9hcmR8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                alt="Mechanical Keyboard"
                class="deal-image"
              />
              <div class="deal-info">
                <h3 class="deal-title">Mechanical Gaming Keyboard</h3>
                <div class="deal-price">
                  <span class="deal-current">$49.99</span>
                  <span class="deal-original">$79.99</span>
                  <span class="deal-discount">38% OFF</span>
                </div>
                <div class="deal-meta">
                  <span class="deal-rating">
                    <i class="fas fa-star"></i> 4.5 (87)
                  </span>
                  <span>22 sold</span>
                </div>
                <div class="deal-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Deal 2 -->
            <div class="deal-card">
              <span class="deal-badge">Today Only</span>
              <img
                src="https://images.unsplash.com/photo-1585386959984-a4155224a1ad?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8cGVyZnVtZXxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60"
                alt="Perfume"
                class="deal-image"
              />
              <div class="deal-info">
                <h3 class="deal-title">Luxury Perfume 100ml</h3>
                <div class="deal-price">
                  <span class="deal-current">$39.99</span>
                  <span class="deal-original">$69.99</span>
                  <span class="deal-discount">43% OFF</span>
                </div>
                <div class="deal-meta">
                  <span class="deal-rating">
                    <i class="fas fa-star"></i> 4.8 (134)
                  </span>
                  <span>58 sold</span>
                </div>
                <div class="deal-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Deal 3 -->
            <div class="deal-card">
              <span class="deal-badge">Today Only</span>
              <img
                src="https://images.unsplash.com/photo-1560343090-f0409e92791a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8c2hpcnR8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                alt="T-Shirt"
                class="deal-image"
              />
              <div class="deal-info">
                <h3 class="deal-title">Premium Cotton T-Shirt</h3>
                <div class="deal-price">
                  <span class="deal-current">$14.99</span>
                  <span class="deal-original">$29.99</span>
                  <span class="deal-discount">50% OFF</span>
                </div>
                <div class="deal-meta">
                  <span class="deal-rating">
                    <i class="fas fa-star"></i> 4.6 (215)
                  </span>
                  <span>87 sold</span>
                </div>
                <div class="deal-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>
          </div>
        </section>
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
      <a href="deals.php" class="mbnav-item active" aria-label="Deals"
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
          const productCard = e.target.closest(".deal-card");
          const productName =
            productCard.querySelector(".deal-title").textContent;
          const productPrice = parseFloat(
            productCard
              .querySelector(".deal-current")
              .textContent.replace("$", "")
          );
          const productId = productCard.dataset.productId || Date.now(); // Assuming a data-product-id attribute, or use a timestamp
          const productImage = productCard.querySelector(".deal-image").src; // Assuming product image source

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

      // Initialize cart counter on page load
      document.addEventListener("DOMContentLoaded", updateCartCounter);

      // Simple countdown timer for demonstration
      document.addEventListener("DOMContentLoaded", function () {
        const countdownElement = document.getElementById("dealCountdown");
        if (!countdownElement) return;

        const targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + 7); // 7 days from now

        function updateCountdown() {
          const now = new Date().getTime();
          const distance = targetDate.getTime() - now;

          if (distance < 0) {
            countdownElement.innerHTML = "EXPIRED";
            return;
          }

          const days = Math.floor(distance / (1000 * 60 * 60 * 24));
          const hours = Math.floor(
            (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
          );
          const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          const seconds = Math.floor((distance % (1000 * 60)) / 1000);

          countdownElement.innerHTML = `
                        <span class="countdown-value">${days}</span><span class="countdown-label">Days</span>
                        <span class="countdown-value">${hours}</span><span class="countdown-label">Hours</span>
                        <span class="countdown-value">${minutes}</span><span class="countdown-label">Mins</span>
                        <span class="countdown-value">${seconds}</span><span class="countdown-label">Secs</span>
                    `;
        }

        setInterval(updateCountdown, 1000);
        updateCountdown();
      });

      // Tab functionality for categories
      document.querySelectorAll(".category-tab").forEach((tab) => {
        tab.addEventListener("click", () => {
          document
            .querySelectorAll(".category-tab")
            .forEach((t) => t.classList.remove("active"));
          tab.classList.add("active");
          // In a real application, you would filter products here based on the tab clicked
          console.log(`Category selected: ${tab.textContent}`);
        });
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
