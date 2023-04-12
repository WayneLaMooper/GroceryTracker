<?php

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(isset($_GET['imgSrc']) && isset($_GET['imgCode'])) {
    $img_src = $_GET['imgSrc'];
    $img_srl = $_GET['imgCode'];
    $query = "select * from product where serial_code = '$img_srl'";
    $result = mysqli_query($con, $query);
    $user_data = mysqli_fetch_assoc($result);

    if (isset($img_srl)) {
      if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);

        if($img_srl === $user_data['serial_code']) {
          $_SESSION['i_src'] = $img_src;
          $_SESSION['i_code'] = $user_data['serial_code'];
          $_SESSION['i_stock'] = $user_data['stock'];
          $_SESSION['i_price'] = $user_data['price'];
          header("Location: product.php");
          die;
        }
      }
    }
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

  <!-- search function here. search an item for a popup?-->
  <hr>
  <div id="search">
    <form method="post">
      <div>Search:</div>
      <input type="text" name="item"><br>
    </form>
  </div>
  <br>

  <button class="favourites-button" onclick="location.href='favourites.php';">
    Favourites
  </button>

  <br>
  <!-- pictures on a gridlike fashion. click on image for a popup -->
  <?php
  
  ?>
  <hr>
  <div class="gallery">
    <figure>
      <img src="images/apple.jpg" alt = "1" class ="image">
    </figure>

    <figure>
      <img src="images/orange.jpg" alt = "2" class ="image">
    </figure>

    <figure>
      <img src="images/banana.jpg" alt = "3" class ="image">
    </figure>

    <figure>
      <img src="images/flour.jpg" alt = "4" class ="image">
    </figure>

    <figure>
      <img src="images/eggs.jpg" alt = "5" class ="image">
    </figure>

    <figure>
      <img src="images/butter.jpg" alt = "6" class ="image">
    </figure>

    <script>
      var images = document.querySelectorAll('.image');

      for (var i = 0; i < images.length; i++) {
        images[i].addEventListener('click', check)
      }

      function check(img) {
        var imgName = event.target.src;
        var imgCode = event.target.alt;
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "<?php echo $_SERVER['PHP_SELF']; ?>?imgSrc=" + imgName + "&imgCode=" + imgCode, true);
        xhttp.send();
        
      }
    </script>

  </div>
</body>

</html>