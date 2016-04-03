<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
    //header("Location: LogOut.php"); // Redirecting to logout confirmation page
}
?>