<?php
$servername = "localhost";
$username = "robotics_user";
$password = "buzzybots#1";
$dbname = "robotics_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
