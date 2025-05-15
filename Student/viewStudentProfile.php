<?php
$userEmail = $_SESSION['email'];
$query = "SELECT * FROM tblregstudents WHERE email = '$userEmail' LIMIT 1";
$rs = $conn->query($query);

if ($rs->num_rows > 0) {
  $row = $rs->fetch_assoc();
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
<body>
 <div class="col-md-8 offset-md-2 mb-5">
  <div class="card shadow-lg border-left-primary">
    <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
      <h5 class="mb-0">
        <i class="fas fa-user-circle me-2"></i> Student Profile
      </h5>
    </div>
    <div class="card-body">

      <div class="text-center mb-4">
        <i class="fas fa-user-circle fa-5x text-primary mb-2"></i>
        <h4 class="text-primary"><?= $row['firstName'] . ' ' . $row['lastName'] ?></h4>
      </div>

      <div class="row mb-2">
        <div class="col-md-6"><i class="fas fa-venus-mars me-2 text-secondary"></i><strong>  Gender:</strong> <?= $row['gender'] ?></div>
        <div class="col-md-6"><i class="fas fa-envelope me-2 text-secondary"></i><strong>  Email:</strong> <?= $row['email'] ?></div>
      </div>

      <div class="row mb-2">
        <div class="col-md-6"><i class="fas fa-phone me-2 text-secondary"></i><strong>  Phone:</strong> <?= $row['phone'] ?></div>
        <div class="col-md-6"><i class="fas fa-bed me-2 text-secondary"></i><strong>  Hostel Type:</strong> <?= $row['hostelType'] ?></div>
      </div>

      <div class="row mb-2">
        <div class="col-md-6"><i class="fas fa-graduation-cap me-2 text-secondary"></i><strong>  Degree:</strong> <?= $row['degree'] ?></div>
        <div class="col-md-6"><i class="fas fa-code-branch me-2 text-secondary"></i><strong>  Branch:</strong> <?= $row['branch'] ?></div>
      </div>

      <div class="row mb-2">
        <div class="col-md-6"><i class="fas fa-percentage me-2 text-secondary"></i><strong>  JEE:</strong> <?= $row['jeePercentage'] ?>%</div>
        <div class="col-md-6"><i class="fas fa-calendar-alt me-2 text-secondary"></i><strong>  Session:</strong> <?= $row['session'] ?></div>
      </div>

      <div class="row mb-2">
        <div class="col-md-6"><i class="fas fa-calendar-check me-2 text-secondary"></i><strong>  Registered:</strong> <?= date("d M Y", strtotime($row['regDate'])) ?></div>
      </div>

    </div>
  </div>
</div>

<?php
} else {
  echo "<div class='col-12 text-center text-danger'><strong>No profile found.</strong></div>";
}
?>
</body>
</html>