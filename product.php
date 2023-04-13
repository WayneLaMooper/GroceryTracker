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
    $query = "select * from product where name = '$current_item'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($product_info = mysqli_fetch_assoc($result)) {
            $query = "select * from provides where ser_code = $product_info[serial_code]";
            $provide_results = mysqli_query($con, $query);
            while ($provide_info = mysqli_fetch_assoc($provide_results)) {
                $query = "select * from department where dept_ID = $provide_info[dept_id]";
                $loc_result = mysqli_query($con, $query);
                $loc_info = mysqli_fetch_assoc($loc_result);
                $query = "select * from shop where location = '$loc_info[shop_location]'";
                $shop_result = mysqli_query($con, $query);
                $shop_info = mysqli_fetch_assoc($shop_result);
                if ($provide_info['stock'] > 0) {
                    echo "<p> Location: " . $shop_info['store_name'] . " at " . $loc_info['shop_location'] .
                        "<br> Department: " . $loc_info['dept_name'] .
                        "<br>&nbsp;&nbsp;The price is: $" . $provide_info['price'] .
                        "<br>&nbsp;&nbsp;The quantity is: " . $provide_info['stock'] . "<br></p>";
                } else {
                    echo "<p> Location: " . $shop_info['store_name'] . " at " . $loc_info['shop_location'] .
                        "<br> Department: " . $loc_info['dept_name'] .
                        "<br>&nbsp;&nbsp;The price is: $" . $provide_info['price'] .
                        "<br>&nbsp;&nbsp;Not available at this location currently. <br></p>";
                }
            }
        }
        echo "<form name='form' action='' method='post'>
    Add product to favourites: 
    <input type='submit' name='new_fav_prod' value='" . $current_item . "'class='add-to-favourites-button'><br><br></form>";
    } else {
        "<p> This product does not exist within our database currently. <br></p>";
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['new_fav_prod'])) {
            $fav_prob = $_POST['new_fav_prod'];
            $query = "select * from product where name = '$current_item'";
            $result = mysqli_query($con, $query);
            $fav_info = mysqli_fetch_assoc($result);
            $query = "insert into favourites (cust_ID, ser_code) values ($user_data[account_ID], $fav_info[serial_code])";
            mysqli_query($con, $query);
        }
    }
    ?>
    <br>
    <hr>

    <!-- pictures on a gridlike fashion. click on image for a popup -->
    <hr>
    <div class="round-image">
        <figure>
            <img src="images/shopping cart.jpg">
        </figure>
    </div>

</body>

</html>