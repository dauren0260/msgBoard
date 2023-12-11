<?php
require_once("connectDB.php");
$searchText = $_GET["q]"];

$sql = "SELECT comment, commentNo
        FROM message
        ORDER BY commentNo 
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

// header("Location: message.php");

?>