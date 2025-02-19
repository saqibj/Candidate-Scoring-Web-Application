<?php
require_once("../config/database.php");
require_once("../libs/tcpdf/tcpdf.php");
session_start();

if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "hr")) {
    header("Location: ../auth/login.php");
    exit;
}

// Validate candidate_id
$candidate_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? 0;
if ($candidate_id <= 0) {
    header("Location: ../dashboard/hr.php?error=invalid_id");
    exit;
}

// Fetch candidate details
$candidate_sql = "SELECT * FROM candidates WHERE id = ?";
$stmt = $conn->prepare($candidate_sql);
$stmt->bind_param("i", $candidate_id);
$stmt->execute();
$candidate_result = $stmt->get_result();
$candidate = $candidate_result->fetch_assoc();

// Check if candidate exists
if (!$candidate) {
    header("Location: ../dashboard/hr.php?error=not_found");
    exit;
}

// Fetch evaluations
$evaluation_sql = "SELECT u.username, e.* FROM evaluations e
                   JOIN users u ON e.interviewer_id = u.id
                   WHERE e.candidate_id = ?";
$stmt = $conn->prepare($evaluation_sql);
$stmt->bind_param("i", $candidate_id);
$stmt->execute();
$evaluation_result = $stmt->get_result();

// Initialize PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle("Candidate Report - " . htmlspecialchars($candidate['name']));
$pdf->SetMargins(15, 25, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);

// Add header with company logo
$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Candidate Evaluation Report', 'Generated: ' . date('Y-m-d H:i:s'));

$pdf->AddPage();
$pdf->SetFont("helvetica", "", 12);

// Add CSS styling for better presentation
$html = '
<style>
    h2 { color: #333; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
    .section { margin-bottom: 10px; padding: 5px; border: 1px solid #eee; }
    .label { font-weight: bold; color: #555; }
</style>
<h2>Candidate Report</h2>
<div class="section">
    <span class="label">Name:</span> ' . htmlspecialchars($candidate['name']) . '<br>
    <span class="label">Position Applied:</span> ' . htmlspecialchars($candidate['position_applied']) . '
</div>
<h3>Evaluations</h3>';

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
