<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true) {
    header("Location: /shoestore/client/login.php");
    exit;
}

include '../includes/db.php';

// Get client info from session
$clientName = $_SESSION['client_name'] ?? 'User';
$clientEmail = $_SESSION['client_email'] ?? 'email@example.com';

// Get selected products from POST (single or multiple)
$selectedIds = [];
if (isset($_POST['product_id'])) {
    $selectedIds[] = (int)$_POST['product_id']; // single product
}
if (isset($_POST['product_ids'])) {
    foreach ($_POST['product_ids'] as $pid) {
        $selectedIds[] = (int)$pid; // multiple products
    }
}

$cartItems = [];
$totalPrice = 0.0;

if (!empty($selectedIds)) {
    $placeholders = implode(',', array_fill(0, count($selectedIds), '?'));
    $types = str_repeat('i', count($selectedIds));

    $stmt = $conn->prepare("SELECT * FROM shoes WHERE id IN ($placeholders)");
    $stmt->bind_param($types, ...$selectedIds);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($shoe = $result->fetch_assoc()) {
        // If quantity exists in session cart, use it; otherwise default 1
        $qty = $_SESSION['cart'][$shoe['id']] ?? 1;
        $shoe['quantity'] = $qty;
        $shoe['subtotal'] = $shoe['price'] * $qty;
        $totalPrice += $shoe['subtotal'];

        $shoe['type_label'] = ($shoe['type'] === "0" || $shoe['type'] === 0) ? 'Sport Wear' : 'Fashion Wear';

        $cartItems[] = $shoe;
    }
    $stmt->close();
}

// Optional: Clear these items from cart after ordering
// foreach ($selectedIds as $id) { unset($_SESSION['cart'][$id]); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KickHard</title>
    <link rel="stylesheet" href="../assets/css/order-slip.css" />


</head>
<body>
    <div class="slip-container">
    <h2>Order Slip</h2>
    <p><strong>Name:</strong> <?= htmlspecialchars($clientName) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($clientEmail) ?></p>
    <hr>

    <?php if (!empty($cartItems)): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['brand']) ?></td>
                        <td><?= htmlspecialchars($item['type_label']) ?></td>
                        <td><?= (int)$item['quantity'] ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td>$<?= number_format($item['subtotal'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" class="total">Total:</td>
                    <td><strong>$<?= number_format($totalPrice, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>

        <div class="print-btn">
            <button onclick="window.print()">Download / Print Slip</button>
        </div>
    <?php else: ?>
        <p>No items selected for your order.</p>
    <?php endif; ?>
    </div>
</body>
</html>
