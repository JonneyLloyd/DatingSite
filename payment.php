<?php
function checkPayment(){

    $fullname = $_POST['Firstname'] . "+" . $_POST['Surname'];
    $ccNumber = $_POST['ccNumber'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $security = $_POST['security'];


    $curl = curl_init();
// Set some options - we are passing in a useragent too here

    curl_setopt($curl, CURLOPT_URL, 'http://amnesia.csisdmz.ul.ie/4014/cc.php?' . "fullname=" . $fullname . "&ccNumber=" . $ccNumber . "&month=" . $month . "&year=" . $year . "&security=" . $security);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, '3');
    $content = trim(curl_exec($curl));
    curl_close($curl);

    return $content;

}