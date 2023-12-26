<?php
require_once("connectDB.php");

$email = $_POST["email"];
//消毒並確認email格式
$filterEmail = filter_var($email,FILTER_SANITIZE_EMAIL);
if (filter_var($filterEmail,FILTER_VALIDATE_EMAIL)){
    $email = filter_var($filterEmail,FILTER_VALIDATE_EMAIL);
} else {
    // 調整
    $email = false;
}

$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$memberName = $_POST["memberName"];

$sql = "INSERT INTO member (memEmail, memPassword, memName)
    VALUES (?,?,?)";

$stmt = $dbLink->prepare($sql);
$stmt->bind_param("sss",$email, $password, $memberName);

if($stmt->execute()){
    echo "<script type='text/javascript'>alert('註冊成功!'); window.location = '../index.php'</script>";
}else{
    echo "<script type='text/javascript'>alert('註冊失敗!<br/>請重新註冊'); window.location = '../signup.php'</script>";
}
?>