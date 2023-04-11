<?php
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password)) {
        $user_id = random_num(20);
        $queryName = "select * from user_account where username = '$user_name'";
        $result = mysqli_query($con, $queryName);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "Username taken, please try again.";
        } else {
            $query = "insert into user_account (account_ID, username, password) values ('$user_id', '$user_name', '$password')";

            mysqli_query($con, $query);
            $query = "insert into customer_acc (customer_ID) values ('$user_id')";
            mysqli_query($con, $query);
            header("Location: login.php");
            die;
        }
    } else {
        echo "Empty entry, please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="logpages.css" />

<head>
    <title>Welcome to Grocery Tracker!</title>
    <link rel="icon" href="images/icon.jpg" type="image/x-icon">
</head>

<body>
    <div id="box">
        <img src="images/loginPic.jpg" alt="Fruits and Vegetables">
        <form method="post">
            <div>Welcome to Grocery Tracker Signup!</div>
            <br>
            <div>Username:</div>
            <input type="text" name="username"><br>
            <br>
            <div>Password:</div>
            <input type="password" name="password"><br>
            <br>
            <input type="submit" value="Signup"><br>
            <br>
            <a href="login.php">Click to Login</a>
        </form>
    </div>

    <p id="credits"> Made by Wayne La, Anson Sieu, and John Lugue &copy; </p>

</body>

</html>