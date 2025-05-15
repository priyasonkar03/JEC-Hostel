<?php
include '../Includes/dbcon.php';

if (isset($_GET['id'])) {
    $roomId = $_GET['id'];
    mysqli_query($conn, "UPDATE tblstudents SET roomId=NULL WHERE roomId='$roomId'");
    mysqli_query($conn, "DELETE FROM tblrooms WHERE Id='$roomId'");
    header("Location: createRooms.php");
}
?>
