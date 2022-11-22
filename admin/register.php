<?php
require "connect.php";
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body class="bg-dark">

    <?php
    $nameErr = $emailErr = $passErr = $repassErr = $roleErr = "";
    $name = $email = $password = $repass = $role = "";
    $valid_name = $valid_email = $valid_pass = $valid_repass = $valid_role = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "* Full name is required";
        } else {
            $name = test_input($_POST["name"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
                $nameErr = "Only letters and white space allowed";
            } else {
                $valid_name = true;
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "* Email is required";
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "* Invalid email format";
            } else {
                // read data email from table user
                require "connect.php";
                $sql = "SELECT email FROM user";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        // check is email already exists?
                        if ($row["email"] != $email) {
                            $valid_email = true;
                            break;
                        } else {
                            $emailErr = "* Email already exist!";
                            $valid_email = false;
                            break;
                        }
                    }
                } else {
                    $valid_email = true;
                }
            }
        }

        if (empty($_POST["password"])) {
            $passErr = "* Password is required";
        } else {
            $password = test_input($_POST["password"]);
            $valid_pass = true;
        }

        if (empty($_POST["repassword"])) {
            $repassErr = "* Repeat the password";
        } else {
            $repass = test_input($_POST['repassword']);
        }

        if ($password != $repass) {
            $repassErr = "* Password must be the same as the one that you input";
        } else {
            $valid_repass = true;
        }

        if (empty($_POST["role"])) {
            $roleErr = "* Role is required";
        } else {
            $role = test_input($_POST["role"]);
            $valid_role = true;
        }
    }

    if (isset($_POST['submit'])) {
        if ($valid_name && $valid_email && $valid_role && $valid_pass && $valid_repass == true) {
            include 'insert_data.php';
        }
    }

    function test_input($data)    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <div class="container">
        <div class="card card-register mx-auto mt-5">
            <div class="card-header">Register an Account</div>
            <div class="card-body">
                <form action="" method="POST">
                <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-label-group">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Full name">
                                    <label for="name">Full name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 text-danger"><?php echo $nameErr; ?></div>
                        </div>
                    </div>
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
                            <div class="col-md-6 text-danger"><?php echo $emailErr; ?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
                                    <label for="inputPassword">Password</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="password" name="repassword" id="confirmPassword" class="form-control" placeholder="Confirm password">
                                    <label for="confirmPassword">Confirm password</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 text-danger"><?php echo $passErr; ?></div>
                            <div class="col-md-6 text-danger"><?php echo $repassErr; ?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-label-group">
                                    <select name="role" id="role" class="form-control form-select-md" aria-label="form-select-md">
                                        <option selected>Select a role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Dosen">Dosen</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 text-danger"><?php echo $roleErr; ?></div>
                        </div>
                    </div>
                    <!-- <a class="btn btn-primary btn-block" href="login.php">Register</a> -->
                    <input class="btn btn-primary btn-block" type="submit" name="submit" value="Register">
                </form>
                <div class="text-center">
                    <a class="d-block small mt-3" href="login.php">Login Page</a>
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