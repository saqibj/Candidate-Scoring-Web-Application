<?php
include("../config/database.php");
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "hr") {
    header("Location: ../auth/login.php");
    exit;
}

$result = $conn->query("SELECT candidates.id, candidates.name, candidates.position_applied, AVG(evaluations.overall_score) as avg_score 
                        FROM candidates 
                        LEFT JOIN evaluations ON candidates.id = evaluations.candidate_id 
                        GROUP BY candidates.id");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HR Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>HR Dashboard</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Average Score</th>
                <th>Reports</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['position_applied']) ?></td>
                    <td><?= number_format($row['avg_score'], 2) ?></td>
                    <td>
                        <a href="../reports/generate.php?id=<?= $row['id'] ?>" class="btn btn-success">Generate Report</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
</body>
</html>
