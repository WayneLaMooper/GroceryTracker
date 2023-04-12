<?php

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

$query = "select * from manager_acc where adminm_account_ID = '$user_data[account_ID]'";
$result = mysqli_query($con, $query);
$manager_info = mysqli_fetch_assoc($result);

$query = "select * from shop where location = '$manager_info[shop_location]'";
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
                <div>Employee Account Creation!</div>
                <br>
                <div>Username:</div>
                <input type="text" name="e_username"><br>
                <br>
                <div>Password:</div>
                <input type="password" name="e_password"><br>
                <br>
                <input type="submit" value="Create Account"><br>
            </form><br>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (isset($_POST['e_username'])) {
                    $user_name = $_POST['e_username'];
                    $password = $_POST['e_password'];

                    if (!empty($user_name) && !empty($password)) {
                        $user_id = random_num(20);
                        $queryName = "select * from user_account where username = '$user_name'";
                        $result = mysqli_query($con, $queryName);

                        if ($result && mysqli_num_rows($result) > 0) {
                            echo "Username taken, please try again.";
                        } else {
                            $query = "insert into user_account (account_ID, username, password) values ('$user_id', '$user_name', '$password')";
                            mysqli_query($con, $query);
                            $query = "insert into admin_acc (admin_ID) values ('$user_id')";
                            mysqli_query($con, $query);
                            $query = "insert into employee_acc (admine_account_ID, shop_location) values ('$user_id', '$store_info[location]')";
                            mysqli_query($con, $query);
                            echo "Account successfully created!";
                        }
                    } else {
                        echo "Empty entry, please try again.";
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="column-style">
        <h1>Unassigned Employees:</h1>
        <?php
        $freeEmps = "select * from employee_acc where shop_location = '$store_info[location]' and dept_ID is NULL";
        $result = mysqli_query($con, $freeEmps);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($employee = mysqli_fetch_assoc($result)) {
                $empQuery = "select username from user_account where account_ID = $employee[admine_account_ID]";
                $employee_result = mysqli_query($con, $empQuery);
                $employee_info = mysqli_fetch_assoc($employee_result);
                echo $employee_info['username'] . " " . $employee['admine_account_ID'] . "<br>";
            }
        }
        ?>
        <div class="divider">
            <?php
            if (isset($manager_info['dept_ID'])) {
            } else {
                echo "Currently not assigned a department. Restricted permissions, please ask your superior if permissions are required.";
            }
            ?>
        </div>
    </div>
    <div class="column-style">
        <h1>Departments:</h1>
        <?php
        $allDepartments = "select * from department";
        $result = mysqli_query($con, $allDepartments);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($department = mysqli_fetch_assoc($result)) {
                echo "<div class='divider'>" . $department['dept_name'] . " department managers: <br>";
                $departQuery = "select * from manager_acc where dept_ID = $department[dept_ID]";
                $deptmanager_result = mysqli_query($con, $departQuery);
                while ($deptmanager_info = mysqli_fetch_assoc($deptmanager_result)) {
                    $manQuery = "select username from user_account where account_ID = $deptmanager_info[adminm_account_ID]";
                    $manager_result = mysqli_query($con, $manQuery);
                    $manager_info = mysqli_fetch_assoc($manager_result);
                    echo $manager_info['username'] . " " . $deptmanager_info['adminm_account_ID'] . "<br>";
                }
                echo "<br> Enter new " . $department['dept_name'] . " department manager ID below <br><form name='form' action='' method='post'>
                <input type='text' name='new_m_ID'> <br>
                <input type='submit' name='new_m_dept' value='" . $department['dept_name'] . "'><br><br></form></div>";
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['new_m_ID'])) {
                $new_manager_ID = $_POST['new_m_ID'];
                $new_manager_dept = $_POST['new_m_dept'];

                if (!empty($new_manager_ID) && !empty($new_manager_dept)) {
                    $queryName = "select * from manager_acc where adminm_account_ID = '$new_manager_ID' and dept_ID is NULL";
                    $result = mysqli_query($con, $queryName);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $departmentQ = "select * from department where dept_name = '$new_manager_dept' and shop_location = '$current_store'";
                        $curdept = mysqli_query($con, $departmentQ);
                        $cur_deptinfo = mysqli_fetch_assoc($curdept);
                        $newquery = "update manager_acc set dept_ID = $cur_deptinfo[dept_ID] where adminm_account_ID = '$new_manager_ID'";
                        mysqli_query($con, $newquery);
                        echo "Manager successfully added!";
                        header("refresh: 0");
                    } else {
                        echo '<script type="text/javascript">
                        window.onload = function () { alert("Error: Manager is already apart of a department, or does not exist."); } 
                        </script>';
                    }
                } else {
                    echo '<script type="text/javascript">
                    window.onload = function () { alert("Error: Empty entry, please try again."); } 
                    </script>';
                }
            }
        }
        ?>
    </div>
</body>

</html>