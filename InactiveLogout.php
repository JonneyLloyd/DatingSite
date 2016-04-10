<?php
include('LogInProcess.php');
$inactive = 1800;

$session_life = time() - $_SESSION['timeout'];
if($session_life > $inactive) {

    session_destroy();
    header("Location: LogOut.php");

}
$_SESSION['timeout']=time();
?>