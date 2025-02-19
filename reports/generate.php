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

// Initialize PDF with better settings
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle("Candidate Report - " . htmlspecialchars($candidate['name']));
$pdf->SetMargins(15, 25, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 25);

// Add custom header/footer
class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 15);
        $this->Cell(0, 10, 'Candidate Evaluation Report', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
    
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Generated on ' . date('Y-m-d H:i:s') . ' - Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C');
    }
}

$pdf = new MYPDF();
$pdf->AddPage();

// Improved HTML structure with better styling
$html = '
<style>
    h2 { color: #2c3e50; font-size: 18px; margin-bottom: 10px; }
    .candidate-info { background-color: #f8f9fa; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
    .evaluation-card { border: 1px solid #dee2e6; padding: 10px; margin-bottom: 10px; }
    .skill-label { color: #495057; font-weight: bold; }
    .skill-value { color: #212529; }
</style>
<h2>Candidate Details</h2>
<div class="candidate-info">
    <p><span class="skill-label">Name:</span> ' . htmlspecialchars($candidate['name']) . '</p>
    <p><span class="skill-label">Position:</span> ' . htmlspecialchars($candidate['position_applied']) . '</p>
</div>
<h2>Evaluation Summary</h2>';

// Check if there are any evaluations
if ($evaluation_result->num_rows === 0) {
    $html .= '<p>No evaluations available for this candidate.</p>';
} else {
    while ($row = $evaluation_result->fetch_assoc()) {
        $html .= '<div class="evaluation-card">
            <p><span class="skill-label">Interviewer:</span> ' . htmlspecialchars($row['username']) . '</p>
            <p><span class="skill-label">Analytical Skills:</span> ' . (int)$row['analytical_skills'] . '/5</p>
            <p><span class="skill-label">Technical Skills:</span> ' . (int)$row['technical_skills'] . '/5</p>
            <p><span class="skill-label">Communication Skills:</span> ' . (int)$row['communication_skills'] . '/5</p>
            <p><span class="skill-label">Business Acumen:</span> ' . (int)$row['business_acumen'] . '/5</p>
            <p><span class="skill-label">Problem Solving:</span> ' . (int)$row['problem_solving'] . '/5</p>
            <p><span class="skill-label">Overall Score:</span> ' . number_format($row['overall_score'], 2) . '</p>
            <p><span class="skill-label">Comments:</span><br>' . nl2br(htmlspecialchars($row['comments'])) . '</p>
        </div>';
    }
}

$pdf->writeHTML($html);
$pdf->Output("Candidate_Report_{$candidate['id']}.pdf", "D");
?>
