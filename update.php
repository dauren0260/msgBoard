<?php
require_once("connectDB.php");

if(isset($_GET['page'])){
    $pageNumber = $_GET['page'];
}
if(isset($_GET['search'])){
    $searchText = "&search=".$_GET['search']."";
}else{
    $searchText = "";
}

$sql = "SELECT  m.commentNo, m.comment, m.commentTime, 
                b.id, b.memName, b.memAvatar 
        FROM message AS m
        LEFT JOIN member AS b
        ON (m.memberId = b.id)
        WHERE m.commentNo = ?";

$stmt = $db_link->prepare($sql);
$stmt->bind_param("s", $_GET["commentNo"]);
$stmt->execute();
$stmt->bind_result($commentNo, $comment, $time, $id, $name, $avatar);
$stmt->fetch();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/index.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/message.css" type="text/css">
    <title>Document</title>
</head>
<body>
        <div class="title">留言版 - 編輯留言</div>    
        <form action="updateDB.php" method="post" class="update">
            <div class="msgContainer">
                <div class="avatar commentAvatar">
                    <?php echo '<img src="./assets/img/member/'.$avatar.'" alt="avatar" />'; ?>
                    <div class="username"><?php echo $name; ?></div>
                </div>
                <textarea name="content" id="content" cols="80" rows="15"><?php echo $comment; ?></textarea>
                <input type="hidden" name="commentNo"  value="<?php echo $commentNo; ?>">
                <input type="hidden" name="prevComment"  value="<?php echo $comment; ?>">
            </div>
            <div class="actionArea"> 
                <button type="button" value="send" class="btn btn-outline-secondary">
                    <a href="message.php?page=<?php echo $pageNumber?><?php echo $searchText?>">取消</a>
                </button>
                <button type="submit" value="send" class="btn btn-outline-primary" onSubmit="checkForm">送出</button>
            </div>
        </form>
    
</body>

<script>
function checkForm(){
    let prevComment = document.getElementsByName("prevComment")[0].value;
    let currentComment = document.getElementsByName("content")[0].value;

    if(prevComment != currentComment){
        history.go(-1)
    }
    return false;
}

</script>
</html>

