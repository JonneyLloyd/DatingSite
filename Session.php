<?php
    //DOUBLE CHECK ALL OF THISSSSSSS
    //SHOULD ALL WORK IN CSIS I THINK???
    $servername = "193.1.101.7";
    $dbusername = "group17";
    $password = "bc7u7T8L9";
    $dbname = "group17";
    $connection = mysqli_connect($servername, $dbusername, $password, $dbname, $port = 3307);
    session_start();// Starting Session
    $user_check=$_SESSION['login_user'];
    $password_check =$_SESSION['user_password'];
    // SQL Query To Fetch Complete Information Of User
    $ses_sql=mysqli_query("select username from login where username='$user_check' AND password='$user_password'", $connection);
    $row = mysqli_fetch_assoc($ses_sql);
    $login_session =$row['username'];
    if(!isset($login_session)){
        mysqli_close($connection); // Closing Connection
    }
    //header('Location: MainPage.php');