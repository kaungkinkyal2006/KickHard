<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../auth/page.php");
    exit;
}

include '../includes/db.php';

$message = "";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("Invalid shoe ID");
}

// Fetch current shoe data
$stmt = $conn->prepare("SELECT * FROM shoes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$shoe = $result->fetch_assoc();
$stmt->close();

if (!$shoe) {
    die("Shoe not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $size = (int)$_POST['size'];
    $price = (float)$_POST['price'];
    $imageName = $shoe['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowedTypes)) {
            $newImageName = time() . '_' . basename($_FILES['image']['name']);
            $targetDir = "../assets/images/shoes/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $targetFile = $targetDir . $newImageName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                if ($imageName && file_exists($targetDir . $imageName)) {
                    unlink($targetDir . $imageName);
                }
                $imageName = $newImageName;
            } else {
                $message = "Failed to upload new image.";
            }
        } else {
            $message = "Only JPG, PNG, GIF files allowed.";
        }
    }

    if (!$message) {
        $stmt = $conn->prepare("UPDATE shoes SET name = ?, brand = ?, size = ?, price = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssidsi", $name, $brand, $size, $price, $imageName, $id);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Update error: " . $stmt->error;
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
    <title>Edit Shoe #<?php echo $id; ?></title>
    <link rel="stylesheet" href="../assets/css/edit_shoe.css" />
</head>
<body>

<h2>Edit Shoe #<?php echo $id; ?></h2>

<?php if ($message): ?>
    <div class="message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input id="name" type="text" name="name" required value="<?php echo htmlspecialchars($shoe['name']); ?>" />

    <label for="brand">Brand:</label>
    <input id="brand" type="text" name="brand" required value="<?php echo htmlspecialchars($shoe['brand']); ?>" />

    <label for="size">Size:</label>
    <input id="size" type="number" name="size" min="1" max="50" required value="<?php echo (int)$shoe['size']; ?>" />

    <label for="price">Price:</label>
    <input id="price" type="number" name="price" step="0.01" min="0" required value="<?php echo (float)$shoe['price']; ?>" />

    <label>Current Image:</label>
    <img src="../assets/images/shoes/<?php echo htmlspecialchars($shoe['image']); ?>" alt="Current Shoe Image" />

    <label for="image">Change Image:</label>
    <input id="image" type="file" name="image" accept="image/*" />

    <button type="submit">Update Shoe</button>
</form>

<a href="index.php" class="back-link">← Back to Dashboard</a>

</body>
</html>
