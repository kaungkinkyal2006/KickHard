<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: ../admin/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/auth_page.css">
    <title>Welcome</title>
</head>
<body>

    <h1>Welcome to KickHard</h1>
    <a href="login.php" class="btn">Login</a>
    <a href="register.php" class="btn btn-register">Register</a>

</body>
</html>
