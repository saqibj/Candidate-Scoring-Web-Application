<?php
include("../config/database.php");
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "interviewer") {
    header("Location: ../auth/login.php");
    exit;
}

$result = $conn->query("SELECT * FROM candidates");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Interviewer Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Interviewer Dashboard</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['position_applied']) ?></td>
                    <td>
                        <a href="../evaluations/evaluate.php?id=<?= $row['id'] ?>" class="btn btn-primary">Evaluate</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
</body>
</html>
