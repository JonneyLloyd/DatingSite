<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
if((isset($_SESSION['login_user'])) && ($_SESSION['login_user'] == "admin" )) {

}
else
	header("location: LogIn.php");

//display blocked users and display if permenent or temporary
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
	<h3>Banned users</h3>
<?php
if (isset($_POST['bannedID'])){
	$query = "DELETE FROM `blocked` WHERE user_id = '" . $_POST['bannedID'] . "';";
	$result = mysqli_query($conn, $query)
	or die ("Couldn't execute delete blocked query." . $query);


}
	$perPage = 10;
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	if ($page == 0) $page = 1;
	$startAt = $perPage * ($page - 1);

	$query = "SELECT COUNT(*) as total FROM `blocked`";
	$r = mysqli_fetch_assoc(mysqli_query($conn, $query));

	$totalPages = ceil($r['total'] / $perPage);
	$i = $page;
	$prev = $i-1;
	$next = $i+1;
	if ($prev == 0) $prev = 1;
	if ($next == $totalPages + 1) $next = $totalPages;
	$links = "<ul class='pagination'>";
		$links .= "<li><a href='Browse.php?page=$prev'>Previous</a></li> ";
		$links .= "<li><a> $page </a></li>";
		$links .= "<li><a href='Browse.php?page=$next'>Next</a></li> ";
		$links .= "</ul>";

	$query = "SELECT * FROM `user` join `blocked` on `user`.user_id = `blocked`.user_id LIMIT " . $startAt . "," . $perPage . ";";
	$result = mysqli_query($conn, $query)
	or die ("Couldn't execute blocked query." . $query);

	while($r = mysqli_fetch_array($result)) {
		$id = $r['user_id'];
		$f_name = ucfirst($r['f_name']);
		$reason = ucfirst($r['reason']);
		$end_date = ($r['end_date']);



	echo "<div class='section'>
		<p>$f_name | $reason | $end_date </p>
		 <form name = 'removeBan' id ='removeBan' action='' method='post' >
            <div class='row requiredRow'>
                <label for='message'></label>
                <input type='hidden' name='bannedID' value='$id' />
                <input type='submit' value='Remove Ban' />
                <p></p>
            </div>
        </form>

		<br>

	</div>";
	}
	echo $links; // show links to other pages



	?>

	</div>
	<div id="footer">
	</div>
</body>
</html>