document.addEventListener("DOMContentLoaded", function () {
  // Hamburger menu
  const navToggle = document.getElementById("navToggle");
  const navLinks = document.getElementById("navLinks");
  if (navToggle && navLinks) {
    navToggle.addEventListener("click", () => {
      navLinks.classList.toggle("active");
    });
  }

  // Category click scroll
  const catItems = document.querySelectorAll(".cat-item, .category-link");
  catItems.forEach((item) => {
    item.addEventListener("click", function (e) {
      const hash = this.getAttribute("href") || this.dataset.category;
      if (hash && hash.startsWith("#category-")) {
        e.preventDefault();
        catItems.forEach((i) => i.classList.remove("active"));
        this.classList.add("active");
        const section = document.querySelector(hash);
        if (section)
          section.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    });
  });

  // Helper: product name to file slug in /products/
  function productNameToFile(name) {
    return (
      "products/" +
      name
        .replace(/[^a-zA-Z0-9 ]/g, "")
        .replace(/\s+/g, "-")
        .trim() +
      ".php"
    );
  }

  function renderProductGrid(products, gridId) {
    const grid = document.getElementById(gridId);
    if (!grid) return;
    grid.innerHTML = "";
    products.forEach((prod) => {
      const card = document.createElement("div");
      card.className = "product-news-card";
      card.tabIndex = 0;
      // Card click goes to product page
      card.onclick = (e) => {
        // Only allow navigation if not clicking a button
        if (
          e.target.classList.contains("btn-sm") ||
          e.target.classList.contains("btn-buy")
        )
          return;
        window.location.href = productNameToFile(prod.name);
      };
      card.innerHTML = `
        <div class="news-img">
          <img src="${prod.img}" alt="${prod.name}">
          <span class="badge ${prod.badgeClass}">${prod.badge}</span>
        </div>
        <div class="news-content">
          <h3>${prod.name}</h3>
          <div class="news-meta">
            <span class="product-price">$${prod.price}</span>
          </div>
          <div class="news-actions-row">
            <span class="news-desc">${prod.desc}</span>
            <button class="btn-sm btn-add-cart" title="Add to cart">Add to Cart</button>
            <button class="btn-sm btn-buy" title="Buy now">Buy Now</button>
            <span class="product-rating"><i class="fas fa-star"></i> ${prod.rating}</span>
          </div>
        </div>
      `;
      // Image fallback
      card.querySelector(".news-img img").onerror = function () {
        this.src = "images/placeholder.png";
      };
      // Add to cart button
      card.querySelector(".btn-add-cart").onclick = function (e) {
        e.stopPropagation();
        addToCart(prod);
        showToast("Added to cart!");
      };
      // Buy now button
      card.querySelector(".btn-buy").onclick = function (e) {
        e.stopPropagation();
        addToCart(prod);
        window.location.href = "cart.php";
      };
      grid.appendChild(card);
    });
  }

  // Social links animation
  document.querySelectorAll(".social-links a.social").forEach((link) => {
    link.addEventListener("click", function () {
      document
        .querySelectorAll(".social-links a.social")
        .forEach((l) => l.classList.remove("active"));
      this.classList.add("active");
      setTimeout(() => this.classList.remove("active"), 1200);
    });
  });

  // Navbar search
  const navSearchForm = document.getElementById("navSearchForm");
  if (navSearchForm) {
    navSearchForm.onsubmit = function (e) {
      e.preventDefault();
      const q = document.getElementById("navSearchInput").value.trim();
      if (!q) return;
      showToast(`Searching for "${q}"...`);
    };
  }

  // Mobile bottom nav actions
  const mbnavProfile = document.getElementById("mbnavProfile");
  if (mbnavProfile) {
    mbnavProfile.onclick = (e) => {
      e.preventDefault();
      window.location.href = "profile.php";
    };
  }
});
