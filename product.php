<?php

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$current_img = $_SESSION['i_src'];
$current_code = $_SESSION['i_code'];
$current_price = $_SESSION['i_price'];
$current_stock = $_SESSION['i_stock'];
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

    <a href="index.php">back to main page</a>
    <h1>This is the product page </h1>
    <?php echo '<img src="'. $current_img .'" alt = "">'; ?>
    <p> Serial code: <?php echo $current_code ?>
        <br>&nbsp;&nbsp; Price of product: <?php echo $current_price ?>
        <br>&nbsp;&nbsp; Stock: <?php echo $current_stock ?>

    </p>

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