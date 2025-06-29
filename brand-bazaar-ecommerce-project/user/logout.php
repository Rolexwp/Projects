<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Logging Out - Brand Bazaar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <style>
      body {
        background: linear-gradient(135deg, #e6f0ff 0%, #fff 100%);
        font-family: "Segoe UI", "Roboto", Arial, sans-serif;
        margin: 0;
        display: flex;
        height: 100vh;
        align-items: center;
        justify-content: center;
      }
      .logout-container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 36px -10px #0a45a63a;
        padding: 2.5rem 2rem 2rem 2rem;
        text-align: center;
        max-width: 380px;
        width: 90vw;
      }
      .logout-title {
        font-size: 2rem;
        color: #0a45a6;
        font-weight: 800;
        margin-bottom: 18px;
        letter-spacing: 0.01em;
      }
      .logout-icon {
        font-size: 3.2rem;
        color: #0a45a6;
        margin-bottom: 16px;
        animation: spin-out 1.3s cubic-bezier(0.6, -0.28, 0.74, 1.59) 1;
      }
      @keyframes spin-out {
        0% {
          transform: rotate(0deg);
        }
        70% {
          transform: rotate(420deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }
      .logout-message {
        font-size: 1.18rem;
        color: #222;
        margin-bottom: 24px;
        font-weight: 500;
      }
      .redirect-message {
        color: #0a45a6;
        font-size: 1.01rem;
      }
    </style>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
  </head>
  <body>
    <div class="logout-container">
      <div class="logout-icon"><i class="fas fa-sign-out-alt"></i></div>
      <div class="logout-title">Logging Out</div>
      <div class="logout-message">You have been logged out successfully.</div>
      <div class="redirect-message">Redirecting to sign in page...</div>
    </div>
    <script>
      // Remove login state and redirect to sign in page
      localStorage.removeItem("loggedInUser");
      setTimeout(function () {
        window.location.href = "signin.php";
      }, 1350);
    </script>
  </body>
</html>
