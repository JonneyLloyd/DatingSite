<?php
    require_once("./include/dbConfig.php");

    session_start(); // Starting Session
    $error=''; // Variable To Store Error Message
if((isset($_SESSION['login_user'])) && (isset($_SESSION['user_password']))){
    $query = "UPDATE `group17db`.`login` SET `status` = NOW() WHERE `login`.`user_id` =". $_SESSION['user_id'].  ";";
    $result = mysqli_query($conn,$query)
    or die ("Couldn't execute loginUpdate query.");
}
//compare currdatetime to blocked first and if date is in the past delete entry from blocked table

//ensuring user isn't blocked
//automatically blocks user no matter if they are in the blocked table or not???

/*
 *
    $query = "Select user_id from blocked where user_id = (Select user_id from user Where nickname = '$username')";
    $row = mysqli_query($conn, $query)
    or die ("Couldn't execute blocked table query.");
    if($row > 0){
        header("Location: Blocked.php");
    }
*/
        if (isset($_POST['Asubmit'])) {
            if (empty($_POST['username']) || empty($_POST['password'])) {
                $error = "Username or Password is invalid";
                echo $error;
                header("Location: index.html");
            } else {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $_SESSION['login_user'] = $username;
                $_SESSION['user_password'] = $password;
                header("Location: Profile.php");
            }
        }
            /*
            $connection = mysqli_connect($servername, $dbusername, $password, $dbname, $port = 3307);
            // To protect MySQL injection for Security purpose
            $username = stripslashes($username);
              $password = stripslashes($password);
              $username = mysqli_real_escape_string($username);
             $password = mysqli_real_escape_string($password);
            // SQL query to fetch information of registered users and finds user match.
            $query = mysqli_query("select * from login where password='$password' AND username='$username'", $connection);
            $rows = mysql_num_rows($query);
            if ($rows == 1) {
                $_SESSION['login_user'] = $username; // Initializing Session
                header("location: HomePage.php"); // Redirecting To HomePage
            } else {
                mysqli_close($connection);
                header("location: index.html"); //redirecting to Main page
            }
    else if(isset($_POST['Email'])) {
        if (empty($_POST['username']) || empty($_POST['Password1'])) {
            $error = "Username or Password is invalid";
            echo $error;
            header("Location: LogIn.php");
        } else {
            echo "<h1> test</h1>";
            $_SESSION['login_user'] = strtolower(htmlspecialchars($_POST["username"]));
            $_SESSION['user_password'] = htmlspecialchars($_POST["Password1"]);

            $query1 = "SELECT * from user WHERE nickname =  '" .$_SESSION['login_user'] . "';";
            $result = mysqli_query($conn,$query1)
                or die ("Couldn't execute query login id.");
            $row = mysqli_fetch_array($result);
            $_SESSION['user_id'] = $row['user_id'];

            echo "<h1> id ". strtolower(htmlspecialchars($_POST['username'])) . "</h1>";
            echo "<h1> id ". $row['user_id'] . "</h1>";
            echo "<h1> name ". $_SESSION['login_user'] . "</h1>";
            sleep(5);

        }
    }*/
