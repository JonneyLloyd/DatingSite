<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((isset($_SESSION['login_user'])) && (isset($_SESSION['user_password']))) {
}
else
    header("location: LogIn.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
    <script type = "text/javascript" src="http://use.edgefonts.net/comfortaa:n4,n3,n7:all;miss-fajardose:n4:all;montez:n4:all.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <title>Dating Website</title>
</head>
    <body>
    <div id="nav">
        <div class="nav-title">
            <h1><a href="Index.html">Perfect Matches</a></h1>
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
    <p>Perfect Matches</p>
        <div class="section">

                <p>Welcome to your home page. Feel free to update your profile, browse other members or check your messages!</p>
        </div>
        </div>
        <div id="footer">

        </div>
        </body>
    </html>