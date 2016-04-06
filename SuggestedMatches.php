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
    <link rel="stylesheet" type="text/css" href="style.css" />
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
    <h3>Suggested Matches</h3>

    <?php
    $user_id = $_SESSION['user_id'];
    $query = "SELECT seeking from user WHERE user_id = '" . $user_id . "'";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute query.");
    $row = mysqli_fetch_array($result);

    $seeking = $row['seeking'];

    $like_array = array();
    $query1 = "SELECT * from user z LEFT JOIN
              (SELECT a.user_id, count(*) as like_score FROM `like` a LEFT JOIN `like` b ON a.like_desc = b.like_desc
              where a.like_desc != '' and a.user_id > b.user_id and a.user_id != '". $user_id . "'
              order by like_score desc)t on z.user_id = t.user_id WHERE sex = '" . $seeking . "'";

    $result = mysqli_query($conn, $query1)
    or die ($query1 . " could not be executed");

    while($row = mysqli_fetch_array($result))
    {
        $user_id = $row['user_id'];
        $f_name = ucfirst($row['f_name']);
        $name = $row['nickname'];
        $bio = $row['about'];
        if ($row['sex'] == "m")
            $sex = "man";
        else
            $sex = "woman";
        if ($row['seeking'] == "m")
            $seeking = "man";
        else
            $seeking = "woman";


        echo "<div class='section'>
            <p></p>
            <div class='thumbnail rounded-frame-small'>
                <img src='uploads/" . $name .".jpg' alt='Profile pic' />
                <br />
                <span class='caption'></span>
            </div>

            <div class='section-content'>
                <ul>
                    <p>My name is " . $f_name . ".</p>
                    <p>I am a " . $sex . " looking for a " .$seeking . "</p>
                    <p>Here's a little about myself:</p>
                    <p> " . $bio . "</p>
                     <br><br>

        <form action='Contact.php' method='post' enctype='multipart/form-data'>
			<div class='row'>
			<label for='Profile'>Contact $f_name</label>
            <input type='hidden' name='contact_id' value='$user_id' />
            <input type='hidden' name='contact_f_name' value='$f_name' />
			<input type='submit' value='Contact' name='submit''>
			</div>
		</form>

                </ul>
            </div>
        </div>";

    }
/*
    $query2 = "SELECT a.user_id, count(*) as dislike_score FROM `dislike` a LEFT JOIN `dislike` b ON a.dislike_desc = b.dislike_desc
              where a.dislike_desc != '' and a.user_id > b.user_id and a.user_id != '" . $user_id . "'
              order by dislike_score desc";

*/





    ?>



    <div id="footer">
    </div>
</div>
</body>
</html>
