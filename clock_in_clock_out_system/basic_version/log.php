<?php
$servername = "localhost";
$username = "robotics_user";
$password = "buzzybots#1";
$dbname = "robotics_db";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$code = trim($_POST['code']);
if (empty($code)) die("Error: Code required!");
$sql = "SELECT id, name FROM users WHERE user_code = '$code'";
$result = $conn->query($sql);
if ($result->num_rows === 0) die("Error: User code not found!");
$user = $result->fetch_assoc();
$user_id = $user['id'];
$user_name = $user['name'];
$sql = "SELECT action FROM logs WHERE user_id = $user_id ORDER BY time DESC LIMIT 1";
$last_result = $conn->query($sql);
$last_action = $last_result->num_rows > 0 ? $last_result->fetch_assoc()['action'] : null;
if (isset($_POST['manualcin'])) {
    // Manual entry case
    $action = 'entry';
    $entrytime = trim($_POST['entrytime']);
    if (empty($entrytime)) die("Error: Please provide a manual time.");
    $entrytime .= ":00"; 
    if ($last_action === $action) die("Error: Cannot repeat the same action twice in a row.");
    $sql = "INSERT INTO logs (user_id, action, time) VALUES ($user_id, '$action', '$entrytime')";
} else {
    // Normal entry/exit
    $action = $_POST['action'];
    if ($last_action === $action) die("Error: Cannot repeat the same action twice in a row.");
    $sql = "INSERT INTO logs (user_id, action) VALUES ($user_id, '$action')";
}
if ($conn->query($sql) === TRUE) {
    echo "Success: $user_name has recorded '$action' at " . date("Y-m-d H:i:s");
} else {
    echo "Error: Could not insert log.";
}

$conn->close();
?>
