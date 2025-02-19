<?php
include("../config/database.php");
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Welcome, Admin!</h2>
    <ul class="list-group mt-3">
        <li class="list-group-item"><a href="../candidates/add.php">Add Candidate</a></li>
        <li class="list-group-item"><a href="../candidates/view.php">View Candidates</a></li>
        <li class="list-group-item"><a href="../reports/generate.php">Generate Reports</a></li>
    </ul>
    <a href="../auth/logout.php" class="btn btn-danger mt-3">Logout</a>
</body>
</html>
