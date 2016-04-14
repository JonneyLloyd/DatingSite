<?php
$servername = "193.1.101.7";
$serv_username = "group17";
$serv_password = "bc7wzT8L9";
$dbname = "group17DB";
$conn = new mysqli($servername, $serv_username, $serv_password, $dbname, $port = 3307)
or die ("Couldn't connect to server.");