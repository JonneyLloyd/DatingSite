<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((isset($_SESSION['login_user'])) && ($_SESSION['login_user'] == "admin" )) {

}
else
	header("location: LogIn.php");

$error = 0;
$banErr = $reasonErr = $exists = $already_banned = "";
//check if submit has been pressed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$user = strtolower(htmlspecialchars($_POST["user"]));
	$reason = strtolower(htmlspecialchars($_POST["Reason"]));
	if(empty($user)){
		$banErr = "Username Required";
		$error = 1;
	}

	if(empty($reason)) {
		$reasonErr = "Reason is required";
		$error = 1;
	}

	if($error != 1){
		$query = ("SELECT * FROM user WHERE nickname = '$user'");
		$result = mysqli_query($conn, $query);
		if($result->num_rows){
			//get user_id...could be a function
			$query = "SELECT user_id FROM user WHERE nickname = '$user'";
			$result = mysqli_query($conn, $query)
			or die ("Couldn't execute query.");

			$row = mysqli_fetch_array($result);
			$user_id = $row[0];

			//check if user already in blocked
			$query = ("SELECT * FROM blocked WHERE user_id = '$user_id'");
			$result = mysqli_query($conn, $query);
			if($result->num_rows){
				$already_banned = "User is already banned.";
			}
			else{
				//enter user into blocked database
				$query = "INSERT INTO blocked (user_id, reason) VALUES ('$user_id', '$reason')";
				$result = mysqli_query($conn, $query)
				or die ("Couldn't execute query.");
			}
		}
		else{
			$exists = "Username does not exist.";
		}
	}
}


//display blocked users
$display = "SELECT user.nickname FROM user WHERE user.user_id IN (SELECT blocked.user_id FROM blocked)";
$banned_users = mysqli_query($conn, $display)
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
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
			<li><a href='admin.php'>Admin</a></li>
			<li>
				<span class="link-sep">&#9679;</span></li>
			<li class='has-sub'><a href='#'>Search</a>
				<ul>
					<li><a href='Search.php'>Search Users</a></li>
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
	<h3>Ban User</h3>
		<form method = "post" name = "submitted">
			<div class="row requiredRow">
				<label for = "user">Username*</label>
				<input id="user" name="user" type="text" />
				<?php echo $banErr;?>
				<?php echo $exists; ?>
				<?php echo $already_banned;?>
			</div>

			<div class="row requiredRow">
				<label for="Reason">Reason*</label>
				<textarea name="Reason" input id="Reason" type="text"  title="" /></textarea>
				<?php echo $reasonErr;?>
				<br><br>
			</div>
			<div class="row">
				<input type="submit" value="Ban User" />
			</div>
			</br>
		</form>
	<div>
	</div>
	<div id="footer">
	</div>
</div>
</body>
</html>