<?php
    session_start();

    if(!isset($_SESSION["isLoggedIn"])){
        header('Location: login.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Social Network</title>
</head>
<body>
    <?php
        require 'showUsers.php';
    ?>
</body>
</html>