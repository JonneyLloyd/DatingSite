<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php');

//Check user is logged in
if((isset($_SESSION['login_user'])) && ($_SESSION['login_user'] == "admin" )) {
	$username = $_POST['nickname'];;
}
else if((isset($_SESSION['login_user'])) && (isset($_SESSION['user_password']))) {
	$username = $_SESSION['login_user'];

}
else 
	header("Location: LogIn.php");

	//get all users details
	$query = "SELECT * from user WHERE nickname =  '" . $username . "';";
	$result = mysqli_query($conn, $query)
	or die ("Couldn't execute query.");
	$row = mysqli_fetch_array($result);

	$user_id = $row['user_id'];

	$f_name = ucfirst($row['f_name']);
	$s_name = ucfirst($row['l_name']);
	$sex = $row['sex'];
	if ($sex == "m")
		$sex = "man";
	else
		$sex = "woman";
	$pref = $row['seeking'];
	if ($pref == "m")
		$pref = "man";
	else
		$pref = "woman";
	$dob = $row['dob'];
	$about = $row['about'];
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
		</div>
	</div>
	<div id="footer">
	</div>
	</div>
</body>
</html>