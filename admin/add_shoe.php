<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../auth/page.php");
    exit;
}

include '../includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $size = (int)$_POST['size'];
    $price = (float)$_POST['price'];
    $type = isset($_POST['type']) ? (int)$_POST['type'] : 0; // 0 = sport_wear, 1 = fashion_wear

    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowedTypes)) {
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            $targetDir = "../assets/images/shoes/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $targetFile = $targetDir . $imageName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $message = "Failed to upload image.";
            }
        } else {
            $message = "Only JPG, PNG, GIF files allowed.";
        }
    } else {
        $message = "Please upload an image.";
    }

    if (empty($message)) {
        $stmt = $conn->prepare("INSERT INTO shoes (name, brand, size, price, image, type) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssidsi", $name, $brand, $size, $price, $imageName, $type);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add New Shoe</title>
    <link rel="stylesheet" href="../assets/css/add_shoe.css" />
</head>
<body>

<h2>Add New Shoe</h2>

<?php if (!empty($message)): ?>
    <div class="message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="POST" action="" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input id="name" type="text" name="name" required />

    <label for="brand">Brand:</label>
    <input id="brand" type="text" name="brand" required />

    <label for="size">Size:</label>
    <input id="size" type="number" name="size" min="1" max="50" required />

    <label for="price">Price:</label>
    <input id="price" type="number" name="price" step="0.01" min="0" required />

    <label for="image">Image:</label>
    <input id="image" type="file" name="image" accept="image/*" required />

    <label for="type">Type:</label>
    <div class="select-wrapper">
        <select id="type" name="type" required>
            <option value="0">Sport Wear</option>
            <option value="1">Fashion Wear</option>
        </select>
    </div>

    <button type="submit">Add Shoe</button>
</form>

<a href="index.php" class="back-link">← Back to Dashboard</a>

</body>
</html>
