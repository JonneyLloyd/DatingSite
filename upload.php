<?php
require_once("./include/dbConfig.php");
include('LogInProcess.php'); // Includes Login Script
/*
$query1 = "SELECT user_id from user WHERE nickname =  '" .$_SESSION['login_user'] . "';";
$result = mysqli_query($conn,$query1)
or die ("Couldn't execute query.");
$row = mysqli_fetch_array($result);*/
$user = $_SESSION['login_user'];
if (isset($_POST['nickname'])) $user = $_POST['nickname'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$outputFile = $target_dir . $user . "." . $imageFileType;
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg"){
//&& $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $outputFile )) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        include_once("image_resizer.php");
        $target_file = $outputFile;
        $resized_file = $outputFile;
        $wmax = 150;
        $hmax = 150;
        img_resize($target_file, $resized_file, $wmax, $hmax, $imageFileType);
        if (isset($_POST['nickname'])) header("Location: admin.php");
        else header("Location: Details.php");



    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
if (isset($_POST['nickname'])) header("Location: admin.php");
else header("Location: Details.php");
?>