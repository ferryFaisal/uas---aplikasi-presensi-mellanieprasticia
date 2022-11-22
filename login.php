<?php
session_start();

$emailErr = $passErr = "";
$email = $password = "";
$valid_email = $valid_pass = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'admin/connect.php';
    
    $email = test_input($_POST['email']);
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    if (empty($_POST["email"])) {
        $emailErr = "* Email is required";
    } else {
        $email = test_input($_POST['email']);
        $sql = "SELECT * FROM user";
        $query = mysqli_query($conn, $sql);
        //ngecek jika email yang dimasukkan benar
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                if ($row["email"] != $email) {
                    $valid_email = false;
                    $emailErr = "* Email is wrong";
                } else {
                    $valid_email = true;
                    break;
                }
            }
        } else {
            echo "0 results";
        }
    } 

    if (empty($_POST["password"])) {
        $passErr = "* Password is required";
    } else {
        $password = sha1(test_input(($_POST['password'])));
        $sql = "SELECT * FROM user";
        $query = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                if ($row["password"] != $password) {
                    $valid_pass = false;
                    $passErr = "* Password is wrong";
                } else {
                    $valid_pass = true;
                    break;
                }
            }
        } else {
            echo "0 results";
        }
        mysqli_close($conn);
    }  
}    

function test_input($data)    {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['login'])){
        if($valid_email && $valid_pass == true) {
            if (($email == $result['email']) && ($password == $result['password'])) {
                switch ($result['role']) {
                    case 'Admin':
                        $_SESSION['login'] = $email;
                        $_SESSION['role'] = $result['role'];
                        $_SESSION['name'] = $result['name'];
                        header('Location: 5B.php');
                        break;
                    case 'Dosen':
                        $_SESSION['login'] = $email;
                        $_SESSION['role'] = $result['role'];
                        $_SESSION['name'] = $result['name'];
                        header('Location: dosen.php');
                        break;    
                }
            } 
        }
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

  <title>SB Admin - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">


  <!-- Custom styles for this template-->
  <link href="admin/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">


  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="" method="post">
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-label-group">
                        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address">
                        <label for="inputEmail">Email address</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 text-danger">
                    <?php if (isset($emailErr)) { ?>
                        <p><?php echo $emailErr?></p>
                    <?php } ?>
                </div>
            </div>    
        </div>    
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-label-group">
                        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
                        <label for="inputPassword">Password</label>
                     </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 text-danger">
                    <?php if (isset($passErr)) { ?>
                        <p><?php echo $passErr?></p>
                    <?php } ?>
                </div>
            </div>    
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me">
                Remember Password
              </label>
            </div>
          </div>
          <input class="btn btn-primary btn-block" type="submit" name="login" value="Login">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.php">Register an Account</a>
          <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
