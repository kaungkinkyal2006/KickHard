<?php
session_start();

// Redirect if not logged in as client
if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true) {
    header("Location: /kickhard/auth/page.php");
    exit;
}

// Get client info
$clientName = $_SESSION['client_name'] ?? 'User';
$clientEmail = $_SESSION['client_email'] ?? 'email@example.com';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: ../admin/index.php");
    exit;
}

include '../includes/db.php';
include '../includes/header.php';
?>

<link rel="stylesheet" href="../assets/css/client_page.css?v=<?=time();?>" />


<main class="overlay-wrapper">
    <h2>New Arrival</h2>
<div class="shoe-list">
    <?php
    // Select only latest 3 products by highest id
    $sql = "SELECT * FROM shoes ORDER BY id DESC LIMIT 3"; 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($shoe = $result->fetch_assoc()) {
            ?>
            <a href="shoe_detail.php?id=<?php echo $shoe['id']; ?>" class="shoe-card">
                <img src="../assets/images/shoes/<?php echo htmlspecialchars($shoe['image']); ?>" alt="<?php echo htmlspecialchars($shoe['name']); ?>">
                <h3><?php echo htmlspecialchars($shoe['name']); ?></h3>
                <p>Brand: <?php echo htmlspecialchars($shoe['brand']); ?></p>
                <p>Price: $<?php echo number_format($shoe['price'], 2); ?></p>
            </a>
            <?php
        }
    } else {
        echo "<p style='text-align:center; font-style: italic;'>No shoes available right now. Check back later!</p>";
    }
    ?>
</div>
</main>


<!-- Link your prevent_back.js file here -->
<script src="../assets/js/prevent_back.js"></script>

<?php include '../includes/footer.php'; ?>
