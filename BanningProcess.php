<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((isset($_SESSION['login_user'])) && ($_SESSION['login_user'] == "admin" )) {

}
else
    header("location: LogIn.php");

$error = 0;
$banErr = $reasonErr = $exists = $already_banned = "";
//check if submit has been pressed
// enter nickname of user
if ($_SERVER["REQUEST_METHOD"] == "POST")
    $user = strtolower(htmlspecialchars($_POST['user_ban']));
    $reason = strtolower(htmlspecialchars($_POST['block_reason']));
    if(empty($user)){
        $banErr = "Username Required";
        $error = 1;
    }
    if(empty($reason)) {
        $reasonErr = "Reason is required";
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
                $query = "INSERT INTO blocked (user_id, reason) VALUES ('$user_id', '$reason')";
                $result = mysqli_query($conn, $query)
                or die ("Couldn't execute query cannot insert into blocked table.");
            }
        }
        else{
            $exists = "Username does not exist.";
        }
    header("location: Admin.php");
}
?>