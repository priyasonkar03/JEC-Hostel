<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Handle form submission
if (isset($_POST['assign'])) {
    $admissionNumber = $_POST['admissionNumber'];
    $roomId = $_POST['roomId'];

    // Check if student exists
    $studentCheck = mysqli_query($conn, "SELECT * FROM tblstudents WHERE admissionNumber='$admissionNumber'");
    if (mysqli_num_rows($studentCheck) == 0) {
        $statusMsg = "No student found with that Admission Number!";
    } else {
        // Get room capacity
        $capacityQuery = mysqli_query($conn, "SELECT capacity FROM tblrooms WHERE Id='$roomId'");
        $roomCapacity = mysqli_fetch_assoc($capacityQuery)['capacity'];

        // Current number of students in the room
        $studentCountQuery = mysqli_query($conn, "SELECT COUNT(*) as studentCount FROM tblstudents WHERE roomId='$roomId'");
        $studentCount = mysqli_fetch_assoc($studentCountQuery)['studentCount'];

        if ($studentCount >= $roomCapacity) {
            $statusMsg = "This room is already full!";
        } else {
            // Assign room to student
            mysqli_query($conn, "UPDATE tblstudents SET roomId='$roomId' WHERE admissionNumber='$admissionNumber'");

            // Update room status if now full
            $newCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM tblstudents WHERE roomId='$roomId'"))['cnt'];
            if ($newCount >= $roomCapacity) {
                mysqli_query($conn, "UPDATE tblrooms SET status='Full' WHERE Id='$roomId'");
            }

            $statusMsg = "Student assigned to room successfully.";
        }
    }
}

// Fetch available rooms
$roomsQuery = mysqli_query($conn, "SELECT * FROM tblrooms WHERE status='Available'");

// Fetch students
$studentsQuery = mysqli_query($conn, "SELECT admissionNumber FROM tblstudents");
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
  <title>Hostel Warden - Dashboard</title>
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
            <!-- <h1 class="h3 mb-0 text-gray-800">Hostel Wardern Dashboard (<?php echo $rrw['className'].' - '.$rrw['classArmName'];?>)</h1> -->
            <h1 class="h3 mb-0 text-gray-800">Assign Rooms </h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Allocation Dashboard</li>
            </ol>
          </div>
        </div>

            


  <?php if (isset($statusMsg)) echo "<div class='alert alert-info'>$statusMsg</div>"; ?>

  <form method="post" class="ml-3 mr-3">
    <div class="form-group">
      <label for="admissionNumber">Admission Number</label>
      <select name="admissionNumber" class="form-control" required>
        <option value="">Select Admission Number</option>
        <?php while ($student = mysqli_fetch_assoc($studentsQuery)) { ?>
          <option value="<?php echo $student['admissionNumber']; ?>">
            <?php echo $student['admissionNumber']; ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label for="roomId">Select Room</label>
      <select name="roomId" class="form-control" required>
        <option value="">Select Room</option>
        <?php while ($room = mysqli_fetch_assoc($roomsQuery)) { ?>
          <option value="<?php echo $room['Id']; ?>">
            <?php echo $room['roomNumber']; ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <button type="submit" name="assign" class="btn btn-success">Assign Room</button>
  </form>
</div>
</div>
    </div>
  </div> 
<!-- Footer -->
<?php include 'includes/footer.php';?>
      <!-- Footer -->
    </div>
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
