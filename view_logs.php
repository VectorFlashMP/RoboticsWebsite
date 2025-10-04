<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- DB connection ---
$servername = "localhost";
$username = "robotics_user";
$password = "buzzybots#1";
$dbname = "robotics_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// --- Fetch logs with user names ---
$sql = "SELECT logs.log_id, users.name, logs.action, logs.time 
        FROM logs 
        JOIN users ON logs.user_id = users.id
        ORDER BY logs.time DESC";

$result = $conn->query($sql);
if (!$result) die("Query failed: " . $conn->error);

// --- Display as HTML table ---
echo "<h2>Team Logs</h2>";
echo "<table border='1' cellpadding='8' cellspacing='0'>";
echo "<tr><th>Log ID</th><th>Name</th><th>Action</th><th>Time</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['log_id']."</td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['action']."</td>";
    echo "<td>".$row['time']."</td>";
    echo "</tr>";
}

echo "</table>";

$conn->close();
?>
