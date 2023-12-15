<?php
require_once("connectDB.php");

$sql = "DELETE FROM message
        WHERE commentNo = ?";

$stmt = $dbLink->prepare($sql);
$stmt->bind_param("s" ,$_GET["commentNo"]);
$stmt->execute();
$stmt->close();

header("Location: message.php");

?>