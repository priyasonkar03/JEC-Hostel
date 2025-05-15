<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

if (isset($_POST['save'])) {
    $roomNumber = $_POST['roomNumber'];
    $capacity = $_POST['capacity'];
    $block = $_POST['block'];
    $dateCreated = date("Y-m-d");

    $query = mysqli_query($conn, "INSERT INTO tblrooms (roomNumber, capacity, block, dateCreated) 
                VALUES ('$roomNumber', '$capacity', '$block', '$dateCreated')");

    $statusMsg = $query ? "Room Created Successfully!" : "Error: Could not create room.";
}

$roomsQuery = mysqli_query($conn, "SELECT * FROM tblrooms");
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
  <title>Create Rooms </title>
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
            <h1 class="h3 mb-0 text-gray-800">Create Rooms</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>
        </div>
<!--Add here me code-->
        <!-- Create Room Form Card -->
<div class="card mb-4 ml-3 mr-3">
  <div class="card-header">
    <h5 class="m-0">Create New Room</h5>
  </div>
  <div class="card-body">
    <form method="post">
      <div class="form-group">
        <input type="text" name="roomNumber" placeholder="Room Number" class="form-control mb-2" required>
      </div>
      <div class="form-group">
        <input type="number" name="capacity" placeholder="Capacity" class="form-control mb-2" required>
      </div>
      <div class="form-group">
        <input type="text" name="block" placeholder="Block (optional)" class="form-control mb-2">
      </div>
      <button type="submit" name="save" class="btn btn-primary">
        <i class="fas fa-save"></i> Save Room
      </button>
    </form>

    <?php if (isset($statusMsg)) echo "<div class='alert alert-info mt-3'>$statusMsg</div>"; ?>
  </div>
</div>

<!-- Room List Table Card -->
<!--<div class="card ml-3 mr-3">
  <div class="card-header">
    <h5 class="m-0">Room List</h5>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <th>Room Number</th>
          <th>Capacity</th>
          <th>Block</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($roomsQuery)) { ?>
          <tr>
            <td><?php echo $row['roomNumber']; ?></td>
            <td><?php echo $row['capacity']; ?></td>
            <td><?php echo $row['block']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
              <!-- <a href="editRoom.php?id=<?php echo $row['Id']; ?>" class="btn btn-info btn-sm mr-1">
                <i class="fas fa-edit"></i>
              </a>
              <a href="deleteRoom.php?id=<?php echo $row['Id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this room?')">
                <i class="fas fa-trash-alt"></i>
              </a> -->
           <!-- </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>-->

      </div>
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
