<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((! isset($_SESSION['login_user'])) || (! isset($_SESSION['user_password']))) {
    header("location: LogIn.php");
}
$reciever_id = "";
$reciever_name = "";
$sender_id = "";
$hidden_fields = "";
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
        <h1><a href="MainPage.html">Perfect Matches</a></h1>
    </div>
    <div class="navbar">
        <ul>
            <li class='active'><a href='Profile.php'>Profile</a></li>
            <li>
                <span class="link-sep">&#9679;</span></li>
            <li><a href='Details.php'>Account Settings</a></li>
            <li>
                <span class="link-sep">&#9679;</span></li>
            <li class='has-sub'><a href='#'>Options</a>
                <ul>
                    <li><a href='Search.php'>Search Users</a></li>
                    <li><a href='Browse.php'>Browse Users</a></li>
                    <li><a href='SuggestedMatches.php'>Suggested Matches</a></li>
                    <li><a href='Mailbox.php'>Mailbox</a></li>
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
        <p>To: <?=$reciever_name?> </p>
        <?php
        if (isset($_POST['report_id']) && isset($_POST['report_f_name'])) {
            $hidden_fields = "Reporting ID: " . $_POST['report_id'] . "\nReporting: " . $_POST['report_f_name'] . ".\n";
            echo $hidden_fields;
                }
        ?>
        <form name = "sendMessage" id ="sendMessage" action="ContactUser.php" method="post" >
            <div class="row requiredRow">
                <label for="message">Message</label>
                <textarea name="message_text" input id="message_text" type="text"  title=""  rows="4" cols="50"> <?=$hidden_fields?></textarea><br><br>

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