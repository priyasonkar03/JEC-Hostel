<?php
session_start();
include '../Includes/dbcon.php';
date_default_timezone_set("Asia/Kolkata");

$statusMsg = "";
?>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Student Attendance History</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head> -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>Student Attendance History</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
<div id="wrapper">

  <?php include "Includes/sidebar.php"; ?>

  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

      <?php include "Includes/topbar.php"; ?>

      <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <!-- <h3 class="mb-0 text-gray-800">📊 Student Attendance History</h3> -->
          <h3 class="mb-0 text-gray-800"> Student Attendance History</h3>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Attendance Records</li>
          </ol>
        </div>

        <?php if (!empty($statusMsg)) echo $statusMsg; ?>

        <div class="card shadow mb-4">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>Admission No</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Remarks</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // FIXED QUERY — using tblstudents now
                  $query = mysqli_query($conn, "SELECT a.*, s.admissionNumber 
                    FROM tblattendancebystd a 
                    JOIN tblstudents s ON a.studentId = s.Id 
                    ORDER BY a.timeRecorded DESC");

                  $sn = 1;
                  while ($row = mysqli_fetch_assoc($query)) {
                      $date = date("Y-m-d", strtotime($row['timeRecorded']));
                      $time = date("h:i:s A", strtotime($row['timeRecorded']));

                      echo "<tr>
                              <td>" . $sn++ . "</td>
                              <td>" . htmlspecialchars($row['admissionNumber']) . "</td>
                              <td>" . htmlspecialchars($row['status']) . "</td>
                              <td>" . $date . "</td>
                              <td>" . $time . "</td>
                              <td>" . htmlspecialchars($row['remarks']) . "</td>
                            </tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

</div>

<?php include 'includes/footer.php'; ?>

<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/ruang-admin.min.js"></script>
</body>

</html>
