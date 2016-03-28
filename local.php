
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
    <title>Dating Website</title>

</head>
<body>
<p> test</p>

<?php
echo "hello";


if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!';
} else {
    echo 'Phew we have it!';
}


$servername = "";
$username = "root";
$password = "";
$dbname = "mydb";
echo "hello";
$conn = new mysqli($servername, $username, $password, $dbname, $port = 3306)
    or die ("Couldn’t connect to server.");


//use htmlspecialchars() on incomung values



function registerUser(){
    $first_name = htmlspecialchars($_POST['Firstname']);
    $surname = htmlspecialchars($_POST['Surname']);
    $email = htmlspecialchars($_POST['Email']);
}


function select_1111($conn){
    $query = "SELECT f_name FROM user where user_id = '1111'";
    $result = mysqli_query($conn,$query)
    or die ("Couldn't execute query.");
    $number=mysqli_num_rows($result);
    echo $number;
    $row = mysqli_fetch_array($result);
echo $row[0];
}

?>

</body>
</head>
</html>