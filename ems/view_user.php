<?php
require('config.php');
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: user_management.php");
    exit();
}

$user_id = $_GET['id'];

$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: user_management.php");
    exit();
}

function getProfilePicturePath($filename)
{
    return "uploads/" . $filename;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>View User</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        .card {
            width: 400px;
        }

        .card-img-top {
            object-fit: cover;
            height: 200px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <img src="<?php echo getProfilePicturePath($user['profile_path']); ?>" class="card-img-top" alt="Profile Picture">
            <div class="card-body">
                <h5 class="card-title">User Details</h5>
                <p class="card-text">ID: <?php echo $user['user_id']; ?></p>
                <p class="card-text">First Name: <?php echo $user['firstname']; ?></p>
                <p class="card-text">Last Name: <?php echo $user['lastname']; ?></p>
                <p class="card-text">Email: <?php echo $user['email']; ?></p>
                <a href="user_management.php" class="btn btn-primary">Back to User Management</a>
            </div>
        </div>
    </div>
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
