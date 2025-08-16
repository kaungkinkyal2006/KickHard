<?php

if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true) {
    header("Location: /kickhard/client/login.php");
    exit;
}

$clientName = $_SESSION['client_name'] ?? 'username';
$clientEmail = $_SESSION['client_email'] ?? 'email@example.com';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>KickHard</title>
<style>
  /* Scoped styles for header */
  #main-header {
    position: fixed !important;
    top: 0 !important; left: 0 !important; right: 0 !important;
    height: 70px !important;
    background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%) !important;
    padding: 20px 40px !important;
    color: white !important;
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    box-shadow: 0 3px 8px rgba(0,0,0,0.2) !important;
    z-index: 1000 !important;
    box-sizing: border-box !important;
  }

  #main-header h1 {
    font-weight: 700 !important;
    font-size: 1.8rem !important;
    margin: 0 !important;
    letter-spacing: 1.2px !important;
  }

  #main-header nav a {
    color: white !important;
    text-decoration: none !important;
    margin-left: 25px !important;
    font-weight: 600 !important;
    font-size: 1rem !important;
    transition: color 0.3s ease !important;
  }

  #main-header nav a:hover {
    color: #ff416c !important;
  }

  /* Responsive */
  @media (max-width: 600px) {
    #main-header {
      flex-direction: column !important;
      text-align: center !important;
      padding: 15px 20px !important;
      height: auto !important;
      padding-bottom: 10px !important;
    }
    #main-header nav {
      margin-top: 10px !important;
    }
    #main-header nav a {
      margin-left: 15px !important;
      font-size: 0.9rem !important;
    }
  }

  #main-header > div {
    margin-left: 20px !important;
    text-align: right !important;
    font-weight: 600 !important;
    font-size: 0.9rem !important;
  }

  @media (max-width: 600px) {
    #main-header > div {
      margin-left: 0 !important;
      margin-top: 10px !important;
      text-align: center !important;
      font-size: 0.85rem !important;
    }
  }
</style>
<script>
  // Dynamically adjust body padding to avoid content hidden under fixed header
  function adjustBodyPadding() {
    const header = document.querySelector('#main-header');
    if (header) {
      const height = header.offsetHeight;
      document.body.style.paddingTop = height + 'px';
    }
  }
  window.addEventListener('load', adjustBodyPadding);
  window.addEventListener('resize', adjustBodyPadding);
</script>
</head>
<body>
<header id="main-header">
  <h1>KickHard</h1>
  <nav>
    <a href="/kickhard/client/collections.php">Collections</a>
    <a href="/kickhard/client/contact.php">Contact</a>
    <a href="/kickhard/client/logout.php" onclick="return confirm('Do you want to log out?')">Logout</a>
  </nav>
  <div>
    Welcome, <?php echo htmlspecialchars($clientName); ?> <br />
    <small><?php echo htmlspecialchars($clientEmail); ?></small>
  </div>
</header>
