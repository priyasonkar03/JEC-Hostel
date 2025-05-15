<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Fetch class and arm for the logged-in teacher
$query = "SELECT classId, classArmId FROM tblclassteacher WHERE Id = '$_SESSION[userId]'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    echo "<div class='alert alert-danger'>No class assigned to you.</div>";
    exit();
}

$classData = $result->fetch_assoc();
$classId = $classData['classId'];
$classArmId = $classData['classArmId'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Hostel Warden - Student Room Allocation</title>
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
<div id="wrapper">
  <?php include "Includes/sidebar.php";?>
  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
      <?php include "Includes/topbar.php";?>
      <div class="container-fluid ml-3 mr-3">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Students with Room Allocation</h1>
        </div>

        <table class="table table-bordered" id="dataTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Admission Number</th>
              <th>Name</th>
              <th>Room Number</th>
              <th>Block</th>
              <th>Date Created</th>
            </tr>
          </thead>
          <tbody>
          <?php
          // Fetch students for this teacher's class and arm
          $query = "
          SELECT s.admissionNumber, CONCAT(s.firstName,' ',s.lastName) AS fullName, r.roomNumber, r.block, s.dateCreated
          FROM tblstudents s
          LEFT JOIN tblrooms r ON s.roomId = r.Id
          WHERE s.classId='$classId' AND s.classArmId='$classArmId'
          ORDER BY s.dateCreated DESC";
          
          $result = $conn->query($query);
          $sn = 1;
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$sn}</td>
              <td>{$row['admissionNumber']}</td>
              <td>{$row['fullName']}</td>
              <td>".($row['roomNumber'] ?? 'Not Assigned')."</td>
              <td>".($row['block'] ?? '-')."</td>
              <td>{$row['dateCreated']}</td>
            </tr>";
            $sn++;
          }
          ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php include "Includes/footer.php";?>
  </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="js/ruang-admin.min.js"></script>
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable();
  });
</script>
</body>
</html>
