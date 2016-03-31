<?php
$servername = "";
$serv_username = "root";
$serv_password = "";
$dbname = "group17db";
$conn = new mysqli($servername, $serv_username, $serv_password, $dbname, $port = 3306)
or die ("Couldn't connect to server.");