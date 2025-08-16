<?php
session_start();

// Redirect if not logged in as client
if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true) {
    header("Location: /kickhard/auth/page.php");
    exit;
}

// Redirect admin to admin dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: ../admin/index.php");
    exit;
}

// Get client info
$clientName = $_SESSION['client_name'] ?? 'User';
$clientEmail = $_SESSION['client_email'] ?? 'email@example.com';

include '../includes/db.php';
include '../includes/header.php';

// Validate shoe ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Invalid shoe ID.</p>";
    include '../includes/footer.php';
    exit;
}

$id = (int)$_GET['id'];

// Fetch shoe by ID
$stmt = $conn->prepare("SELECT * FROM shoes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$shoe = $result->fetch_assoc();
$stmt->close();

if (!$shoe) {
    echo "<p>Shoe not found.</p>";
    include '../includes/footer.php';
    exit;
}

// Map type to readable label
$typeLabel = ($shoe['type'] === "0" || $shoe['type'] === 0) ? 'Sport Wear' : 'Fashion Wear';
?>

<link rel="stylesheet" href="../assets/css/client_shoe_detail.css" />

<div class="shoe-detail">
    <h2><?= htmlspecialchars($shoe['name']); ?></h2>
    <img src="../assets/images/shoes/<?= htmlspecialchars($shoe['image']); ?>" alt="<?= htmlspecialchars($shoe['name']); ?>" />
    
    <p><strong>Brand:</strong> <?= htmlspecialchars($shoe['brand']); ?></p>
    <p><strong>Size:</strong> <?= htmlspecialchars($shoe['size']); ?></p>
    <p><strong>Price:</strong> $<?= number_format($shoe['price'], 2); ?></p>
    <p><strong>Type:</strong> <?= htmlspecialchars($typeLabel); ?></p>
    
    <p><a href="cart.php?action=add&id=<?= $shoe['id']; ?>" class="btn-add-to-cart">Add to Cart</a></p>
    
    <p><a href="index.php" class="btn-back">← Back to Shoes List</a></p>
</div>

<?php include '../includes/footer.php'; ?>
