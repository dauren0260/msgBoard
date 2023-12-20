<?php

session_start();

// 是否有會員登入
if( !isset($_SESSION["userLogIn"]) ||  $_SESSION["userLogIn"]===false){
    header("Location: index.php");
}

if(isset($_SESSION["userLogIn"]) && $_SESSION["userLogIn"]){
    // 獲取登入的會員資訊
    $sqlMember = "SELECT id, memAccount,memName, memAvatar, memEmail
                    FROM member
                    WHERE memAccount = ?";
    $stmt = $dbLink->prepare($sqlMember);
    $stmt->bind_param("s", $_SESSION["userAccount"]);
    $stmt->execute();
    $stmt->bind_result($id ,$memAccount, $memName, $memAvatar, $memEmail);
    $stmt->fetch();
    $stmt -> close();
}
?>