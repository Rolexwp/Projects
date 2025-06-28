<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - Brand Bazaar</title>
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

      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      body {
        background: var(--light-bg);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
          Oxygen, Ubuntu, Cantarell, sans-serif;
        line-height: 1.5;
        color: #333;
      }

      .contact-hero {
        background: linear-gradient(135deg, #0a45a6 0%, #1a6dff 100%);
        color: white;
        padding: 3rem 1rem;
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
      }

      .contact-hero::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8Y29udGFjdHxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60")
          center/cover;
        opacity: 0.15;
      }

      .contact-hero h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        position: relative;
      }

      .contact-hero p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto 1.5rem;
        position: relative;
      }

      .contact-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
      }

      .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin: 3rem 0;
      }

      .contact-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 2rem;
        transition: transform 0.3s, box-shadow 0.3s;
      }

      .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      }

      .contact-icon {
        width: 60px;
        height: 60px;
        background: rgba(10, 69, 166, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        color: var(--primary);
        font-size: 1.5rem;
      }

      .contact-card h3 {
        font-size: 1.4rem;
        margin-bottom: 1rem;
        color: var(--secondary);
      }

      .contact-info {
        margin-bottom: 1rem;
        color: var(--text-light);
      }

      .contact-info a {
        color: var(--primary);
        text-decoration: none;
        transition: color 0.2s;
      }

      .contact-info a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
      }

      .contact-form-container {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 2rem;
        margin: 3rem 0;
      }

      .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
      }

      .section-header h2 {
        color: var(--primary);
        font-size: 1.8rem;
        margin: 0;
      }

      .contact-form {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }

      .form-group {
        display: flex;
        flex-direction: column;
      }

      .form-group label {
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--secondary);
      }

      .form-control {
        padding: 12px;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        font-size: 1rem;
        transition: border 0.3s;
      }

      .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(10, 69, 166, 0.2);
      }

      textarea.form-control {
        min-height: 150px;
        resize: vertical;
      }

      .btn {
        padding: 14px;
        font-size: 1.1rem;
        background: var(--primary);
        color: #fff;
        border-radius: var(--radius);
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
      }

      .btn:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
      }

      .btn:active {
        transform: translateY(0);
      }

      .store-locations {
        margin: 3rem 0;
      }

      .location-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 2rem;
      }

      .location-header {
        background: var(--primary);
        color: white;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
      }

      .location-header i {
        font-size: 1.2rem;
      }

      .location-body {
        padding: 1.5rem;
      }

      .location-details h4 {
        margin-bottom: 1rem;
        color: var(--secondary);
      }

      .location-details p {
        margin-bottom: 0.8rem;
        color: var(--text-light);
      }

      .location-hours {
        margin-top: 1.5rem;
      }

      .location-hours h5 {
        margin-bottom: 0.8rem;
        color: var(--secondary);
      }

      .hours-table {
        width: 100%;
        border-collapse: collapse;
      }

      .hours-table tr {
        border-bottom: 1px solid var(--border-color);
      }

      .hours-table tr:last-child {
        border-bottom: none;
      }

      .hours-table td {
        padding: 0.5rem 0;
      }

      .hours-table td:last-child {
        text-align: right;
        font-weight: 500;
      }

      /* FAQ Section */
      .faq-section {
        margin: 3rem 0;
      }

      .faq-item {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 1rem;
        overflow: hidden;
      }

      .faq-question {
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        font-weight: 600;
        color: var(--secondary);
        transition: background 0.2s;
      }

      .faq-question:hover {
        background: rgba(10, 69, 166, 0.05);
      }

      .faq-question i {
        transition: transform 0.3s;
      }

      .faq-item.active .faq-question i {
        transform: rotate(180deg);
      }

      .faq-answer {
        padding: 0 1.5rem;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out, padding 0.3s ease;
      }

      .faq-item.active .faq-answer {
        padding: 0 1.5rem 1.5rem;
        max-height: 500px;
      }

      /* Responsive styles */
      @media (max-width: 768px) {
        .contact-hero h1 {
          font-size: 2rem;
        }

        .contact-hero p {
          font-size: 1rem;
        }
      }

      @media (max-width: 480px) {
        .contact-grid {
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

          <a href="trending.php">Trending</a>
          <a href="contact.php" class="active">Contact</a>
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
      <!-- Contact Hero Section -->
      <section class="contact-hero">
        <div class="contact-container">
          <h1><i class="fas fa-headset"></i> Contact Us</h1>
          <p>
            We're here to help! Reach out to our team for any questions or
            concerns you might have.
          </p>
        </div>
      </section>

      <div class="contact-container">
        <!-- Contact Methods Grid -->
        <div class="contact-grid">
          <!-- Contact Card 1 -->
          <div class="contact-card">
            <div class="contact-icon">
              <i class="fas fa-phone-alt"></i>
            </div>
            <h3>Call Us</h3>
            <div class="contact-info">
              <p>Speak directly with our customer service team</p>
              <p><strong>Mon-Fri:</strong> 8:00 AM - 8:00 PM EST</p>
              <p><strong>Sat-Sun:</strong> 9:00 AM - 6:00 PM EST</p>
            </div>
            <a href="tel:+18005551234" class="btn">+1 (800) 555-1234</a>
          </div>

          <!-- Contact Card 2 -->
          <div class="contact-card">
            <div class="contact-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <h3>Email Us</h3>
            <div class="contact-info">
              <p>Send us an email and we'll respond within 24 hours</p>
              <p>
                For order inquiries:
                <a href="mailto:orders@brandbazaar.com"
                  >orders@brandbazaar.com</a
                >
              </p>
              <p>
                General questions:
                <a href="mailto:help@brandbazaar.com">help@brandbazaar.com</a>
              </p>
            </div>
            <a href="mailto:help@brandbazaar.com" class="btn">Send Email</a>
          </div>

          <!-- Contact Card 3 -->
          <div class="contact-card">
            <div class="contact-icon">
              <i class="fas fa-comment-dots"></i>
            </div>
            <h3>Live Chat</h3>
            <div class="contact-info">
              <p>Chat with a representative in real-time</p>
              <p><strong>Available:</strong> 24/7</p>
              <p>Average wait time: less than 2 minutes</p>
            </div>
            <button class="btn" id="startChatBtn">Start Live Chat</button>
          </div>
        </div>

        <!-- Contact Form Section -->
        <div class="contact-form-container">
          <div class="section-header">
            <h2><i class="fas fa-paper-plane"></i> Send Us a Message</h2>
          </div>
          <form class="contact-form" id="contactForm">
            <div class="form-group">
              <label for="name">Your Name</label>
              <input
                type="text"
                id="name"
                class="form-control"
                placeholder="Enter your name"
                required
              />
            </div>
            <div class="form-group">
              <label for="email">Email Address</label>
              <input
                type="email"
                id="email"
                class="form-control"
                placeholder="Enter your email"
                required
              />
            </div>
            <div class="form-group">
              <label for="subject">Subject</label>
              <input
                type="text"
                id="subject"
                class="form-control"
                placeholder="What's this about?"
                required
              />
            </div>
            <div class="form-group">
              <label for="message">Your Message</label>
              <textarea
                id="message"
                class="form-control"
                placeholder="How can we help you?"
                required
              ></textarea>
            </div>
            <button type="submit" class="btn">Send Message</button>
          </form>
        </div>

        <!-- Store Locations Section -->
        <div class="store-locations">
          <div class="section-header">
            <h2><i class="fas fa-store"></i> Our Store Locations</h2>
          </div>

          <!-- Location 1 -->
          <div class="location-card">
            <div class="location-header">
              <i class="fas fa-map-marker-alt"></i>

              <h3>New York Flagship Store</h3>
            </div>
            <div class="location-body">
              <div class="location-details">
                <h4>Visit Us</h4>
                <p>123 Broadway Avenue</p>
                <p>New York, NY 10001</p>
                <p>United States</p>
                <p><strong>Phone:</strong> +1 (212) 555-6789</p>

                <div class="location-hours">
                  <h5>Store Hours</h5>
                  <table class="hours-table">
                    <tr>
                      <td>Monday - Friday</td>
                      <td>9:00 AM - 9:00 PM</td>
                    </tr>
                    <tr>
                      <td>Saturday</td>
                      <td>10:00 AM - 8:00 PM</td>
                    </tr>
                    <tr>
                      <td>Sunday</td>
                      <td>11:00 AM - 6:00 PM</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Location 2 -->
          <div class="location-card">
            <div class="location-header">
              <i class="fas fa-map-marker-alt"></i>
              <h3>Los Angeles Store</h3>
            </div>
            <div class="location-body">
              <div class="location-details">
                <h4>Visit Us</h4>
                <p>456 Sunset Boulevard</p>
                <p>Los Angeles, CA 90028</p>
                <p>United States</p>
                <p><strong>Phone:</strong> +1 (213) 555-9876</p>

                <div class="location-hours">
                  <h5>Store Hours</h5>
                  <table class="hours-table">
                    <tr>
                      <td>Monday - Friday</td>
                      <td>10:00 AM - 8:00 PM</td>
                    </tr>
                    <tr>
                      <td>Saturday</td>
                      <td>10:00 AM - 7:00 PM</td>
                    </tr>
                    <tr>
                      <td>Sunday</td>
                      <td>11:00 AM - 5:00 PM</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- FAQ Section -->
        <div class="faq-section">
          <div class="section-header">
            <h2>
              <i class="fas fa-question-circle"></i> Frequently Asked Questions
            </h2>
          </div>

          <!-- FAQ Item 1 -->
          <div class="faq-item">
            <div class="faq-question">
              <span>How can I track my order?</span>
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
              <p>
                You can track your order by logging into your account and
                visiting the "My Orders" section. Alternatively, you can use the
                tracking number provided in your shipping confirmation email on
                the carrier's website.
              </p>
            </div>
          </div>

          <!-- FAQ Item 2 -->
          <div class="faq-item">
            <div class="faq-question">
              <span>What is your return policy?</span>
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
              <p>
                We offer a 30-day return policy for most items. Items must be in
                their original condition with all tags attached. Some items like
                electronics may have different return windows - please check the
                product page for specific details.
              </p>
            </div>
          </div>

          <!-- FAQ Item 3 -->
          <div class="faq-item">
            <div class="faq-question">
              <span>Do you offer international shipping?</span>
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
              <p>
                Yes, we ship to over 100 countries worldwide. Shipping costs and
                delivery times vary by destination. During checkout, you'll see
                the available shipping options and costs for your location.
              </p>
            </div>
          </div>

          <!-- FAQ Item 4 -->
          <div class="faq-item">
            <div class="faq-question">
              <span>How can I change or cancel my order?</span>
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
              <p>
                If your order hasn't been shipped yet, you can request changes
                or cancellation by contacting our customer service team
                immediately. Once an order has been shipped, you'll need to wait
                for delivery and then initiate a return if needed.
              </p>
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
      <a href="contact.php" class="mbnav-item active" aria-label="Contact"
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
      // FAQ Accordion functionality
      document.addEventListener("DOMContentLoaded", function () {
        const faqItems = document.querySelectorAll(".faq-item");

        faqItems.forEach((item) => {
          const question = item.querySelector(".faq-question");

          question.addEventListener("click", () => {
            // Close all other items
            faqItems.forEach((otherItem) => {
              if (otherItem !== item) {
                otherItem.classList.remove("active");
              }
            });

            // Toggle current item
            item.classList.toggle("active");
          });
        });

        // Contact form submission
        const contactForm = document.getElementById("contactForm");
        if (contactForm) {
          contactForm.addEventListener("submit", function (e) {
            e.preventDefault();

            // In a real implementation, you would send the form data to your server
            alert("Thank you for your message! We'll get back to you soon.");
            contactForm.reset();
          });
        }

        // Live chat button
        const startChatBtn = document.getElementById("startChatBtn");
        if (startChatBtn) {
          startChatBtn.addEventListener("click", function () {
            alert("Live chat would open in a real implementation.");
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
