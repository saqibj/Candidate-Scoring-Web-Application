<?php
include("../config/database.php");
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "interviewer") {
    header("Location: ../auth/login.php");
    exit;
}

$candidate_id = $_GET['id'] ?? 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $analytical = $_POST["analytical"];
    $technical = $_POST["technical"];
    $communication = $_POST["communication"];
    $business = $_POST["business"];
    $problem_solving = $_POST["problem_solving"];
    $comments = $_POST["comments"];
    $interviewer_id = $_SESSION["user_id"];

    $overall_score = ($analytical * 0.20) + ($technical * 0.20) + ($communication * 0.15) + ($business * 0.15) + ($problem_solving * 0.15);

    $sql = "INSERT INTO evaluations (candidate_id, interviewer_id, analytical_skills, technical_skills, communication_skills, 
            business_acumen, problem_solving, overall_score, comments) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiiiids", $candidate_id, $interviewer_id, $analytical, $technical, $communication, $business, $problem_solving, $overall_score, $comments);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Evaluation submitted!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Evaluate Candidate</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Evaluate Candidate</h2>
    <form method="POST">
        <label>Analytical Skills (1-5):</label>
        <input type="number" name="analytical" min="1" max="5" class="form-control" required>
        
        <label>Technical Skills (1-5):</label>
        <input type="number" name="technical" min="1" max="5" class="form-control" required>

        <label>Communication Skills (1-5):</label>
        <input type="number" name="communication" min="1" max="5" class="form-control" required>

        <label>Business Acumen (1-5):</label>
        <input type="number" name="business" min="1" max="5" class="form-control" required>

        <label>Problem Solving (1-5):</label>
        <input type="number" name="problem_solving" min="1" max="5" class="form-control" required>

        <label>Comments:</label>
        <textarea name="comments" class="form-control" required></textarea>

        <button type="submit" class="btn btn-primary mt-3">Submit Evaluation</button>
    </form>
</body>
</html>
