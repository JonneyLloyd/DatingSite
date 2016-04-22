<?php
    require_once("./include/dbConfig.php");
if((!isset($_SESSION['login_user'])) || (!isset($_SESSION['user_password']))) {
    session_start(); // Starting Session
}
    $error=''; // Variable To Store Error Message
if((isset($_SESSION['login_user'])) && (isset($_SESSION['user_password']))){
    //update logins table
    $query = "UPDATE `group17db`.`login` SET `status` = NOW() WHERE `login`.`user_id` =". $_SESSION['user_id'].  ";";
    $result = mysqli_query($conn,$query)
    or die ("Couldn't execute loginUpdate query.");
}

