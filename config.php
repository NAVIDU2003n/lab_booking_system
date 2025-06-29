<?php
// config.php
$servername = "localhost";
$username = "root"; // default XAMPP username
$password = "";     // default XAMPP password is empty
$dbname = "lab_booking_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session for user authentication
session_start();
?>
