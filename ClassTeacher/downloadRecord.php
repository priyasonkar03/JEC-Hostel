<?php
session_start();
include '../Includes/dbcon.php';
date_default_timezone_set("Asia/Kolkata");

$statusMsg = "";
$dateToday = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>Today's Detailed Attendance Report</title>
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
          <h3 class="mb-0 text-gray-800">📊 Detailed Attendance Report - Today</h3>
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
                    <th>First Name</th>
                    <th>Last Name</th>
                   
                    <th>Admission No</th>
                    <th>Hostel</th>
                    <th>Hostel Arm</th>
                    <th>Session</th>
                    <th>Term</th>
                    <th>Status</th>
                    <th>Date</th>
                    <!-- <th>Time</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $cnt = 1;
                  $ret = mysqli_query($conn, "SELECT tblattendance.Id, tblattendance.status, tblattendance.dateTimeTaken,
                          tblclass.className, tblclassarms.classArmName, tblsessionterm.sessionName, tblsessionterm.termId,
                          tblterm.termName, tblstudents.firstName, tblstudents.lastName, 
                          tblstudents.admissionNumber
                          FROM tblattendance
                          INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
                          INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
                          INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
                          INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
                          INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                          WHERE tblattendance.dateTimeTaken = '$dateToday'
                          AND tblattendance.classId = '$_SESSION[classId]'
                          AND tblattendance.classArmId = '$_SESSION[classArmId]'
                          ORDER BY tblattendance.dateTimeTaken DESC");

                  if (mysqli_num_rows($ret) > 0) {
                    while ($row = mysqli_fetch_assoc($ret)) {
                      $statusText = ($row['status'] == '1') ? "Present" : "Absent";
                      echo "<tr>
                              <td>" . $cnt++ . "</td>
                              <td>" . htmlspecialchars($row['firstName']) . "</td>
                              <td>" . htmlspecialchars($row['lastName']) . "</td>
                           
                              <td>" . htmlspecialchars($row['admissionNumber']) . "</td>
                              <td>" . htmlspecialchars($row['className']) . "</td>
                              <td>" . htmlspecialchars($row['classArmName']) . "</td>
                              <td>" . htmlspecialchars($row['sessionName']) . "</td>
                              <td>" . htmlspecialchars($row['termName']) . "</td>
                              <td>" . $statusText . "</td>
                              <td>" . htmlspecialchars($row['dateTimeTaken']) . "</td>
                            </tr>";
                    }
                  } else {
                    echo "<tr><td colspan='11' class='text-center'>No records found for today.</td></tr>";
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



















<!--<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

?>
        <table border="1">
        <thead>
            <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <!-- <th>Other Name</th> -->
           <!-- <th>Admission No</th>
            <th>Hostel</th>
            <th>Hostel Arm</th>
            <th>Session</th>
            <th>Term</th>
            <th>Status</th>
            <th>Date</th>
            </tr>
        </thead>

<?php 
$filename="Attendance list";
$dateTaken = date("Y-m-d");

$cnt=1;			
$ret = mysqli_query($conn,"SELECT tblattendance.Id,tblattendance.status,tblattendance.dateTimeTaken,tblclass.className,
        tblclassarms.classArmName,tblsessionterm.sessionName,tblsessionterm.termId,tblterm.termName,
        tblstudents.firstName,tblstudents.lastName,tblstudents.admissionNumber
        FROM tblattendance
        INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
        INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
        INNER JOIN tblsessionterm ON tblsessionterm.Id = tblattendance.sessionTermId
        INNER JOIN tblterm ON tblterm.Id = tblsessionterm.termId
        INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
        where tblattendance.dateTimeTaken = '$dateTaken' and tblattendance.classId = '$_SESSION[classId]' and tblattendance.classArmId = '$_SESSION[classArmId]'");

if(mysqli_num_rows($ret) > 0 )
{
while ($row=mysqli_fetch_array($ret)) 
{ 
    
    if($row['status'] == '1'){$status = "Present"; $colour="#00FF00";}else{$status = "Absent";$colour="#FF0000";}

echo '  
<tr>  
<td>'.$cnt.'</td> 
<td>'.$firstName= $row['firstName'].'</td> 
<td>'.$lastName= $row['lastName'].'</td> 

<td>'.$admissionNumber= $row['admissionNumber'].'</td> 
<td>'.$className= $row['className'].'</td> 
<td>'.$classArmName=$row['classArmName'].'</td>	
<td>'.$sessionName=$row['sessionName'].'</td>	 
<td>'.$termName=$row['termName'].'</td>	
<td>'.$status=$status.'</td>	 	
<td>'.$dateTimeTaken=$row['dateTimeTaken'].'</td>	 					
</tr>  
';
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$filename."-report.xls");
header("Pragma: no-cache");
header("Expires: 0");
			$cnt++;
			}
	}
?>
</table>-->