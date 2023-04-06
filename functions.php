<?php

function check_login($con)
{
    if (isset($_SESSION['account_id'])) {
        $id = $_SESSION['account_id'];
        $query = "select * from user_account where account_id = '$id' limit 1";

        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    //Redirect to login
    header("Location : login.php");
    die;
}
