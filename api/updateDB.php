<?php
require_once("connectDB.php");
require_once("memberInfo.php");

$content = htmlentities($_POST["content"], ENT_QUOTES, "utf-8");

if($_SERVER["REQUEST_METHOD"]=="POST"){

        $sql = "UPDATE message 
        SET comment = ?, commentTime = NOW()
        WHERE commentNo = ?";

        $stmt = $dbLink->prepare($sql);
        $stmt->bind_param("si", $content, $_POST["commentNo"]);
        $stmt->execute();
        $stmt->close();

        header("Location: ../message.php");
}

?>