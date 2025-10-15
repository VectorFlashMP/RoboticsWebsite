<?php
$servername = "localhost";
$username = "robotics_user";
$password = "buzzybots#1";
$dbname = "robotics_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
$request_type = $_POST['request_type'] ?? '';
if ($request_type === 'verify_code') {
    $code = trim($_POST['code']);
    $sql = "SELECT id FROM users WHERE user_code = '$code'";
    $res = $conn->query($sql);
    echo ($res->num_rows > 0) ? "verified" : "invalid";
    exit;
}

if ($request_type === 'log_action') {
    $code = trim($_POST['code']);
    $action = $_POST['action'] ?? 'entry';
    $manual = isset($_POST['manual']);
    $entrytime = $_POST['entrytime'] ?? '';
    $sql = "SELECT id, name FROM users WHERE user_code = '$code'";
    $res = $conn->query($sql);
    if ($res->num_rows === 0) die("Error: Code not found.");
    $user = $res->fetch_assoc();
    $user_id = $user['id'];
    $name = $user['name'];
    $sql = "SELECT action FROM logs WHERE user_id = $user_id ORDER BY time DESC LIMIT 1";
    $last = $conn->query($sql)->fetch_assoc()['action'] ?? null;
    if ($last === $action) die("Error: Cannot repeat same action twice.");

    if ($manual && $entrytime) {
        $entrytime = date('Y-m-d') . ' ' . $entrytime . ':00';
        $sql = "INSERT INTO logs (user_id, action, time) VALUES ($user_id, 'entry', '$entrytime')";
    } else {
        $sql = "INSERT INTO logs (user_id, action) VALUES ($user_id, '$action')";
    }

    if ($conn->query($sql))
        echo "Success: $name has recorded '$action' at " . date('Y-m-d H:i:s');
    else
        echo "Error inserting log.";
}

$conn->close();
?>
