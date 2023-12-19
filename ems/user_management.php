<?php
require('config.php');
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isAdminLoggedIn()) {
    header("Location: login.php"); // Replace 'login.php' with the actual login page
    exit();
}

function isAdminLoggedIn()
{
    return isset($_SESSION['admin_username']);
}


function getNumberOfUsers($con)
{
    $query = "SELECT COUNT(*) AS totalUsers FROM users";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['totalUsers'];
}

function getAllUsers($con)
{
    $query = "SELECT * FROM users";
    $result = mysqli_query($con, $query);
    return $result;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>User Management</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        main {
            flex: 1;
            padding: 20px;
            transition: margin-left 0.5s;
        }

        h2 {
            margin-top: 0;
        }

        @media (max-width: 768px) {
            main {
                padding: 10px;
            }
        }

        /* Add some styles for the logout button */
        .logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="logoutadmin.php" class="btn btn-danger logout-btn">Logout</a>

        <main>
            <h2 class="mb-4">User Management</h2>
            <p>Total Registered Users: <?php echo getNumberOfUsers($con); ?></p>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = getAllUsers($con);

                    while ($row = mysqli_fetch_assoc($users)) {
                        echo "<tr>
                                <td>{$row['user_id']}</td>
                                <td>{$row['firstname']}</td>
                                <td>{$row['lastname']}</td>
                                <td>{$row['email']}</td>
                                <td>
                                    <a href='view_user.php?id={$row['user_id']}' class='btn btn-info btn-sm'>View</a>
                                    <a href='edit_user.php?id={$row['user_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_user.php?id={$row['user_id']}' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>

    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
