<?php
require_once("connectDB.php");
session_start();
$email = strtolower($_POST["email"]);
$postPassword = $_POST["password"];

$sql = "SELECT id, memEmail, memPassword
        FROM member
        WHERE memEmail = ?";

$stmt = $dbLink->prepare($sql);
$stmt->bind_param("s", $email);

if($stmt->execute()){
    $stmt->bind_result($id ,$memEmail, $hashPassword);
    $stmt->fetch();

    if (password_verify($postPassword, $hashPassword)) {

        $_SESSION["userLogIn"] = true;
        $_SESSION["userAccount"] = $email;

        header("Location: ../message.php");
        exit;
        // echo "<script type='text/javascript'>window.location = 'message.php'</script>";
    } else {
        echo "<script type='text/javascript'>alert('帳號或密碼錯誤'); window.location = '../index.php'</script>";
    }
}
?>