<?php

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
$current_store = $_SESSION['current_store'];

$query = "select * from shop where location = '$current_store'";
$result = mysqli_query($con, $query);
$store_info = mysqli_fetch_assoc($result);
$current_name = $store_info['store_name'];

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
        <button class="return-button" onclick="location.href='ownerindex.php';">
            Return to all Stores
        </button>

        <h1> Welcome back <?php echo $user_data['username']; ?> to <?php echo $current_name; ?>!</h1>
        <br>
        <div class="divider">
            <form method="post">
                <br>
                <div>Add New Department!</div>
                <br>
                <div>Department Name:</div>
                <input type="text" name="d_name"><br>
                <br>
                <input type="submit" value="Add Department"><br><br>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (isset($_POST['d_name'])) {
                    $dept_name = $_POST['d_name'];

                    if (!empty($dept_name)) {
                        $queryName = "select * from department where shop_location = '$current_store' and dept_name = '$dept_name'";
                        $result = mysqli_query($con, $queryName);

                        if ($result && mysqli_num_rows($result) > 0) {
                            echo "Department already exists.";
                        } else {
                            $query = "insert into department (dept_name, shop_location) values ('$dept_name', '$current_store')";
                            mysqli_query($con, $query);
                            echo "Department successfully added!";
                        }
                    } else {
                        echo "Empty entry, please try again.";
                    }
                }
            }
            ?>
        </div>
        <form method="post">
            <br>
            <div>Manager Account Creation!</div>
            <br>
            <div>Username:</div>
            <input type="text" name="m_username"><br>
            <br>
            <div>Password:</div>
            <input type="password" name="m_password"><br>
            <br>
            <input type="submit" value="Create Account"><br>
        </form><br>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['m_username'])) {
                $user_name = $_POST['m_username'];
                $password = $_POST['m_password'];

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
                        $query = "insert into manager_acc (adminm_account_ID, shop_location) values ('$user_id', '$current_store')";
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
    <div class="column-style">
        <h1>Unassigned Managers:</h1>
        <?php
        $freeManagers = "select * from manager_acc where shop_location = '$current_store' and dept_ID is NULL";
        $result = mysqli_query($con, $freeManagers);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($manager = mysqli_fetch_assoc($result)) {
                $manQuery = "select username from user_account where account_ID = $manager[adminm_account_ID]";
                $manager_result = mysqli_query($con, $manQuery);
                $manager_info = mysqli_fetch_assoc($manager_result);
                echo $manager_info['username'] . " " . $manager['adminm_account_ID'] . "<br>";
            }
        }
        ?>
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