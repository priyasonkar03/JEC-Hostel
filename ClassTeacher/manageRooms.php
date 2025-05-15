<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';

// ========== Create Room ==========
if (isset($_POST['saveRoom'])) {
    $roomNumber = $_POST['roomNumber'];
    $capacity = $_POST['capacity'];
    $block = $_POST['block'];
    $dateCreated = date("Y-m-d");

    $query = mysqli_query($conn, "INSERT INTO tblrooms (roomNumber, capacity, block, dateCreated) 
                VALUES ('$roomNumber', '$capacity', '$block', '$dateCreated')");

    $statusMsg = $query ? "Room Created Successfully!" : "Error: Could not create room.";
}

// ========== Edit Room ==========
if (isset($_POST['updateRoom'])) {
    $roomId = $_POST['roomId'];
    $roomNumber = $_POST['roomNumber'];
    $capacity = $_POST['capacity'];
    $block = $_POST['block'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE tblrooms SET roomNumber='$roomNumber', capacity='$capacity', block='$block', status='$status' WHERE Id='$roomId'");
    $statusMsg = "Room Updated Successfully!";
}

// ========== Delete Room ==========
if (isset($_GET['deleteRoom'])) {
    $roomId = $_GET['deleteRoom'];
    mysqli_query($conn, "UPDATE tblstudents SET roomId=NULL WHERE roomId='$roomId'");
    mysqli_query($conn, "DELETE FROM tblrooms WHERE Id='$roomId'");
    header("Location: manageRooms.php");
}

// ========== Assign Student ==========
if (isset($_POST['assignStudent'])) {
    $admissionNumber = $_POST['admissionNumber'];
    $roomId = $_POST['assignRoomId'];

    $capacityQuery = mysqli_query($conn, "SELECT capacity FROM tblrooms WHERE Id='$roomId'");
    $roomCapacity = mysqli_fetch_assoc($capacityQuery)['capacity'];

    $studentCountQuery = mysqli_query($conn, "SELECT COUNT(*) as studentCount FROM tblstudents WHERE roomId='$roomId'");
    $studentCount = mysqli_fetch_assoc($studentCountQuery)['studentCount'];

    if ($studentCount >= $roomCapacity) {
        $statusMsg = "This room is already full!";
    } else {
        mysqli_query($conn, "INSERT INTO tblstudents (admissionNumber, studentName, roomId) VALUES ('$admissionNumber', 'Student-$admissionNumber', '$roomId')");
        $newCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM tblstudents WHERE roomId='$roomId'"))['cnt'];
        if ($newCount >= $roomCapacity) {
            mysqli_query($conn, "UPDATE tblrooms SET status='Full' WHERE Id='$roomId'");
        }
        $statusMsg = "Student assigned to room.";
    }
}

// ========== Fetch Data ==========
$rooms = mysqli_query($conn, "SELECT * FROM tblrooms ORDER BY dateCreated DESC");
$availableRooms = mysqli_query($conn, "SELECT * FROM tblrooms WHERE status='Available'");

// If editing a room
if (isset($_GET['editRoom'])) {
    $editRoomId = $_GET['editRoom'];
    $editRoom = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tblrooms WHERE Id='$editRoomId'"));
}
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
            <h1 class="h3 mb-0 text-gray-800">Manage Rooms </h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>
        </div>
     
<?php if (isset($statusMsg)) echo "<div class='alert alert-info'>$statusMsg</div>"; ?>

<!-- Add / Edit Room Form -->
<div class="card mb-4 ml-3 mr-3">
    <div class="card-body">
        <h5><?php echo isset($editRoom) ? "Edit Room" : "Add New Room"; ?></h5>
        <form method="post">
            <?php if (isset($editRoom)) { ?>
                <input type="hidden" name="roomId" value="<?php echo $editRoom['Id']; ?>">
            <?php } ?>
            <input type="text" name="roomNumber" class="form-control mb-2" placeholder="Room Number" value="<?php echo $editRoom['roomNumber'] ?? ''; ?>" required>
            <input type="number" name="capacity" class="form-control mb-2" placeholder="Capacity" value="<?php echo $editRoom['capacity'] ?? ''; ?>" required>
            <input type="text" name="block" class="form-control mb-2" placeholder="Block" value="<?php echo $editRoom['block'] ?? ''; ?>">
            <?php if (isset($editRoom)) { ?>
                <select name="status" class="form-control mb-2">
                    <option value="Available" <?php if ($editRoom['status'] == 'Available') echo 'selected'; ?>>Available</option>
                    <option value="Full" <?php if ($editRoom['status'] == 'Full') echo 'selected'; ?>>Full</option>
                </select>
            <?php } ?>
            <button type="submit" name="<?php echo isset($editRoom) ? 'updateRoom' : 'saveRoom'; ?>" class="btn btn-primary">
                <?php echo isset($editRoom) ? 'Update Room' : 'Add Room'; ?>
            </button>
            <?php if (isset($editRoom)) { ?>
                <a href="manageRooms.php" class="btn btn-secondary">Cancel</a>
            <?php } ?>
        </form>
    </div>
</div>

<!-- Assign Student Form -->
<div class="card mb-4 ml-3 mr-4">
    <div class="card-body">
        <h5>Assign Student to Room</h5>
        <form method="post">
            <input type="text" name="admissionNumber" class="form-control mb-2" placeholder="Admission Number" required>
            <select name="assignRoomId" class="form-control mb-2" required>
                <option value="">Select Room</option>
                <?php while ($room = mysqli_fetch_assoc($availableRooms)) { ?>
                    <option value="<?php echo $room['Id']; ?>"><?php echo $room['roomNumber']; ?></option>
                <?php } ?>
            </select>
            <button type="submit" name="assignStudent" class="btn btn-success">Assign</button>
        </form>
    </div>
</div>

<!-- Room List -->
<h5 class="mb-0 ml-3 text-gray-800">Rooms List</h5>
<!-- <h5 class="mr-3">Room List</h5> -->
<table class="table table-bordered mr-3 ml-3">
    <thead>
        <tr><th>#</th><th>Room Number</th><th>Capacity</th><th>Block</th><th>Status</th><th>Date Created</th><th>Action</th></tr>
    </thead>
    <tbody>
    <?php $sn = 1; while ($room = mysqli_fetch_assoc($rooms)) { ?>
        <tr>
            <td><?php echo $sn++; ?></td>
            <td><?php echo $room['roomNumber']; ?></td>
            <td><?php echo $room['capacity']; ?></td>
            <td><?php echo $room['block']; ?></td>
            <td><?php echo $room['status']; ?></td>
            <td><?php echo $room['dateCreated']; ?></td>
            <td>
                <a href="?editRoom=<?php echo $room['Id']; ?>" class="btn btn-info btn-sm">Edit</a>
                <a href="?deleteRoom=<?php echo $room['Id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this room?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
    </div>
    </div>
    <!---Container Fluid-->
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

