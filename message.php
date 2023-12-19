<?php
require_once("connectDB.php");

$pageRow = 3;  //每頁顯示3筆
$pageNumber = 1;  //當前頁數

if(isset($_GET["page"])){
    $pageNumber = $_GET["page"];
}

$startRow = ($pageNumber - 1) * $pageRow;  //本頁開始的筆數

$sql = "SELECT b.id, b.memName, b.memAvatar, 
                m.commentNo, m.comment, m.commentTime 
        FROM message AS m
        LEFT JOIN member AS b
        ON (m.memberId = b.id)";

if(isset($_GET["search"])){
    $searchText = trim($_GET["search"]);
    $searchHref = "&search=".$searchText."";
    $sql = $sql . "WHERE m.comment LIKE '%".$searchText."%'";
}else{
    $searchText = "";
    $searchHref = "";
}

$sql = $sql . "ORDER BY m.commentTime DESC";

$sqlLimit = $sql . " LIMIT " . $startRow . "," . $pageRow;
$allResult = $dbLink->query($sql);
$result = $dbLink->query($sqlLimit);

$totalRow = $allResult->num_rows;   //總筆數
$totalPage = ceil($totalRow/$pageRow);  //總頁數
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/index.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/message.css" type="text/css">
    <title>留言版</title>
</head>
<body>
    <div class="title">留言版</div>
    
        <form action="message.php" method="get">
            <div class="searchArea">
                搜尋留言 <input type="text" name="search" class="searchInput" id="searchInput" autocomplete="off" value=<?php echo $searchText?>>
                <button type="submit" class="btn btnPrimary" onSubmit="searchComment()">搜尋</button>
            </div>
        </form>

        <div id="containerArea">
        <?php
        if( $totalRow == 0){
            echo "<script type='text/javascript'>alert('Oops! 沒有任何查詢結果');</script>";
        }

        while($rowResult = $result->fetch_assoc()){
            echo ' <div class="container">
                        <div class="contentArea" id="contentArea'.$rowResult["commentNo"].'">
                            <div class="avatar">
                                <img src="./assets/img/member/'. $rowResult["memAvatar"] .'" alt="avatar">
                            </div>
                            <div class="memContent">
                                <div class="memberName">'.$rowResult["memName"].'</div>
                                <div class="commentTime">'.$rowResult["commentTime"].'</div>
                            </div>
                            <div class="msgContent showContent" id="msgContent'.$rowResult["commentNo"].'">
                                '.nl2br($rowResult["comment"]).'
                            </div>
                        </div>
                        <div class="actionArea">
                            <div class="edit">
                                <a href="update.php?page='.$pageNumber.'&commentNo='.$rowResult["commentNo"].''.$searchHref.'" class="btn btnSecondary">編輯</a>
                            </div>
                            <div class="delete">
                                <a href="javascript:void(0)" onClick="dropData('.$rowResult["commentNo"].')" class="btn btnWarning">刪除</a>
                            </div>
                            <input type="hidden" name="commentNo'.$rowResult["commentNo"].'"  value="'.$rowResult["commentNo"] . '" class="hiddenInput">
                            <input type="hidden" name="memId'.$rowResult["commentNo"].'" value="'.$rowResult["id"] . '">                    
                        </div>
                    </div>';
        }
        ?>
            <div class="paginationBlock">
            <ul class="pagination" id="pagination">
                <?php
                    $basePageRow = 5; //每組分頁有五頁
                    if($totalRow > $pageRow){

                        // 小於等於5頁，直接打印頁碼
                        if( $totalPage <= $basePageRow){
                            for( $i=1; $i <= $totalPage; $i++){
                                if($i==$pageNumber){
                                    echo '<li><a href="message.php?page='.$i.''.$searchHref.'" class="on">'.$i.'</a></li>';
                                }else{
                                    echo '<li><a href="message.php?page='.$i.''.$searchHref.'">'.$i.'</a></li>';
                                }
                            }
                        }else{
                            // 現在是第幾組分頁
                            $currentGroup = ceil($pageNumber/$basePageRow);
                            
                            //起始頁 1、6、11
                            $startPage = $basePageRow * ($currentGroup-1) + 1;

                            //下五組頁數的起始頁 6、11、16
                            $nextPage =  $startPage + $basePageRow;  
                            
                            // 計算頁數迴圈最後一圈的數字 $loopPage 
                            if($basePageRow * $currentGroup >= $totalPage){
                                $loopPage = $totalPage;
                                $nextPage = false;
                            }else{
                                $loopPage = $basePageRow*$currentGroup;
                            }

                            // 起始頁不為1時，前五頁的<<按鈕要出現，此時$currentGroup至少為2以上
                            if($startPage != 1){
                                echo '<li><a href="message.php?page='.(($currentGroup-1)*$basePageRow).''.$searchHref.'">&#171;</a></li>';
                            }

                            for( $i = $startPage; $i <= $loopPage; $i++){
                                if($i==$pageNumber){
                                    echo '<li><a href="message.php?page='.$i.''.$searchHref.'" class="on">'.$i.'</a></li>';
                                }else{
                                    echo '<li><a href="message.php?page='.$i.''.$searchHref.'">'.$i.'</a></li>';
                                }
                            }
                            // 當前頁數不等於下五組頁碼時才出現
                            if($nextPage && $pageNumber < $nextPage){
                                echo '<li><a href="message.php?page='.$nextPage .''.$searchHref.'">&#187;</a></li>';
                            }
                        }
                    }
                ?>
                </ul>
            </div>
        </div>

    <form action="insert.php" method="post" class="insert">
        <div class="msgContainer">
            <div class="avatar commentAvatar">
                <img src="./assets/img/member/memDefault.png" alt="avatar">
                <div class="username">哆啦美</div>
            </div>
            <textarea name="content" id="content" cols="50" rows="5" required></textarea>
        </div>
        <button type="submit" value="send" class="btn btnPrimary">送出</button>
    </form>
    <script>
        function dropData(params, e) {
            if(confirm("確認刪除留言?")){
                window.location =  `deleteData.php?commentNo=${params}`;
            }else{
                e.preventDefault();
            }
        }
    </script>
</body>
</html>