<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

if (isset($_GET['id'])) {
    $roomId = $_GET['id'];
    $room = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tblrooms WHERE Id='$roomId'"));
}

if (isset($_POST['update'])) {
    $roomNumber = $_POST['roomNumber'];
    $capacity = $_POST['capacity'];
    $block = $_POST['block'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE tblrooms SET roomNumber='$roomNumber', capacity='$capacity', block='$block', status='$status' WHERE Id='$roomId'");
    header("Location: createRooms.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Room</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h3>Edit Room</h3>
<form method="post">
    <input type="text" name="roomNumber" value="<?php echo $room['roomNumber']; ?>" class="form-control mb-2" required>
    <input type="number" name="capacity" value="<?php echo $room['capacity']; ?>" class="form-control mb-2" required>
    <input type="text" name="block" value="<?php echo $room['block']; ?>" class="form-control mb-2">
    <select name="status" class="form-control mb-2">
        <option value="Available" <?php if ($room['status']=='Available') echo 'selected'; ?>>Available</option>
        <option value="Full" <?php if ($room['status']=='Full') echo 'selected'; ?>>Full</option>
    </select>
    <button type="submit" name="update" class="btn btn-primary">Update Room</button>
</form>
</body>
</html>
