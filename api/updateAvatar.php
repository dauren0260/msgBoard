<?php
require_once("connectDB.php");
require_once("memberInfo.php");

$sql = "UPDATE member 
SET memAvatar = ?
WHERE id = ?";

$stmt = $dbLink->prepare($sql);
$stmt->bind_param("si", $content, $id);
$stmt->execute();
$stmt->close();


?>