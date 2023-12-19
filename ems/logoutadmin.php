<?php
session_start();

if (isset($_POST['logout'])) {
    if (session_destroy()) {
        header("Location: login.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>

    <script>
        
        function confirmLogout() {
            var result = window.confirm("Are you sure you want to log out?");
            if (result) {
                document.getElementById('logoutForm').submit();
            } else {
                window.location.href = "user_management.php";
            }
        }
    </script>

    <form id="logoutForm" method="post">
        
        <input type="hidden" name="logout" value="1">
    </form>

    
    <script>
        window.onload = function() {
            confirmLogout();
        };
    </script>

</body>
</html>
