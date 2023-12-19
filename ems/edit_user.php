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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    // Handle file upload for profile picture
    $profilePicture = $_FILES['profile_picture'];

    if ($profilePicture['error'] === UPLOAD_ERR_OK) {
        $filename = uniqid() . '_' . $profilePicture['name'];
        $destination = "uploads/" . $filename;

        // Move the uploaded file to the destination
        if (move_uploaded_file($profilePicture['tmp_name'], $destination)) {
            // Update the user's profile picture path in the database
            $updateQuery = "UPDATE users SET firstname=?, lastname=?, email=?, profile_path=? WHERE user_id=?";
            $stmt = mysqli_prepare($con, $updateQuery);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssssi', $firstname, $lastname, $email, $filename, $user_id);
                $success = mysqli_stmt_execute($stmt);

                if ($success) {
                    header("Location: user_management.php");
                    exit();
                } else {
                    $error = "Error updating user data.";
                }

                mysqli_stmt_close($stmt);
            }
        } else {
            $error = "Error uploading the profile picture.";
        }
    } else {
        // If no new picture is uploaded, update other user details
        $updateQuery = "UPDATE users SET firstname=?, lastname=?, email=? WHERE user_id=?";
        $stmt = mysqli_prepare($con, $updateQuery);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sssi', $firstname, $lastname, $email, $user_id);
            $success = mysqli_stmt_execute($stmt);

            if ($success) {
                header("Location: user_management.php");
                exit();
            } else {
                $error = "Error updating user data.";
            }

            mysqli_stmt_close($stmt);
        }
    }
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
    <title>Edit User</title>
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
                <h5 class="card-title">Edit User</h5>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture:</label>
                        <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="user_management.php" class="btn btn-secondary">Cancel</a>
                </form>

                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
