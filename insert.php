<?php
require_once("connectDB.php");

$content = $_POST["content"];

$sql = "INSERT INTO message (memberId, comment,commentTime) VALUES (1, ?, NOW())";

$stmt = $db_link->prepare($sql);
$stmt->bind_param("s",$content);
$stmt->execute();
$stmt->close();

header("Location: message.php");

?>