<?php

require_once("connectDB.php");

$account = htmlentities($_POST["account"], ENT_QUOTES, 'utf-8');
$password = htmlentities($_POST["password"], ENT_QUOTES, 'utf-8');
$memberName = htmlentities($_POST["memberName"], ENT_QUOTES, 'utf-8');

$email = $_POST["email"];
//消毒並確認email格式
$filterEmail = filter_var($email,FILTER_SANITIZE_EMAIL);
if (filter_var($filterEmail,FILTER_VALIDATE_EMAIL)){
    $email = filter_var($filterEmail,FILTER_VALIDATE_EMAIL);
} else {
    $email = false;
}

$sql = "INSERT INTO member (memAccount,memPassword, memEmail, memName)
    VALUES (?,?,?,?)";

$stmt = $db_link->prepare($sql);
$stmt->bind_param("ssss",$account, $password, $email, $memberName);
$stmt->execute();

header("Location: index.php");



?>