<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php');
//check user is logged in
if((! isset($_SESSION['login_user'])) || (! isset($_SESSION['user_password']))) {
    header("location: LogIn.php");
}
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
	<h3>Mailbox</h3>

<?php
//pagination setup
$user = $_SESSION['user_id'];
$perPage = 10;
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
if ($page == 0) $page = 1;
$startAt = $perPage * ($page - 1);

$query = "SELECT COUNT(*) as total FROM `messages` WHERE receiver_id = '" . $user . "';";
$r = mysqli_fetch_assoc(mysqli_query($conn, $query));

$totalPages = ceil($r['total'] / $perPage);
$i = $page;
$prev = $i-1;
$next = $i+1;
if ($prev == 0) $prev = 1;
if ($next == $totalPages + 1) $next = $totalPages;
$links = "<ul class='pagination'>";
$links .= "<li><a href='Mailbox.php?page=$prev'>Previous</a></li> ";
$links .= "<li><a> $page </a></li>";
$links .= "<li><a href='Mailbox.php?page=$next'>Next</a></li> ";
$links .= "</ul>";


//getting message for the user
$query = "SELECT * FROM `messages` WHERE receiver_id = '" . $user . "' order by message_id desc LIMIT " . $startAt . "," . $perPage . ";";
$result = mysqli_query($conn, $query)
or die ("Couldn't execute message query.");
while($row = mysqli_fetch_array($result))
{
	//loop through results and display on screen
    $sender = $row['sender_id'];
    $message = $row['message_body'];
    $query2 = "SELECT f_name, l_name, nickname FROM `user` WHERE user_id = '" . $sender . "'";
    $result2 = mysqli_query($conn, $query2)
    or die ("Couldn't execute name query.");
	$row2 = mysqli_fetch_array($result2);
	$receiver_nickname = $row2['nickname'];
    $sender_f_name = ucfirst(htmlspecialchars($row2['f_name']));
	if ($row2['f_name'] == "admin")
		$sender_l_name = "No-Reply";
	else
		$sender_l_name = ucfirst(htmlspecialchars($row2['l_name']));
	$now = date("Y-m-d H:i:s", time());
	$sent_time = $row['time_sent'];
	$hour_correction = 3600;
	$diff = (abs(strtotime($now) - strtotime($sent_time)))- $hour_correction ;
	$years = abs(floor($diff / 31536000));
	$days = abs(floor(($diff-($years * 31536000))/86400));
	$hours = abs(floor(($diff-($years * 31536000)-($days * 86400))/3600));
	$mins = abs(floor(($diff-($years * 31536000)-($days * 86400)-($hours * 3600))/60));


	$min_tag = "Minutes";
	if ($mins == 1) $min_tag = "Minute";

	$hour_tag = "Hours";
	if ($hours == 1) $hour_tag = "Hour";

	$day_tag = "Days";
	if ($days == 1) $day_tag = "Day";
	//check timing to only display years, days etc when relevant
	$year_tag = "Years";
	if ($years == 1) $year_tag = "Year";
	if ($diff < 60)
		$time_print = "Just now";
	else if ($diff < 3600)
		$time_print = $mins . " ". $min_tag. " ago.";
	else if ($diff < 86400)
		$time_print = $hours . " " . $hour_tag . ", " . $mins . " ". $min_tag. " ago.";
	else if ($diff < 31536000)
		$time_print = $days . " " . $day_tag . ", " . $hours . " " . $hour_tag . ", " . $mins . " ". $min_tag. " ago.";
	else
		$time_print = $years . " " . $year_tag . ", " . $days . " " . $day_tag . ", " . $hours . $hour_tag . ", " . $mins . " ". $min_tag. " ago.";




    echo "<div class='section'>
            <p></p>
            <div class='thumbnail rounded-frame-small'>
                <img src='uploads/" . $receiver_nickname .".jpg' alt='Profile pic' />
                <br />
                <span class='caption'></span>
            </div>
            <div class='section-content'>
                <ul>
                    <p>Message from: " . $sender_f_name . " " .$sender_l_name . ".</p>
                    <p>" . $message . "</p> 
                    <br> 
                    <p>Sent: " .$time_print . "</p>";
	if ($sender_l_name != "No-Reply"){
		echo "<form action='Contact.php' method='post' enctype='multipart/form-data'>
					<div class='row'>
						<label for='Profile'></label>
						<input type='hidden' name='contact_id' value='$sender' />
						<input type='hidden' name='contact_f_name' value='$sender_f_name' />
						<input type='submit' value='Reply' name='submit''>
					</div>
					</form>";
					}
			echo "

                </ul>
            </div>
        </div>";

}
echo $links; // show links to other pages
?>

<div id="footer">
    </div>
</div>
</body>
</html>


