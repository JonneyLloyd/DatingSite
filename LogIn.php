<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
$login_error = "";
if((isset($_SESSION['login_user'])) && (isset($_SESSION['user_password']))){
	header("location: Profile.php");
}
if(isset($_POST['username'])) {
	$nickname = strtolower(htmlspecialchars($_POST["username"]));
	$password = htmlspecialchars($_POST["password"]);
	$query = "SELECT * from user WHERE nickname =  '" . $nickname . "' AND  password = '" . $password . "';";
	$result = mysqli_query($conn, $query)
	or die ("Couldn't execute query.");
	$row = mysqli_fetch_array($result);
	if ($row[0] != null){

		$_SESSION['login_user'] = $nickname;
		$_SESSION['user_password'] = $password;
		$_SESSION['user_id'] = $row[0];

			//update login table

		$query = "UPDATE `group17db`.`login` SET `status` = '1' WHERE `login`.`user_id` =". $_SESSION['user_id'].  ";";
		$result = mysqli_query($conn,$query)
		or die ("Couldn't execute query.");

		header("Location: Profile.php");
	}
	else {
		$login_error = "Username or password not found";
	}
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<script type = "text/javascript" src="http://use.edgefonts.net/comfortaa:n4,n3,n7:all;miss-fajardose:n4:all;montez:n4:all.js"></script>
	<script type = "text/javascript" src="formValidation.js"></script>
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
			<li class='active'><a href='index.html'>Home</a></li>
			<li>
				<span class="link-sep">&#9679;</span></li>
			<li><a href='About.html'>About us</a></li>
			<li>
				<span class="link-sep">&#9679;</span></li>
			<li><a href='LogIn.php'>Log In</a></li>
			<span class="link-sep">&#9679;</span></li>
			<li><a href='Register.php'>Register</a></li>
		</ul>
	</div>
</div>

<div id="content">
<p>Perfect Matches</p>
	<div class="section">
		<p>

		<form name = "login" id = "login" action="" method="post" onsubmit="return checkLoginForm(this);" >
		<div class="row requiredRow">
			<label for="username">Username</label>
			<input id="username" name="username" type="text" onblur="checkFormUsername(this);"  title="" />
		</div>

		<div class="row requiredRow">
			<label for="password">Password</label>
			<input id="password" name="password" type="text" onblur="checkFormPassword1(this);"  title="" />
			<?= $login_error?>
		</div>
		<div class="row">
			<input type="submit" value="Log In" />
		</div>
		</form>

	</div>
	<div id="footer">
	</div>
	</div>
</body>
</html>