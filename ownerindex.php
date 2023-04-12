<?php

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $store_location = $_POST['Location'];
    $store_name = $_POST['Store_name'];

    if (!empty($store_location) && !empty($store_name)) {
        $queryName = "select * from shop where location = '$store_location'";
        $result = mysqli_query($con, $queryName);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "Store already exists at this location, please try again.";
        } else {
            $query = "insert into shop (location, store_name, owner_ID) values ('$store_location', '$store_name', $user_data[account_ID])";
            mysqli_query($con, $query);
            echo "Store successfully added!";
        }
    } else {
        echo "Empty entry, please try again.";
    }
}
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

    <button class="logout-button" onclick="location.href='logout.php';">
        Logout
    </button>
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
        <div>
            <h1> Stores:</h1>
            <?php
            $allStores = "select * from shop where owner_ID = $user_data[account_ID]";
            $result = mysqli_query($con, $allStores);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($store = mysqli_fetch_assoc($result)) {
                    echo "<a href='ownerindex.php'>" . $store['store_name'], " ", $store['location'] . "</a><br>";
                }
            }
            ?>
        </div>
    </body>

</html>