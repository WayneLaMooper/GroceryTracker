<?php

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

// if ($_SERVER['REQUEST_METHOD'] == 'GET') {
//   if(isset($_GET['imgSrc']) && isset($_GET['imgCode'])) {
//     $img_src = $_GET['imgSrc'];
//     $img_srl = $_GET['imgCode'];

//     $query = "select * from product where serial_code = '$img_srl'";
//     $result = mysqli_query($con, $query);
//     $item_data = mysqli_fetch_assoc($result);

//     if ($result && mysqli_num_rows($result) > 0) {
//       $item_data = mysqli_fetch_assoc($result);

//       if($img_srl === $user_data['serial_code']) {
//         $_SESSION['i_src'] = $img_src;
//         $_SESSION['i_code'] = $img_code;
//         $_SESSION['i_stock'] = $user_data['stock'];
//         $_SESSION['i_price'] = $user_data['price'];
//         header("Location: product.php");
//         die;
//       }
//     }

//   }
// }

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $product_name = $_POST['item'];
  $_SESSION['item_name'] = $product_name;

  if (isset($product_name)) {
    $query = "select * from product where name = '$product_name'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $i = 0;

      while ($item_row_data = mysqli_fetch_assoc($result)) {
        $serial = $item_row_data['serial_code'];
        $_SESSION['ser_code'][$i] = $serial;

        $query = "select * from provides where ser_code = '$serial'";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
          $j = 0;

          while ($provides_row = mysqli_fetch_assoc($result)) {
            $_SESSION['price'][$j] = $provides_row['price'];
            $_SESSION['stock'][$j] = $provides_row['stock'];
            $dept_id = $provides_row['dept_id'];
            $query = "select * from department where dept_ID = '$dept_id'";
            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
              $_SESSION['location'][$j] = $provides_row['shop_location'];
            }

            $j++;
          }
        }

        $i++;
      }
    }
  }

  header("Location: product.php");
  die;
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
      <input type="text" name="item">
      < <br>
        <input type="submit" value="Enter">
        <br>
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
      <img src="images/apple.jpg" alt="apple" class="image">
    </figure>

    <figure>
      <img src="images/orange.jpg" alt="orange" class="image">
    </figure>

    <figure>
      <img src="images/banana.jpg" alt="banana" class="image">
    </figure>

    <figure>
      <img src="images/flour.jpg" alt="flour" class="image">
    </figure>

    <figure>
      <img src="images/eggs.jpg" alt="eggs" class="image">
    </figure>

    <figure>
      <img src="images/butter.jpg" alt="butter" class="image">
    </figure>

    <!-- <script>
      var images = document.querySelectorAll('.image');

      for (var i = 0; i < images.length; i++) {
        images[i].addEventListener('click', function() {
          check(images[i]);
        });
      }

      function check(img) {
        console.log("Image clicked!");
        var imgName = img.src;
        var imgCode = img.alt;
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "index.php?imgSrc=" + imgName + "&imgCode=" + imgCode, true);
        xhttp.send();
        
      }
    </script> -->

  </div>
</body>

</html>