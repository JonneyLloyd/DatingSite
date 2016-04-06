<?php
require_once("./include/dbConfig.php");
include('Session.php');
if((isset($_SESSION['login_user'])) && (isset($_SESSION['user_password']))) {
    //get current profiles pages id somehow
    $sender = $user_id;
    $recipient = "";
    $message = $_POST['message'];
    $query = "INSERT INTO `messages` VALUES (NULL,$sender,$recipient,$message)";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute query.");
}
else
    header("location: LogIn.php");