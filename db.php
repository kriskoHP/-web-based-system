<?php
if(!defined('SITE')){
    die("Грешка");
}

//connnection data
$db_host = "localhost";
$db_user = 'root';
$db_pass = '';
$db_database = 'autovesperfect';

$conn = @mysqli_connect($db_host, $db_user, $db_pass, $db_database );

if(!$conn){
    die("няма връзка с база данни");
}

//проверка на връзката
//echo 'Връзката е установена';
