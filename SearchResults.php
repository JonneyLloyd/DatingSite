<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php');
//check user is logged in
if((! isset($_SESSION['login_user'])) || (! isset($_SESSION['user_password']))) {
    header("location: LogIn.php");
}
//handle empty search
else if ((( $_POST['Firstname'] == "")) && (( $_POST['Surname'] == ""))&& (( $_POST['Like'] == ""))&& (( $_POST['Disike'] == "")))
    header("location: Search.php");
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
    <h3>Search Results</h3>

    <?php
    //Create start of query
    $count = 0;
    $query_count = 0;
    $i = 0;
    $final_query = "SELECT user_id, f_name, nickname, about, sex, seeking, dob FROM user WHERE ";
    $query_parts = array(
        0    => "",
        1    => "",
        2    => "",
        3    => ""
    );
    //handle any serach terms entered/not entered and append to query
    $firstname = strtolower(htmlspecialchars($_POST['Firstname']));
    if ($firstname != null) {
        $final_query .= "f_name LIKE '%" . $firstname . "%'";
        $count++;

    }
    $surname = strtolower(htmlspecialchars($_POST['Surname']));
    if ($surname != null) {
        if ($count != 0) $final_query .= " AND l_name = '" .$surname . "'";
        else $final_query .= "l_name LIKE '%" . $surname . "%'";
        $count++;

    }
    $like = strtolower(htmlspecialchars($_POST['Like']));
    if ($like != null) {

        if ($count != 0) $final_query .= " AND user_id in (SELECT user_id FROM group17db.like WHERE `like_desc` LIKE '%" . $like . "%')";
        else $final_query = "SELECT user.user_id, user.f_name, user.nickname, user.about, user.sex, user.seeking, user.dob FROM `user` JOIN `like` on user.user_id = like.user_id WHERE like_desc LIKE'" . $like . "'";
        $count++;
    }
    $dislike = strtolower(htmlspecialchars($_POST['Dislike']));
    if ($dislike != null) {
        if ($count != 0) $final_query .= " AND user_id in (SELECT user_id FROM group17db.dislike WHERE `dislike_desc` LIKE '%" . $dislike . "%')";
        else $final_query = "SELECT user.user_id, user.f_name, user.nickname, user.about, user.sex, user.seeking, user.dob FROM `user` JOIN `dislike` on user.user_id = dislike.user_id WHERE dislike_desc LIKE'" . $dislike . "'";
        $count++;
    }
    $sex = strtolower(htmlspecialchars($_POST['gender']));
    if ($sex != null) {
        if ($count != 0) $final_query .= " AND sex = '" . $sex . "'";
        else $final_query = "SELECT user.user_id, user.f_name, user.nickname, user.about, user.sex, user.seeking, user.dob FROM `user` JOIN `dislike` on user.user_id = dislike.user_id WHERE dislike_desc LIKE'" . $dislike . "'";
        $count++;
    }


if ($count == 0){
    echo "<div class='section'>
            <h3>No serarch terms entered!</h3>
            </div>";
}
    else {
        //run final query
        $result = mysqli_query($conn, $final_query)
            or die ($final_query . " could not be executed");
        //loop through results
        while ($row = mysqli_fetch_array($result)) {
            if (strtolower($row['nickname'] != "admin")) {
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


		<form name = 'report' action='ContactUser.php' method='post' enctype='multipart/form-data'>
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
    }
    ?>


    <div id="footer">
    </div>
</div>
</body>
</html>