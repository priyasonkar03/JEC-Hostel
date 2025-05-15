<?php 
include 'Includes/dbcon.php';
session_start();
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
    <title>JEC Hostel - Login</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    
</head>

<body class="bg-gradient-login" style="background-image: url('img/logo/loral1.jpe00g');">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <h5 align="center">JABALPUR ENGINEERING COLLEGE HOSTEL</h5>
                                    <div class="text-center">
                                        <img src="img/logo/attnlg.jpg" style="width:100px;height:100px">
                                        <br><br>
                                        <h1 class="h4 text-gray-900 mb-4">Login Panel</h1>
                                        
                                    </div>
                                    <form class="user" method="Post" action="">
                                        <div class="form-group">
                                            <select required name="userType" class="form-control mb-3">
                                                <option value="">--Select User Roles--</option>
                                                <option value="Administrator">Administrator</option>
                                                <option value="ClassTeacher">Hostel Warden</option>
                                                <option value="Student">Student</option>
                                                <!-- ========= Here add me data after register the student -->
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="username" id="exampleInputEmail" placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" required class="form-control" id="exampleInputPassword" placeholder="Enter Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <!-- <label class="custom-control-label" for="customCheck">Remember
                          Me</label> -->
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success btn-block" value="Login" name="login" />
                                        </div>
                                        <a href="Home.php">Back to Home</a>
                                    </form>
                                    <?php

  if(isset($_POST['login'])){

    $userType = $_POST['userType'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = md5($password);

    // ==================Administor=======================
    if($userType == "Administrator"){

      $query = "SELECT * FROM tbladmin WHERE emailAddress = '$username' AND password = '$password'";
      $rs = $conn->query($query);
      $num = $rs->num_rows;
      $rows = $rs->fetch_assoc();

      if($num > 0){

        $_SESSION['userId'] = $rows['Id'];
        $_SESSION['firstName'] = $rows['firstName'];
        $_SESSION['lastName'] = $rows['lastName'];
        $_SESSION['emailAddress'] = $rows['emailAddress'];

        echo "<script type = \"text/javascript\">
        window.location = (\"Admin/index.php\")
        </script>";
      }

      else{

        echo "<div class='alert alert-danger' role='alert'>
        Invalid Username/Password!
        </div>";

      }
    }
    // ==================ClassTeacher=======================
    else if($userType == "ClassTeacher"){

      $query = "SELECT * FROM tblclassteacher WHERE emailAddress = '$username' AND password = '$password'";
      $rs = $conn->query($query);
      $num = $rs->num_rows;
      $rows = $rs->fetch_assoc();

      if($num > 0){

        $_SESSION['userId'] = $rows['Id'];
        $_SESSION['firstName'] = $rows['firstName'];
        $_SESSION['lastName'] = $rows['lastName'];
        $_SESSION['emailAddress'] = $rows['emailAddress'];
        $_SESSION['classId'] = $rows['classId'];
        $_SESSION['classArmId'] = $rows['classArmId'];

        echo "<script type = \"text/javascript\">
        window.location = (\"ClassTeacher/index.php\")
        </script>";
      }
    }
    // ==================Student=======================
    else if($userType == "Student") {
      $email = mysqli_real_escape_string($conn, $username);
      $passwordInput = $_POST['password']; // Keep raw password for verify
  
      $query = "SELECT * FROM tblregstudents WHERE email = '$email'";
      $rs = $conn->query($query);
  
      if ($rs->num_rows > 0) {
          $student = $rs->fetch_assoc();
  
          // Verify password using password_verify()
          if (password_verify($passwordInput, $student['password'])) {
  
              $_SESSION['userId'] = $student['id'];
              $_SESSION['firstName'] = $student['firstName'];
              $_SESSION['lastName'] = $student['lastName'];
              $_SESSION['email'] = $student['email'];
              $_SESSION['hostelType'] = $student['hostelType'];
              $_SESSION['branch'] = $student['branch'];
  
              echo "<script type = \"text/javascript\">
                  window.location = (\"Student/index.php\")
              </script>";
  
          } else {
              echo "<div class='alert alert-danger' role='alert'>
                  Invalid Password!
              </div>";
          }
  
      } else {
          echo "<div class='alert alert-danger' role='alert'>
              Email not found!
          </div>";
      }
  }
  else{

    echo "<div class='alert alert-danger' role='alert'>
    Invalid Username/Password!
    </div>";

  }
}

 // ==================Student End=======================
      
  

?>

                                    <!-- <hr>
                    <a href="index.html" class="btn btn-google btn-block">
                      <i class="fab fa-google fa-fw"></i> Login with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a> -->


                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/js/ruang-admin.min.js"></script>
</body>

</html>