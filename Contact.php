<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((! isset($_SESSION['login_user'])) || (! isset($_SESSION['user_password']))) {
    header("location: LogIn.php");
}

if (isset( $_POST['report_id']) && isset($_POST['report_f_name'])) {
    $receiver_id = $_POST['contact_id'];
    $receiver_name = $_POST['contact_f_name'];
    $report_id = $_POST['report_id'];
    $report_name = $_POST['report_f_name'];
    $sender_id = $_SESSION['user_id'];
}

else if (isset($_POST['contact_id']) && isset($_POST['contact_f_name'])) {
    $receiver_id = $_POST['contact_id'];
    $receiver_name = $_POST['contact_f_name'];
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
        <h1><a href="index.html">Perfect Matches</a></h1>
    </div>
    <div class="navbar">
        <ul>
            <li class='active'><a href='Profile.php'>Profile</a></li>
            <li>
                <span class="link-sep">&#9679;</span></li>
            <li class='has-sub'><a href='#'>Account</a>
                <ul>
                    <li><a href='Details.php'>My Details</a></li>
                    <li><a href='Mailbox.php'>Mailbox</a></li>
                </ul>
                <span class="link-sep">&#9679;</span></li>
            <li class='has-sub'><a href='#'>Search</a>
                <ul>
                    <li><a href='Search.php'>Search Users</a></li>
                    <li><a href='Browse.php'>Browse Users</a></li>
                    <li><a href='SuggestedMatches.php'>Suggested Matches</a></li>
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
        <p>To: <?=$receiver_name?> </p>
        <?php
        $hidden_fields = "Hello " . $receiver_name . ",\n";
        if (isset($report_id) && isset($report_name)) {
            $hidden_fields = "Reporting ID: " . $report_id . " \nReporting: " . $report_name . ".\n";
            echo $hidden_fields;
                }
        ?>
        <form name = "sendMessage" id ="sendMessage" action="ContactUser.php" method="post" >
            <div class="row requiredRow">
                <label for="message">Message</label>
                <textarea name="message_text" input id="message_text" type="text"  title=""  rows="4" cols="50"> <?=$hidden_fields?></textarea><br><br>
                <input type='hidden' name='sender_id' value='<?=$sender_id?>' />
                <?php if (isset( $_POST['report_id'])){
                echo "<input type='hidden' name='report_id' value='$report_id' />";
                }
                ?>
                <input type='hidden' name='receiver_id' value='<?=$receiver_id?>' />
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