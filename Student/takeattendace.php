<?php
session_start();
include '../Includes/dbcon.php';
date_default_timezone_set("Asia/Kolkata");

$statusMsg = "";
$userEmail = $_SESSION['email'] ?? null;

if (!$userEmail) {
    // User not logged in, redirect or show error
    header("Location: login.php");
    exit();
}

// Fetch logged-in student's admission number once here:
$query = "SELECT rs.*, s.roomId, s.classId, s.classArmId, s.admissionNumber 
          FROM tblregstudents rs
          JOIN tblstudents s ON rs.email = '$userEmail'
          LIMIT 1";
$rs = $conn->query($query);

if ($rs->num_rows > 0) {
    $row = $rs->fetch_assoc();
    $admissionNumber = $row['admissionNumber'];
} else {
    die("Student profile not found.");
}

// Handle form submission
if (isset($_POST['mark'])) {
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    // Get studentId from admissionNumber (from session/profile)
    $query = mysqli_query($conn, "SELECT Id FROM tblstudents WHERE admissionNumber='$admissionNumber'");
    $result = mysqli_fetch_array($query);

    if ($result) {
        $studentId = $result['Id'];
        $timeRecorded = date("Y-m-d H:i:s");

        // Insert attendance
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
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Student Attendance</title>
  <link href="img/logo/icon.ico" rel="icon" />
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="css/ruang-admin.min.css" rel="stylesheet" />
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
            <h3 class="mb-0 text-gray-800">📌 Student Attendance Marking</h3>
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

          <form method="POST" class="mb-5">

            <div class="form-group mb-3">
              <label>Admission Number:</label>
              <!-- Show admission number readonly and also send it as hidden field -->
              <input type="text" class="form-control" value="<?= htmlspecialchars($admissionNumber) ?>" readonly>
              <input type="hidden" name="admissionNumber" value="<?= htmlspecialchars($admissionNumber) ?>">
            </div>

            <div class="form-group mb-3">
              <label>Status:</label>
              <select name="status" class="form-control" required>
                <option value="">Select Status</option>
                <option value="In">In</option>
                <option value="Out">Out</option>
              </select>
            </div>

            <div class="form-group mb-3">
              <label>Remarks (optional):</label>
              <input type="text" name="remarks" class="form-control" />
            </div>

            <button type="submit" name="mark" class="btn btn-primary">Mark Attendance</button>
            <a href="index.php" class="btn btn-secondary">Back To Home</a>
          </form>

          <!-- You can enable attendance history table here if needed -->

        </div> <!-- container-wrapper -->

      </div> <!-- content -->
    </div> <!-- content-wrapper -->

  </div> <!-- wrapper -->

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
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
