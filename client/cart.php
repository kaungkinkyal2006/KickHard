<?php
session_start();

// Redirect if not logged in as client
if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true) {
    header("Location: /shoestore/client/login.php");
    exit;
}

// Redirect admin to admin dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: ../admin/index.php");
    exit;
}

include '../includes/db.php';
include '../includes/header.php';
?>

<link rel="stylesheet" href="../assets/css/cart.css" />

<?php
// Initialize cart session if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add/remove actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = (int)$_GET['id'];

    if ($action === 'add') {
        // Keep previous items, increment quantity if already in cart
        if (!empty($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        } else {
            $_SESSION['cart'][$id] = 1;
        }
    }

    if ($action === 'remove') {
        unset($_SESSION['cart'][$id]);
    }

    // Redirect to avoid form resubmission
    header("Location: cart.php");
    exit;
}

// Fetch shoe details for items in cart
$cartItems = [];
$totalPrice = 0;

if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));

    $stmt = $conn->prepare("SELECT * FROM shoes WHERE id IN ($placeholders)");
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($shoe = $result->fetch_assoc()) {
        $shoe['quantity'] = $_SESSION['cart'][$shoe['id']];
        $shoe['subtotal'] = $shoe['price'] * $shoe['quantity'];
        $totalPrice += $shoe['subtotal'];

        // Correct type mapping
        $shoe['type_label'] = ($shoe['type'] === "0" || $shoe['type'] === 0) ? 'Sport Wear' : 'Fashion Wear';

        $cartItems[] = $shoe;
    }

    $stmt->close();
}
?>

<h2 style="text-align:center;">Your Shopping Cart</h2>

<?php if (empty($cartItems)): ?>
    <p style="text-align:center;">Your cart is empty. <a href="index.php">Go shopping!</a></p>
<?php else: ?>
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; max-width:800px; margin:auto;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Brand</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Remove</th>
               
            </tr>
        </thead>
        <tbody>
        <?php foreach ($cartItems as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= htmlspecialchars($item['brand']) ?></td>
                <td><?= htmlspecialchars($item['type_label']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>$<?= number_format($item['price'], 2) ?></td>
                <td>$<?= number_format($item['subtotal'], 2) ?></td>
                <td>
                    <a href="cart.php?action=remove&id=<?= $item['id'] ?>" style="color:red; text-decoration:none;" onclick="return confirm('Remove this item?')">Remove</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="5" style="text-align:right;"><strong>Total:</strong></td>
            <td colspan="3"><strong>$<?= number_format($totalPrice, 2) ?></strong></td>
        </tr>
        </tbody>
    </table>

    <!-- Buttons below table for all products -->
    <div style="max-width:800px; margin:20px auto; display:flex; flex-wrap:wrap; gap:10px;">
        <a href="index.php" style="
            flex:1 1 45%;
            padding:10px 20px;
            background-color:#28a745;
            color:white;
            text-align:center;
            border-radius:5px;
            text-decoration:none;
            font-size:16px;
        ">Continue Shopping</a>

        <form action="order-slip.php" method="post" style="flex:1 1 45%; margin:0;">
            <?php foreach ($cartItems as $item): ?>
                <input type="hidden" name="product_ids[]" value="<?= $item['id'] ?>">
            <?php endforeach; ?>
            <button type="submit" style="
                width:100%;
                padding:10px 20px;
                background-color:#007bff;
                color:white;
                border:none;
                border-radius:5px;
                cursor:pointer;
                font-size:16px;
            ">Order All</button>
        </form>
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
