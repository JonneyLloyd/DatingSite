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
    <h3>Your Top Five Matches</h3>

    <?php
    $user_id = $_SESSION['user_id'];
    $query = "SELECT seeking, sex from user WHERE user_id = '" . $user_id . "'";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute query.");
    $row = mysqli_fetch_array($result);

    $seeking = $row['seeking'];
    $sex = $row['sex'];

    $like_array = array();


    /*$query1 =  "SELECT * from user d LEFT JOIN (select user_id, ((score * 2) - neg_score) as total from
                ((select b.user_id, count(*) as score from `like` a left join `like` b on a.like_desc = b.like_desc
                where a.user_id = '". $user_id . "' and b.user_id != '". $user_id . "' and a.like_desc != '' group by b.user_id)q join
                (select z.user_id, count(*) as neg_score from `dislike` x left join `dislike` z on x.dislike_desc = z.dislike_desc
                where x.user_id = '". $user_id . "' and z.user_id != '". $user_id . "' and x.dislike_desc != '' group by z.user_id)w using(user_id)))t
                on d.user_id = t.user_id WHERE sex = 'f' order by total desc";*/


    $query1 = "SELECT * from user d LEFT JOIN
                (select user_id, (IFNULL(score * 2, 0) - IFNULL(neg_score, 0)) as total from
                ((select b.user_id, IFNULL(count(*), 0) as score from `like` a left join
                 `like` b on a.like_desc = b.like_desc where a.user_id = '". $user_id . "' and b.user_id != '". $user_id . "'
                  and a.like_desc != '' group by b.user_id)q left join
                 (select z.user_id, IFNULL(count(*), 0) as neg_score
                 from `like` x left join `dislike` z on x.like_desc = z.dislike_desc
                  where x.user_id = '". $user_id . "' and x.like_desc != '' group by z.user_id)w using(user_id)))t
                  on d.user_id = t.user_id WHERE sex = '". $seeking . "' and seeking = '" . $sex . "' and d.user_id != '" . $user_id .
                "' order by total desc";

    $result = mysqli_query($conn, $query1)
    or die ($query1 . " could not be executed");
    $count = 0;
    while($count < 5 && $row = mysqli_fetch_array($result))
    {
        if (strtolower($row['nickname'] != "admin")) {
            $count++;
            $user_id = $row['user_id'];
            $f_name = ucfirst($row['f_name']);
            $name = $row['nickname'];
            $bio = $row['about'];
            $dob = $row['dob'];
            $age = date("Y/m/d") - $dob;
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
                <img src='uploads/" . $name . ".jpg' alt='Profile pic' />
                <br />
                <span class='caption'></span>

            <form name = 'contact' action='Contact.php' method='post' enctype='multipart/form-data'>
			<div class='row'>
			<label for='Profile'></label>
            <input type='hidden' name='contact_id' value='$user_id' />
            <input type='hidden' name='contact_f_name' value='$f_name' />
			<input type='submit' class='contact'  value='Contact' name='submit''>
			</div>
			</div>
		</form>
<br>

            <div class='section-content'>
                <ul>
                    <p>My name is " . $f_name . ".</p>
                    <p>I am a " .$age . " year old " . $sex . " looking for a " . $seeking . ".</p>
                    <p>Here's a little about myself:</p>
                    <p> " . $bio . "</p>
                     <br><br>


		<form name = 'report' action='Contact.php' method='post' enctype='multipart/form-data'>
			<div class='row'>
			<label for='Profile'></label>
            <input type='hidden' name='contact_id' value='admin' />
            <input type='hidden' name='contact_f_name' value='Administrator' />
             <input type='hidden' name='report_id' value='$user_id' />
            <input type='hidden' name='report_f_name' value='$f_name' />
			<input type='submit'class='report' value='Report user' name='submit''>
			</div>
		</form>

                </ul>
            </div>
        </div>";
        }
    }
    ?>



    <div id="footer">
    </div>
</div>
</body>
</html>
