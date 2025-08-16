<?php
session_start();

// Client login check
if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true) {
    header("Location: /kickhard/auth/page.php");
    exit;
}

// Redirect admin
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: ../admin/index.php");
    exit;
}

$clientName = $_SESSION['client_name'] ?? 'User';
$clientEmail = $_SESSION['client_email'] ?? 'email@example.com';

include '../includes/db.php';
include '../includes/header.php';
?>

<link rel="stylesheet" href="../assets/css/collections.css?v=<?=time();?>" />

<h2 style="text-align:center;color:white;">All Products</h2>

<!-- Type filter dropdown -->
<div style="text-align:center; margin-bottom:20px;">
    <form method="GET" action="collections.php" style="display:inline-block; margin-right:15px;">
        <select name="type" onchange="this.form.submit()" 
            style="padding:8px 12px; border-radius:6px; border:1px solid #ccc; font-size:1rem;">
            <option value="" <?= (!isset($_GET['type']) || $_GET['type'] === '') ? 'selected' : '' ?>>All</option>
            <option value="0" <?= (isset($_GET['type']) && $_GET['type'] === "0") ? 'selected' : '' ?>>Sport Wear</option>
            <option value="1" <?= (isset($_GET['type']) && $_GET['type'] === "1") ? 'selected' : '' ?>>Fashion Wear</option>
        </select>
    </form>

    <!-- Search bar -->
    <form method="GET" action="collections.php" style="display:inline-block;">
        <input 
            type="text" 
            name="search" 
            placeholder="Search by name..." 
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
            style="padding:8px 12px; border-radius:6px; border:1px solid #ccc; font-size:1rem; width:200px;"
        >
        <?php if (isset($_GET['type']) && $_GET['type'] !== ''): ?>
            <input type="hidden" name="type" value="<?= htmlspecialchars($_GET['type']); ?>">
        <?php endif; ?>
        <button type="submit" style="padding:8px 12px; border:none; background:#333; color:#fff; border-radius:6px; cursor:pointer;">
            Search
        </button>
    </form>
</div>

<div class="shoe-list">
    <?php
    $typeFilter = isset($_GET['type']) ? $_GET['type'] : '';
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    if (($typeFilter === "0" || $typeFilter === "1") && $search !== '') {
        // Filter by type + search
        $stmt = $conn->prepare("SELECT * FROM shoes WHERE type = ? AND name LIKE ? ORDER BY id DESC");
        $searchTerm = "%" . $search . "%";
        $stmt->bind_param("is", $typeFilter, $searchTerm);
        $typeLabelMsg = ($typeFilter === "0") ? "Sport Wear" : "Fashion Wear";

    } elseif ($typeFilter === "0" || $typeFilter === "1") {
        // Only type filter
        $stmt = $conn->prepare("SELECT * FROM shoes WHERE type = ? ORDER BY id DESC");
        $stmt->bind_param("i", $typeFilter);
        $typeLabelMsg = ($typeFilter === "0") ? "Sport Wear" : "Fashion Wear";

    } elseif ($search !== '') {
        // Only search
        $stmt = $conn->prepare("SELECT * FROM shoes WHERE name LIKE ? ORDER BY id DESC");
        $searchTerm = "%" . $search . "%";
        $stmt->bind_param("s", $searchTerm);
        $typeLabelMsg = "";

    } else {
        // No filters
        $stmt = $conn->prepare("SELECT * FROM shoes ORDER BY id DESC");
        $typeLabelMsg = "";
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($shoe = $result->fetch_assoc()) {
            $typeLabel = ($shoe['type'] === "0" || $shoe['type'] === 0) ? 'Sport Wear' : 'Fashion Wear';
            ?>
            <a href="shoe_detail.php?id=<?= $shoe['id']; ?>" class="shoe-card">
                <img src="../assets/images/shoes/<?= htmlspecialchars($shoe['image']); ?>" alt="<?= htmlspecialchars($shoe['name']); ?>">
                <h3><?= htmlspecialchars($shoe['name']); ?></h3>
                <p>Brand: <?= htmlspecialchars($shoe['brand']); ?></p>
                <p>Price: $<?= number_format($shoe['price'], 2); ?></p>
                <p>Type: <?= $typeLabel; ?></p>
            </a>
            <?php
        }
    } else {
        if ($search !== '') {
            echo "<p style='text-align:center; font-style: italic;'>No products found matching '<b>" . htmlspecialchars($search) . "</b>'.</p>";
        } elseif ($typeLabelMsg) {
            echo "<p style='text-align:center; font-style: italic;'>No $typeLabelMsg shoes available right now.</p>";
        } else {
            echo "<p style='text-align:center; font-style: italic;'>No shoes available right now. Check back later!</p>";
        }
    }

    $stmt->close();
    ?>
</div>

<?php include '../includes/footer.php'; ?>
