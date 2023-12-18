<?php

session_start();

// 是否有會員登入
if($_SESSION["userLogIn"]===false){
    header("Location: index.php");
}
// 獲取登入的會員資訊
$sqlMember = "SELECT id, memAccount,memName, memAvatar
                FROM member
                WHERE memAccount = ?";
$stmt = $dbLink->prepare($sqlMember);
$stmt->bind_param("s", $_SESSION["userAccount"]);
$stmt->execute();
$stmt->bind_result($id ,$memAccount, $memName, $memAvatar);
$stmt->fetch();
$stmt -> close();
?>