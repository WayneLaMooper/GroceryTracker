<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mainpage.css">
    <title>Grocery Tracker</title>
    <link rel="icon" href="images/icon.jpg" type="image/x-icon">
</head>
<body>
    <h1> Grocery Tracker </h1>

    <!-- search function here -->
    <div id = "search">
        <form method="post">
            <div>Search:</div> 
            <input type="text" name="item"><br>
        </form>
    </div>

    <!-- pictures on a gridlike fashion. click on image for a popup -->
    
    <div class ="row">
        <div class = "column">
            <img src="images/apple.jpg">
            <img src="images/orange.jpg">
            <img src="images/banana.jpg">
        </div>

        <div class = "column">
            <img src="images/flour.jpg">
            <img src="images/eggs.jpg">
            <img src="images/butter.jpg">
        </div>
    </div>

</body>
</html>