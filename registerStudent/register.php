<?php

include '../Includes/dbcon.php';
// include '../Includes/session.php';

$statusMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName     = $_POST['firstName'];
    $lastName      = $_POST['lastName'];
    $gender        = $_POST['gender'];
    $dob           = $_POST['dob'];
    $email         = $_POST['email'];
    $phone         = $_POST['phone'];
    $address       = $_POST['address'];
    $password      = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $category      = $_POST['category'];
    $session       = $_POST['session'];
    $degree        = $_POST['degree'];
    $branch        = $_POST['branch'];
    $jeePercentage = floatval($_POST['jeePercentage']);
    $hostelType    = $_POST['hostelType'];

    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT id FROM tblregstudents WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $statusMsg = "<div class='alert alert-danger'>This Email Address Already Exists!</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO tblregstudents (
            firstName, lastName, gender, dob, email, phone, address, password, category, session, degree, branch, jeePercentage, hostelType
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param(
                "ssssssssssssis",
                $firstName, $lastName, $gender, $dob, $email, $phone, $address, $password,
                $category, $session, $degree, $branch, $jeePercentage, $hostelType
            );

            if ($stmt->execute()) {
                $statusMsg = "<div class='alert alert-success'>Student Registered Successfully!</div>";
            } else {
                $statusMsg = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            $statusMsg = "<div class='alert alert-danger'>Prepare failed: " . $conn->error . "</div>";
        }
    }

    $checkStmt->close();
}


//------------------------SAVE--------------------------------------------------

/*if (isset($_POST['save'])) {
    // Get form data and sanitize (optional but recommended)
    $firstName     = $_POST['firstName'];
    $lastName      = $_POST['lastName'];
    $gender        = $_POST['gender'];
    $dob           = $_POST['dob'];
    $email         = $_POST['email'];
    $phone         = $_POST['phone'];
    $address       = $_POST['address'];
    $password      = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $category      = $_POST['category'];
    $session       = $_POST['session'];
    $degree        = $_POST['degree'];
    $branch        = $_POST['branch'];
    $jeePercentage = floatval($_POST['jeePercentage']);
    $hostelType    = $_POST['hostelType'];

    // Check if email already exists
    $query = mysqli_query($conn, "SELECT * FROM tblregstudents WHERE email = '$email'");
    if (mysqli_num_rows($query) > 0) {
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Email Address Already Exists!</div>";
    } else {
        // Insert the record
        $query = mysqli_query($conn, "INSERT INTO tblregstudents (
            firstName, lastName, gender, dob, email, phone, address, password, category, session, degree, branch, jeePercentage, hostelType
        ) VALUES (
            '$firstName', '$lastName', '$gender', '$dob', '$email', '$phone', '$address', '$password', '$category', '$session', '$degree', '$branch', $jeePercentage, '$hostelType'
        )");

        if ($query) {
            $statusMsg = "<div class='alert alert-success' style='margin-right:700px;'>Created Successfully!</div>";
        } else {
            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred: " . mysqli_error($conn) . "</div>";
        }
    }
}*/
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
  <title>Dashboard - Student Registration</title>
  <?php include './title.php';?>
  
  <!-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"> -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
</head>
<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
       <?php include "./topbar.php";?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Registration Student</h1>
            <ol class="breadcrumb">
              <!-- <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Registeration Student</li> -->
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Registration Student</h6>
                    <?php echo $statusMsg;?>
                </div>
                <div class="card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
              <div class="form-group row mb-3">
                <div class="col-xl-6">
                  <label for="firstName" class="form-control-label">Firstname<span class="text-danger ml-2">*</span></label>
                  <input type="text" class="form-control" name="firstName" value="" id="firstName" required>
                </div>
                <div class="col-xl-6">
                  <label for="lastName" class="form-control-label">Lastname<span class="text-danger ml-2">*</span></label>
                  <input type="text" class="form-control" name="lastName" value="" id="lastName" required>
                </div>

                <div class="col-xl-6">
                  <label for="gender" class="form-control-label">Gender<span class="text-danger ml-2">*</span></label>
                  <select class="form-control" name="gender" value=""id="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                </div>

                <div class="col-xl-6">
                  <label for="dob" class="form-control-label">Date of Birth<span class="text-danger ml-2">*</span></label>
                  <input type="date" class="form-control" name="dob" value="" id="dob" required>
                </div>

                <div class="col-xl-6">
                  <label for="email" class="form-control-label">Email<span class="text-danger ml-2">*</span></label>
                  <input type="email" class="form-control" name="email" value="" id="email" required>
                </div>

                <div class="col-xl-6">
                  <label for="phone" class="form-control-label">Phone<span class="text-danger ml-2">*</span></label>
                  <input type="tel" class="form-control" name="phone" value="" id="phone" required>
                </div>

                <div class="col-xl-12">
                  <label for="address" class="form-control-label">Address<span class="text-danger ml-2">*</span></label>
                  <input type="text" class="form-control" name="address" value="" id="address" required>
                </div>

                <div class="col-xl-6">
                  <label for="password" class="form-control-label">Password<span class="text-danger ml-2">*</span></label>
                  <input type="password" class="form-control" name="password" value="" id="password" required>
                </div>

                <div class="col-xl-6">
                  <label for="category" class="form-control-label">Category<span class="text-danger ml-2">*</span></label>
                  <select class="form-control" name="category" value="" id="category" required>
                    <option value="">Select Category</option>
                    <option value="General">General</option>
                    <option value="OBC">OBC</option>
                    <option value="SC">SC</option>
                    <option value="ST">ST</option>
                  </select>
                </div>

                <!-- HOSTEL TYPE DROPDOWN -->
                <div class="col-xl-6">
                  <label for="hostelType" class="form-control-label">Hostel Type<span class="text-danger ml-2">*</span></label>
                  <select class="form-control" name="hostelType" value="" id="hostelType" required>
                    <option value="">Select Hostel Type</option>
                    <option value="Boy">Boys Hostel</option>
                    <option value="Girl">Girls Hostel</option>
                  </select>
                </div>

                <div class="col-xl-6">
                  <label for="session" class="form-control-label">Session<span class="text-danger ml-2">*</span></label>
                  <input type="text" class="form-control" name="session" value="" id="session" placeholder="e.g. 2024-2028" required>
                </div>

                <div class="col-xl-6">
                  <label for="degree" class="form-control-label">Degree<span class="text-danger ml-2">*</span></label>
                  <input type="text" class="form-control" name="degree" value="" id="degree" required>
                </div>

                <div class="col-xl-6">
                  <label for="branch" class="form-control-label">Branch<span class="text-danger ml-2">*</span></label>
                  <input type="text" class="form-control" name="branch" value="" id="branch" required>
                </div>

                <div class="col-xl-6">
                  <label for="jeePercentage" class="form-control-label">JEE Percentage<span class="text-danger ml-2">*</span></label>
                  <input type="number" class="form-control" name="jeePercentage" value="" id="jeePercentage" step="0.01" max="100" min="0" required>
                </div>
              </div>
              
              <button type="submit" class="btn btn-primary">Register Student</button>
              <!-- <button type="submit" class="btn btn-primary" onclick="this.innerHTML='<span class=\'spinner-border spinner-border-sm\'></span> Registering...'; this.disabled=true;">
              Register Student</button> -->

              </form>
              <a href="../Home.php">Back to Home</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>



<!-- Footer -->
<?php include './footer.php';?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  
  <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="vendor/jquery-easing/jquery.easing.min.js"></script> -->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- <script src="js/ruang-admin.min.js"></script> -->
  <script src="../js/ruang-admin.min.js"></script>
  <!-- <script src="vendor/chart.js/Chart.min.js"></script> -->
  <!-- <script src="vendor/"></script> -->
  <!-- <script src="js/demo/chart-area-demo.js"></script>   -->
</body>
</html>
