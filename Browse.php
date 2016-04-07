<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((isset($_SESSION['login_user'])) && (isset($_SESSION['user_password']))) {
//this is  a comment
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
	<h3>Browse users</h3>
<?php
    $query = "SELECT * FROM `user`";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute query.");
    while($row = mysqli_fetch_array($result))
    {
if (strtolower($row['nickname'] != "admin")) {
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
                <img src='uploads/" . $name . ".jpg' alt='Profile pic' />
                <br />
                <span class='caption'></span>
            </div>

            <div class='section-content'>
                <ul>
                    <p>My name is " . $f_name . ".</p>
                    <p>I am a " . $sex . " looking for a " . $seeking . "</p>
                    <p>Here's a little about myself:</p>
                    <p> " . $bio . "</p>
                     <br><br>

        <form name = 'contact' action='Contact.php' method='post' enctype='multipart/form-data'>
			<div class='row'>
			<label for='Profile'>Contact $f_name</label>
            <input type='hidden' name='contact_id' value='$user_id' />
            <input type='hidden' name='contact_f_name' value='$f_name' />
			<input type='submit' value='Contact' name='submit''>
			</div>
		</form>
<br>
		<form name = 'report' action='Contact.php' method='post' enctype='multipart/form-data'>
			<div class='row'>
			<label for='Profile'>Report $f_name</label>
            <input type='hidden' name='contact_id' value='admin' />
            <input type='hidden' name='contact_f_name' value='Administrator' />
             <input type='hidden' name='report_id' value='$user_id' />
            <input type='hidden' name='report_f_name' value='$f_name' />
			<input type='submit' value='Report' name='submit''>
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