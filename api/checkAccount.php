<?php
require_once("connectDB.php");

$email = strtolower($_GET["email"]);
$sql = "SELECT memEmail 
        FROM member 
        WHERE memEmail = '".$email."'";

$stmt = $dbLink->query($sql);
$result_num = $stmt->num_rows;
echo json_encode($result_num);


?>