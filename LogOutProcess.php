<?php
include('LogInProcess.php');
require_once("./include/dbConfig.php");
$user_id = $_SESSION['user_id'];

if(session_destroy()) // Destroying All Sessions
{

    //update login table
    $query = "UPDATE `group17db`.`login` SET `status` = '0' WHERE `login`.`user_id` =". $user_id .  ";";
    $result = mysqli_query($conn,$query)
    or die ("Couldn't execute query.");
}
?>