<?php

require_once("./include/dbConfig.php");


if(isset($_POST['username']))
{
    //checking username available and returning HTML
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
    $query = "SELECT * FROM user where nickname = " . "'" . $username . "'";
    $result = mysqli_query($conn,$query)
    or die ("Couldn't execute query.");
    $row = mysqli_fetch_array($result);
    if ($row[0] != null)
    {
        die('<img src="no.jpg" />');
    }
    else {
        die('<img src="yes.jpg" />');
    }
}

if(isset($_POST['email']))
{
    //checking email available and returning HTML
    $email = filter_var($_POST["email"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
    $query = "SELECT * FROM user WHERE email = " . "'" . $email . "'";
    $result = mysqli_query($conn,$query)
    or die ("Couldn't execute query.");
    $row = mysqli_fetch_array($result);
    if ($row[0] != null)
    {
        die('<img src="no.jpg" />');
    }
    else {
        die('<img src="yes.jpg" />');
    }
}



function selectNameFromID($conn, $id){
    $query = "SELECT f_name, l_name FROM user where user_id = " . "'" . $id . "';";
    $result = mysqli_query($conn,$query)
    or die ("Couldn't execute query.");
    $number=mysqli_num_rows($result);
    echo $number;
    $row = mysqli_fetch_array($result);
    echo $row[0];
}

