<?php
$dbhost = "localhost";
$user = "root";
$password = "root1204";
$dbname = "board";

$db_link = new mysqli($dbhost, $user, $password, $dbname);

if($db_link->connect_error != ""){
    echo "failed connect to Database";
}else{
    $db_link -> query("SET NAMES 'utf8'");
}


?>