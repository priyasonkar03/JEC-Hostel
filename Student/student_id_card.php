<?php
session_start();
include '../Includes/dbcon.php';

$userEmail = $_SESSION['email'];

$query = "SELECT rs.*, s.roomId, s.classId, s.classArmId, s.admissionNumber 
          FROM tblregstudents rs
          JOIN tblstudents s ON rs.email = '$userEmail'
          LIMIT 1";
$rs = $conn->query($query);

if ($rs->num_rows > 0) {
  $row = $rs->fetch_assoc();

  $roomDetails = ['roomNumber' => 'N/A', 'block' => 'N/A'];
  if (!empty($row['roomId'])) {
    $roomQuery = "SELECT roomNumber, block FROM tblrooms WHERE Id = " . $row['roomId'];
    $roomResult = $conn->query($roomQuery);
    if ($roomResult->num_rows > 0) {
      $roomDetails = $roomResult->fetch_assoc();
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Student ID Card</title>
  <link rel="icon" href="img/logo/attnlg.jpg">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: #f5f5f5;
    }

    .id-card {
      max-width: 600px;
      margin: 40px auto;
      padding: 30px;
      background: #fff;
      border: 2px solid #007bff;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .id-card h4 {
      color: #007bff;
    }

    .id-card i {
      color: #6c757d;
      margin-right: 8px;
    }

    .download-btn {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .print-heading {
      display: none;
      text-align: center;
      font-size: 28px;
      font-weight: bold;
      color: #000;
      margin-bottom: 20px;
    }

    @media print {
      @page {
        size: landscape;
      }

      body {
        -webkit-print-color-adjust: exact !important;
        color-adjust: exact !important;
      }

      .download-btn,
      .breadcrumb,
      .topbar,
      .sidebar {
        display: none !important;
      }

      .print-heading {
        display: block;
      }

      .id-card {
        border: 2px solid #000;
        box-shadow: none;
      }
    }
  </style>
</head>
<body>

  <div class="print-heading">JEC HOSTEL ID CARD</div>

  <div class="id-card text-center">
    <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
    <h4><?= $row['firstName'] . ' ' . $row['lastName'] ?></h4>
    <hr>

    <div class="row text-start mb-2">
      <div class="col-md-6"><i class="fas fa-id-card"></i><strong> Admission No:</strong> <?= $row['admissionNumber'] ?></div>
      <div class="col-md-6"><i class="fas fa-envelope"></i><strong> Email:</strong> <?= $row['email'] ?></div>
    </div>

    <div class="row text-start mb-2">
      <div class="col-md-6"><i class="fas fa-venus-mars"></i><strong> Gender:</strong> <?= $row['gender'] ?></div>
      <div class="col-md-6"><i class="fas fa-phone"></i><strong> Phone:</strong> <?= $row['phone'] ?></div>
    </div>

    <div class="row text-start mb-2">
      <div class="col-md-6"><i class="fas fa-building"></i><strong> Block:</strong> <?= $roomDetails['block'] ?></div>
      <div class="col-md-6"><i class="fas fa-bed"></i><strong> Room:</strong> <?= $roomDetails['roomNumber'] ?></div>
    </div>

    <!-- <div class="row text-start mb-2">
      <div class="col-md-6"><i class="fas fa-layer-group"></i><strong> Class:</strong> <?= $row['classId'] ?></div>
      <div class="col-md-6"><i class="fas fa-code-branch"></i><strong> Class Arm:</strong> <?= $row['classArmId'] ?></div>
    </div> -->

    <div class="row text-start mb-2">
      <div class="col-md-6"><i class="fas fa-bed"></i><strong> Hostel Type:</strong> <?= $row['hostelType'] ?></div>
      <div class="col-md-6"><i class="fas fa-calendar-alt"></i><strong> Session:</strong> <?= $row['session'] ?></div>
    </div>

    <div class="row text-start mb-2">
      <div class="col-md-6"><i class="fas fa-calendar-check"></i><strong> Registered:</strong> <?= date("d M Y", strtotime($row['regDate'])) ?></div>
    </div>
  </div>

  <!-- <div class="download-btn">
    <button class="btn btn-primary" onclick="window.print()">
      <i class="fas fa-download"></i> Download ID Card
    </button>
  </div>-->
    <div class="d-flex justify-content-center mt-4" style="gap: 1rem;">
    <button class="btn btn-primary" onclick="window.print()">
        <i class="fas fa-download"></i> Download ID Card
    </button>

    <a href="index.php" class="btn btn-primary text-white">
        Back To Home
    </a>
    </div>


  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
} else {
  echo "<div class='text-center text-danger mt-5'><strong>No profile found.</strong></div>";
}
?>
