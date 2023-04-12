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

    <body>
        <div id="box">
            <form method="post">
                <div>Manager Account Creation!</div>
                <br>
                <div>Username:</div>
                <input type="text" name="m_username"><br>
                <br>
                <div>Password:</div>
                <input type="password" name="m_password"><br>
                <br>
                <input type="submit" value="Create Account"><br>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $user_name = $_POST['m_username'];
                $password = $_POST['m_password'];

                if (!empty($user_name) && !empty($password)) {
                    $user_id = random_num(20);
                    $queryName = "select * from user_account where username = '$user_name'";
                    $result = mysqli_query($con, $queryName);

                    if ($result && mysqli_num_rows($result) > 0) {
                        echo "Username taken, please try again.";
                    } else {
                        $query = "insert into user_account (account_ID, username, password) values ('$user_id', '$user_name', '$password')";
                        mysqli_query($con, $query);
                        $query = "insert into admin_acc (admin_ID) values ('$user_id')";
                        mysqli_query($con, $query);
                        $query = "insert into manager_acc (adminm_account_ID) values ('$user_id')";
                        mysqli_query($con, $query);
                        echo "Account successfully created!";
                    }
                } else {
                    echo "Empty entry, please try again.";
                }
            }
            ?>
        </div>
    </body>

</html>