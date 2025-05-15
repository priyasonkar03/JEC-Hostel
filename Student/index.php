
<?php 
include '../Includes/dbcon.php';
// session_start();
include '../Includes/session.php';


    // $query = "SELECT tblclass.className,tblclassarms.classArmName 
    // FROM tblclassteacher
    // INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
    // INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
    // Where tblclassteacher.Id = '$_SESSION[userId]'";

    // $rs = $conn->query($query);
    // $num = $rs->num_rows;
    // $rrw = $rs->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>Student - Dashboard</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
   <?php include "Includes/sidebar.php";?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
           <?php include "Includes/topbar.php";?>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <!-- <h1 class="h3 mb-0 text-gray-800">Student Dashboard (<?php echo $rrw['className'].' - '.$rrw['classArmName'];?>)</h1> -->
            <h1 class="h3 mb-0 text-gray-800">Student Dashboard </h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>
          
          
          <!---Container Fluid-->
        <?php include 'viewStudentProfile.php'?>

      </div>
      <!-- Footer -->
      <!-- Footer -->
    </div>
    <?php include 'includes/footer.php';?>
  </div>

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