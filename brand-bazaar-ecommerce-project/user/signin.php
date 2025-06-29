<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Sign In - Brand Bazaar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <style>
      :root {
        --primary-color: #0a45a6;
        --primary-dark: #07347a;
        --primary-light: #e6f0ff;
        --error-color: #f44336;
        --success-color: #43a047;
        --text-color: #333;
        --text-light: #666;
        --border-color: #a7c4f2;
        --bg-gradient: linear-gradient(135deg, #e6f0ff 0%, #fff 100%);
      }

      body {
        background: var(--bg-gradient);
        font-family: "Segoe UI", "Roboto", Arial, sans-serif;
        margin: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
      }

      .signin-container {
        width: 100%;
        max-width: 420px;
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 12px 40px -12px rgba(10, 69, 166, 0.25);
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out,
          containerFloat 8s ease-in-out infinite;
        transform-origin: center;
      }

      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @keyframes containerFloat {
        0%,
        100% {
          transform: translateY(0);
        }
        50% {
          transform: translateY(-8px);
        }
      }

      .signin-container::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: var(--primary-color);
        animation: progressBar 2s ease-out;
      }

      @keyframes progressBar {
        from {
          width: 0;
        }
        to {
          width: 100%;
        }
      }

      .brand-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1rem;
        animation: logoBounce 1s ease;
      }

      @keyframes logoBounce {
        0%,
        20%,
        50%,
        80%,
        100% {
          transform: translateY(0);
        }
        40% {
          transform: translateY(-20px);
        }
        60% {
          transform: translateY(-10px);
        }
      }

      .brand-logo i {
        font-size: 1.8rem;
        color: var(--primary-color);
        animation: spinIn 0.8s ease-out;
      }

      @keyframes spinIn {
        from {
          transform: rotate(-90deg);
          opacity: 0;
        }
        to {
          transform: rotate(0);
          opacity: 1;
        }
      }

      .brand-logo span {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--primary-color);
        letter-spacing: 0.03em;
      }

      .signin-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 1.5rem;
        text-align: center;
        animation: fadeIn 0.8s ease-out 0.3s both;
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
        }
        to {
          opacity: 1;
        }
      }

      .signin-form {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        animation: formSlideIn 0.8s ease-out 0.4s both;
      }

      @keyframes formSlideIn {
        from {
          opacity: 0;
          transform: translateY(20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .input-group {
        position: relative;
      }

      .input-group label {
        position: absolute;
        left: 14px;
        top: -10px;
        background: white;
        padding: 0 6px;
        font-size: 0.9rem;
        color: var(--text-light);
        z-index: 1;
        animation: labelSlideIn 0.4s ease-out 0.6s both;
      }

      @keyframes labelSlideIn {
        from {
          opacity: 0;
          transform: translateX(-10px);
        }
        to {
          opacity: 1;
          transform: translateX(0);
        }
      }

      .signin-form input {
        width: 100%;
        font-size: 1rem;
        padding: 14px 16px;
        border-radius: 8px;
        border: 1.5px solid var(--border-color);
        background: #f8fbff;
        transition: all 0.3s ease;
        outline: none;
        box-sizing: border-box;
        animation: inputFadeIn 0.5s ease-out 0.7s both;
      }

      @keyframes inputFadeIn {
        from {
          opacity: 0;
          transform: scale(0.95);
        }
        to {
          opacity: 1;
          transform: scale(1);
        }
      }

      .signin-form input:focus {
        border-color: var(--primary-color);
        background: #f2f7ff;
        box-shadow: 0 0 0 3px rgba(10, 69, 166, 0.1);
        transform: scale(1.01);
      }

      .password-container {
        position: relative;
      }

      .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .toggle-password:hover {
        color: var(--primary-color);
        transform: translateY(-50%) scale(1.1);
      }

      .signin-btn {
        background: var(--primary-color);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 14px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 0.5rem;
        box-shadow: 0 4px 12px -4px rgba(10, 69, 166, 0.3);
        letter-spacing: 0.03em;
        animation: btnPulse 2s infinite 1s;
      }

      @keyframes btnPulse {
        0% {
          box-shadow: 0 0 0 0 rgba(10, 69, 166, 0.4);
        }
        70% {
          box-shadow: 0 0 0 10px rgba(10, 69, 166, 0);
        }
        100% {
          box-shadow: 0 0 0 0 rgba(10, 69, 166, 0);
        }
      }

      .signin-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px -4px rgba(10, 69, 166, 0.4);
      }

      .signin-btn:active {
        transform: translateY(0);
      }

      .signin-footer {
        margin-top: 1.5rem;
        color: var(--text-light);
        font-size: 1rem;
        text-align: center;
        width: 100%;
        animation: fadeIn 0.8s ease-out 0.8s both;
      }

      .signin-footer a {
        color: var(--primary-color);
        font-weight: 600;
        margin-left: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
      }

      .signin-footer a::after {
        content: "";
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -2px;
        left: 0;
        background-color: var(--primary-color);
        transition: width 0.3s ease;
      }

      .signin-footer a:hover::after {
        width: 100%;
      }

      .snackbar {
        visibility: hidden;
        min-width: 280px;
        background: var(--primary-color);
        color: #fff;
        text-align: center;
        border-radius: 8px;
        padding: 16px;
        position: fixed;
        z-index: 99;
        left: 50%;
        top: 30px;
        font-size: 1rem;
        transform: translateX(-50%);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      }

      .snackbar.show {
        visibility: visible;
        animation: fadein 0.3s, fadeout 0.5s 2.2s;
      }

      @keyframes fadein {
        from {
          top: 10px;
          opacity: 0;
        }
        to {
          top: 30px;
          opacity: 1;
        }
      }

      @keyframes fadeout {
        from {
          top: 30px;
          opacity: 1;
        }
        to {
          top: 10px;
          opacity: 0;
        }
      }

      @media (max-width: 480px) {
        .signin-container {
          padding: 2rem 1.5rem;
          border-radius: 18px;
        }

        .brand-logo span {
          font-size: 1.5rem;
        }

        .signin-title {
          font-size: 1.5rem;
          margin-bottom: 1.2rem;
        }

        .signin-form {
          gap: 1.2rem;
        }

        .signin-form input {
          padding: 12px 14px;
        }
      }
    </style>
  </head>
  <body>
    <div class="signin-container">
      <div class="brand-logo">
        <i class="fas fa-shopping-bag"></i>
        <span>Brand Bazaar</span>
      </div>

      <h1 class="signin-title">Welcome back</h1>

      <form class="signin-form" id="signinForm" autocomplete="off">
        <div class="input-group">
          <label for="signinEmail">Email</label>
          <input
            type="email"
            id="signinEmail"
            placeholder="Enter your email"
            required
          />
        </div>

        <div class="input-group password-container">
          <label for="signinPassword">Password</label>
          <input
            type="password"
            id="signinPassword"
            placeholder="Enter your password"
            required
          />
          <i class="fas fa-eye toggle-password" id="togglePassword"></i>
        </div>

        <button type="submit" class="signin-btn">Sign In</button>
      </form>

      <div class="signin-footer">
        Don't have an account?
        <a href="signup.php">Sign up</a>
      </div>
    </div>

    <div id="snackbar" class="snackbar"></div>

    <script>
      // DOM Elements
      const signinForm = document.getElementById("signinForm");
      const togglePassword = document.getElementById("togglePassword");
      const passwordInput = document.getElementById("signinPassword");
      const snackbar = document.getElementById("snackbar");

      // Toggle password visibility
      togglePassword.addEventListener("click", function () {
        const type =
          passwordInput.getAttribute("type") === "password"
            ? "text"
            : "password";
        passwordInput.setAttribute("type", type);
        this.classList.toggle("fa-eye-slash");
        this.classList.toggle("fa-eye");
      });

      // Show snackbar notification
      function showSnackbar(msg, type = "primary") {
        const colors = {
          primary: "#0a45a6",
          error: "#f44336",
          success: "#43a047",
        };

        snackbar.style.backgroundColor = colors[type] || colors.primary;
        snackbar.textContent = msg;
        snackbar.className = "snackbar show";

        setTimeout(() => {
          snackbar.className = snackbar.className.replace("show", "");
        }, 2200);
      }

      // Form submission
      signinForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const email = document
          .getElementById("signinEmail")
          .value.trim()
          .toLowerCase();
        const password = document.getElementById("signinPassword").value;

        if (!email || !password) {
          showSnackbar("Please fill all fields", "error");
          return;
        }

        // Validate email format
        if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
          showSnackbar("Please enter a valid email", "error");
          return;
        }

        let users = [];
        try {
          users = JSON.parse(localStorage.getItem("users")) || [];
        } catch (error) {
          console.error("Error reading users:", error);
        }

        const user = users.find(
          (u) => u.email === email && u.password === password
        );

        if (!user) {
          showSnackbar("Invalid email or password", "error");
          return;
        }

        showSnackbar("Login successful!", "success");

        setTimeout(() => {
          localStorage.setItem("loggedInUser", email);
          window.location.href = "index.php";
        }, 900);
      });
    </script>
  </body>
</html>
