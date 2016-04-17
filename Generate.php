<?php
require_once("./include/dbConfig.php");

for($count = 0; $count<1000; $count++) {
    $password = 'abcd123';
    $nickname = $count . 'a';
    $f_name = "firstname";
    $l_name = "lastname";
    $sex = "m";
    $seeking = "f";
    $DOB = "1990-01-01";
    $bio = NULL;
    $email = $nickname . "@gmail.com";

    $query = "INSERT INTO user(user_id, password, nickname, f_name, l_name, sex, seeking, dob, about, email) 
              VALUES (NULL,'$password','$nickname','$f_name','$l_name', '$sex', '$seeking', '$DOB', '$bio', '$email')";
    $result = mysqli_query($conn, $query)
    or die ("Couldn't execute query generate.");
}
?>
<html>
    <body>
        <h1>query complete!</h1>
    </body>
</html>