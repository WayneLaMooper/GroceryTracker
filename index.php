<?php

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="index.css" />

<head>
  <title>Welcome to Grocery Tracker!</title>
</head>

<body>

  <a href="logout.php">Logout</a>
  <h1>This is the index page </h1>

  <br>
  Hello Username.
</body>

</html>