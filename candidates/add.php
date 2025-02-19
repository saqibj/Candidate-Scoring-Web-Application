<?php
include("../config/database.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $position = $_POST["position"];
    $referred_by = $_POST["referred_by"];

    $sql = "INSERT INTO candidates (name, position_applied, referred_by) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $position, $referred_by);

    if ($stmt->execute()) {
        echo "Candidate added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="POST">
    Name: <input type="text" name="name" required><br>
    Position Applied: <input type="text" name="position" required><br>
    Referred By: <input type="text" name="referred_by"><br>
    <input type="submit" value="Add Candidate">
</form>
