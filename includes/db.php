<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kickhard";
$port = 3307; // your own port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
