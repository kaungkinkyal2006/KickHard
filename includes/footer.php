<footer>
  <div class="footer-container">
    <div class="footer-section">
      <h3>KickHard</h3>
      <p>&copy; <?php echo date('Y'); ?> KickHard</p>
    </div>
    <div class="footer-section">
      <h3>Contact Us</h3>
      <p>Email: support@kickhard.com</p>
      <p>Phone: +95 123 456 789</p>
    </div>
    <div class="footer-section">
      <h3>Quick Links</h3>
      <p><a href="collections.php">Products</a></p>
      <p><a href="about.php">About Us</a></p>
    </div>
  </div>
</footer>

<style>
  /* Make footer sticky without touching page content */
  footer {
    position: sticky;
    top: 100vh; /* pushes footer to bottom of viewport */
    margin-top: 40px; /* optional gap above footer */
    background: linear-gradient(90deg, #2575fc 0%, #6a11cb 100%);
    color: white;
    padding: 60px 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-weight: 500;
    box-shadow: 0 -3px 12px rgba(0,0,0,0.3);
    width: 100%;
    box-sizing: border-box;
    overflow-x: hidden;
  }

  .footer-container {
    width:100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    max-width: 1200px;
    margin: 0 auto;
    gap: 30px;
  }

  .footer-section h3 {
    margin-bottom: 12px;
    font-size: 1.2rem;
    color: #fff;
  }

  .footer-section p,
  .footer-section a {

    font-size: 0.95rem;
    color: #eee;
    text-decoration: none;
  }

  .footer-section a:hover {
    text-decoration: underline;
    color: #fff;
  }

  @media(max-width: 768px){
    .footer-container {
      flex-direction: column;
      align-items: center;
      text-align: center;
    }
  }
</style>
