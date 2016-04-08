<?php
include('LogInProcess.php');
require_once("./include/dbConfig.php");
$user_id = $_SESSION['user_id'];

if(session_destroy()) // Destroying All Sessions
{
}
?>