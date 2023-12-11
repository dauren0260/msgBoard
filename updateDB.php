<?php
require_once("connectDB.php");

$sql = "UPDATE message 
        SET comment = ?, commentTime = NOW()
        WHERE commentNo = ?";

$stmt = $db_link->prepare($sql);
$stmt->bind_param("ss", $_POST["content"],$_POST["commentNo"]);
$stmt->execute();
$stmt->close();

header("Location: message.php");
?>