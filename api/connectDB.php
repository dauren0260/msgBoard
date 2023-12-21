<?php
$dbHost = "localhost";
$user = "root";
$passWord = "root1204";
$dbName = "board";

$dbLink = new mysqli($dbHost, $user, $passWord, $dbName);

if($dbLink->connect_error != ""){
    echo "failed connect to Database";
}else{
    $dbLink -> query("SET NAMES 'utf8'");
}


?>