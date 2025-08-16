<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../auth/page.php");
    exit;
}

include '../includes/db.php';

if (!isset($_GET['id'])) {
    die("ID is required");
}

$id = (int)$_GET['id'];

// Get image filename
$stmt = $conn->prepare("SELECT image FROM shoes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$shoe = $result->fetch_assoc();
$stmt->close();

if (!$shoe) {
    die("Shoe not found");
}

// Delete shoe record
$stmt = $conn->prepare("DELETE FROM shoes WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    $stmt->close();
    // Delete image file
    $targetDir = "../assets/images/shoes/";
    if ($shoe['image'] && file_exists($targetDir . $shoe['image'])) {
        unlink($targetDir . $shoe['image']);
    }
    header("Location: index.php");
    exit();
} else {
    $stmt->close();
    die("Delete failed: " . $conn->error);
}
