<?php
require_once("connectDB.php");

$pageRow = 3;  //每頁顯示3筆
$pageNumber = 1;  //當前頁數

if(isset($_GET['page'])){
    $pageNumber = $_GET['page'];
}

$startRow = ($pageNumber - 1) * $pageRow;  //本頁開始的筆數

$sql = "SELECT b.id, b.memName, b.memAvatar, 
                m.commentNo, m.comment, m.commentTime 
        FROM message AS m
        LEFT JOIN member AS b
        ON (m.memberId = b.id)";

if(isset($_GET['search'])){
    $searchText = trim($_GET['search']);
    $searchHref = "&search=".$searchText."";
    $sql = $sql . "WHERE m.comment LIKE '%".$searchText."%'";
}else{
    $searchText = "";
    $searchHref = "";
}

$sql = $sql . "ORDER BY m.commentTime DESC";

$sql_limit = $sql . " LIMIT " . $startRow . "," . $pageRow;
$allResult = $db_link->query($sql);
$result = $db_link->query($sql_limit);

$totalRow = $allResult->num_rows;   //總筆數
$totalPage = ceil($totalRow/$pageRow);  //總頁數
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js" integrity="sha512-b94Z6431JyXY14iSXwgzeZurHHRNkLt9d6bAHt7BZT38eqV+GyngIi/tVye4jBKPYQ2lBdRs0glww4fmpuLRwA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="./assets/css/index.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/message.css" type="text/css">
    <title>Document</title>
</head>

<body>
    <div class="title">留言版</div>
    
        <form action="searchComment.php" method="get">
            <div class="searchArea">
                搜尋留言 <input type="text" name="search" class="searchInput" id="searchInput">
                <button type="submit" class="btn btn-outline-primary" onSubmit="searchComment()">搜尋</button>
            </div>
        </form>

        <div id="containerArea">

        <?php
        if( $totalRow == 0){
            echo "<script type='text/javascript'>alert('Oops! 沒有任何查詢結果');</script>";
        }

        while($row_result = $result->fetch_assoc()){
            echo ' <div class="container">
                        <div class="contentArea" id="contentArea'.$row_result["commentNo"].'">
                            <div class="avatar">
                                <img src="./assets/img/member/'. $row_result["memAvatar"] .'" alt="avatar">
                            </div>
                            <div class="memContent">
                                <div class="memberName">'.$row_result["memName"].'</div>
                                <div class="commentTime">'.$row_result["commentTime"].'</div>
                            </div>
                            <div class="msgContent showContent" id="msgContent'.$row_result["commentNo"].'">
                                '.nl2br($row_result["comment"]).'
                            </div>
                        </div>
                        <div class="actionArea">
                            <div class="edit">
                                <a href="update.php?page='.$pageNumber.'&commentNo='.$row_result["commentNo"].''.$searchHref.'" class="btn btn-outline-secondary">編輯</a>
                            </div>
                            <div class="delete">
                                <a href="javascript:void(0)" onClick="dropData('.$row_result["commentNo"].')" class="btn btn-outline-warning">刪除</a>
                            </div>
                            <input type="hidden" name="commentNo'.$row_result["commentNo"].'"  value="'.$row_result["commentNo"] . '" class="hiddenInput">
                            <input type="hidden" name="memId'.$row_result["commentNo"].'" value="'.$row_result["id"] . '">                    
                        </div>
                    </div>';
        }
        ?>
        </div>

        <div class="pagination_block">
            <ul class="pagination" id="pagination">
                <?php
                if($totalRow > 3){
                    for($i=1; $i<=$totalPage; $i++){
                        if($i==$pageNumber){
                            echo '<li><a href="message.php?page='.$i.''.$searchHref.'" class="on">'.$i.'</a></li>';
                        }else{
                            echo '<li><a href="message.php?page='.$i.''.$searchHref.'">'.$i.'</a></li>';
                        }
                    }
                }
                ?>
            </ul>
        </div>

    <form action="insert.php" method="post" class="insert">
        <div class="msgContainer">
            <div class="avatar commentAvatar">
                <img src="./assets/img/member/memDefault.png" alt="avatar">
                <div class="username">訪客</div>
            </div>
            <textarea name="content" id="content" cols="50" rows="5" required></textarea>
        </div>
        <button type="submit" value="send" class="btn btn-outline-primary">送出</button>
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