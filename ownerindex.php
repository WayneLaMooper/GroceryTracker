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
    <h1>Welcome <?php echo $user_data['username']; ?>
    </h1>

    <br>

    <body>
        <div id="box">
            <form method="post">
                <div>Add a Store!</div>
                <br>
                <div>Store Location:</div>
                <input type="text" name="Location"><br>
                <br>
                <div>Store Name:</div>
                <input type="text" name="Store_name"><br>
                <br>
                <input type="submit" value="Add"><br>
            </form>
        </div>
    </body>

</html>