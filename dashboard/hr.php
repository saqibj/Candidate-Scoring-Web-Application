<?php
include("../config/database.php");
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "hr") {
    header("Location: ../auth/login.php");
    exit;
}

// Pagination settings
$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Optimized query with proper GROUP BY
$query = "SELECT c.id, c.name, c.position_applied, 
          ROUND(AVG(e.overall_score), 2) as avg_score,
          COUNT(e.id) as evaluation_count
          FROM candidates c
          LEFT JOIN evaluations e ON c.id = e.candidate_id 
          GROUP BY c.id, c.name, c.position_applied
          ORDER BY c.created_at DESC
          LIMIT ? OFFSET ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Get total count for pagination
$total_query = "SELECT COUNT(DISTINCT id) as total FROM candidates";
$total_result = $conn->query($total_query);
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $items_per_page);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HR Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body class="container mt-5">
    <h2>HR Dashboard</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_GET['error'] === 'invalid_id' ? 'Invalid candidate ID' : 'Candidate not found') ?>
        </div>
    <?php endif; ?>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Average Score</th>
                    <th>Evaluations</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['position_applied']) ?></td>
                        <td><?= $row['avg_score'] ? number_format($row['avg_score'], 2) : 'N/A' ?></td>
                        <td><?= $row['evaluation_count'] ?></td>
                        <td class="text-center">
                            <a href="../reports/generate.php?id=<?= $row['id'] ?>" 
                               class="btn btn-success btn-sm">
                                <i class="bi bi-file-pdf"></i> Generate Report
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Add pagination -->
    <?php if ($total_pages > 1): ?>
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page-1 ?>">&laquo; Previous</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page+1 ?>">Next &raquo;</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

    <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
</body>
</html>
