<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((isset($_SESSION['login_user'])) && ($_SESSION['login_user'] == "admin" )) {

}
else
    header("location: LogIn.php");

$error = 0;
$banErr = $reasonErr = $exists = $already_banned = $date_error = $interval = "";
$date = date("d.m.y");
//check if submit has been pressed
// enter nickname of user
if ($_SERVER["REQUEST_METHOD"] == "POST")
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
                $already_banned = "User is already banned.";
            }
            else{
                //enter user into blocked database
                if ($end_date == "day"){
                    $blocked_til=strtotime("+1 day", $date);
                }
                else if ($end_date == "week")
                    $blocked_til=strtotime("+7 days", $date);
                else
                    $blocked_til = NULL;
                $query = "INSERT INTO blocked (user_id, reason, end_date) VALUES ('$user_id', '$reason', $blocked_til)";
                $result = mysqli_query($conn, $query)
                or die ("Couldn't execute query cannot insert into blocked table.");
            }
        }
        else{
            $exists = "Username does not exist.";
        }
    header("location: Admin.php");
}