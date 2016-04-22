<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php');
//Get the reason and duration of ban for the user
$query = "SELECT reason, end_date from blocked WHERE user_id = '" . $_SESSION['user_id'] . "'";
$result = mysqli_query($conn, $query)
or die ("Couldn't execute query.");
$row = mysqli_fetch_array($result);
$end_date = ($row['end_date']);
$reason =$row['reason'];
$end_date = ($row['end_date']);
$time = strtotime($end_date);
if ($end_date == "" || $end_date == NULL) $end_date = "Lifetime";
else $end_date = date("d/m/y ", $time);

include('LogOutProcess.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
    <script type = "text/javascript" src="http://use.edgefonts.net/comfortaa:n4,n3,n7:all;miss-fajardose:n4:all;montez:n4:all.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Dating Website</title>
</head>
<body>
<div id="nav">
    <div class="nav-title">
        <h1><a href="index.html">Perfect Matches</a></h1>
    </div>
    <div class="navbar">
        <ul>
            <li class='active'><a href='index.html'>Home</a></li>
            <li>
                <span class="link-sep">&#9679;</span></li>
            <li><a href='About.html'>About us</a></li>
            <li>
                <span class="link-sep">&#9679;</span></li>
            <li><a href='LogIn.php'>Log In</a></li>
            <span class="link-sep">&#9679;</span></li>
            <li><a href='Register.php'>Register</a></li>
        </ul>
    </div>
</div>

<div id="content">
    <h2>Perfect Matches</h2>
    <div class="section">
        <p>You have been blocked by the administrator and are unable to access your account.</p>
        <p><?='Reason for ban: ' . $reason . '<BR>' .
            'Ban until: ' . $end_date?></p>
        </div>
</div>
<div id="footer">

</div>
</body>

</html>