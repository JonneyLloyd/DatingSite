<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
$banErr = $reasonErr = $exists = $already_banned = $date_error = $interval = "";
if((isset($_SESSION['login_user'])) && (isset($_SESSION['user_password']))) {
    if ($_SESSION['login_user'] != "admin")
        header("location: LogIn.php");


    //get all details for user being viewed
    $nickname = $_POST['nickname'];
    $query = "SELECT * from user WHERE nickname =  '" . $nickname . "';";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute query.");
    $row = mysqli_fetch_array($result);
    $user_id = $row['user_id'];
    $f_name = ucfirst($row['f_name']);
    $l_name = ucfirst($row['l_name']);
    $sexMale = "";
    $sexFemale = "";
    $seekingMale = "";
    $seekingFemale = "";
    $bio = $row['about'];
    if ($bio == null)
        $bio = "Say something about yourself";

    $sex = $row['sex'];
    if ($sex == "m")
        $sexMale = "Checked";
    else
        $sexFemale = "Checked";
    $seeking = $row['seeking'];
    if ($seeking == "m")
        $seekingMale = "Checked";
    else
        $seekingFemale = "Checked";

    $query = "SELECT like_desc FROM `like` WHERE user_id = '" . $user_id . "'";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute query.");
    $counter = 0;
    $like = array(
        0 => "",
        1 => "",
        2 => "",
        3 => "",
        4 => "",
        5 => ""
    );
    while ($row = mysqli_fetch_array($result)) {
        $like[$counter] = $row["like_desc"];
        $counter++;
    }
    $query = "SELECT dislike_desc FROM `dislike` WHERE user_id = '" . $user_id . "'";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute query.");
    $counter = 0;
    $dislike = array(
        0 => "",
        1 => "",
        2 => "",
        3 => "",
        4 => ""
    );
    while ($row = mysqli_fetch_array($result)) {
        $dislike[$counter] = $row["dislike_desc"];
        $counter++;
    }
    //If ban has been submitted handle the post.
    if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['user_ban']))){
        include('BanningProcess.php');

    }
    //If profile change submitted
    if (isset($_POST['gender'])) {
        if (empty($_POST['bio']) || empty($_POST['seeking'])) {
            $error = "Please complete form";
            echo $error;
            header("Location: adminDetails.php");
        } else {
            $sexMale = "";
            $sexFemale = "";
            $seekingMale = "";
            $seekingFemale = "";
            $sex = strtolower(htmlspecialchars($_POST["gender"]));
            if ($sex == "m")
                $sexMale = "Checked";
            else
                $sexFemale = "Checked";
            $pref = strtolower(htmlspecialchars($_POST["seeking"]));
            if ($pref == "m")
                $seekingMale = "Checked";
            else
                $seekingFemale = "Checked";

            $bio = htmlspecialchars($_POST["bio"],ENT_QUOTES);
            $query1 = "SELECT user_id from user WHERE nickname =  '" . $nickname . "';";
            $result = mysqli_query($conn, $query1)
            or die ("Couldn't execute query.");
            $row = mysqli_fetch_array($result);
            $query2 = "UPDATE `user` SET `sex` = '" . $sex . "', `seeking` = '" . $pref .
                "', `about` = '" . $bio . "' WHERE `user`.`user_id` = " . $row[0] . ";";
            $result = mysqli_query($conn, $query2)
            or die ("Couldn't execute query2.");

            $like[0] = strtolower(htmlspecialchars($_POST["Like1"],ENT_QUOTES));
            $like[1] = strtolower(htmlspecialchars($_POST["Like2"],ENT_QUOTES));
            $like[2] = strtolower(htmlspecialchars($_POST["Like3"],ENT_QUOTES));
            $like[3] = strtolower(htmlspecialchars($_POST["Like4"],ENT_QUOTES));
            $like[4] = strtolower(htmlspecialchars($_POST["Like5"],ENT_QUOTES));

            //deleting old likes before inserting new ones
            $query = "DELETE FROM `like` WHERE user_id = '" . $user_id . "'";
            $result = mysqli_query($conn, $query)
            or die ("Couldn't execute delete query.");
            $query_tail = "VALUES ('" . $user_id . "', NULL, '" . $like[0] . "')";
            for ($i = 1; $i < 5; $i++) {
                if ($like != "")
                    $query_tail .= ", ('" . $user_id . "', NULL, '" . $like[$i] . "')";

            }
            //Insert new likes
            $query = "INSERT INTO `like` (`user_id`, `like_id`, `like_desc`)" . $query_tail . ";";
            $result = mysqli_query($conn, $query)
            or die ("Couldn't execute insert like query.");

            $dislike[0] = strtolower(htmlspecialchars($_POST["Dislike1"],ENT_QUOTES));
            $dislike[1] = strtolower(htmlspecialchars($_POST["Dislike2"],ENT_QUOTES));
            $dislike[2] = strtolower(htmlspecialchars($_POST["Dislike3"],ENT_QUOTES));
            $dislike[3] = strtolower(htmlspecialchars($_POST["Dislike4"],ENT_QUOTES));
            $dislike[4] = strtolower(htmlspecialchars($_POST["Dislike5"],ENT_QUOTES));

            //deleting old dislikes before inserting new ones
            $query = "DELETE FROM `dislike` WHERE user_id = '" . $user_id . "'";
            $result = mysqli_query($conn, $query)
            or die ("Couldn't execute delete query.");
            $query_tail = "VALUES ('" . $user_id . "', NULL, '" . $dislike[0] . "')";
            for ($i = 1; $i < 5; $i++) {
                if ($like != "")
                    $query_tail .= ", ('" . $user_id . "', NULL, '" . $dislike[$i] . "')";
            }
            //Insert new dislikes
            $query = "INSERT INTO `group17db`.`dislike` (`user_id`, `dislike_id`, `dislike_desc`)" . $query_tail . ";";
            $result = mysqli_query($conn, $query)
            or die ("Couldn't execute insert dislike query.");
        }
    }
}
else
    header("location: LogIn.php");

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
        <h1><a href="index.html">Perfect Matches</a></h1>
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
    <h3><?= $f_name . " " . $l_name?></h3>
    <h3> Username is: <?= $nickname ?> </h3>


    <div class="section">
        <h3>Details</h3>
        <p>
        <form name="Details" method="post" id="Details"  onsubmit="" >
            <div class="row requiredRow">
                <label for="Sex">I am:</label>
                <input type="radio" name="gender" value="m" <?=$sexMale?>>Male
                <input type="radio" name="gender" value="f"<?=$sexFemale?>>Female<br><br>
            </div>
            <div class="row requiredRow">
                <label for="Seeking">Interested in:</label>
                <input type="radio" name="seeking" value="m" <?=$seekingMale?>>Male
                <input type="radio" name="seeking" value="f" <?=$seekingFemale?>>Female<br><br>
            </div>

            <div class="row requiredRow">
                <label for="Bio">Bio</label>
                <textarea name="bio" input id="bio" type="text"  title=""   rows="4" cols="50"><?=$bio?> </textarea><br><br>

            </div>

            <div class="row">
                <label for="Like1">Like 1</label>
                <input id="Like1" name="Like1" type="text" title="" value="<?=$like[0]?>"/>
            </div>
            <div class="row">
                <label for="Like2">Like 2</label>
                <input id="Like2" name="Like2" type="text" title=""  value="<?=$like[1]?>"/>
            </div>
            <div class="row">
                <label for="Like3">Like 2</label>
                <input id="Like3" name="Like3" type="text" title=""  value="<?=$like[2]?>"/>
            </div>
            <div class="row">
                <label for="Like4">Like 4</label>
                <input id="Like4" name="Like4" type="text" title=""  value="<?=$like[3]?>"/>
            </div>
            <div class="row">
                <label for="Like5">Like 5</label>
                <input id="Like5" name="Like5" type="text" title=""  value="<?=$like[4]?>"/>
            </div>
            <br><br>
            <div class="row">
                <label for="Dislike 1">Dislike 1</label>
                <input id="Dislike1" name="Dislike1" type="text" title=""  value="<?=$dislike[0]?>"/>
            </div>
            <div class="row">
                <label for="Dislike 2">Dislike 2</label>
                <input id="Dislike2" name="Dislike2" type="text" title=""  value="<?=$dislike[1]?>"/>
            </div>
            <div class="row">
                <label for="Dislike 3">Dislike 3</label>
                <input id="Dislike3" name="Dislike3" type="text" title=""  value="<?=$dislike[2]?>"/>
            </div>
            <div class="row">
                <label for="Dislike 4">Dislike 4</label>
                <input id="Dislike4" name="Dislike4" type="text" title=""  value="<?=$dislike[3]?>"/>
            </div>
            <div class="row">
                <label for="Dislike 5">Dislike 5</label>
                <input id="Dislike5" name="Dislike5" type="text" title=""  value="<?=$dislike[4]?>"/>
            </div>
            <input type='hidden' name='nickname' value='<?=$nickname?>' />

            <div class="row">
                <input type="submit" value="Update" />
            </div>
        </form>
        <br><br><br>
        <form action="upload.php" method="post" enctype="multipart/form-data" >
            <div class="row">
                <label for="Profile">Change Profile Pic:</label>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Upload Image" name="submit">
                <input type='hidden' name='nickname' value='<?=$nickname?>' />
            </div>
        </form>
        <div class="thumbnail rounded-frame-small">
            <?="<img src='uploads/" .  $nickname . ".jpg' alt='Profile pic' />"?>
            <br />
            <span class="caption"></span>
        </div>
        <form name = 'contact' action='' method='post' >
            <h3>Ban User</h3>
            <p>
                Ban user: <?=$f_name . " " . $l_name?>
                <input type="hidden" readonly name="user_ban" value = "<?=$nickname?>"> <?= $banErr?><br />
                <input type='hidden' name='nickname' value='<?=$nickname?>' />
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