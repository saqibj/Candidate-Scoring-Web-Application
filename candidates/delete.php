<?php
include("../config/database.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    $sql = "DELETE FROM candidates WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Candidate deleted!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="POST">
    Candidate ID to Delete: <input type="number" name="id" required><br>
    <input type="submit" value="Delete">
</form>
