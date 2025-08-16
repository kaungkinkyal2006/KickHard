<?php
session_start();

if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true) {
    header("Location: /kickhard/auth/page.php");
    exit;
}

$clientName = $_SESSION['client_name'] ?? 'User';
$clientEmail = $_SESSION['client_email'] ?? 'email@example.com';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: ../admin/index.php");
    exit;
}

include '../includes/db.php';
include '../includes/header.php'; // Your shared header file
?>

<style>
  body {
    margin: 0;
    background: #121212;
    color: #eee;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .page-content {
    padding: 20px;
    max-width: 600px;
    margin: 0 auto;
  }

  h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #f0f0f0;
  }

  .contact-container {
    background: #1a1a1a;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.7);
  }

  label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #ccc;
  }

  input[type="text"],
  input[type="email"],
  textarea {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 18px;
    border-radius: 5px;
    border: 1px solid #444;
    background: #222;
    color: #eee;
    font-size: 1rem;
    resize: vertical;
  }

  button[type="submit"] {
    background: #000;
    border: none;
    color: #fff;
    font-weight: 700;
    padding: 12px 25px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1.1rem;
    transition: background-color 0.3s ease;
  }

  button[type="submit"]:hover {
    background: #444;
  }

  /* Modal styles */
  .modal {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
  }

  .modal.show {
    display: flex !important;
  }

  .modal-content {
    background: #111;
    padding: 20px 30px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.9);
    color: #eee;
    text-align: center;
    font-size: 1.2rem;
    max-width: 300px;
    width: 90%;
  }

  .modal-content button {
    margin-top: 15px;
    padding: 10px 20px;
    background: #000;
    border: none;
    border-radius: 6px;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .modal-content button:hover {
    background: #444;
  }
</style>

<div class="page-content">
  <h2>Contact Us</h2>

  <div class="contact-container">
    <form method="POST" action="index.php">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($clientName); ?>" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($clientEmail); ?>" required>

      <label for="message">Message</label>
      <textarea id="message" name="message" rows="6" placeholder="Write your message here..." required></textarea>

      <button type="submit">Send Message</button>
    </form>
  </div>
</div>

<!-- Modal -->
<div id="msgModal" class="modal">
  <div class="modal-content">
    <p>Message sent!</p>
    <button id="closeModalBtn">Close</button>
  </div>
</div>

<?php include '../includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('msgModal');
  const closeBtn = document.getElementById('closeModalBtn');

  // Show modal if URL contains ?sent=1
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('sent') === '1') {
    modal.classList.add('show');
  }

  closeBtn.addEventListener('click', () => {
    modal.classList.remove('show');
    // Remove 'sent' param from URL without reload
    if (window.history.replaceState) {
      const url = new URL(window.location);
      url.searchParams.delete('sent');
      window.history.replaceState({}, document.title, url.toString());
    }
  });
});
</script>
