<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((isset($_SESSION['login_user'])) && ($_SESSION['login_user'] == "admin" )) {
}
else
    header("location: LogIn.php");
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
            <li class='has-sub'><a href='#'>Options</a>
                <ul>
                    <li><a href='Ban_user.php'>Ban User</a></li>
                    <li><a href='admin.php'>Ban View</a></li>
                </ul>
            </li>
            <li>
                <span class="link-sep">&#9679;</span></li>
            <li class='has-sub'><a href='#'>Search</a>
                <ul>
                    <li><a href='AdminSearch.php'>Search Users</a></li>
                    <li><a href='AdminMailbox.php'>Mailbox</a></li>
                </ul>
            </li>

            <li>
                <span class="link-sep">&#9679;</span></li>
            <li><a href='LogOut.php'>Log Out</a></li>
        </ul>
    </div>
</div>

<div id="content">
    <h3>Search Users</h3>
    <div class="section">
        <h3>Enter 1 or more search terms</h3>
        <p>
        <form name="Details" method="post" id="Details"  action="AdminSearchResults.php" onsubmit="">
            <div class="row">
                <label for="Firstname">Firstname</label>
                <input id="Firstname" name="Firstname" type="text" title="" placeholder="Firstname"/>
            </div>
            <div class="row">
                <label for="Surname">Surname</label>
                <input id="Surname" name="Surname" type="text" title=""  placeholder="Surname"/>
            </div>
            <div class="row">
                <label for="Like">Like</label>
                <input id="Like" name="Like" type="text" title=""  placeholder="Like"/>
            </div>
            <div class="row">
                <label for="Dislike">Dislike</label>
                <input id="Dislike" name="Dislike" type="text" title=""  placeholder="Dislike"/>
            </div>
            <div class="row requiredRow">
                <label for="Sex">Sex</label>
                <input type="radio" name="gender" value="m" checked>Male
                <input type="radio" name="gender" value="f">Female<br><br>
            </div>
            <div class="row">
                <input type="submit" value="Search" />
            </div>
        </form>
    </div>


    <div id="footer">
    </div>
</div>
</body>
</html>
