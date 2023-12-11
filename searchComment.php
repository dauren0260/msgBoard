<?php
require_once("connectDB.php");
$searchText = $_GET["q"];

$sql = "SELECT comment, commentNo, commentTime
        FROM message
        ORDER BY commentTime 
        DESC";

$result = $db_link->query($sql);

$resArray = array();
while($row_result = $result->fetch_assoc()){

    $searchResult = strpos($row_result["comment"], $searchText);

    if($searchResult !== false){
        $resArray[] = $row_result["commentNo"];
    }else{
        continue;
    }
}

echo json_encode($resArray);
?>