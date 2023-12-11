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
    <div class="title">留言版</div>    
            <?php
                // echo strpos("php, I love php, I love php too!","PHP") === false;

                $str = '全球氣候危機已成為本世紀人類共同面臨的課題，中央大學太空及遙測研究中心發行的2024衛星影像月曆「寒‧極」（諧音蕃薯）。

                象徵台灣出發、立足世界，透過超高解析度的衛星影像，捕捉劇變下冰雪圈面貌。';

                $str_number = mb_strlen($str);
                $shortContent = substr( $str , 0 , 99) . '...';
                $hidecontent = substr($str, 99 );

                echo "str_number:  $str_number  <br/>";
                echo "shortContent: $shortContent <br/>";
                echo "hidecontent: $hidecontent <br/>";
            ?>
        







    <!-- <script>
        function editMsg(commentNo){
            let contentArea = document.getElementById(`contentArea${commentNo}`);
            let editBtn = document.getElementById(`editBtn${commentNo}`);

            let msgContent = document.getElementById(`msgContent${commentNo}`);
            msgContent.className = "msgContent hideContent";

            // 創建提供編輯留言的textarea
            var textarea = document.createElement("textarea");
            textarea.name = "editContent";
            textarea.id = "editId";
            textarea.cols = "50";
            textarea.rows = "5";
            textarea.value = msgContent.innerText;
            contentArea.appendChild(textarea);

            // 創建更新留言按鈕
            var okBtn = document.createElement("button");
            okBtn.type = "button";
            okBtn.value = "Send";
            okBtn.innerText = "Send";
            okBtn.className = "btn btn-outline-secondary";
            okBtn.addEventListener("click",sendEditMsg(commentNo),false);
            contentArea.appendChild(okBtn);

        }

        function sendEditMsg(commentNo){
            let editId = document.getElementById("editId");
            let msgContent = document.getElementById(`msgContent${commentNo}`);

            console.log("editId.value"+editId.value);
            msgContent.className = "msgContent showContent";
            // msgContent.innerText = editId.value;

        }

    </script> -->
</body>

</html>