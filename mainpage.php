<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mainpage.css?v=<?php echo time(); ?>">
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
    
    <div class ="gallery">
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