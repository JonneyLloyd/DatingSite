<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((!isset($_SESSION['login_user'])) || (!isset($_SESSION['user_password']))) {
    header("location: LogIn.php");
}

$testing = "some other problem";
    if((isset($_POST['report_id']))&& (isset($_POST['sender_id'])) && (isset($_POST['message_text']))) {
        $sender = $_POST['sender_id'];
        $report_id = $_POST['report_id'];
        $reason = (htmlspecialchars($_POST['message_text']));
        $query = "INSERT INTO `admin_mail` VALUES (NULL, $sender, $report_id, '" . $reason . "')";
        $result = mysqli_query($conn, $query)
        or die ("\nCouldn't execute admin query. ". $query);
    }
    else 
        if((isset($_POST['receiver_id'])) && (isset($_POST['sender_id'])) && (isset($_POST['message_text']))) {
        $sender = $_POST['sender_id'];
        $recipient = $_POST['receiver_id'];
        $message = $_POST['message_text'];
        $query = "INSERT INTO `messages` VALUES (NULL, $sender, $recipient, '" . $message . "')";
        $result = mysqli_query($conn, $query)
        or die ("Couldn't execute query.");
    }
    else
        echo $testing;
header("location: Profile.php");