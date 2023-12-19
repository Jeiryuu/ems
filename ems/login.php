<?php
require('config.php');
session_start();
$errormsg = "";

// Regular user login
if (isset($_POST['user_email'])) {
  $user_email = stripslashes($_REQUEST['user_email']);
  $user_email = mysqli_real_escape_string($con, $user_email);
  $user_password = stripslashes($_REQUEST['user_password']);
  $user_password = mysqli_real_escape_string($con, $user_password);

  $query = "SELECT * FROM `users` WHERE email='$user_email' AND password='" . md5($user_password) . "'";
  $result = mysqli_query($con, $query) or die(mysqli_error($con));
  $rows = mysqli_num_rows($result);

  if ($rows == 1) {
      $_SESSION['email'] = $user_email; // Set the session variable
      header("Location: index.php");
  } else {
      $errormsg = "Wrong user credentials.";
  }
}


// Admin login
if (isset($_POST['admin_email'])) {
  $admin_username = stripslashes($_REQUEST['admin_email']);
  $admin_username = mysqli_real_escape_string($con, $admin_username);
  $admin_password = stripslashes($_REQUEST['admin_password']);
  $admin_password = mysqli_real_escape_string($con, $admin_password);

  $admin_query = "SELECT * FROM `admin` WHERE username='$admin_username' AND password='" . md5($admin_password) . "'";
  $admin_result = mysqli_query($con, $admin_query) or die(mysqli_error($con));
  $admin_rows = mysqli_num_rows($admin_result);

  if ($admin_rows == 1) {
      $_SESSION['admin_username'] = $admin_username;
      header("Location: user_management.php");
  } else {
      $errormsg = "Wrong admin credentials.";
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-form {
            width: 340px;
            margin: 50px auto;
            font-size: 15px;
        }

        .login-form form {
            margin-bottom: 15px;
            background: #fff;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
            border: 1px solid #ddd;
        }

        .login-form h2 {
            color: #636363;
            margin: 0 0 15px;
            position: relative;
            text-align: center;
        }

        .login-form h2:before,
        .login-form h2:after {
            content: "";
            height: 2px;
            width: 30%;
            background: #d4d4d4;
            position: absolute;
            top: 50%;
            z-index: 2;
        }

        .login-form h2:before {
            left: 0;
        }

        .login-form h2:after {
            right: 0;
        }

        .login-form .hint-text {
            color: #999;
            margin-bottom: 30px;
            text-align: center;
        }

        .login-form a:hover {
            text-decoration: none;
        }

        .form-control,
        .btn {
            min-height: 38px;
            border-radius: 2px;
        }

        .btn {
            font-size: 15px;
            font-weight: bold;
        }

        .admin-form {
            display: none;
        }
    </style>
</head>

<body>
    <div class="login-form">
        <form action="" method="POST" autocomplete="off" id="userLoginForm">
            <h2 class="text-center">E.M.S</h2>
            <p class="hint-text">User Login Panel</p>
            <div class="form-group">
                <input type="text" name="user_email" class="form-control" placeholder="Email" required="required">
            </div>
            <div class="form-group">
                <input type="password" name="user_password" class="form-control" placeholder="Password" required="required">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block" style="border-radius:0%;">Login</button>
            </div>
            <div class="form-group text-center">
                <a href="#" id="adminLoginBtn" class="btn btn-primary">Admin Login</a>
            </div>
        </form>

        <form action="" method="POST" autocomplete="off" id="adminLoginForm" class="admin-form">
            <h2 class="text-center">Admin</h2>
            <div class="form-group">
                <input type="text" name="admin_email" class="form-control" placeholder="Admin Username" required="required">
            </div>
            <div class="form-group">
                <input type="password" name="admin_password" class="form-control" placeholder="Admin Password" required="required">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block" style="border-radius:0%;">Login as Admin</button>
            </div>
            <div class="form-group text-center">
                <a href="#" id="userLoginBtn" class="btn btn-primary">Back to User Login</a>
            </div>
        </form>

        <?php if (!empty($errormsg)) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo $errormsg; ?>
            </div>
        <?php endif; ?>

        <p class="text-center">Don't have an account?<a href="register.php" class="text-danger"> Register Here</a></p>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        document.getElementById('adminLoginBtn').addEventListener('click', function () {
            document.getElementById('userLoginForm').style.display = 'none';
            document.getElementById('adminLoginForm').style.display = 'block';
        });

        document.getElementById('userLoginBtn').addEventListener('click', function () {
            document.getElementById('adminLoginForm').style.display = 'none';
            document.getElementById('userLoginForm').style.display = 'block';
        });
    </script>
</body>

</html>
