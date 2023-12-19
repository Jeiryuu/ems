<?php
require('config.php');
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: user_management.php");
    exit();
}

$user_id = $_GET['id'];

$query = "DELETE FROM users WHERE user_id = $user_id";
$result = mysqli_query($con, $query);

if ($result) {
    // Deletion successful
} else {
    // Deletion failed
}

header("Location: user_management.php");
exit();

?>
