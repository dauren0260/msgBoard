<?php
require_once("connectDB.php");

$content = htmlentities($_POST["content"], ENT_QUOTES, "utf-8");

$sql = "INSERT INTO message (memberId, comment,commentTime) VALUES (1, ?, NOW())";

$stmt = $dbLink->prepare($sql);
$stmt->bind_param("s",$content);
$stmt->execute();
$stmt->close();

header("Location: message.php");

?>