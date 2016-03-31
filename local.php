

<?php header('Access-Control-Allow-Origin: *');

$servername = "";
$serv_username = "root";
$serv_password = "";
$dbname = "mydb";
$conn = new mysqli($servername, $serv_username, $serv_password, $dbname, $port = 3306)
    or die ("Couldn't connect to server.");


//use htmlspecialchars() on incoming values



function registerUser(){
    $first_name = htmlspecialchars($_POST['Firstname']);
    $surname = htmlspecialchars($_POST['Surname']);
    $email = htmlspecialchars($_POST['Email']);
    $password = htmlspecialchars($_POST['Password1']);
    $dob = htmlspecialchars($_POST['DOBday' . '-' . 'DOBmonth' . '-' . 'DOByear']);
}

if(isset($_POST['username']))
{
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


    /*
    $statement = $mysqli->prepare("SELECT nickname FROM user WHERE nickname=?");
    $statement->bind_param('s', $username);
    $statement->execute();
    $statement->bind_result($username);
    if($statement->fetch()){
        die('<img src="no.jpg" />');
    }else{
        die('<img src="yes.jpg" />');
    }
    */
}

/*
function usernameCheck()
{
    $username 	= $_REQUEST['username'];
    $query = "select * from username_availablity where username = '".strtolower($username)."'";
    $results = mysqli_query($conn, $query) or die('ok');

    if(mysqli_num_rows($results) > 0) // not available
    {
        echo '<div id="Error">Already Taken</div>';
    }
    else
    {
        echo '<div id="Success">Available</div>';
    }
}*/

function selectNameFromID($conn, $id){
    $query = "SELECT f_name, l_name FROM user where user_id = " . "'" . $id . "';";
    $result = mysqli_query($conn,$query)
    or die ("Couldn't execute query.");
    $number=mysqli_num_rows($result);
    echo $number;
    $row = mysqli_fetch_array($result);
echo $row[0];
}

