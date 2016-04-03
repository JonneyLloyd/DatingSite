<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((isset($_SESSION['login_user'])) && (isset($_SESSION['user_password']))) {
	$username = $_SESSION['login_user'];

	$query = "SELECT user_id from user WHERE nickname =  '" . $_SESSION['login_user'] . "';";
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
	<h3><?= $f_name . " " . $s_name ?></h3>
	<div class="section">
		<p></p>
		<div class="thumbnail rounded-frame-small">
			<img src="uploads/<?= $username?>.jpg" alt="Profile pic" />
			<br />
			<span class="caption">Profile</span>
		</div>
		<div class="section-content">

			<ul>
				<p>My name is  <?= $f_name . " " . $s_name . "."?></p>
				<p>I am a <?= $age . " year old " . $sex . " looking for a " . $pref . "."?></p>
				<p>Here's a little about myself:</p>
				<p><?=$about?></p>

			</ul>
		</div>
	</div>
	<div id="footer">
	</div>
	</div>
</body>
</html>