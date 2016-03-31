<?php
require_once("./include/dbConfig.php");

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
			<li class='active'><a href='LuxuryCruises.html'>Home</a></li>
			<li>
				<span class="link-sep">&#9679;</span></li>
			<li><a href='About.html'>About us</a></li>
			<li>
				<span class="link-sep">&#9679;</span></li>
			<li><a href='LogIn.html'>Log In</a></li>
				<span class="link-sep">&#9679;</span></li>
			<li><a href='Register.php'>Register</a></li>
		</ul>
	</div>
</div>
<div id="content">
<p>Perfect Matches</p>
	<div class="section">
			<h3>Details</h3>
			<p>
			<form>
				Location: 
					<select name="location">
					<option value="ireland">Ireland</option>
					<option value="uk">UK</option>
					</select><br><br>
				Nearest City:<input type="text" name="city"><br><br>
				I am:	<input type="radio" name="gender" value="male" checked> Male
					<input type="radio" name="gender" value="female"> Female<br><br>	
				Seeking:<input type="radio" name="seeking" value="male"> Male
					<input type="radio" name="seeking" value="female"> Female <br><br>
				Mobile: <input type="tel" name="mob" id="tel"><br><br>
				Username:<input type="text" name="username"><br><br>
				Password:<input type="text" name="password"><br><br>
				Confirm Password:<input type="text" name="password2"><br><br>
				Bio: <textarea name="bio"></textarea><br><br>
					<input type="register" name="Reser">
					<input type="submit" value="Register">
			</form> 
			</p>
			
	</div>
	</div>
	<div id="footer">

	</div>
	</body>

</html>