<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((!isset($_SESSION['login_user'])) || (!isset($_SESSION['user_password']))) {
    header("location: LogIn.php");
}
if((isset($_POST['receiver_id'])) && (isset($_POST['sender_id'])) &&(isset($_POST['message_text']))) {
    //get current profiles pages id somehow
    $sender = $_POST['sender_id'];
    $recipient = $_POST['receiver_id'];
    $message = $_POST['message_text'];
    $query = "INSERT INTO `messages` VALUES (NULL,$sender,$recipient,'" . $message . "')";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute query.");
}
header("location: Profile.php");
