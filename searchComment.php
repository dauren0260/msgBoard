<?php
require_once("connectDB.php");

$searchText = trim($_GET["search"]);
$pageRow = 3;  //每頁顯示3筆
$pageNumber = 1;  //當前頁數

if(isset($_GET["page"])){
    $pageNumber = $_GET["page"];
}
$startRow = ($pageNumber - 1) * $pageRow;  //本頁開始的筆數

$sql = "SELECT  m.commentNo, m.comment, m.commentTime,
                b.id, b.memName, b.memAvatar 
        FROM message AS m
        LEFT JOIN member AS b 
        ON (m.memberId = b.id)
        WHERE m.comment LIKE '%".$searchText."%'
        ORDER BY m.commentTime 
        DESC";

$allResult = $dbLink->query($sql);

$sql_limit = $sql . " LIMIT " . $startRow . "," . $pageRow;
$result = $dbLink->query($sql_limit);


$resArray = array();
$totalRow = $allResult->num_rows;
$resArray["totalRow"] = $totalRow;  //總筆數
$resArray["pageRow"] = $pageRow;  //每頁顯示筆數
$resArray["pageNumber"] = (int)$pageNumber;  //當前頁數

if($totalRow>0){
        $resArray["totalPage"] = ceil($totalRow/$pageRow);  //總頁數

        while($rowResult = $result->fetch_assoc()){
                
                $resArray["commentArr"][] = array("commentNo" => $rowResult['commentNo'],
                                                "comment" => $rowResult['comment'],
                                                "commentTime" => $rowResult['commentTime'],
                                                "memberId" => $rowResult['id'],
                                                "memName" => $rowResult['memName'],
                                                "memAvatar" => $rowResult['memAvatar']);
        }
}

echo json_encode($resArray);

header("Location: message.php?page=$pageNumber&search=$searchText");
?>