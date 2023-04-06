<?php
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password)) {
        $user_id = random_num(20);
        $query = "insert into user_account (account_ID, username, password) values ('$user_id', '$user_name', '$password')";

        mysqli_query($con, $query);
        header("Location: login.php");
        die;
    } else {
        echo "Please enter valid information";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="index.css" />

<head>
    <title>Welcome to Grocery Tracker!</title>
</head>

<body>
    <div id="box">
        <form method="post">
            <div>Welcome to Grocery Tracker Signup!</div>
            <div>Username:</div>
            <input type="text" name="username"><br>
            <div>Password:</div>
            <input type="password" name="password"><br>
            <input type="submit" value="Signup"><br>
            <a href="login.php">Click to Login</a>
        </form>
    </div>

</body>

</html>