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

    <button class="logout-button" onclick="location.href='index.php';">
        Main Page
    </button>
    <h1>This is the favourites page </h1>
    <?php
    $query = "select * from favourites where cust_ID = $user_data[account_ID]";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($fav_info = mysqli_fetch_assoc($result)) {
            $query = "select * from product where serial_code = $fav_info[ser_code]";
            $prod_result = mysqli_query($con, $query);
            $prod_info = mysqli_fetch_assoc($prod_result);
            echo "<form name='form' action='' method='post'>
            <input type='submit' name='goto_fav' value='" . $prod_info['name'] . "'class='add-to-favourites-button'><br><br></form>";
        }
    } else {
        echo "<p> No products have been favourited yet. <br></p>";
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['goto_fav'])) {
            $_SESSION['item_name'] = $_POST['goto_fav'];
            header('location: product.php');
            header("refresh:0");
            die;
        }
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