<?php

require_once("connectDB.php");

$account = $_POST["account"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$memberName = $_POST["memberName"];

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

$stmt = $dbLink->prepare($sql);
$stmt->bind_param("ssss",$account, $password, $email, $memberName);

if($stmt->execute()){
    echo "<script type='text/javascript'>alert('註冊成功!'); window.location = 'index.php'</script>";
}else{
    echo "<script type='text/javascript'>alert('註冊失敗!<br/>請重新註冊'); window.location = 'signup.php'</script>";
}
?>