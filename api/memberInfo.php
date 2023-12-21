<?php
session_start();

// 是否有會員登入
if( !isset($_SESSION["userLogIn"]) ||  $_SESSION["userLogIn"]==false){
    header("Location: ../index.php");
    exit;
}

if(isset($_SESSION["userLogIn"]) && $_SESSION["userLogIn"]==true){
    // 獲取登入的會員資訊
    $sqlMember = "SELECT id,memEmail,memPassword,memName, memAvatar
                    FROM member
                    WHERE memEmail = ?";
    $stmt = $dbLink->prepare($sqlMember);
    $stmt->bind_param("s", $_SESSION["userAccount"]);
    $stmt->execute();
    $stmt->bind_result($id ,$memEmail,$memPassword ,$memName, $memAvatar);
    $stmt->fetch();
    $stmt -> close();
}
?>