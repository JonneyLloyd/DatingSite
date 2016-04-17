<?php

$error = 0;
$banErr = $reasonErr = $exists = $already_banned = $date_error = $interval = "";
$date = date("d.m.y");
//check if submit has been pressed
// enter nickname of user

    $user = strtolower(htmlspecialchars($_POST['user_ban']));
    $reason = strtolower(htmlspecialchars($_POST['block_reason']));
    $end_date = strtolower(htmlspecialchars($_POST['ban']));
    if(empty($user)){
        $banErr = "Username Required";
        $error = 1;
    }
    if(empty($reason)) {
        $reasonErr = "Reason is required";
        $error = 1;
    }
    if(empty($end_date)) {
        $date_error = "End date is required";
        $error = 1;
    }
    if($error != 1){
        $query = ("SELECT * FROM user WHERE nickname = '$user'");
        $result = mysqli_query($conn, $query);
        if($result->num_rows){
            //get user_id...could be a function
            $query = "SELECT user_id FROM user WHERE nickname = '$user'";
            $result = mysqli_query($conn, $query)
            or die ("Couldn't execute query cannot get user id from nickname.");

            $row = mysqli_fetch_array($result);
            $user_id = $row[0];

            //check if user already in blocked
            $query = ("SELECT * FROM blocked WHERE user_id = '$user_id'");
            $result = mysqli_query($conn, $query);
            if($result->num_rows){
                $banErr = "User is already banned.";
                $error = 1;
            }
            else{
                //enter user into blocked database
                //INSERT INTO `group17db`.`blocked` (`user_id`, `reason`, `end_date`) VALUES ('234', 'asdasd', NOW() + INTERVAL 1 DAY);
                if ($end_date == "day"){
                    $blocked_til= " NOW() + INTERVAL 1 DAY";
                }
                else if ($end_date == "week")
                    $blocked_til= " NOW() + INTERVAL 1 WEEK";
                else
                    $blocked_til = " NULL";
                $query = "INSERT INTO blocked (user_id, reason, end_date) VALUES ('$user_id', '$reason', $blocked_til)";
                $result = mysqli_query($conn, $query)
                or die ("Couldn't execute query cannot insert into blocked table.");
            }
        }
        else{
            $banErr = "Username does not exist.";
            $error = 1;
        }
        if ($error != 1)
    header("location: Admin.php");
}