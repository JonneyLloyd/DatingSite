<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((isset($_SESSION['login_user'])) && ($_SESSION['login_user'] == "admin" )) {
	header("location: admin.php");
}
else if((isset($_SESSION['login_user'])) && (isset($_SESSION['user_password']))){
	header("location: Profile.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//if user has submitted form successfully
	//cleanse all data
	$firstName = strtolower(htmlspecialchars($_POST["Firstname"],ENT_QUOTES));
	$surname = strtolower(htmlspecialchars($_POST["Surname"],ENT_QUOTES));
	$email = strtolower(htmlspecialchars($_POST["Email"],ENT_QUOTES));
	$email2 = strtolower($_POST["Email"]);
	$password = htmlspecialchars($_POST["Password1"],ENT_QUOTES);
	//create a Hash
	$password = password_hash($password, PASSWORD_DEFAULT);
	$dob = htmlspecialchars($_POST["DOByear"] . "-" . $_POST["DOBmonth"] . "-" . $_POST["DOBday"]);
	$nickname = strtolower(htmlspecialchars($_POST["username"],ENT_QUOTES));


	//query to check username & email not already in table!
	$query = "SELECT * from user WHERE nickname = '" . $nickname . "' OR email = '" . $email . "'";
	$result = mysqli_query($conn, $query)
	or die ("Couldn't execute Check user exists query.");
	$row = mysqli_fetch_array($result);
	if ($row['user_id'] != NULL)
		header("Location: Register.php");

	include('payment.php');
	if (checkPayment() != "1"){

		header("location: FailedPayment.html");
	}
	else {

		//create user entry
		$query = "INSERT INTO `group17db`.`user` (`user_id`, `password`, `nickname`,
												`f_name`, `l_name`, `sex`, `seeking`,
												`dob`, `about`, `email`)
			VALUES (NULL, '" . $password . "', '" . $nickname . "','" . $firstName . "', '" . $surname . "', NULL, NULL, '" . $dob . "', NULL, '" . $email . "')";
		$result = mysqli_query($conn, $query)
		or die ("Couldn't execute addUser query.");
		copy("uploads/user.jpg", "uploads/$nickname.jpg");


		//another query to add user to login table
		$query = "SELECT user_id from user WHERE nickname =  '" . $nickname . "';";
		$result = mysqli_query($conn, $query)
		or die ("Couldn't execute getID query.");
		$row = mysqli_fetch_array($result);
		$user_id = $row[0];


		$query = "INSERT INTO `group17db`.`login` (`user_id`, `status`) VALUES ('" . $user_id . "', NOW());";
		$result = mysqli_query($conn, $query)
		or die ("Couldn't execute insert login query.");


		if (empty($_POST['username']) || empty($_POST['Password1'])) {
			$error = "Username or Password is invalid";
			echo $error;
			header("Location: LogIn.php");
		} else {
			//set session variables
			$_SESSION['login_user'] = strtolower(htmlspecialchars($_POST["username"]));
			$_SESSION['user_password'] = true;

			$query1 = "SELECT * from user WHERE nickname =  '" . $_SESSION['login_user'] . "';";
			$result = mysqli_query($conn, $query1)
			or die ("Couldn't execute query login id.");
			$row = mysqli_fetch_array($result);
			$_SESSION['user_id'] = $row['user_id'];

		}
		header("Location: Details.php");
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type = "text/javascript" src="http://use.edgefonts.net/comfortaa:n4,n3,n7:all;miss-fajardose:n4:all;montez:n4:all.js"></script>
	<script type = "text/javascript" src="formValidation.js"></script>
	<script type="text/javascript" src="jquery-2.2.2.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var x_timer;
			$("#username").keyup(function (e){
				$('#Registration').addClass('no-submit');
				clearTimeout(x_timer);
				var user_name = $(this).val();
				x_timer = setTimeout(function(){
					if (user_name.length > 2)check_username_ajax(user_name);
				}, 1000);
			});

			function check_username_ajax(username){
				$("#user-result").html('<img src="loader.gif" />');
				$.post('local.php', {username:username}, function(data) {
					$("#user-result").html(data);
				});
			}

		});

		function check_email_ajax(email){
			$("#email-result").html('<img src="loader.gif" />');
			var emailCheck = $(email).val();
			if (emailCheck.length > 4)$.post('local.php', {email:emailCheck}, function(data) {
				$("#email-result").html(data);
			});
		}



	</script>


	<title>Register</title>

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
			<p></p>
			<h3>Register</h3>
				<form name="Registration" method="post" id="Registration" onsubmit="return checkForm(this);" >
					<div class="row requiredRow">
						<label for="Firstname">First name</label>
						<input id="Firstname" name="Firstname" type="text" onblur="checkFormFirstname(this); " title="" />
					</div>

				<div class="row requiredRow">
					<label for="Surname">Surname</label>
					<input id="Surname" name="Surname" type="text" onblur="checkFormSurname(this);" title="" />
				</div>

				<div class="row requiredRow">
					<label for="Email">E-mail</label>
					<input id="Email" name="Email" type="text" onblur="checkFormEmail(this); check_email_ajax(this);" title="" />  <span id="email-result">
				</div>

				<div class="row requiredRow">
					<label for="username">Username</label>
					<input id="username" name="username" type="text" onblur="checkFormUsername(this);"  title="" /> <span id="user-result"></span>
				</div>

				<div class="row requiredRow">
					<label for="Password1">Password</label>
					<input id="Password1" name="Password1" type="password" onblur="checkFormPassword1(this);" title="" />
				</div>

				<div class="row requiredRow">
					<label for="Password2">Password</label>
					<input id="Password2" name="Password2" type="password" onblur="checkFormPassword2(this);" title="" />
				</div>

					<div class="row requiredRow">
						<label for="DOBday DOBmonth DOByear">Date of Birth</label>
						<select id="DOBday" name="DOBday" title="">
							<option value="01">01</option>
							<option value="02">02</option>
							<option value="03">03</option>
							<option value="04">04</option>
							<option value="05">05</option>
							<option value="06">06</option>
							<option value="07">07</option>
							<option value="08">08</option>
							<option value="09">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
							<option value="25">25</option>
							<option value="26">26</option>
							<option value="27">27</option>
							<option value="28">28</option>
							<option value="29">29</option>
							<option value="30">30</option>
							<option value="31">31</option>
						</select>
						<select id="DOBmonth" name="DOBmonth" title="">
							<option value="01">January</option>
							<option value="02">February</option>
							<option value="03">March</option>
							<option value="04">April</option>
							<option value="05">May</option>
							<option value="06">June</option>
							<option value="07">July</option>
							<option value="08">August</option>
							<option value="09">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
						<select id="DOByear" name="DOByear" title="">
							<option value="2016">2016</option>
							<option value="2015">2015</option>
							<option value="2014">2014</option>
							<option value="2013">2013</option>
							<option value="2012">2012</option>
							<option value="2011">2011</option>
							<option value="2010">2010</option>
							<option value="2009">2009</option>
							<option value="2008">2008</option>
							<option value="2007">2007</option>
							<option value="2006">2006</option>
							<option value="2005">2005</option>
							<option value="2004">2004</option>
							<option value="2003">2003</option>
							<option value="2002">2002</option>
							<option value="2001">2001</option>
							<option value="2000">2000</option>
							<option value="1999">1999</option>
							<option value="1998">1998</option>
							<option value="1997">1997</option>
							<option value="1996">1996</option>
							<option value="1995">1995</option>
							<option value="1994">1994</option>
							<option value="1993">1993</option>
							<option value="1992">1992</option>
							<option value="1991">1991</option>
							<option value="1990">1990</option>
							<option value="1989">1989</option>
							<option value="1988">1988</option>
							<option value="1987">1987</option>
							<option value="1986">1986</option>
							<option value="1985">1985</option>
							<option value="1984">1984</option>
							<option value="1983">1983</option>
							<option value="1982">1982</option>
							<option value="1981">1981</option>
							<option value="1980">1980</option>
							<option value="1979">1979</option>
							<option value="1978">1978</option>
							<option value="1977">1977</option>
							<option value="1976">1976</option>
							<option value="1975">1975</option>
							<option value="1974">1974</option>
							<option value="1973">1973</option>
							<option value="1972">1972</option>
							<option value="1971">1971</option>
							<option value="1970">1970</option>
							<option value="1969">1969</option>
							<option value="1968">1968</option>
							<option value="1967">1967</option>
							<option value="1966">1966</option>
							<option value="1965">1965</option>
							<option value="1964">1964</option>
							<option value="1963">1963</option>
							<option value="1962">1962</option>
							<option value="1961">1961</option>
							<option value="1960">1960</option>
							<option value="1959">1959</option>
							<option value="1958">1958</option>
							<option value="1957">1957</option>
							<option value="1956">1956</option>
							<option value="1955">1955</option>
							<option value="1954">1954</option>
							<option value="1953">1953</option>
							<option value="1952">1952</option>
							<option value="1951">1951</option>
							<option value="1950">1950</option>
							<option value="1949">1949</option>
							<option value="1948">1948</option>
							<option value="1947">1947</option>
							<option value="1946">1946</option>
							<option value="1945">1945</option>
							<option value="1944">1944</option>
							<option value="1943">1943</option>
							<option value="1942">1942</option>
							<option value="1941">1941</option>
							<option value="1940">1940</option>
							<option value="1939">1939</option>
							<option value="1938">1938</option>
							<option value="1937">1937</option>
							<option value="1936">1936</option>
							<option value="1935">1935</option>
							<option value="1934">1934</option>
							<option value="1933">1933</option>
							<option value="1932">1932</option>
							<option value="1931">1931</option>
							<option value="1930">1930</option>
							<option value="1929">1929</option>
							<option value="1928">1928</option>
							<option value="1927">1927</option>
							<option value="1926">1926</option>
							<option value="1925">1925</option>
							<option value="1924">1924</option>
							<option value="1923">1923</option>
							<option value="1922">1922</option>
							<option value="1921">1921</option>
							<option value="1920">1920</option>
							<option value="1919">1919</option>
							<option value="1918">1918</option>
							<option value="1917">1917</option>
							<option value="1916">1916</option>
							<option value="1915">1915</option>
							<option value="1914">1914</option>
							<option value="1913">1913</option>
							<option value="1912">1912</option>
							<option value="1911">1911</option>
							<option value="1910">1910</option>
							<option value="1909">1909</option>
							<option value="1908">1908</option>
							<option value="1907">1907</option>
							<option value="1906">1906</option>
							<option value="1905">1905</option>
							<option value="1904">1904</option>
							<option value="1903">1903</option>
							<option value="1901">1901</option>
							<option value="1900">1900</option>
						</select>
					</div>


				<div class="row requiredRow">
					<input id="DOBage" name="DOBage" type="checkbox" title="" />
					<span><label for="DOBage" class="accept-terms">I accept the terms and conditions and that I am over the age of 18.</label></span>
				</div>

					<br><br><br>
					<div class="row requiredRow">
						<label for="ccNumber">Credit Card Number</label>
						<input id="ccNumber" name="ccNumber" type="text" onblur="checkFormCreditCard(this);" title="" />
					</div>

					<div class="row requiredRow">
						<label for="month year">Expiry Date</label>
						<select id="month" name="month" title="">
							<option value="01">January</option>
							<option value="02">February</option>
							<option value="03">March</option>
							<option value="04">April</option>
							<option value="05">May</option>
							<option value="06">June</option>
							<option value="07">July</option>
							<option value="08">August</option>
							<option value="09">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
						<select id="year" name="year" title="">
							<option value="16">2016</option>
							<option value="17">2017</option>
							<option value="18">2018</option>
							<option value="19">2019</option>
							<option value="20">2020</option>
							<option value="21">2021</option>

						</select>
					</div>

					<div class="row requiredRow">
						<label for="security">Security number</label>
						<input id="security" name="security" type="text" onblur="checkFormSecurityNum(this);" title="" />
					</div>


				<div class="row">
					<input type="submit" value="Register" />
				</div>
				</form>


	</div>
	</div>
	<div id="footer">

	</div>
	</body>
</html>