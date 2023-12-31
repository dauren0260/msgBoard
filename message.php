<?php
require_once("connectDB.php");

$sql = "SELECT b.id, b.memName, b.memAvatar, 
                m.commentNo, m.comment, m.commentTime 
        FROM message AS m
        LEFT JOIN member AS b
        ON (m.memberId = b.id)
        ORDER BY m.commentNo 
        DESC";
$result = $db_link->query($sql);
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
    
        <div class="searchArea">
            搜尋留言 <input type="text" name="searchInput" class="searchInput" id="searchInput">
            <button type="button" class="btn btn-outline-primary" onClick="searchComment()">搜尋</button>
        </div>

        <?php
        while($row_result = $result->fetch_assoc()){
            echo ' <div class="container">
                        <div class="contentArea" id="contentArea'.$row_result["commentNo"].'">
                            <div class="avatar">
                                <img src="./assets/img/'. $row_result["memAvatar"] .'" alt="avatar">
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
                                <a href="update.php?commentNo='.$row_result["commentNo"].'" class="btn btn-outline-secondary">編輯</a>
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
        

    <form action="insert.php" method="post">
        <div class="msgContainer">
            <div class="avatar commentAvatar">
                <img src="./assets/img/memDefault.png" alt="avatar">
                <div class="username">訪客</div>
            </div>
            <textarea name="content" id="content" cols="50" rows="5"></textarea>
            <button type="submit" value="send" class="btn btn-outline-primary">Send</button>
        </div>
    </form>
    <script>
        function searchComment(){
            let searchInput = document.getElementById("searchInput");
            let url = `http://localhost/msgboard/searchComment.php?q=${searchInput.value}`;
            axios.get(url)
            .then(res => showComment(res.data))
            .catch(err => console.log(err))
        }
  
        // 搜尋框文字為空，重新show出所有留言
        function resetPage(){
            console.log("resetPage")
            let allcontainer = document.querySelectorAll(".container");
            if(searchInput.value.length == 0){
                for (let i = 0; i < allcontainer.length; i++) {
                    allcontainer[i].className = "container"    
                }
            }
        }

        // 顯示符合的留言
        function showComment(data){
            let allcomment = document.querySelectorAll(".hiddenInput");
            var arr = Array.prototype.slice.call( allcomment );

            for(let i=0; i<data.length; i++){
                console.log(data[i])

                for (let j = 0; j < arr.length; j++) {
                    // 只留下要隱藏的container
                    if(data[i]==arr[j].value){  
                        arr.splice(j,1)
                        break;
                    }
                }
            }

            for(let i=0; i<arr.length; i++){  
                arr[i].parentNode.parentNode.className = "container hide";                
            }
        }

        function dropData(params, e) {
            if(confirm("確認刪除留言?")){
                window.location =  `deleteData.php?commentNo=${params}`;
            }else{
                e.preventDefault();
            }
        }

        window.onload = function(){
            searchInput.addEventListener("input",resetPage,false);
            searchInput.addEventListener("keydown",function(e){
                if(e.keyCode === 13){
                    searchComment();
                }
            },false);
        }
    </script>
</body>

</html>