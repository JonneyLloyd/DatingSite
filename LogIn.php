<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php');
$login_error = "";
//check that user is logged in and its a regular user
if((isset($_SESSION['login_user'])) && ($_SESSION['login_user'] == "admin")){
	header("location: admin.php");
}


else if((isset($_SESSION['login_user'])) && (isset($_SESSION['user_password']))){
	header("location: Profile.php");
}


if(isset($_POST['username'])) {
	$nickname = strtolower(htmlspecialchars($_POST["username"]));
	$password = htmlspecialchars($_POST["password"]);
//user can login with email or username
	$query = "SELECT * from user WHERE nickname =  '" . $nickname . "' OR email = '" . $nickname . "';";
	$result = mysqli_query($conn, $query)
	or die ("Couldn't execute query.");
	$row = mysqli_fetch_array($result);
	if ($row[0] != null){
		//if email/username is there then check password hash
if (password_verify($password, $row['password'])) {
	$_SESSION['login_user'] = $row['nickname'];
	$_SESSION['user_password'] = true;;
	$_SESSION['user_id'] = $row[0];

	//update login table
	$query = "UPDATE `group17db`.`login` SET `status` = NOW() WHERE `login`.`user_id` =" . $_SESSION['user_id'] . ";";
	$result = mysqli_query($conn, $query)
	or die ("Couldn't execute loginUpdate query.");
	if ($nickname == "admin") {
		header("location: admin.php");
	} else {
		$del_query = "delete from blocked where user_id = '" . $_SESSION['user_id']. "' and end_date < NOW()";
		$del_result = mysqli_query($conn,$del_query)
		or die ("Couldn't execute del blocked query.");

		$query2 = "select * from blocked where user_id = '" . $_SESSION['user_id'] . "'";
		$result2 = mysqli_query($conn,$query2)
		or die ("Couldn't execute block check query.");
		$row = mysqli_fetch_array($result2);
		if ($row != null)
		{
			header("Location: Blocked.php");

		}
		else
		header("Location: Profile.php");
	}

}
		else {
			$login_error = "Incorrect password";
			sleep(1); //basic brute force prevention
		}
	}
	else {
		$login_error = "Username not found";
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
	<h2>Perfect Matches</h2>
	<div class="section">
		<p>

		<form name = "login" id = "login" action="" method="post" onsubmit="return checkLoginForm(this);" >
		<div class="row requiredRow">
			<label for="username">Username</label>
			<input id="username" name="username" type="text"   title="" />
		</div>

		<div class="row requiredRow">
			<label for="password">Password</label>
			<input id="password" name="password" type="password" onblur="checkFormPassword1(this);"  title="" />
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