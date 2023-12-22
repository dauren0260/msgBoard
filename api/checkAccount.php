<?php
require_once("connectDB.php");

$email = strtolower($_GET["email"]);
$sql = "SELECT memEmail 
        FROM member 
        WHERE memEmail = ?";

$stmt = $dbLink->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$resultNumber = $result->num_rows; 
echo json_encode($resultNumber);
?>