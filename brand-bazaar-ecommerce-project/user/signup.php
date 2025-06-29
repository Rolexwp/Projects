<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Sign Up - Brand Bazaar</title>
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
      }

      body {
        background: linear-gradient(135deg, #e6f0ff 0%, #fff 100%);
        font-family: "Segoe UI", "Roboto", Arial, sans-serif;
        margin: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        animation: bgFadeIn 1s ease-out;
      }

      @keyframes bgFadeIn {
        from {
          opacity: 0;
          background-position: 0% 50%;
        }
        to {
          opacity: 1;
          background-position: 100% 50%;
        }
      }

      .signup-container {
        max-width: 400px;
        background: #fff;
        border-radius: 22px;
        box-shadow: 0 8px 36px -10px rgba(10, 69, 166, 0.23);
        padding: 2.7rem 2.2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        overflow: hidden;
        animation: slideIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-origin: center;
      }

      @keyframes slideIn {
        from {
          opacity: 0;
          transform: translateY(50px) scale(0.9);
        }
        to {
          opacity: 1;
          transform: translateY(0) scale(1);
        }
      }

      .signup-container::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: var(--primary-color);
        animation: progressBar 1.5s ease-out;
      }

      @keyframes progressBar {
        from {
          width: 0;
        }
        to {
          width: 100%;
        }
      }

      .flipkart-logo {
        font-size: 2.2rem;
        color: var(--primary-color);
        margin-bottom: 8px;
        font-weight: 900;
        letter-spacing: 0.04em;
        display: flex;
        align-items: center;
        gap: 9px;
        animation: logoBounce 1s ease 0.2s;
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
          transform: translateY(-15px);
        }
        60% {
          transform: translateY(-7px);
        }
      }

      .flipkart-logo i {
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

      .signup-title {
        font-size: 2.1rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 24px;
        letter-spacing: 0.01em;
        animation: fadeIn 0.8s ease-out 0.3s both;
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
          transform: translateY(10px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .signup-form {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 16px;
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

      .signup-form input {
        font-size: 1.07rem;
        padding: 14px 16px;
        border-radius: 7px;
        border: 1.4px solid var(--border-color);
        background: #f8fbff;
        transition: all 0.3s ease;
        outline: none;
        animation: inputFadeIn 0.5s ease-out 0.6s both;
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

      .signup-form input:focus {
        border: 1.6px solid var(--primary-color);
        background: #f2f7ff;
        box-shadow: 0 0 0 3px rgba(10, 69, 166, 0.1);
        transform: scale(1.01);
      }

      .signup-btn {
        background: var(--primary-color);
        color: #fff;
        border: none;
        border-radius: 7px;
        padding: 13px 0;
        font-size: 1.18rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 5px;
        box-shadow: 0 2px 8px -6px rgba(10, 69, 166, 0.53);
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

      .signup-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 16px -4px rgba(10, 69, 166, 0.4);
      }

      .signup-btn:active {
        transform: translateY(0);
      }

      .signup-footer {
        margin-top: 20px;
        color: var(--text-light);
        font-size: 1.02rem;
        text-align: center;
        animation: fadeIn 0.8s ease-out 0.8s both;
      }

      .signup-footer a {
        color: var(--primary-color);
        font-weight: 600;
        margin-left: 7px;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
      }

      .signup-footer a::after {
        content: "";
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -2px;
        left: 0;
        background-color: var(--primary-color);
        transition: width 0.3s ease;
      }

      .signup-footer a:hover::after {
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

      @media (max-width: 600px) {
        .signup-container {
          max-width: 97vw;
          padding: 1.3rem 4vw 1.7rem 4vw;
        }
        .signup-title {
          font-size: 1.3rem;
        }
        .flipkart-logo {
          font-size: 1.2rem;
        }
      }
    </style>
  </head>
  <body>
    <div class="signup-container">
      <div class="flipkart-logo">
        <i class="fas fa-shopping-bag"></i> Brand Bazaar
      </div>
      <div class="signup-title">Create Account</div>
      <form class="signup-form" id="signupForm" autocomplete="off">
        <input type="text" id="signupName" placeholder="Full Name" required />
        <input
          type="email"
          id="signupEmail"
          placeholder="Email Address"
          required
        />
        <input
          type="text"
          id="signupPhone"
          placeholder="Phone Number"
          maxlength="12"
          required
        />
        <input
          type="password"
          id="signupPassword"
          placeholder="Password"
          minlength="6"
          required
        />
        <button type="submit" class="signup-btn">Sign Up</button>
      </form>
      <div class="signup-footer">
        Already have an account?
        <a href="signin.php">Sign in</a>
      </div>
    </div>
    <div id="snackbar" class="snackbar"></div>
    <script>
      function showSnackbar(msg, color = "#0a45a6") {
        var sb = document.getElementById("snackbar");
        sb.style.background = color;
        sb.textContent = msg;
        sb.className = "snackbar show";
        setTimeout(function () {
          sb.className = sb.className.replace("show", "");
        }, 2200);
      }

      document.getElementById("signupForm").onsubmit = function (e) {
        e.preventDefault();
        const name = document.getElementById("signupName").value.trim();
        const email = document
          .getElementById("signupEmail")
          .value.trim()
          .toLowerCase();
        const phone = document.getElementById("signupPhone").value.trim();
        const password = document.getElementById("signupPassword").value;

        if (!name || !email || !phone || !password) {
          showSnackbar("Please fill all fields.", "#f44336");
          return;
        }

        if (!/^[6-9]\d{9,11}$/.test(phone)) {
          showSnackbar("Enter valid Indian phone number.", "#f44336");
          return;
        }

        let users = [];
        try {
          users = JSON.parse(localStorage.getItem("users")) || [];
        } catch {}

        if (users.some((u) => u.email === email)) {
          showSnackbar("Email already registered!", "#f44336");
          return;
        }

        if (users.some((u) => u.phone === phone)) {
          showSnackbar("Phone already registered!", "#f44336");
          return;
        }

        users.push({ name, email, phone, password });
        localStorage.setItem("users", JSON.stringify(users));
        showSnackbar("Signup successful! Logging in...", "#43a047");

        setTimeout(() => {
          localStorage.setItem("loggedInUser", email);
          window.location.href = "index.php";
        }, 1200);
      };
    </script>
  </body>
</html>
