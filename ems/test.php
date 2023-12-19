<?php
require('config.php');
session_start();

// Function to get the number of registered/active users
function getNumberOfUsers($con)
{
    $query = "SELECT COUNT(*) AS totalUsers FROM users";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['totalUsers'];
}

// Function to fetch all users
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
            overflow-x: hidden; /* Prevent horizontal scroll on smaller screens */
        }

        main {
            flex: 1;
            padding: 20px;
            transition: margin-left 0.5s;
        }

        .sidebar {
    height: 100%;
    width: 0;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #343a40;
    color: white;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
    z-index: 1; /* Set a higher z-index than the content */
}

.sidebar a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 18px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidebar a:hover {
    color: #f1f1f1;
}


        .content {
            margin-left: 250px;
            padding: 1px 16px;
            transition: margin-left 0.5s;
        }

        .hamburger {
            font-size: 30px;
            cursor: pointer;
            position: fixed;
            left: 10px;
            top: 10px;
            z-index: 2;
            color: #fff;
            transition: 0.5s;
        }

        .hamburger:hover {
            color: #f1f1f1;
        }

        /* Style adjustments */
        h2 {
            margin-top: 0; /* Avoid overlap with the hamburger icon */
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0;
            }

            .sidebar {
                width: 0;
            }
        }
    </style>
</head>

<body>
    <div class="hamburger" onclick="toggleSidebar()">&#9776;</div>

    <div class="sidebar">
        <a href="admin_profile.php">Admin Profile</a>
    </div>

    <div class="content">
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
    </div>

    <script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content');
        const hamburger = document.querySelector('.hamburger');

        if (sidebar.style.width === '250px') {
            sidebar.style.width = '0';
            content.style.marginLeft = '0';
            hamburger.style.left = '10px';
        } else {
            sidebar.style.width = '250px';
            content.style.marginLeft = '250px';
            hamburger.style.left = '260px';
        }

        // Dynamically set the z-index based on the sidebar's width
        content.style.zIndex = sidebar.style.width === '250px' ? '0' : '1';
    }
</script>

</body>

</html>
