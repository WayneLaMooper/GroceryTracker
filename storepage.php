<?php

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="index.css" />
<link rel="icon" href="images/icon.jpg" type="image/x-icon">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Grocery Tracker!</title>
</head>

<body>

    <a href="logout.php">Logout</a>
    <h1>This is the store page </h1>

    <br>
    <hr>

    <!-- pictures on a gridlike fashion. click on image for a popup -->
    <hr>
    <div class="gallery">
        <figure>
            <img src="images/shelves.jpg">
        </figure>
    </div>
</body>

</html>