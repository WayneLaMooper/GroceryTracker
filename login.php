<?php
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password)) {
        $query = "select * from user_account where username = '$user_name' limit 1";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($user_data['password'] === $password) {
                $_SESSION['user_id'] = $user_data['account_ID'];
                $query = "select * from customer_acc where customer_ID = $user_data[account_ID] limit 1";
                $result = mysqli_query($con, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    header("Location: index.php");
                    die;
                } else {
                    $query = "select * from owner_acc where admino_account_ID = $user_data[account_ID] limit 1";
                    $result = mysqli_query($con, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        header("Location: ownerindex.php");
                        die;
                    }
                    $query = "select * from manager_acc where adminm_account_ID = $user_data[account_ID] limit 1";
                    $result = mysqli_query($con, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        header("Location: managerAcc.php");
                        die;
                    }
                }
            } else {
                echo "Incorrect username or password";
            }
        } else {
            echo "Incorrect username or password";
        }
    } else {
        echo "Incorrect username or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="logpages.css" />
<link rel="icon" href="images/icon.jpg" type="image/x-icon">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Grocery Tracker!</title>
</head>

<body>
    <div id="box">
        <img src="images/loginPic.jpg" alt="Fruits and Vegetables">
        <form method="post">
            <div>Welcome to Grocery Tracker Login!</div>
            <br>
            <div>Username:</div>
            <input type="text" name="username"><br>
            <br>
            <div>Password:</div>
            <input type="password" name="password"><br>
            <br>
            <br>
            <input type="submit" value="Login"><br>
            <br>

            <!-- <a href="signup.php">Click to Signup</a><br>
            <br>
            <a href="ownersignup.php">Click to Signup as Owner</a> -->
        </form>
    </div>

    <br>
    <button class="signup-button" onclick="location.href='signup.php';">
        Sign up
    </button>

    <br>

    <button class="ownersignup-button" onclick="location.href='ownersignup.php';">
        Sign up as Owner
    </button>
    <p id="credits"> Made by Wayne La, Anson Sieu, and John Lugue &copy; </p>
</body>

</html>