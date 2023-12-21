<?php
require_once("connectDB.php");
require_once("memberInfo.php");

$content = htmlentities($_POST["content"], ENT_QUOTES, "utf-8");

$sql = "INSERT INTO message (memberId, comment,commentTime) VALUES (?, ?, NOW())";

$stmt = $dbLink->prepare($sql);
$stmt->bind_param("is",$id ,$content);
$stmt->execute();
$stmt->close();

header("Location: ../message.php");

?>