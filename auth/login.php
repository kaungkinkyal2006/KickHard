<?php
session_start();

include '../includes/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. Try admin login
    $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {  // plaintext check
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $row['username'];
            header("Location: ../admin/index.php");
            exit;
        } else {
            $error = "Wrong password for admin!";
        }
    } else {
        $stmt->close();

        // 2. Try client login - double-check table name and column names!
        $stmt = $conn->prepare("SELECT id, username, password, email FROM clients WHERE username = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);  // DB error if statement fails
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // DEBUG: Check password and username fetched from DB
            // echo "<pre>", print_r($row, true), "</pre>";

            if (password_verify($password, $row['password'])) {
                $_SESSION['client_logged_in'] = true;
                $_SESSION['client_name'] = $row['username'];
                $_SESSION['client_email'] = $row['email'];
                header("Location: /kickhard/client/index.php");
                exit;
            } else {
                $error = "Wrong password for client!";
            }
        } else {
            $error = "User not found in admin or client!";
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/login.css" />
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php if ($error): ?>
      <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <label for="username">Username</label>
      <input id="username" type="text" name="username" required autocomplete="username" />
      
      <label for="password">Password</label>
      <input id="password" type="password" name="password" required autocomplete="current-password" />
      
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
