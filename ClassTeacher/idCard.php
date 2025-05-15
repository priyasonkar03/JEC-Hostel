<?php
// require 'vendor/autoload.php'; // or path to dompdf/autoload.inc.php if manually installed
require '../vendor/autoload.php'; // or path to dompdf/autoload.inc.php if manually installed
use Dompdf\Dompdf;

include '../Includes/dbcon.php';
session_start();

$_SESSION['studentId'] = $studentIdFromDatabase;

// TEMPORARY for testing ONLY
$_SESSION['studentId'] = 1;

// Assuming student is logged in and session holds their ID
if (!isset($_SESSION['studentId'])) {
    die("Unauthorized access");
}

$studentId = $_SESSION['studentId'];

$query = "SELECT s.*, r.roomNumber, r.block 
          FROM tblstudents s 
          LEFT JOIN tblrooms r ON s.roomId = r.Id 
          WHERE s.Id = '$studentId'";
$result = $conn->query($query);
$student = $result->fetch_assoc();

if (!$student) {
    die("Student not found.");
}

// Build HTML for ID card
$html = '
<style>
  .id-card {
    width: 300px;
    border: 2px solid #333;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    font-family: Arial;
  }
  .id-card img {
    border-radius: 50%;
  }
</style>

<div class="id-card">
  <h3>Hostel Student ID Card</h3>
  <img src="../student_images/' . $student['photo'] . '" width="100" height="100"><br><br>
  <strong>Name:</strong> ' . $student['firstName'] . ' ' . $student['lastName'] . '<br>
  <strong>Admission No:</strong> ' . $student['admissionNumber'] . '<br>
  <strong>Room:</strong> ' . ($student['roomNumber'] ?? 'Not Assigned') . '<br>
  <strong>Block:</strong> ' . ($student['block'] ?? '-') . '<br>
  <strong>Valid Till:</strong> ' . (date('Y') + 1) . '
</div>
';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render and output the PDF
$dompdf->render();
$dompdf->stream("ID_Card_" . $student['admissionNumber'] . ".pdf", array("Attachment" => false));
exit();
