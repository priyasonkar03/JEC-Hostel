<?php
session_start();
include '../Includes/dbcon.php';
date_default_timezone_set("Asia/Kolkata");

$statusMsg = "";

if (isset($_POST['mark'])) {
    $admissionNumber = $_POST['admissionNumber'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    // Get studentId from admissionNumber
    $query = mysqli_query($conn, "SELECT Id FROM tblstudents WHERE admissionNumber='$admissionNumber'");
    $result = mysqli_fetch_array($query);

    if ($result) {
        $studentId = $result['Id'];
        $timeRecorded = date("Y-m-d H:i:s");

        // Insert into attendance table
        $insertQuery = mysqli_query($conn, "INSERT INTO tblattendancebystd (studentId, status, timeRecorded, remarks) 
        VALUES ('$studentId', '$status', '$timeRecorded', '$remarks')");

        if ($insertQuery) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit();
        } else {
            $statusMsg = "<div class='alert alert-danger'>❌ Error occurred while marking attendance.</div>";
        }
    } else {
        $statusMsg = "<div class='alert alert-warning'>⚠️ Invalid Admission Number!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Student Attendance</title>
  <link href="img/logo/attnlg.jpg" rel="icon">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
<div id="wrapper">

  <!-- Sidebar -->
  <?php include "Includes/sidebar.php"; ?>
  <!-- Sidebar -->

  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

      <!-- TopBar -->
      <?php include "Includes/topbar.php"; ?>
      <!-- Topbar -->

      <div class="container-fluid" id="container-wrapper">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h3 class="mb-0 text-gray-800">📊 Attendance History</h3>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
          </ol>
        </div>

        <?php
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<div class='alert alert-success'>✅ Attendance marked successfully!</div>";
        }
        if (!empty($statusMsg)) echo $statusMsg;
        ?>

    
        <!-- <h4 class="mb-3">📊 Attendance History</h4> -->

        <table class="table table-bordered table-hover">
          <thead>
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
                        <td>" . $row['admissionNumber'] . "</td>
                        <td>" . $row['status'] . "</td>
                        <td>" . $date . "</td>
                        <td>" . $time . "</td>
                        <td>" . $row['remarks'] . "</td>
                      </tr>";
            }
            ?>
          </tbody>
        </table>

      </div> <!-- container-wrapper -->

    </div> <!-- content -->
  </div> <!-- content-wrapper -->
  
  
</div> <!-- wrapper -->
<!-- Footer -->
<?php include 'includes/footer.php';?>
  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>
