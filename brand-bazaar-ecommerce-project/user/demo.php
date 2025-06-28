<?php
require_once 'config.php';

// Function to get featured products
function getFeaturedProducts($conn) {
    $query = "SELECT p.id, p.name, p.price, p.image_url, p.is_featured 
              FROM products p 
              WHERE p.is_featured = '1' AND p.is_active = 1 
              LIMIT 8";
    $result = mysqli_query($conn, $query);
    $products = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    
    return $products;
}

// Function to get best deals (products with lowest stock)
function getBestDeals($conn) {
    $query = "SELECT p.id, p.name, p.price, p.image_url, p.stock_quantity 
              FROM products p 
              WHERE p.is_active = 1 
              ORDER BY p.stock_quantity ASC, p.price ASC 
              LIMIT 8";
    $result = mysqli_query($conn, $query);
    $products = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    
    return $products;
}

// Get products data
$featuredProducts = getFeaturedProducts($conn);
$bestDeals = getBestDeals($conn);
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brand Bazaar - Home</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="index.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <!-- Inter Font - Used in slider text styling -->
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <style></style>
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
      <!-- Slider Section -->
      <section class="slider-container">
        <div class="slides" id="slides-container">
          <!-- Slide 1 -->
          <div class="slide">
            <div class="slide-badge">New Arrivals</div>
            <img src="images/slider-1.jpg" alt="New Arrivals" />
            <div class="slide-overlay">
              <div class="slide-content"></div>
            </div>
          </div>
          <!-- Slide 2 -->
          <div class="slide">
            <div class="slide-badge">50% Off</div>
            <div class="deal-countdown">Limited Time: 2 days left!</div>
            <img src="images/slider-2.jpg" alt="Summer Sale" />
            <div class="slide-overlay">
              <div class="slide-content"></div>
            </div>
          </div>
          <!-- Slide 3 -->
          <div class="slide">
            <div class="slide-badge">Exclusive</div>
            <img src="images/slider-3.jpg" alt="Limited Edition" />
            <div class="slide-overlay">
              <div class="slide-content"></div>
            </div>
          </div>
        </div>

        <!-- Navigation Arrows -->
        <button class="slider-nav-btn prev" id="prev-btn">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slider-nav-btn next" id="next-btn">
          <i class="fas fa-chevron-right"></i>
        </button>
      </section>

      <!-- Category Menu -->
      <section class="category-menu" id="categoryMenu">
        <a href="#category-laptops" class="cat-item" data-category="laptops"
          ><i class="fas fa-laptop"></i> Laptops</a
        >
        <a href="#category-mobiles" class="cat-item" data-category="mobiles"
          ><i class="fas fa-mobile-alt"></i> Mobiles</a
        >
        <a href="#category-gadgets" class="cat-item" data-category="gadgets"
          ><i class="fas fa-tablet-alt"></i> Gadgets</a
        >
        <a href="#category-fashion" class="cat-item" data-category="fashion"
          ><i class="fas fa-tshirt"></i> Fashion</a
        >
        <a href="#category-audio" class="cat-item" data-category="audio"
          ><i class="fas fa-headphones"></i> Audio</a
        >
        <a href="#category-shoes" class="cat-item" data-category="shoes"
          ><i class="fas fa-shoe-prints"></i> Shoes</a
        >
      </section>

      <!-- Featured Products Section -->
      <section class="section section-gray" id="featured-products">
        <div class="section-header">
          <h2><i class="fas fa-star"></i> Featured Products</h2>
          <a href="#" class="see-all">See All</a>
        </div>
        <div class="product-news-grid large-grid" id="featuredProductsGrid">
          <!-- Products will be loaded here by JavaScript -->
        </div>
      </section>

      <!-- Best Deals Section -->
      <section class="section section-gray" id="best-deals">
        <div class="section-header">
          <h2><i class="fas fa-fire"></i> Best Deals</h2>
          <a href="#" class="see-all">See All</a>
        </div>
        <div class="product-news-grid large-grid" id="bestDealsGrid">
          <!-- Products will be loaded here by JavaScript -->
        </div>
      </section>
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
          rel="noopener"
          ><i class="fab fa-facebook-f"></i
        ></a>
        <a
          href="https://twitter.com"
          class="social twitter"
          target="_blank"
          rel="noopener"
          ><i class="fab fa-twitter"></i
        ></a>
        <a
          href="https://instagram.com"
          class="social instagram"
          target="_blank"
          rel="noopener"
          ><i class="fab fa-instagram"></i
        ></a>
        <a
          href="https://youtube.com"
          class="social youtube"
          target="_blank"
          rel="noopener"
          ><i class="fab fa-youtube"></i
        ></a>
      </div>
    </section>

    <!-- Footer -->
    <!-- Add this just before the existing footer -->
    <section class="footer-links-section">
      <div class="footer-links-container">
        <div class="footer-links-column">
          <h3>Get to Know Us</h3>
          <ul>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#">Press Releases</a></li>
            <li><a href="#">Brand Bazaar Science</a></li>
          </ul>
        </div>

        <div class="footer-links-column">
          <h3>Make Money with Us</h3>
          <ul>
            <li><a href="#">Sell products on Brand Bazaar</a></li>
            <li><a href="#">Sell on Brand Bazaar Business</a></li>
            <li><a href="#">Become an Affiliate</a></li>
            <li><a href="#">Advertise Your Products</a></li>
          </ul>
        </div>

        <div class="footer-links-column">
          <h3>Payment Products</h3>
          <ul>
            <li><a href="#">Brand Bazaar Business Card</a></li>
            <li><a href="#">Shop with Points</a></li>
            <li><a href="#">Reload Your Balance</a></li>
            <li><a href="#">Currency Converter</a></li>
          </ul>
        </div>

        <div class="footer-links-column">
          <h3>Let Us Help You</h3>
          <ul>
            <li><a href="#">Your Account</a></li>
            <li><a href="#">Your Orders</a></li>
            <li><a href="#">Shipping Rates & Policies</a></li>
            <li><a href="#">Returns & Replacements</a></li>
            <li><a href="#">Help</a></li>
          </ul>
        </div>
      </div>
    </section>

    <!-- Add this CSS in the head section -->
    <style>
      /* Footer Links Section */
      .footer-links-section {
        background-color: #0a45a6; /* Using your primary color */
        color: white;
        padding: 40px 0;
        margin-top: 40px;
      }

      .footer-links-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 0 20px;
      }

      .footer-links-column {
        flex: 1;
        min-width: 200px;
        margin-bottom: 20px;
        padding: 0 15px;
      }

      .footer-links-column h3 {
        font-size: 1.1rem;
        margin-bottom: 15px;
        font-weight: 700;
        color: #fff;
      }

      .footer-links-column ul {
        list-style: none;
        padding: 0;
        margin: 0;
      }

      .footer-links-column li {
        margin-bottom: 10px;
      }

      .footer-links-column a {
        color: #e0e0e0;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.2s;
      }

      .footer-links-column a:hover {
        color: white;
        text-decoration: underline;
      }

      @media (max-width: 768px) {
        .footer-links-column {
          min-width: 150px;
        }
      }

      @media (max-width: 480px) {
        .footer-links-column {
          min-width: 100%;
        }
      }
    </style>
    <!-- Add this before the existing footer -->
    <section class="policy-section">
      <div class="policy-container">
        <!-- Box 1: Customer Service -->
        <div class="policy-box">
          <div class="policy-icon">
            <i class="fas fa-headset"></i>
          </div>
          <h3>Customer Service</h3>
          <ul>
            <li>
              <a href="#"><i class="fas fa-chevron-right"></i> Help Center</a>
            </li>
            <li>
              <a href="#"><i class="fas fa-chevron-right"></i> Track Order</a>
            </li>
            <li>
              <a href="#"
                ><i class="fas fa-chevron-right"></i> Returns & Refunds</a
              >
            </li>
            <li>
              <a href="#"><i class="fas fa-chevron-right"></i> 24/7 Support</a>
            </li>
          </ul>
        </div>

        <!-- Box 2: Payment Security -->
        <div class="policy-box">
          <div class="policy-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h3>Payment Security</h3>
          <ul>
            <li>
              <a href="#"
                ><i class="fas fa-chevron-right"></i> Payment Methods</a
              >
            </li>
            <li>
              <a href="#"
                ><i class="fas fa-chevron-right"></i> SSL Encryption</a
              >
            </li>
            <li>
              <a href="#"
                ><i class="fas fa-chevron-right"></i> Fraud Protection</a
              >
            </li>
            <li>
              <a href="#"
                ><i class="fas fa-chevron-right"></i> Privacy Policy</a
              >
            </li>
          </ul>
        </div>

        <!-- Box 3: Shipping Info -->
        <div class="policy-box">
          <div class="policy-icon">
            <i class="fas fa-truck"></i>
          </div>
          <h3>Shipping Info</h3>
          <ul>
            <li>
              <a href="#"
                ><i class="fas fa-chevron-right"></i> Delivery Options</a
              >
            </li>
            <li>
              <a href="#"><i class="fas fa-chevron-right"></i> Free Shipping</a>
            </li>
            <li>
              <a href="#"><i class="fas fa-chevron-right"></i> International</a>
            </li>
            <li>
              <a href="#"><i class="fas fa-chevron-right"></i> Track Package</a>
            </li>
          </ul>
        </div>

        <!-- Box 4: About Brand Bazaar -->
        <div class="policy-box">
          <div class="policy-icon">
            <i class="fas fa-store"></i>
          </div>
          <h3>About Brand Bazaar</h3>
          <ul>
            <li>
              <a href="#"><i class="fas fa-chevron-right"></i> Our Story</a>
            </li>
            <li>
              <a href="#"><i class="fas fa-chevron-right"></i> Careers</a>
            </li>
            <li>
              <a href="#"><i class="fas fa-chevron-right"></i> Investors</a>
            </li>
            <li>
              <a href="#"
                ><i class="fas fa-chevron-right"></i> Sustainability</a
              >
            </li>
          </ul>
        </div>
      </div>
    </section>

    <!-- Add this CSS in the head section -->
    <style>
      /* Policy Section Styles */
      .policy-section {
        background: linear-gradient(135deg, #f6f8fb 0%, #e6ecf5 100%);
        padding: 50px 0;
        border-top: 1px solid #c9e0fc;
        border-bottom: 1px solid #c9e0fc;
      }

      .policy-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        padding: 0 20px;
      }

      .policy-box {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(10, 69, 166, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #e3e6ec;
      }

      .policy-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(10, 69, 166, 0.15);
      }

      .policy-icon {
        width: 50px;
        height: 50px;
        background: rgba(10, 69, 166, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        color: #0a45a6;
        font-size: 1.5rem;
      }

      .policy-box h3 {
        color: #0a45a6;
        font-size: 1.2rem;
        margin-bottom: 15px;
        font-weight: 700;
      }

      .policy-box ul {
        list-style: none;
        padding: 0;
        margin: 0;
      }

      .policy-box li {
        margin-bottom: 10px;
        position: relative;
        padding-left: 20px;
      }

      .policy-box li:before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 8px;
        background: #0a45a6;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
      }

      .policy-box li:hover:before {
        opacity: 1;
      }

      .policy-box a {
        color: #444;
        text-decoration: none;
        font-size: 0.95rem;
        transition: color 0.3s ease, padding-left 0.3s ease;
        display: block;
      }

      .policy-box a:hover {
        color: #0a45a6;
        padding-left: 5px;
      }

      .policy-box a i {
        margin-right: 8px;
        color: #0a45a6;
        font-size: 0.8rem;
        transition: margin-right 0.3s ease;
      }

      .policy-box a:hover i {
        margin-right: 10px;
      }

      @media (max-width: 768px) {
        .policy-container {
          grid-template-columns: 1fr 1fr;
        }
      }

      @media (max-width: 480px) {
        .policy-container {
          grid-template-columns: 1fr;
        }

        .policy-box {
          padding: 20px;
        }
      }
    </style>
    <footer>
      <p>
        © 2025 Brand Bazaar. All rights reserved. |
        <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a> |
        <a href="#">Shipping Policy</a>
      </p>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav">
      <a href="index.php" class="mbnav-item active" aria-label="Home"
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

    <div id="toast"></div>

    <script src="js/main.js"></script>
    <script>
      // Slider functionality
      document.addEventListener("DOMContentLoaded", () => {
        const slidesContainer = document.getElementById("slides-container");
        const slides = document.querySelectorAll(".slide");
        const prevBtn = document.getElementById("prev-btn");
        const nextBtn = document.getElementById("next-btn");
        let currentIndex = 0;
        let slideInterval;
        const slideDuration = 5000;

        const updateSlider = () => {
          const offset = -currentIndex * 100;
          slidesContainer.style.transform = `translateX(${offset}%)`;
        };

        const nextSlide = () => {
          currentIndex = (currentIndex + 1) % slides.length;
          updateSlider();
        };

        const prevSlide = () => {
          currentIndex = (currentIndex - 1 + slides.length) % slides.length;
          updateSlider();
        };

        const startAutoSlide = () => {
          clearInterval(slideInterval);
          slideInterval = setInterval(nextSlide, slideDuration);
        };

        const stopAutoSlide = () => {
          clearInterval(slideInterval);
        };

        nextBtn.addEventListener("click", () => {
          nextSlide();
          startAutoSlide();
        });

        prevBtn.addEventListener("click", () => {
          prevSlide();
          startAutoSlide();
        });

        slidesContainer.addEventListener("mouseenter", stopAutoSlide);
        slidesContainer.addEventListener("mouseleave", startAutoSlide);

        updateSlider();
        startAutoSlide();

        document.addEventListener("keydown", (e) => {
          if (e.key === "ArrowRight") {
            nextSlide();
            startAutoSlide();
          } else if (e.key === "ArrowLeft") {
            prevSlide();
            startAutoSlide();
          }
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

      // Dropdown functionality
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
    </script>
  </body>
</html>
