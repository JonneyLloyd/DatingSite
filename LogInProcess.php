<?php
    session_start(); // Starting Session
    $error=''; // Variable To Store Error Message
    if (isset($_POST['Asubmit'])) {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            $error = "Username or Password is invalid";
            echo $error;
            header("Location: MainPage.html");
        } else {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $_SESSION['login_user'] = $username;
            $_SESSION['user_password'] = $password;
            header("Location: HomePage.html");
            /*$connection = mysqli_connect($servername, $dbusername, $password, $dbname, $port = 3307);
            // To protect MySQL injection for Security purpose
            /**$username = stripslashes($username);
             * $password = stripslashes($password);
             * $username = mysqli_real_escape_string($username);
             * $password = mysqli_real_escape_string($password);*/
            // SQL query to fetch information of registered users and finds user match.
            /*$query = mysqli_query("select * from login where password='$password' AND username='$username'", $connection);
            $rows = mysql_num_rows($query);
            if ($rows == 1) {
                $_SESSION['login_user'] = $username; // Initializing Session
                header("location: HomePage.php"); // Redirecting To HomePage
            } else {
                mysqli_close($connection);
                header("location: MainPage.html"); //redirecting to Main page
            }*/
        }
    }
    else if(isset($_POST['Email'])) {
        if (empty($_POST['username']) || empty($_POST['Password1'])) {
            $error = "Username or Password is invalid";
            echo $error;
            header("Location: MainPage.html");
        } else {
            $_SESSION['login_user'] = strtolower(htmlspecialchars($_POST["username"]));
            $_SESSION['user_password'] = htmlspecialchars($_POST["Password1"]);

        }
    }

?>