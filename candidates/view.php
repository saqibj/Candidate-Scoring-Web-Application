<?php
include("../config/database.php");
session_start();

$result = $conn->query("SELECT * FROM candidates");

echo "<h2>Candidate List</h2>";
echo "<table border='1'><tr><th>Name</th><th>Position</th><th>Referred By</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['name']}</td><td>{$row['position_applied']}</td><td>{$row['referred_by']}</td></tr>";
}

echo "</table>";
?>
<a href="../auth/logout.php">Logout</a>
