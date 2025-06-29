<?php
// Start the session at the very beginning of the script
session_start();

// Include the database configuration file
// IMPORTANT: Ensure 'config.php' establishes a $conn variable for mysqli or a $pdo variable for PDO
// Example for mysqli in config.php:
/*
$db_host = 'localhost';
$db_user = 'your_db_username';
$db_pass = 'your_db_password';
$db_name = 'your_database_name';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
*/
require_once 'config.php'; // Use require_once to ensure it's included and only once

// Check if a user is logged in using the session variable
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

// Fetch active sliders from the database
$sliders = [];
$query_sliders = "SELECT * FROM sliders WHERE is_active = 1 ORDER BY order_by ASC, id DESC";
$result_sliders = mysqli_query($conn, $query_sliders); // Use the $conn from config.php

if ($result_sliders) {
    while ($slider = mysqli_fetch_assoc($result_sliders)) {
        $sliders[] = $slider;
    }
    mysqli_free_result($result_sliders);
} else {
    error_log("Database query failed for sliders: " . mysqli_error($conn));
    // Optionally, display a message or use default sliders if fetching fails
}

// Fetch featured products from the database
$featured_products = [];
$featured_query = "SELECT * FROM products WHERE is_featured = 1 ORDER BY created_at DESC LIMIT 8";
$featured_result = mysqli_query($conn, $featured_query);

if ($featured_result) {
    while ($product = mysqli_fetch_assoc($featured_result)) {
        $featured_products[] = $product;
    }
    mysqli_free_result($featured_result);
} else {
    error_log("Database query failed for featured products: " . mysqli_error($conn));
}

// Fetch best deals from the database
$best_deals_products = [];
$deals_query = "SELECT * FROM products WHERE is_best_deal = 1 ORDER BY created_at DESC LIMIT 8";
$deals_result = mysqli_query($conn, $deals_query);

if ($deals_result) {
    while ($product = mysqli_fetch_assoc($deals_result)) {
        $best_deals_products[] = $product;
    }
    mysqli_free_result($deals_result);
} else {
    error_log("Database query failed for best deals: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Bazaar - Home</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Inter Font - Used in slider text styling -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Combined Inline Styles (from your original file) -->
    <style>
        /* Nav Icons Styling */
        .nav-icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-icons .nav-icon {
            color: #fff;
            font-size: 1.23rem;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 32px;
            width: 32px;
            border-radius: 50%;
            transition: background 0.15s, color 0.15s;
            text-decoration: none;
            position: relative;
        }

        .nav-icons .nav-icon:hover {
            background: var(--primary-dark);
            color: #fff;
        }

        /* Cart and Wishlist count styling */
        .nav-icon .cart-count,
        .nav-icon .wishlist-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.75rem;
            min-width: 18px;
            text-align: center;
            line-height: 1.5;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        /* Search input styling */
        .nav-search {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .nav-search input {
            height: 32px;
            padding: 0 10px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 0.9rem;
        }

        .nav-search input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .nav-search-btn {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 1.23rem;
            cursor: pointer;
            height: 32px;
            width: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.15s;
        }

        .nav-search-btn:hover {
            background: var(--primary-dark);
        }

        /* Slider styles */
        .slider-container {
            position: relative;
            max-width: 1500px;
            margin: 0rem auto;
            overflow: hidden;
            border-radius: 0px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
        }

        .slides {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border-radius: 10px;
            height: 500px;
        }

        .slide {
            min-width: 100%;
            box-sizing: border-box;
            flex-shrink: 0;
            position: relative;
            border-radius: 10px;
            overflow: hidden;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .slide:hover img {
            transform: scale(1.02);
        }

        .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                to right,
                rgba(0, 0, 0, 0.7) 0%,
                rgba(0, 0, 0, 0.3) 50%,
                rgba(0, 0, 0, 0) 100%
            );
            display: flex;
            align-items: center;
            padding-left: 10%;
            color: white;
        }

        .slide-content {
            max-width: 50%;
            animation: fadeInUp 0.8s ease;
        }

        .slide-content h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            font-family: "Inter", sans-serif;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
        }

        .slide-content p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            font-family: "Inter", sans-serif;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            line-height: 1.5;
        }
        .slide-content button {
            background-color: white;
            color: #2d3748;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            font-weight: 700;
            transition: all 0.1s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: none;
            cursor: pointer;
            font-family: "Inter", sans-serif;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }

        .slide-content button:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .slider-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            font-size: 1.5rem;
            z-index: 10;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .slider-container:hover .slider-nav-btn {
            opacity: 1;
            visibility: visible;
        }

        .slider-nav-btn:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .slider-nav-btn.prev {
            left: 20px;
        }

        .slider-nav-btn.next {
            right: 20px;
        }

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

        .slide-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: var(--accent);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        .deal-countdown {
            position: absolute;
            bottom: 80px;
            left: 10%;
            background: rgba(0, 0, 0, 0.6);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-family: "Inter", sans-serif;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .slider-container {
                padding: 10px;
                margin: 0.5rem auto;
            }

            .slides {
                height: 300px;
            }

            .slide-overlay {
                padding-left: 5%;
                background: linear-gradient(
                    to top,
                    rgba(0, 0, 0, 0.7),
                    rgba(0, 0, 0, 0.1)
                );
                align-items: flex-end;
                padding-bottom: 20%;
            }

            .slide-content {
                max-width: 90%;
                text-align: center;
            }

            .slide-content h2 {
                font-size: 1.8rem;
            }

            .slide-content p {
                font-size: 1rem;
            }

            .slide-content button {
                padding: 0.2rem 1.5rem; /* Corrected typo: 0.2 rem -> 0.2rem */
                font-size: 0.9rem;
            }

            .slider-nav-btn {
                opacity: 1;
                visibility: visible;
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }

        /* Product Card Styles */
        .product-news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 0 10px;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: var(--primary);
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .product-img-container {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
            background: #f5f7fa;
            padding: 20px;
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 15px;
        }

        .product-title {
            font-size: 1.1rem;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-desc {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2; /* Standard property for compatibility */
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 40px;
        }

        .product-price {
            margin-bottom: 10px;
        }

        .current-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
        }

        .original-price {
            font-size: 0.9rem;
            text-decoration: line-through;
            color: #999;
            margin-left: 8px;
        }

        .discount {
            font-size: 0.8rem;
            color: var(--danger);
            font-weight: 600;
            margin-left: 8px;
        }

        .product-rating {
            color: #ffb300;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .product-rating span {
            color: #666;
            margin-left: 5px;
        }

        .product-actions {
            display: flex;
            gap: 10px;
            padding: 0 15px 15px;
            /* Allow buttons to wrap in smaller screens */
            flex-wrap: wrap;
        }

        .product-actions .btn {
            flex: 1; /* Allow buttons to take equal space */
            padding: 8px;
            font-size: 0.9rem;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        /* Specific style for the wishlist button to keep its size */
        .product-actions .add-to-wishlist {
            flex: 0 0 auto; /* Do not grow or shrink, base on content/padding */
            width: 40px; /* Fixed width */
            height: 40px; /* Fixed height, adjust as needed */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0; /* Remove padding as width/height are fixed */
        }


        .btn-secondary {
            background-color: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-secondary:hover {
            background-color: #e0e0e0;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: 1px solid var(--primary-dark);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        @media (max-width: 768px) {
            .product-news-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }

            .product-img-container {
                height: 160px;
            }

            .product-actions {
                flex-direction: column;
            }

            .product-actions .add-to-wishlist {
                width: 100%; /* Make wishlist button full width on small screens */
            }
        }

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
</head>
<body>
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="index.php" class="brand">
                <i class="fas fa-gem"></i> Brand Bazaar
            </a>
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

                <!-- Logout Icon -->
<a href="logout.php" class="nav-icon" id="logoutIcon" title="Logout">
    <i class="fas fa-sign-out-alt"></i>
</a>
            </div>
        </div>
    </nav>

    <main>
        <section class="slider-container">
            <div class="slides" id="slides-container">
                <?php
                if (!empty($sliders)):
                    foreach ($sliders as $slider):
                        $imagePath = htmlspecialchars($slider['image_path']);
                        // Adjust image path if it's relative like 'uploads/sliders/image.jpg' and project is in a subdirectory,
                        // you might need to prepend the project path or ensure it's relative to the web root.
                        // Example: if your project is /brand-bazaar-ecommerce-project/ and uploads is inside it,
                        // then $imagePath = '/brand-bazaar-ecommerce-project/' . $imagePath;
                        if (strpos($imagePath, '/') !== 0 && strpos($imagePath, 'http') !== 0) {
                            // This path adjustment assumes your project is directly accessible at '/brand-bazaar-ecommerce-project/'
                            // You might need to change '/brand-bazaar-ecommerce-project/' to your actual base path if different.
                            $imagePath = '/brand-bazaar-ecommerce-project/' . $imagePath;
                        }
                ?>
                <div class="slide">
                    <?php if(!empty($slider['badge_text'])): ?>
                        <div class="slide-badge"><?php echo htmlspecialchars($slider['badge_text']); ?></div>
                    <?php endif; ?>

                    <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($slider['title']); ?>"
                         onerror="this.onerror=null;this.src='https://placehold.co/1500x500/E3E9F2/232323?text=Slider+Image+Missing';" />

                    <div class="slide-overlay">
                        <div class="slide-content">
                            <h2><?php echo htmlspecialchars($slider['title']); ?></h2>
                            <?php if(!empty($slider['description'])): ?>
                                <p><?php echo htmlspecialchars($slider['description']); ?></p>
                            <?php endif; ?>

                            <?php if(!empty($slider['link'])): ?>
                                <a href="<?php echo htmlspecialchars($slider['link']); ?>" class="btn btn-slider">Shop Now</a>
                            <?php endif; ?>

                            <?php
                            // Check if show_countdown is set and true, and if countdown_date is not empty
                            if(isset($slider['show_countdown']) && $slider['show_countdown'] && !empty($slider['countdown_date'])):
                            ?>
                                <div class="deal-countdown" data-countdown="<?php echo htmlspecialchars($slider['countdown_date']); ?>">
                                    Limited Time Offer!
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
                    endforeach;
                else:
                    // Default slider if no dynamic sliders are found
                    ?>
                    <div class="slide">
                        <img src="https://placehold.co/1500x500/0A45A6/FFFFFF?text=Welcome+to+Brand+Bazaar" alt="Default Welcome Slide" />
                        <div class="slide-overlay">
                            <div class="slide-content">
                                <h2>Discover Amazing Deals</h2>
                                <p>Explore our wide range of products and find what you love.</p>
                                <a href="#featured-products" class="btn btn-slider">Shop Now</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <button class="slider-nav-btn prev" id="prev-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="slider-nav-btn next" id="next-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </section>

        <!-- Category Menu -->
        <section class="category-menu" id="categoryMenu">
            <a href="laptops.php" class="cat-item" data-category="laptops"><i class="fas fa-laptop"></i> Laptops</a>
            <a href="mobiles.php" class="cat-item" data-category="mobiles"><i class="fas fa-mobile-alt"></i> Mobiles</a>
            <a href="gadgets.php" class="cat-item" data-category="gadgets"><i class="fas fa-tablet-alt"></i> Gadgets</a>
            <a href="fashion.php" class="cat-item" data-category="fashion"><i class="fas fa-tshirt"></i> Fashion</a>
            <a href="audio.php" class="cat-item" data-category="audio"><i class="fas fa-headphones"></i> Audio</a>
            <a href="shoes.php" class="cat-item" data-category="shoes"><i class="fas fa-shoe-prints"></i> Shoes</a>
        </section>

        <!-- Featured Products Section -->
        <section class="section section-gray" id="featured-products">
            <div class="section-header">
                <h2><i class="fas fa-star"></i> Featured Products</h2>
                <a href="products.php?filter=featured" class="see-all">See All</a>
            </div>
            <div class="product-news-grid large-grid" id="featuredProductsGrid">
                <?php
                if (!empty($featured_products)) :
                    foreach ($featured_products as $product) :
                        $product_image_path = htmlspecialchars($product['image_path']);
                        if (strpos($product_image_path, 'uploads/') === 0) {
                            $product_image_path = '/brand-bazaar-ecommerce-project/' . $product_image_path;
                        }
                ?>
                <div class="product-card">
                    <?php if (!empty($product['badge'])) : ?>
                        <div class="product-badge"><?php echo htmlspecialchars($product['badge']); ?></div>
                    <?php endif; ?>
                    <div class="product-img-container">
                        <img src="<?php echo $product_image_path; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-img"
                             onerror="this.onerror=null;this.src='https://placehold.co/200x200/E3E9F2/232323?text=Image+Missing';">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="product-desc"><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="product-price">
                            <span class="current-price">₹<?php echo htmlspecialchars(number_format($product['current_price'], 2)); ?></span>
                            <?php if (!empty($product['original_price']) && $product['original_price'] > $product['current_price']) : ?>
                                <span class="original-price">₹<?php echo htmlspecialchars(number_format($product['original_price'], 2)); ?></span>
                                <?php
                                $discount_percentage = '';
                                if ($product['original_price'] > 0) {
                                    $discount_percentage = round((($product['original_price'] - $product['current_price']) / $product['original_price']) * 100);
                                }
                                ?>
                                <span class="discount"><?php echo !empty($product['discount']) ? htmlspecialchars($product['discount']) : ($discount_percentage > 0 ? $discount_percentage . '% off' : ''); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="product-rating">
                            <?php
                            $rating = round($product['rating'] * 2) / 2; // Round to nearest 0.5
                            for ($i = 1; $i <= 5; $i++) {
                                if ($rating >= $i) {
                                    echo '<i class="fas fa-star"></i>';
                                } elseif ($rating >= $i - 0.5) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                            <span>(<?php echo htmlspecialchars($product['reviews_count']); ?>)</span>
                        </div>
                    </div>
                    <div class="product-actions">
                        <button class="btn btn-secondary add-to-cart"
                                onclick="addToCart({
                                    id: <?php echo $product['id']; ?>,
                                    name: '<?php echo htmlspecialchars(addslashes($product['name'])); ?>',
                                    price: <?php echo htmlspecialchars($product['current_price']); ?>,
                                    image: '<?php echo $product_image_path; ?>'
                                })">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                        <button class="btn btn-secondary add-to-wishlist"
                                onclick="addToWishlist({
                                    id: <?php echo $product['id']; ?>,
                                    name: '<?php echo htmlspecialchars(addslashes($product['name'])); ?>',
                                    price: <?php echo htmlspecialchars($product['current_price']); ?>,
                                    image: '<?php echo $product_image_path; ?>',
                                    rating: <?php echo htmlspecialchars($product['rating']); ?>,
                                    reviews: <?php echo htmlspecialchars($product['reviews_count']); ?>,
                                    inStock: true /* Assuming featured products are in stock for this example */
                                })">
                            <i class="fas fa-heart"></i>
                        </button>
                        <button class="btn btn-primary buy-now"
                                onclick="buyNow({
                                    id: <?php echo $product['id']; ?>,
                                    name: '<?php echo htmlspecialchars(addslashes($product['name'])); ?>',
                                    price: <?php echo htmlspecialchars($product['current_price']); ?>,
                                    image: '<?php echo $product_image_path; ?>'
                                })">
                            Buy Now
                        </button>
                    </div>
                </div>
                <?php
                    endforeach;
                else :
                    echo '<p style="text-align: center; width: 100%; grid-column: 1 / -1;">No featured products found. Add some using add-product.php!</p>';
                endif;
                ?>
            </div>
        </section>

        <!-- Best Deals Section -->
        <section class="section section-gray" id="best-deals">
            <div class="section-header">
                <h2><i class="fas fa-fire"></i> Best Deals</h2>
                <a href="products.php?filter=deals" class="see-all">See All</a>
            </div>
            <div class="product-news-grid large-grid" id="bestDealsGrid">
                <?php
                if (!empty($best_deals_products)) :
                    foreach ($best_deals_products as $product) :
                        $product_image_path = htmlspecialchars($product['image_path']);
                        if (strpos($product_image_path, 'uploads/') === 0) {
                            $product_image_path = '/brand-bazaar-ecommerce-project/' . $product_image_path;
                        }
                ?>
                <div class="product-card">
                    <?php if (!empty($product['badge'])) : ?>
                        <div class="product-badge"><?php echo htmlspecialchars($product['badge']); ?></div>
                    <?php endif; ?>
                    <div class="product-img-container">
                        <img src="<?php echo $product_image_path; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-img"
                             onerror="this.onerror=null;this.src='https://placehold.co/200x200/E3E9F2/232323?text=Image+Missing';">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="product-desc"><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="product-price">
                            <span class="current-price">₹<?php echo htmlspecialchars(number_format($product['current_price'], 2)); ?></span>
                            <?php if (!empty($product['original_price']) && $product['original_price'] > $product['current_price']) : ?>
                                <span class="original-price">₹<?php echo htmlspecialchars(number_format($product['original_price'], 2)); ?></span>
                                <?php
                                $discount_percentage = '';
                                if ($product['original_price'] > 0) {
                                    $discount_percentage = round((($product['original_price'] - $product['current_price']) / $product['original_price']) * 100);
                                }
                                ?>
                                <span class="discount"><?php echo !empty($product['discount']) ? htmlspecialchars($product['discount']) : ($discount_percentage > 0 ? $discount_percentage . '% off' : ''); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="product-rating">
                            <?php
                            $rating = round($product['rating'] * 2) / 2; // Round to nearest 0.5
                            for ($i = 1; $i <= 5; $i++) {
                                if ($rating >= $i) {
                                    echo '<i class="fas fa-star"></i>';
                                } elseif ($rating >= $i - 0.5) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                            <span>(<?php echo htmlspecialchars($product['reviews_count']); ?>)</span>
                        </div>
                    </div>
                    <div class="product-actions">
                        <button class="btn btn-secondary add-to-cart"
                                onclick="addToCart({
                                    id: <?php echo $product['id']; ?>,
                                    name: '<?php echo htmlspecialchars(addslashes($product['name'])); ?>',
                                    price: <?php echo htmlspecialchars($product['current_price']); ?>,
                                    image: '<?php echo $product_image_path; ?>'
                                })">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                        <button class="btn btn-secondary add-to-wishlist"
                                onclick="addToWishlist({
                                    id: <?php echo $product['id']; ?>,
                                    name: '<?php echo htmlspecialchars(addslashes($product['name'])); ?>',
                                    price: <?php echo htmlspecialchars($product['current_price']); ?>,
                                    image: '<?php echo $product_image_path; ?>',
                                    rating: <?php echo htmlspecialchars($product['rating']); ?>,
                                    reviews: <?php echo htmlspecialchars($product['reviews_count']); ?>,
                                    inStock: true /* Assuming best deal products are in stock for this example */
                                })">
                            <i class="fas fa-heart"></i>
                        </button>
                        <button class="btn btn-primary buy-now"
                                onclick="buyNow({
                                    id: <?php echo $product['id']; ?>,
                                    name: '<?php echo htmlspecialchars(addslashes($product['name'])); ?>',
                                    price: <?php echo htmlspecialchars($product['current_price']); ?>,
                                    image: '<?php echo $product_image_path; ?>'
                                })">
                            Buy Now
                        </button>
                    </div>
                </div>
                <?php
                    endforeach;
                else :
                    echo '<p style="text-align: center; width: 100%; grid-column: 1 / -1;">No best deals found. Add some using add-product.php!</p>';
                endif;
                ?>
            </div>
        </section>
    </main>

    <!-- Footer Links Section -->
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

    <!-- Policy Section -->
    <section class="policy-section">
        <div class="policy-container">
            <!-- Box 1: Customer Service -->
            <div class="policy-box">
                <div class="policy-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Customer Service</h3>
                <ul>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Help Center</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Track Order</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Returns & Refunds</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> 24/7 Support</a></li>
                </ul>
            </div>

            <!-- Box 2: Payment Security -->
            <div class="policy-box">
                <div class="policy-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Payment Security</h3>
                <ul>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Payment Methods</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> SSL Encryption</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Fraud Protection</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Box 3: Shipping Info -->
            <div class="policy-box">
                <div class="policy-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h3>Shipping Info</h3>
                <ul>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Delivery Options</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Free Shipping</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> International</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Track Package</a></li>
                </ul>
            </div>

            <!-- Box 4: About Brand Bazaar -->
            <div class="policy-box">
                <div class="policy-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h3>About Brand Bazaar</h3>
                <ul>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Our Story</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Careers</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Investors</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Sustainability</a></li>
                </ul>
            </div>
        </div>
    </section>

    <footer>
        <p>
            © 2025 Brand Bazaar. All rights reserved. |
            <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a> |
            <a href="#">Shipping Policy</a>
        </p>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav">
        <a href="index.php" class="mbnav-item active" aria-label="Home">
            <i class="fas fa-home"></i><span>Home</span>
        </a>
        <a href="deals.php" class="mbnav-item" aria-label="Deals">
            <i class="fas fa-tag"></i><span>Deals</span>
        </a>
        <a href="wishlist.php" class="mbnav-item" aria-label="Wishlist">
            <i class="fas fa-heart"></i><span>Wishlist</span>
        </a>
        <a href="cart.php" class="mbnav-item" id="mbnavCart" aria-label="Cart">
            <i class="fas fa-shopping-cart"></i><span>Cart</span>
            <span class="cart-count" id="cartCounterMobile">0</span>
        </a>
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
                <!-- Logout button for mobile/smaller screens removed as per user request -->
                <!-- Original Mobile Logout HTML:
                <a href="logout.php" id="mobileLogoutLink">Logout</a>
                -->
            </div>
        </div>
    </nav>

    <div id="toast"></div>

    <!-- ALL JAVASCRIPT CODE - MOVED AND CONSOLIDATED HERE -->
    <script>
        // Helper function to show a toast message
        function showToast(msg) {
            const t = document.getElementById("toast");
            if (!t) {
                console.warn("Toast element not found.");
                return;
            }
            t.textContent = msg;
            t.style.display = "block";
            setTimeout(() => (t.style.display = "none"), 1800);
        }

        // Function to update cart counter display
        function updateCartCounter() {
            let cart = [];
            try {
                cart = JSON.parse(localStorage.getItem("cart")) || [];
            } catch (e) {
                console.error("Error parsing cart from localStorage:", e);
                cart = []; // Reset cart if parsing fails to prevent further errors
            }
            let total = cart.reduce((sum, item) => sum + (item.qty || 0), 0); // Sum quantities
            const cartCounter = document.getElementById("cartCounter");
            if (cartCounter) cartCounter.textContent = total;
            const cartMobile = document.getElementById("cartCounterMobile");
            if (cartMobile) cartMobile.textContent = total;
        }

        // Function to update wishlist counter display
        function updateWishlistCounter() {
            let wishlist = [];
            try {
                wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
            } catch (e) {
                console.error("Error parsing wishlist from localStorage:", e);
                wishlist = []; // Reset if parsing fails
            }
            const wishlistCounter = document.getElementById("wishlistCounter");
            if (wishlistCounter) {
                wishlistCounter.textContent = wishlist.length;
            }
        }

        // Function to add a product to the cart (called by onclick attributes)
        function addToCart(product) {
            let cart = [];
            try {
                cart = JSON.parse(localStorage.getItem("cart")) || [];
            } catch (e) {
                console.error("Error parsing cart from localStorage:", e);
                cart = [];
            }

            const existingItem = cart.find(item => item.id === product.id);

            if (existingItem) {
                existingItem.qty = (existingItem.qty || 0) + 1;
            } else {
                product.qty = 1; // Initialize quantity for new item
                cart.push(product);
            }

            localStorage.setItem("cart", JSON.stringify(cart));
            updateCartCounter();
            showToast(`${product.name} added to cart!`);
        }

        // Function to add a product to the wishlist (called by onclick attributes)
        function addToWishlist(product) {
            let wishlist = [];
            try {
                wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
            } catch (e) {
                console.error("Error parsing wishlist from localStorage:", e);
                wishlist = [];
            }

            const existingItem = wishlist.find(item => item.id === product.id);

            if (!existingItem) {
                wishlist.push(product);
                localStorage.setItem("wishlist", JSON.stringify(wishlist));
                updateWishlistCounter();
                showToast(`${product.name} added to wishlist!`);
            } else {
                showToast(`${product.name} is already in your wishlist!`);
            }
        }

        // Function for "Buy Now" (called by onclick attributes)
        function buyNow(product) {
            // Create a temporary cart with just this product
            const tempCart = [{
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                qty: 1
            }];

            // Save to localStorage for single-product checkout
            localStorage.setItem('tempCart', JSON.stringify(tempCart));

            // Redirect to checkout page
            window.location.href = 'checkout.php';
        }


        // Function to manage login/logout button visibility based on PHP session status
        // All login/logout icon visibility logic removed as per user request
        function checkLoginStatus() {
            // This function is now empty as logout icons have been removed.
            // If you later add new elements whose visibility depends on login status,
            // you can add logic here.
            console.log("DEBUG: checkLoginStatus called. Logout icons removed.");
        }


        // Slider functionality
        document.addEventListener("DOMContentLoaded", () => {
            const slidesContainer = document.getElementById("slides-container");
            const slides = document.querySelectorAll(".slide");
            const prevBtn = document.getElementById("prev-btn");
            const nextBtn = document.getElementById("next-btn");
            let currentIndex = 0;
            let slideInterval;
            const slideDuration = 5000; // 5 seconds

            if (!slidesContainer || slides.length === 0) {
                console.warn("Slider elements not found. Slider functionality skipped.");
                return; // Exit if no slider to operate on
            }

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
                clearInterval(slideInterval); // Clear any existing interval
                slideInterval = setInterval(nextSlide, slideDuration);
            };

            const stopAutoSlide = () => {
                clearInterval(slideInterval);
            };

            // Event listeners for slider navigation buttons
            nextBtn.addEventListener("click", () => {
                nextSlide();
                startAutoSlide(); // Restart auto-slide after manual interaction
            });

            prevBtn.addEventListener("click", () => {
                prevSlide();
                startAutoSlide(); // Restart auto-slide after manual interaction
            });

            // Pause auto-slide on hover, resume on mouse leave
            slidesContainer.addEventListener("mouseenter", stopAutoSlide);
            slidesContainer.addEventListener("mouseleave", startAutoSlide);

            // Initial setup
            updateSlider();
            startAutoSlide(); // Start auto-slide when page loads

            // Keyboard navigation for slider
            document.addEventListener("keydown", (e) => {
                if (e.key === "ArrowRight") {
                    nextSlide();
                    startAutoSlide();
                } else if (e.key === "ArrowLeft") {
                    prevSlide();
                    startAutoSlide();
                }
            });

            // Countdown timer for deals (if any)
            document.querySelectorAll('.deal-countdown').forEach(countdownElement => {
                const countdownDate = new Date(countdownElement.dataset.countdown).getTime();

                const updateCountdown = () => {
                    const now = new Date().getTime();
                    const distance = countdownDate - now;

                    if (distance < 0) {
                        countdownElement.textContent = "EXPIRED";
                        clearInterval(interval);
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    countdownElement.textContent = `Ends in: ${days}d ${hours}h ${minutes}m ${seconds}s`;
                };

                updateCountdown(); // Initial call
                const interval = setInterval(updateCountdown, 1000); // Update every second
            });
        });


        // Dropdown functionality for navbar
        document.addEventListener("DOMContentLoaded", function () {
            const dropdownButtons = document.querySelectorAll(".dropdown .dropbtn");

            dropdownButtons.forEach((button) => {
                button.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation(); // Stop click from propagating to document

                    const dropdownContent = this.nextElementSibling; // Get the dropdown content div

                    // Close any other open dropdowns
                    document
                        .querySelectorAll(".dropdown-content.show")
                        .forEach((openDropdown) => {
                            if (openDropdown !== dropdownContent) {
                                openDropdown.classList.remove("show");
                            }
                        });

                    // Toggle visibility of the clicked dropdown
                    dropdownContent.classList.toggle("show");
                });
            });

            // Close dropdowns if clicked outside
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

        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('navSearchInput');
            const productGrids = [
                document.getElementById('featuredProductsGrid'),
                document.getElementById('bestDealsGrid')
            ].filter(Boolean); // Filter out nulls if an ID isn't found

            if (searchInput && productGrids.length > 0) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = searchInput.value.toLowerCase();

                    productGrids.forEach(grid => {
                        grid.querySelectorAll('.product-card').forEach(card => {
                            const productNameElement = card.querySelector('.product-title');
                            if (productNameElement) {
                                const productName = productNameElement.textContent.toLowerCase();
                                if (productName.includes(searchTerm)) {
                                    card.style.display = 'block'; // Show the card
                                } else {
                                    card.style.display = 'none'; // Hide the card
                                }
                            }
                        });
                    });
                });
            }
        });

        // Initial setup calls for counters and login status after all DOM is parsed
        window.onload = () => {
            updateCartCounter();
            updateWishlistCounter();
            checkLoginStatus(); // Call checkLoginStatus, now empty but still part of flow.
        };

    </script>

    <!-- Original external JS files, if they exist and contain critical logic, might still be needed.
         However, the above script consolidates most common functionalities.
         If 'js/main.js' or 'js/cart.js' contain *additional* unique functions not replicated above,
         you might need to include them, but be careful of function name conflicts.
    <script src="js/main.js"></script>
    <script src="js/cart.js"></script>
    -->

</body>
</html>
<?php
// Close the database connection at the very end of the file, after all PHP and HTML output
if (isset($conn) && $conn) {
    mysqli_close($conn);
}
?>
