<?php

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$current_store = $_SESSION['current_store'];

$query = "select * from shop where location = '$current_store'";
$result = mysqli_query($con, $query);
$store_info = mysqli_fetch_assoc($result);
$current_name = $store_info['store_name'];
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

    <button class="return-button" onclick="location.href='ownerindex.php';">
        Return to all Stores
    </button>

    <h1> Welcome back <?php echo $user_data['username']; ?> to <?php echo $current_name; ?>!
    </h1>

    <br>

    <body>

    </body>

</html>