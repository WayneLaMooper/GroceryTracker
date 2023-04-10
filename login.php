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

        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                if ($user_data['password'] === $password) {
                    $_SESSION['user_id'] = $user_data['account_ID'];
                    header("Location: index.php");
                    die;
                }
            }
        }
    } else {
        echo "Please enter valid information";
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
            <input type="submit" value="Login"><br>
            <br>
            <a href="signup.php">Click to Signup</a>
        </form>
    </div>

    <p id= "credits"> Made by Wayne La, Anson Sieu, and John Lugue &copy; </p>

</body>

</html>