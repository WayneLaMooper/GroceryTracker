<?php
ob_start();
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

$query = "select * from employee_acc where admine_account_ID = '$user_data[account_ID]'";
$result = mysqli_query($con, $query);
$employee_info = mysqli_fetch_assoc($result);

$query = "select * from shop where location = '$employee_info[shop_location]'";
$result = mysqli_query($con, $query);
$store_info = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="adminstore.css" />
<link rel="icon" href="images/icon.jpg" type="image/x-icon">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Grocery Tracker!</title>
</head>

<body>
    <div class="column-style">
        <button class="logout-button" onclick="location.href='login.php';">
            Logout
        </button>

        <h1> Welcome back <?php echo $user_data['username']; ?> to <?php echo $store_info['store_name'] . " " . $store_info['location']; ?>!</h1>
        <br>
        <div class="divider">
            <form method="post">
                <br>
                <div>Can't find a product in our database? Add it!</div>
                <br>
                <div>Product name:</div>
                <input type="text" name="p_name"><br>
                <br>
                <input type="submit" value="Add Product"><br>
            </form><br>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (isset($_POST['p_name'])) {
                    $new_pname = $_POST['p_name'];
                    $new_serial = random_num(20);
                    if (!empty($new_pname)) {
                        $query = "insert into product (serial_code, name) values ('$new_serial', '$new_pname')";
                        mysqli_query($con, $query);
                    } else {
                        echo "Empty entry, please try again.";
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="column-style">
        <h1>Products:</h1>
        <?php
        if (isset($employee_info['dept_ID'])) {
            $query = "select * from product";
            $result = mysqli_query($con, $query);
            while ($product_info = mysqli_fetch_assoc($result)) {
                $query = "select * from provides where dept_id = $employee_info[dept_ID] and ser_code = $product_info[serial_code]";
                $productResults = mysqli_query($con, $query);
                if ($productResults && mysqli_num_rows($productResults) > 0) {
                    $provides_info = mysqli_fetch_assoc($productResults);
                    echo "<div class='prod-divider'>" . $product_info['name'] . "<br>" . $product_info['serial_code'] .
                        "<br> This product is in your department now. 
                    <form name='form' action='' method='post'>
                    Stock:    <input type='text' name='update_prod_stock' value='$provides_info[stock]'><br>
                    Price:    <input type='text' name='update_prod_price' value='$provides_info[price]'><br>
                    Discount: <input type='text' name='update_prod_discount' value='$provides_info[discount]'><br>
                    Update product info: 
                    <input type='submit' name='update_prod_info' value='" . $product_info['serial_code'] . "'><br><br></form></div>";
                } else {
                    $query = "select * from provides as p natural join department as d where d.shop_location = '$employee_info[shop_location]' and p.ser_code = '$product_info[serial_code]'";
                    $sameloc_Result = mysqli_query($con, $query);
                    if ($sameloc_Result && mysqli_num_rows($sameloc_Result)) {
                        echo "<div class='not-prod-divider'>" . $product_info['name'] . "<br>" . $product_info['serial_code'] .
                            "<br> This product is already under another department.</div>";
                    } else {
                        echo "<div class='maybe-prod-divider'>" . $product_info['name'] . "<br>" . $product_info['serial_code'] . "<br>
                    <form name='form' action='' method='post'>
                    Add product to department: 
                    <input type='submit' name='new_dept_prod' value='" . $product_info['serial_code'] . "'><br><br></form></div>";
                    }
                }
            }
        } else {
            echo "Currently not assigned a department. Restricted permissions, please ask your superior if permissions are required.";
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['new_dept_prod'])) {
                $prod_code = $_POST['new_dept_prod'];
                $query = "insert into provides (ser_code, dept_id) values ('$prod_code', '$employee_info[dept_ID]')";
                mysqli_query($con, $query);
                header("refresh:0");
            } else if (isset($_POST['update_prod_info'])) {
                $prod_code = $_POST['update_prod_info'];
                $prod_stock = $_POST['update_prod_stock'];
                $prod_price = $_POST['update_prod_price'];
                $prod_discount = $_POST['update_prod_discount'];
                $query = "update provides set stock = $prod_stock, price = $prod_price, discount = $prod_discount
                where dept_id = $employee_info[dept_ID] and ser_code = $prod_code";
                if (!empty($prod_stock) || !empty($prod_price) || !empty($prod_discount)) {
                    mysqli_query($con, $query);
                    header("refresh:0");
                } else {
                    echo "One of the entries is empty, cannot update.";
                }
            }
        }
        ?>
        <br>
    </div>
</body>

</html>