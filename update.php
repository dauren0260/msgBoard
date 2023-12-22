<?php
require_once("api/connectDB.php");
require_once("api/memberInfo.php");

if(isset($_GET["page"])){
    $pageNumber = $_GET["page"];
}
if(isset($_GET["search"])){
    $searchText = "&search=".$_GET["search"]."";
}else{
    $searchText = "";
}

$sql = "SELECT  m.commentNo, m.comment, m.commentTime, 
                b.id, b.memName, b.memAvatar 
        FROM message AS m
        LEFT JOIN member AS b
        ON (m.memberId = b.id)
        WHERE m.commentNo = ?";

$stmt = $dbLink->prepare($sql);
$stmt->bind_param("i", $_GET["commentNo"]);
$stmt->execute();
$stmt->bind_result($commentNo, $comment, $time, $memberId, $name, $avatar);
$stmt->fetch();

if($memberId != $id){
    echo "<script type='text/javascript'>alert('僅能修改自己的留言!'); window.location = 'message.php'</script>";
}

?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/index.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/message.css" type="text/css">
    <title>編輯留言</title>
</head>
<body>
        <div class="title">留言版 - 編輯留言</div>    
        <form action="api/updateDB.php" method="post" class="update">
            <div class="msgContainer">
                <div class="avatar commentAvatar">
                    <img src="./assets/img/member/<?php echo $avatar ?>" alt="avatar" />
                    <div class="username"><?php echo $name; ?></div>
                </div>
                <textarea name="content" id="content" cols="80" rows="15"><?php echo $comment; ?></textarea>
                <input type="hidden" name="commentNo"  value="<?php echo $commentNo; ?>">
                <input type="hidden" name="page"  value="<?php echo $_GET["page"]; ?>">
            </div>
            <div class="actionArea"> 
                <a href="message.php?page=<?php echo $pageNumber?><?php echo $searchText?>" class="btn btnSecondary">取消</a>
                <button type="submit" value="send" class="btn btnPrimary">送出</button>
            </div>
        </form>
</body>
</html>

