<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
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
        <h1><a href="MainPage.html">Perfect Matches</a></h1>
    </div>
    <div class="navbar">
        <ul>
            <li><a href='Ban_user.php'>Ban User</a></li>
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
    <h3>Mailbox</h3>

    <?php
    $user = $_SESSION['user_id'];
    $query = "SELECT * FROM `admin_mail` order by message_id desc";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute message query.");
    while($row = mysqli_fetch_array($result))
    {
        $sender = $row['sender_id'];
        $message = htmlspecialchars($row['reason']);
        $query2 = "SELECT f_name, l_name, nickname FROM `user` WHERE user_id = '" . $sender . "'";
        $result2 = mysqli_query($conn, $query2)
        or die ("Couldn't execute sender name query.");
        $row2 = mysqli_fetch_array($result2);
        $sender_nickname = $row2['nickname'];
        $sender_f_name = ucfirst(htmlspecialchars($row2['f_name']));
        $sender_l_name = ucfirst(htmlspecialchars($row2['l_name']));

        $reported = $row['reportee_id'];;
        $query3 = "SELECT f_name, l_name, nickname FROM `user` WHERE user_id = '" . $reported . "'";
        $result3 = mysqli_query($conn, $query3)
        or die ("Couldn't execute reported name query.");
        $row3 = mysqli_fetch_array($result3);
        $reported_nickname = $row3['nickname'];
        $reported_f_name = ucfirst(htmlspecialchars($row3['f_name']));
        $reported_l_name = ucfirst(htmlspecialchars($row3['l_name']));
        echo $reported_nickname, $reported_f_name, $reported_l_name, $reported;

        echo "<div class='section'>
            <p></p>
            <div class='thumbnail rounded-frame-small'>
                <img src='uploads/" . $sender_nickname .".jpg' alt='Profile pic' />
                <br />
                <span class='caption'></span>
            </div>
            <div class='section-content'>
                <ul>
                    <p>Report from: " . $sender_f_name . " " .$sender_l_name . ".</p>
                    <p>" . $message . "</p>
                    <br>
                    <form action='Contact.php' method='post' enctype='multipart/form-data'>
					<div class='row'>
						<label for='Profile'></label>
						<input type='hidden' name='contact_id' value='$sender' />
						<input type='hidden' name='contact_f_name' value='$sender_f_name' />
						<input type='submit' value='Reply' name='submit''>
					</div>
					</form>

                </ul>
            </div>
        </div>";
        echo "<div class='section'>
            <p></p>
            <div class='thumbnail rounded-frame-small'>
                <img src='uploads/" . $reported_nickname .".jpg' alt='Profile pic' />
                <br />
                <span class='caption'></span>
            </div>
            <div class='section-content'>
                <ul>
                    <p>Reported: " . $reported_f_name . " " .$reported_l_name . ".</p>
                    <br>
                    <form action='adminDetailView.php' method='post' enctype='multipart/form-data'>
					<div class='row'>
						<label for='Profile'></label>
						<input type='hidden' name='nickname' value='$reported_nickname' />
						<input type='submit' value='View Profile' name='submit''>
					</div>
					</form>

                </ul>
            </div>
        </div>";

    }

    ?>

    <div id="footer">
    </div>
</div>
</body>
</html>
