<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if(isset($_POST['gender']))
{
	if (empty($_POST['bio']) || empty($_POST['seeking'])) {
		$error = "Please complete form";
		echo $error;
		header("Location: Details.php");
	}
else {
	$sex = strtolower(htmlspecialchars($_POST["gender"]));
	$pref =strtolower(htmlspecialchars($_POST["seeking"]));
	$bio = strtolower(htmlspecialchars($_POST["bio"]));

	$query1 = "SELECT user_id from user WHERE nickname =  '" .$_SESSION['login_user'] . "';";
	$result = mysqli_query($conn,$query1)
		or die ("Couldn't execute query.");
	$row = mysqli_fetch_array($result);


	$query2 = "UPDATE `user` SET `sex` = '" . $sex . "', `seeking` = '" . $pref .
			"', `about` = '" . $bio . "' WHERE `user`.`user_id` = " . $row[0] . ";";
	$result = mysqli_query($conn,$query2)
		or die ("Couldn't execute query2.");
}

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<script type = "text/javascript" src="http://use.edgefonts.net/comfortaa:n4,n3,n7:all;miss-fajardose:n4:all;montez:n4:all.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<title>Details</title>
</head>
<body>
<div id="nav">
	<div class="nav-title">
		<h1><a href="Index.html">Perfect Matches</a></h1>
	</div>
	<div class="navbar">
		<ul>
			<li class='active'><a href='Profile.html'>Profile</a></li>
			<li>
				<span class="link-sep">&#9679;</span></li>
			<li><a href='Details.php'>AccountAdmin</a></li>
			<li>
				<span class="link-sep">&#9679;</span></li>
			<li class='has-sub'><a href='#'>Search</a>
				<ul>
					<li><a href='Page1.html'>SearchPage1</a></li>
					<li><a href='Page2.html'>SuggestedMatches</a></li>
					<li><a href='Page3.html'>Browse</a></li>
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
<p><?= "Welcome " . $_SESSION['login_user'];?></p>
	<div class="section">
			<h3>Details</h3>
			<p>
			<form name="Details" method="post" id="Details"  onsubmit="" >
				<div class="row requiredRow">
					<label for="Sex">I am:</label>
					<input type="radio" name="gender" value="m" checked> Male
					<input type="radio" name="gender" value="f"> Female<br><br>
				</div>
				<div class="row requiredRow">
					<label for="Seeking">Interested in:</label>
					<input type="radio" name="seeking" value="m" checked> Male
					<input type="radio" name="seeking" value="f"> Female<br><br>
				</div>

				<div class="row requiredRow">
					<label for="Bio">Bio</label>
					<textarea name="bio" input id="bio" type="text"  title="" />Say something about yourself</textarea><br><br>

				</div>


				<div class="row">
					<input type="submit" value="Update" />
				</div>
			</form>
	<br><br><br>
		<form action="upload.php" method="post" enctype="multipart/form-data">
			<div class="row">
			<label for="Profile">Change Profile Pic:</label>
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="Upload Image" name="submit">
			</div>
		</form>
		<img src="<?php echo "uploads" . '/' . $_SESSION['login_user']; ?>.jpg" />
		</p>
		</p>


	</div>
	</div>
	<div id="footer">

	</div>
	</body>

</html>