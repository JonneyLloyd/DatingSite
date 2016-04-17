<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
$banErr = $reasonErr = $exists = $already_banned = $date_error = $interval = "";
	if((isset($_SESSION['login_user'])) && ($_SESSION['login_user'] == "admin" )) {
}
	else
		header("location: LogIn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	include('BanningProcess.php');

}




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
		<script type = "text/javascript" src="http://use.edgefonts.net/comfortaa:n4,n3,n7:all;miss-fajardose:n4:all;montez:n4:all.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Ban User</title>
	</head>
	<body>
	<div id="nav">
		<div class="nav-title">
			<h1><a href="MainPage.html">Perfect Matches</a></h1>
		</div>
		<div class="navbar">
			<ul>
				<li class='has-sub'><a href='#'>Options</a>
					<ul>
						<li><a href='Ban_user.php'>Ban User</a></li>
						<li><a href='admin.php'>Ban View</a></li>
					</ul>
				</li>
				<li>
					<span class="link-sep">&#9679;</span></li>
				<li class='has-sub'><a href='#'>Search</a>
					<ul>
						<li><a href='AdminSearch.php'>Search Users</a></li>
						<li><a href='AdminMailbox.php'>Mailbox</a></li>
					</ul>
				</li>

				<li>
					<span class="link-sep">&#9679;</span></li>
				<li><a href='LogOut.php'>Log Out</a></li>
			</ul>
		</div>
	</div>
	
	
	
	<div id="content">
	<p>Perfect Matches</p>
		<div class="section">
			<form name = 'contact' action='' method='post' >
				<h3>Ban User</h3>
					<p>
						Enter user to be banned:
						<input type="text" name="user_ban"> <?= $banErr?><br />
					</p>
					Length of ban:
					<select name="ban">
						<option value="day">1 Day</option>
						<option value="week">1 Week</option>
						<option value="lifetime">Lifetime</option>
					</select><?= $date_error?>
				<p>
					Please enter a reason for blocking this user: <?= $reasonErr?>
					<p>
						<textarea name="block_reason" type="text" rows="4" cols="50"></textarea>
					</p>
				</p>
				<div class="row">
					<input type="submit" value="Ban User" />
				</div>
			</form>
		</div>
	</div>
	<div id="footer">

	</div>
	</body>
</html>