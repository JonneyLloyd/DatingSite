<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
    if((isset($_SESSION['login_user'])) && ($_SESSION['login_user'] == "admin" )) {
        $username = $_POST['nickname'];
    }
    else {
        header("location: LogIn.php");
    }

    $query = "SELECT user_id from user WHERE nickname =  '" . $_POST['nickname'] . "';";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute query.");
    $row = mysqli_fetch_array($result);

    $user_id = $row[0];
    $query = "SELECT * from user WHERE user_id = '" . $user_id . "';";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute query.");
    $row = mysqli_fetch_array($result);

    $f_name = ucfirst($row[3]);
    $s_name = ucfirst($row[4]);
    $sex = $row[5];
    if ($sex == "m")
        $sex = "man";
    else
        $sex = "woman";
    $pref = $row[6];
    if ($pref == "m")
        $pref = "man";
    else
        $pref = "woman";
    $dob = $row[7];
    $about = $row[8];
    $age = date("Y/m/d") - $dob;

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
        <h1><a href="MainPage.html">Perfect Matches</a></h1>
    </div>
    <div class="navbar">
        <ul>
            <li><a href='Ban_user.php'>Ban User</a></li>
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
        </ul>a
    </div>
</div>

<div id="content">
    <h3><?= $f_name . " " . $s_name ?></h3>
    <div class="section">
        <p></p>
        <div class="thumbnail rounded-frame-small">
            <img src="uploads/<?= $username?>.jpg" alt="Profile pic" />
            <br />
            <span class="caption"></span>
        </div>
        <div class="section-content">

            <ul>
                <p>My name is  <?= $f_name . " " . $s_name . "."?></p>
                <p>I am a <?= $age . " year old " . $sex . " looking for a " . $pref . "."?></p>
                <p>Here's a little about myself:</p>
                <p><?=$about?></p>

            </ul>
            <form name = "BlockUser" action="Ban_user.php" method="post" >
                <div class="row requiredRow">
                    <input type='hidden' name='user_id' value='<?=$user_id?>' />
                    <input type="submit" value="Block User" />
                    </form>
                    
            <form name = "Edit_User" action="adminDetailView.php" method="post" >
                <div class="row requiredRow">
                    <input type='hidden' name='user_id' value='<?=$user_id?>' />
                    <input type='hidden' name='firstname' value='<?=$f_name?>' />
                    <input type='hidden' name='lastname' value='<?=$s_name?>' />
                    <input type='hidden' name='age' value='<?=$age?>' />
                    <input type='hidden' name='sex' value='<?=$sex?>' />
                    <input type='hidden' name='preference' value='<?=$pref?>' />
                    <input type='hidden' name='about' value='<?=$about?>' />
                    <input type='hidden' name='dob' value='<?=$dob?>' />
                    <input type="submit" value="Edit User" />
            </form>
        </div>
    </div>
    <div id="footer">
    </div>
</div>
</body>
</html>