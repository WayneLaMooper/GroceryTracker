<?php
session_start();

$_SESSION;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="index.css" />
  <title>Welcome to Grocery Tracker!</title>
</head>

<body>
  <div id="box">
    <form method="post">
      <div>Welcome to Grocery Tracker Login!</div>
      <div>Username:</div>
      <input type="text" name="user_name"><br>
      <div>Password:</div>
      <input type="password" name="password"><br>
      <input type="submit" value="Login"><br>
      <a href="signup.php">Signup</a>
    </form>
  </div>

</body>

</html>