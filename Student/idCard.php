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

  $roomQuery = "SELECT roomNumber, block FROM tblrooms WHERE Id = " . $row['roomId'];
  $roomResult = $conn->query($roomQuery);
  $roomDetails = $roomResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>Student - ID Card</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

  <style>
    .id-card {
      max-width: 500px;
      margin: 20px auto;
      padding: 25px;
      border: 2px solid #007bff;
      border-radius: 15px;
      background: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
    @media print {
      .download-btn, .topbar, .sidebar, .breadcrumb {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div id="wrapper">
    <?php include "Includes/sidebar.php";?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "Includes/topbar.php";?>

        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 text-gray-800">Student ID Card</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">ID Card</li>
            </ol>
          </div>

          <div class="id-card text-center">
            <i class="fas fa-user-circle fa-5x mb-3"></i>
            <h4><?= $row['firstName'] . ' ' . $row['lastName'] ?></h4>

            <p><i class="fas fa-id-card"></i><strong>Admission No:</strong> <?= $row['admissionNumber'] ?></p>
            <p><i class="fas fa-envelope"></i><strong>Email:</strong> <?= $row['email'] ?></p>
            <p><i class="fas fa-venus-mars"></i><strong>Gender:</strong> <?= $row['gender'] ?></p>
            <p><i class="fas fa-phone"></i><strong>Phone:</strong> <?= $row['phone'] ?></p>
            <p><i class="fas fa-bed"></i><strong>Hostel Type:</strong> <?= $row['hostelType'] ?></p>
            <p><i class="fas fa-calendar-alt"></i><strong>Session:</strong> <?= $row['session'] ?></p>
            <p><i class="fas fa-calendar-check"></i><strong>Registered:</strong> <?= date("d M Y", strtotime($row['regDate'])) ?></p>
            <p><i class="fas fa-door-open"></i><strong>Room No:</strong> <?= $roomDetails['roomNumber'] ?></p>
            <p><i class="fas fa-building"></i><strong>Block:</strong> <?= $roomDetails['block'] ?></p>
            <p><i class="fas fa-layer-group"></i><strong>Class ID:</strong> <?= $row['classId'] ?></p>
            <p><i class="fas fa-code-branch"></i><strong>Class Arm:</strong> <?= $row['classArmId'] ?></p>
          </div>

          <div class="download-btn">
            <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-download me-2"></i>Download ID Card</button>
          </div>

        </div>
      </div>
      <?php include 'includes/footer.php';?>
    </div>
  </div>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>
</html>

<?php
} else {
  echo "<div class='text-center text-danger'><strong>No profile found.</strong></div>";
}
?>
