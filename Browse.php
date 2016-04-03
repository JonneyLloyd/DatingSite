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
			<li><a href='Details.php'>AccountAdmin</a></li>
			<li>
				<span class="link-sep">&#9679;</span></li>
			<li class='has-sub'><a href='#'>Search</a>
				<ul>
					<li><a href='Page1.html'>SearchPage1</a></li>
					<li><a href='Page2.html'>SuggestedMatches</a></li>
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
	<h3>Browse users</h3>
<?php
    $query = "SELECT * FROM `user`";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute query.");
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
                <span class='caption'>Profile</span>
            </div>

            <div class='section-content'>
                <ul>
                    <p>My name is " . $f_name . ".</p>
                    <p>I am a " . $sex . " looking for a " .$seeking . "</p>
                    <p>Here's a little about myself:</p>
                    <p> " . $bio . "</p>
                    <p></p>

                </ul>
            </div>
        </div>";

    }
?>

<div id="footer">
</div>
</div>
</body>
</html>