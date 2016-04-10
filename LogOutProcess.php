<?php
include('LogInProcess.php');
require_once("./include/dbConfig.php");
if(!isset($_SESSION['login_user'])) {
    header("location: LogIn.php");
}
$user_id = $_SESSION['user_id'];

if(session_destroy()) // Destroying All Sessions
{
}
?>