<?php
require_once("connectDB.php");

$name = $_GET["name"];
$sql = "SELECT memAccount 
        FROM member 
        WHERE memAccount = '".$name."'";

$stmt = $dbLink->query($sql);
$result_num = $stmt->num_rows;
echo json_encode($result_num);


?>