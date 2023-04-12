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

  <a href="logout.php">Logout</a>
  <h1>Welcome <?php echo $user_data['username']; ?>
  </h1>

  <br>

  <!-- search function here. search an item for a popup?-->
  <hr>
  <div id="search">
    <form method="post">
      <div>Search:</div>
      <input type="text" name="item"><br>
    </form>
  </div>
  <br>

  <button>Favourites</button>

  <a href="favourites.php">Favourites</a>
  <br>
  <!-- pictures on a gridlike fashion. click on image for a popup -->
  <hr>
  <div class="gallery">
    <figure>
      <img src="images/apple.jpg">
    </figure>

    <figure>
      <img src="images/orange.jpg">
    </figure>

    <figure>
      <img src="images/banana.jpg">
    </figure>

    <figure>
      <img src="images/flour.jpg">
    </figure>

    <figure>
      <img src="images/eggs.jpg">
    </figure>

    <figure>
      <img src="images/butter.jpg">
    </figure>


  </div>
</body>

</html>