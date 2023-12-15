<?php
require_once("connectDB.php");

$account = $_POST["account"];
$postPassword = $_POST["password"];

$sql = "SELECT id, memAccount, memPassword
        FROM member
        WHERE memAccount = ?";

$stmt = $dbLink->prepare($sql);
$stmt->bind_param("s", $account);

if($stmt->execute()){
    $stmt->bind_result($id ,$memAccount, $hashPassword);
    $stmt->fetch();

    if (password_verify($postPassword, $hashPassword)) {
        echo "<script type='text/javascript'>window.location = 'message.php'</script>";
    } else {
        echo "<script type='text/javascript'>alert('帳號或密碼錯誤'); window.location = 'index.php'</script>";
    }
}
?>