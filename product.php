<?php

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$current_item = $_SESSION['item_name'];


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

    <button class="logout-button" onclick="location.href='index.php';">
        Main Page
    </button>

    <h1>This is the <?php echo $current_item ?> product page </h1>
    <?php
    for ($i = 0; $i < count($_SESSION['ser_code']); $i++) {
        echo "<p> In the location" . $_SESSION['location'][$i] . "<br>&nbsp;&nbsp;The price is:" . $_SESSION['price'][$i] . "<br>&nbsp;&nbsp;quantity:" . $_SESSION['stock'][$i] . "<br> </p>";
    }
    ?>
    <br>
    <hr>

    <!-- pictures on a gridlike fashion. click on image for a popup -->
    <hr>
    <div class="gallery">
        <figure>
            <img src="images/apple.jpg">
        </figure>
    </div>

</body>

</html>