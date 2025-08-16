<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../auth/page.php");
    exit;
}

include '../includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Dashboard - Shoes</title>
<link rel="stylesheet" href="../assets/css/admin_page.css" />
<style>
    /* Simple badge style for type */
    .badge {
        padding: 5px 10px;
        border-radius: 12px;
        color: #fff;
        font-weight: 600;
        font-size: 12px;
    }
    .sport { background-color: #1abc9c; }   /* green */
    .fashion { background-color: #e67e22; } /* orange */
    table img {
        border-radius: 8px;
    }
    .actions a {
        margin-right: 10px;
        text-decoration: none;
        color: #3498db;
        font-weight: 600;
    }
    .actions a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h1>
<p>
  <a href="add_shoe.php">Add New Shoe</a> | 
  <a href="logout.php">Logout</a>
</p>

<h2>All Shoes</h2>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Brand</th>
            <th>Size</th>
            <th>Price</th>
            <th>Type</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT * FROM shoes ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $typeLabel = ($row['type'] == 0) 
                        ? '<span class="badge sport">Sport Wear</span>'
                        : '<span class="badge fashion">Fashion Wear</span>';
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['brand']) . "</td>";
            echo "<td>" . htmlspecialchars($row['size']) . "</td>";
            echo "<td>$" . number_format($row['price'], 2) . "</td>";
            echo "<td>" . $typeLabel . "</td>";
            echo "<td><img src=\"../assets/images/shoes/" . htmlspecialchars($row['image']) . "\" alt=\"" . htmlspecialchars($row['name']) . "\" width=\"100\" /></td>";
            echo "<td class='actions'>
                <a href='edit_shoe.php?id=" . $row['id'] . "'>Edit</a>
                <a href='delete_shoe.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this shoe?\")'>Delete</a>
            </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8' style='text-align:center;'>No shoes found.</td></tr>";
    }
    ?>
    </tbody>
</table>

<script src="../assets/js/prevent_back.js"></script>
</body>
</html>
