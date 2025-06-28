<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trending Products - Brand Bazaar</title>
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

      /* Trending Page Specific Styles */
      .trending-hero {
        background: linear-gradient(135deg, #0a45a6 0%, #1a6dff 100%);
        color: white;
        padding: 3rem 1rem;
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
      }

      .trending-hero::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8c2hvZXN8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60")
          center/cover;
        opacity: 0.15;
      }

      .trending-hero h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        position: relative;
      }

      .trending-hero p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto 1.5rem;
        position: relative;
      }

      .trending-stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin: 1.5rem 0;
      }

      .stat-item {
        text-align: center;
      }

      .stat-value {
        font-size: 2rem;
        font-weight: 700;
        display: block;
        color: white;
      }

      .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
      }

      .trending-container {
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

      .trending-badge {
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
        object-fit: cover;
        transition: transform 0.3s;
      }

      .product-card:hover .product-image {
        transform: scale(1.03);
      }

      .product-info {
        padding: 1.5rem;
      }

      .product-title {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: var(--secondary);
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

      .product-sales {
        color: var(--danger);
        font-weight: 600;
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

      .hot-categories {
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

      /* Bestsellers Section */
      .bestsellers {
        background: #f6f8fb;
        border-radius: var(--radius);
        padding: 2rem;
        margin: 3rem 0;
      }

      /* Responsive styles */
      @media (max-width: 768px) {
        .trending-hero h1 {
          font-size: 2rem;
        }

        .trending-hero p {
          font-size: 1rem;
        }

        .trending-stats {
          gap: 1rem;
        }

        .stat-value {
          font-size: 1.5rem;
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

        .trending-stats {
          flex-wrap: wrap;
        }

        .stat-item {
          flex: 1 0 40%;
          margin-bottom: 1rem;
        }
      }
    </style>
  </head>
  <body>
    <!-- Navigation (same as other pages) -->
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

          <a href="trending.php" class="active">Trending</a>
          <a href="contact.php">Contact</a>
          <div class="dropdown">
            <button class="dropbtn" aria-haspopup="true">
              <i class="fas fa-th-large"></i> Categories
              <i class="fas fa-angle-down"></i>
            </button>
            <div class="dropdown-content">
              <a href="laptops.php" class="category-link">Laptops</a>
              <a href="#category-mobiles" class="category-link">Mobiles</a>
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
      <!-- Trending Hero Section -->
      <section class="trending-hero">
        <div class="trending-container">
          <h1><i class="fas fa-chart-line"></i> Trending Now</h1>
          <p>
            Discover what's hot and popular right now. These products are flying
            off the shelves!
          </p>

          <div class="trending-stats">
            <div class="stat-item">
              <span class="stat-value">1,245+</span>
              <span class="stat-label">Products Sold Today</span>
            </div>
            <div class="stat-item">
              <span class="stat-value">98%</span>
              <span class="stat-label">Positive Reviews</span>
            </div>
            <div class="stat-item">
              <span class="stat-value">24</span>
              <span class="stat-label">New Trending Items</span>
            </div>
          </div>
        </div>
      </section>

      <div class="trending-container">
        <!-- Bestsellers Section -->
        <section class="bestsellers">
          <div class="section-header">
            <h2><i class="fas fa-trophy"></i> Bestsellers</h2>
            <a href="#" class="view-all"
              >View All <i class="fas fa-chevron-right"></i
            ></a>
          </div>

          <div class="products-grid">
            <!-- Product 1 -->
            <div class="product-card">
              <span class="trending-badge">#1 BESTSELLER</span>
              <img
                src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8c21hcnR3YXRjaHxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60"
                alt="Smart Watch Pro"
                class="product-image"
              />
              <div class="product-info">
                <h3 class="product-title">Smart Watch Pro Series 3</h3>
                <div class="product-price">
                  <span class="product-current">$129.99</span>
                  <span class="product-original">$299.99</span>
                </div>
                <div class="product-meta">
                  <span class="product-rating">
                    <i class="fas fa-star"></i> 4.8 (124)
                  </span>
                  <span class="product-sales">1,245 sold</span>
                </div>
                <div class="product-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
              <span class="trending-badge">#2 BESTSELLER</span>
              <img
                src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8aGVhZHBob25lc3xlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60"
                alt="Wireless Headphones"
                class="product-image"
              />
              <div class="product-info">
                <h3 class="product-title">Premium Wireless Headphones</h3>
                <div class="product-price">
                  <span class="product-current">$89.99</span>
                  <span class="product-original">$199.99</span>
                </div>
                <div class="product-meta">
                  <span class="product-rating">
                    <i class="fas fa-star"></i> 4.7 (89)
                  </span>
                  <span class="product-sales">982 sold</span>
                </div>
                <div class="product-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
              <span class="trending-badge">#3 BESTSELLER</span>
              <img
                src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8c2hvZXN8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                alt="Running Shoes"
                class="product-image"
              />
              <div class="product-info">
                <h3 class="product-title">Men's Running Shoes</h3>
                <div class="product-price">
                  <span class="product-current">$49.99</span>
                  <span class="product-original">$99.99</span>
                </div>
                <div class="product-meta">
                  <span class="product-rating">
                    <i class="fas fa-star"></i> 4.6 (112)
                  </span>
                  <span class="product-sales">876 sold</span>
                </div>
                <div class="product-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Hot Categories Section -->
        <section class="hot-categories">
          <div class="section-header">
            <h2><i class="fas fa-bolt"></i> Hot Categories</h2>
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

          <div class="products-grid">
            <!-- Product 1 -->
            <div class="product-card">
              <span class="trending-badge">TRENDING</span>
              <img
                src="https://images.unsplash.com/photo-1546435770-a3e426bf472b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8c3BlYWtlcnxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60"
                alt="Bluetooth Speaker"
                class="product-image"
              />
              <div class="product-info">
                <h3 class="product-title">Portable Bluetooth Speaker</h3>
                <div class="product-price">
                  <span class="product-current">$39.99</span>
                  <span class="product-original">$129.99</span>
                </div>
                <div class="product-meta">
                  <span class="product-rating">
                    <i class="fas fa-star"></i> 4.5 (67)
                  </span>
                  <span class="product-sales">542 sold</span>
                </div>
                <div class="product-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
              <span class="trending-badge">TRENDING</span>
              <img
                src="https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8c2hpcHxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60"
                alt="Backpack"
                class="product-image"
              />
              <div class="product-info">
                <h3 class="product-title">Travel Backpack 40L</h3>
                <div class="product-price">
                  <span class="product-current">$44.99</span>
                  <span class="product-original">$81.99</span>
                </div>
                <div class="product-meta">
                  <span class="product-rating">
                    <i class="fas fa-star"></i> 4.7 (93)
                  </span>
                  <span class="product-sales">487 sold</span>
                </div>
                <div class="product-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
              <span class="trending-badge">TRENDING</span>
              <img
                src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2FtZXJhfGVufDB8fDB8fHww&auto=format&fit=crop&w=500&q=60"
                alt="Digital Camera"
                class="product-image"
              />
              <div class="product-info">
                <h3 class="product-title">Digital Camera 20MP</h3>
                <div class="product-price">
                  <span class="product-current">$129.99</span>
                  <span class="product-original">$199.99</span>
                </div>
                <div class="product-meta">
                  <span class="product-rating">
                    <i class="fas fa-star"></i> 4.4 (78)
                  </span>
                  <span class="product-sales">398 sold</span>
                </div>
                <div class="product-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Product 4 -->
            <div class="product-card">
              <span class="trending-badge">TRENDING</span>
              <img
                src="https://images.unsplash.com/photo-1596755094514-f87e34085b2c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8c2tpbiUyMGNhcmV8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                alt="Skincare Set"
                class="product-image"
              />
              <div class="product-info">
                <h3 class="product-title">Luxury Skincare Set (5 items)</h3>
                <div class="product-price">
                  <span class="product-current">$89.99</span>
                  <span class="product-original">$129.99</span>
                </div>
                <div class="product-meta">
                  <span class="product-rating">
                    <i class="fas fa-star"></i> 4.9 (67)
                  </span>
                  <span class="product-sales">356 sold</span>
                </div>
                <div class="product-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Customer Favorites Section -->
        <section class="customer-favorites">
          <div class="section-header">
            <h2><i class="fas fa-heart"></i> Customer Favorites</h2>
            <a href="#" class="view-all"
              >View All <i class="fas fa-chevron-right"></i
            ></a>
          </div>

          <div class="products-grid">
            <!-- Product 1 -->
            <div class="product-card">
              <span class="trending-badge">TOP RATED</span>
              <img
                src="https://images.unsplash.com/photo-1546054454-aa26e2b734c7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8a2V5Ym9hcmR8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                alt="Mechanical Keyboard"
                class="product-image"
              />
              <div class="product-info">
                <h3 class="product-title">Mechanical Gaming Keyboard</h3>
                <div class="product-price">
                  <span class="product-current">$49.99</span>
                  <span class="product-original">$79.99</span>
                </div>
                <div class="product-meta">
                  <span class="product-rating">
                    <i class="fas fa-star"></i> 4.9 (215)
                  </span>
                  <span class="product-sales">724 sold</span>
                </div>
                <div class="product-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
              <span class="trending-badge">TOP RATED</span>
              <img
                src="https://images.unsplash.com/photo-1585386959984-a4155224a1ad?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8cGVyZnVtZXxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60"
                alt="Perfume"
                class="product-image"
              />
              <div class="product-info">
                <h3 class="product-title">Luxury Perfume 100ml</h3>
                <div class="product-price">
                  <span class="product-current">$39.99</span>
                  <span class="product-original">$69.99</span>
                </div>
                <div class="product-meta">
                  <span class="product-rating">
                    <i class="fas fa-star"></i> 4.8 (134)
                  </span>
                  <span class="product-sales">689 sold</span>
                </div>
                <div class="product-actions">
                  <button class="btn btn-outline">Add to Wishlist</button>
                  <button class="btn btn-primary">Add to Cart</button>
                </div>
              </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
              <span class="trending-badge">TOP RATED</span>
              <img
                src="https://images.unsplash.com/photo-1560343090-f0409e92791a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8c2hpcnR8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                alt="T-Shirt"
                class="product-image"
              />
              <div class="product-info">
                <h3 class="product-title">Premium Cotton T-Shirt</h3>
                <div class="product-price">
                  <span class="product-current">$14.99</span>
                  <span class="product-original">$29.99</span>
                </div>
                <div class="product-meta">
                  <span class="product-rating">
                    <i class="fas fa-star"></i> 4.7 (315)
                  </span>
                  <span class="product-sales">1,245 sold</span>
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
    </main>

    <!-- Newsletter & Social -->
    <section id="newsletterSocial">
      <div class="newsletter">
        <h3>Get Notified About Trending Products</h3>
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
      <a href="new-arrivals.php" class="mbnav-item" aria-label="New Arrivals"
        ><i class="fas fa-star"></i><span>New</span></a
      >
      <a href="trending.php" class="mbnav-item active" aria-label="Trending"
        ><i class="fas fa-chart-line"></i><span>Trending</span></a
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
      // Tab switching functionality
      document.addEventListener("DOMContentLoaded", function () {
        const tabs = document.querySelectorAll(".category-tab");

        tabs.forEach((tab) => {
          tab.addEventListener("click", function () {
            tabs.forEach((t) => t.classList.remove("active"));
            this.classList.add("active");

            // In a real implementation, you would filter products here
            // based on the selected category
          });
        });
      });

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
          );

          // Show a confirmation (in a real app, you would add to cart)
          alert(
            `Added ${productName} to your cart for $${productPrice.toFixed(2)}`
          );

          // Update cart count
          const cartCounts = document.querySelectorAll(
            ".cart-count, #cartCounterMobile"
          );
          cartCounts.forEach((count) => {
            const current = parseInt(count.textContent) || 0;
            count.textContent = current + 1;
          });
        }
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
