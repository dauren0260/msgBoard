<?php
if($_SERVER["REQUEST_METHOD"]=="GET"){
    
    require_once("logOut.php");
    header("Location: ../index.php");
    exit;
}

require_once("connectDB.php");
require_once("memberInfo.php");

$oldPassword = $_POST["oldPsw"];
$newPassword = password_hash($_POST["newPsw"], PASSWORD_DEFAULT);

// 輸入的舊密碼與原有密碼相同
if(password_verify($oldPassword, $memPassword)){

    $sql = "UPDATE member 
    SET memPassword = ?
    WHERE id = ?";

    $stmt = $dbLink->prepare($sql);
    $stmt->bind_param("si", $newPassword, $id);
    $stmt->execute();
    $stmt->close();

    $res["error"] = false;
    echo json_encode($res);

}else{
    $res["error"] = true;
    echo json_encode($res);
}
?>