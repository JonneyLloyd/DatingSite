<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((! isset($_SESSION['login_user'])) || (! isset($_SESSION['user_password']))) {
    header("location: LogIn.php");
}
$reciever_id = "";
$reciever_name = "";
$sender_id = "";
if (isset($_POST['contact_id']) && isset($_POST['contact_f_name'])) {
    $reciever_id = $_POST['contact_id'];
    $reciever_name = $_POST['contact_f_name'];
    $sender_id = $_SESSION['user_id'];


}


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
            <li class='active'><a href='Profile.php'>Profile</a></li>
            <li>
                <span class="link-sep">&#9679;</span></li>
            <li><a href='Details.php'>AccountAdmin</a></li>
            <li>
                <span class="link-sep">&#9679;</span></li>
            <li class='has-sub'><a href='#'>Search</a>
                <ul>
                    <li><a href='Search.php'>Search Users</a></li>
                    <li><a href='SuggestedMatches.php'>SuggestedMatches</a></li>
                    <li><a href='Browse.php'>Browse</a></li>
                    <li><a href='Page4.html'>Page4</a></li>
                    <li><a href='Page5.html'>Page5</a></li>
                </ul>
            </li>
            <li>
                <span class="link-sep">&#9679;</span></li>
            <li><a href='LogOut.php'>Log Out</a></li>
        </ul>
    </div>
</div>

<div id="content">
    <div class="section">
        <button type="button">Inbox</button>
        <button type="button">Sent Messages</button>
        <p>To: <?=$reciever_name?> </p>
        <form name = "sendMessage" id ="sendMessage" action="ContactUser.php" method="post" >
            <div class="row requiredRow">
                <label for="message">Message</label>
                <textarea name="message_text" input id="message_text" type="text"  title=""  cols="">Hello <?=$reciever_name?>,</textarea><br><br>
                <input type='hidden' name='receiver_id' value='<?=$reciever_id?>' />
                <input type='hidden' name='sender_id' value='<?=$sender_id?>' />
                <input type="submit" value="Send" />
                <p></p>
            </div>
        </form>
    </div>
</div>
<div id="footer">

</div>
</body>
</html>