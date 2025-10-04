<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// --- DB connection ---
$servername = "localhost";
$username = "robotics_user";   // DB user
$password = "buzzybots#1";      // DB password
$dbname = "robotics_db";       // DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Get form data ---
$code = trim($_POST['code']);
$action = $_POST['action']; // 'entry' or 'exit'
var_dump($_POST);
// --- Look up user ---
$stmt = $conn->prepare("SELECT id, name FROM users WHERE user_code = ?");
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: User code not found!");
}

$user = $result->fetch_assoc();
$user_id = $user['id'];
$user_name = $user['name'];

// --- Check last action ---
$stmt = $conn->prepare("SELECT action FROM logs WHERE user_id = ? ORDER BY time DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$last_result = $stmt->get_result();

$last_action = null;
if ($last_result->num_rows > 0) {
    $last_action = $last_result->fetch_assoc()['action'];
}

// --- Insert new log only if different from last ---
if ($last_action === $action) {
    die("Error: Cannot repeat the same action twice in a row.");
}

$stmt = $conn->prepare("INSERT INTO logs (user_id, action) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $action);

if ($stmt->execute()) {
    echo "Success: $user_name has recorded '$action' at " . date("Y-m-d H:i:s");
} else {
    echo "Error: Could not insert log.";
}

$conn->close();
?>
