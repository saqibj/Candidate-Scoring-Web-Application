<?php
require_once("../config/database.php");
require_once("../libs/tcpdf/tcpdf.php");
session_start();

if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "hr")) {
    header("Location: ../auth/login.php");
    exit;
}

$candidate_id = $_GET['id'] ?? 0;

// Fetch candidate details
$candidate_sql = "SELECT * FROM candidates WHERE id = ?";
$stmt = $conn->prepare($candidate_sql);
$stmt->bind_param("i", $candidate_id);
$stmt->execute();
$candidate_result = $stmt->get_result();
$candidate = $candidate_result->fetch_assoc();

// Fetch evaluations
$evaluation_sql = "SELECT u.username, e.* FROM evaluations e
                   JOIN users u ON e.interviewer_id = u.id
                   WHERE e.candidate_id = ?";
$stmt = $conn->prepare($evaluation_sql);
$stmt->bind_param("i", $candidate_id);
$stmt->execute();
$evaluation_result = $stmt->get_result();

// Initialize PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle("Candidate Report - " . $candidate['name']);
$pdf->AddPage();
$pdf->SetFont("helvetica", "", 12);

$html = "<h2>Candidate Report</h2>
         <strong>Name:</strong> {$candidate['name']}<br>
         <strong>Position Applied:</strong> {$candidate['position_applied']}<br><br>
         <h3>Evaluations</h3>";

while ($row = $evaluation_result->fetch_assoc()) {
    $html .= "<strong>Interviewer:</strong> {$row['username']}<br>
              <strong>Analytical Skills:</strong> {$row['analytical_skills']}<br>
              <strong>Technical Skills:</strong> {$row['technical_skills']}<br>
              <strong>Communication Skills:</strong> {$row['communication_skills']}<br>
              <strong>Business Acumen:</strong> {$row['business_acumen']}<br>
              <strong>Problem Solving:</strong> {$row['problem_solving']}<br>
              <strong>Overall Score:</strong> {$row['overall_score']}<br>
              <strong>Comments:</strong> {$row['comments']}<br><br>";
}

$pdf->writeHTML($html);
$pdf->Output("Candidate_Report_{$candidate['id']}.pdf", "D");
?>
