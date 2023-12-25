<?php
require_once("api/connectDB.php");
require_once("api/memberInfo.php");
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js"
        integrity="sha512-b94Z6431JyXY14iSXwgzeZurHHRNkLt9d6bAHt7BZT38eqV+GyngIi/tVye4jBKPYQ2lBdRs0glww4fmpuLRwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="./assets/css/index.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/memberCenter.css" type="text/css">
    <title>會員中心</title>
</head>

<body class="memberCenter">
    <?php
        require_once("header.php");
    ?>
    <div class="container">
        <div class="avatar">
            <img src="./assets/img/member/<?php echo $memAvatar?>" alt="avatar" id="showAvatar">
            <div class="fileInputArea">
                <label for="fileTag">上傳檔案</label>
                <input type="file" name="avatarImg" id="fileTag" />
            </div>
        </div>
        <div class="uploadArea hide">
            預覽圖片
            <img src="" alt="preview" class="preview hide" />
            <div class="btnArea">
                <button class="btn btnWarning delPreview">刪除檔案</button>
                <button class="btn btnPrimary" id="uploadImg">上傳</button>
            </div>
        </div>
        <div>姓名：<?php echo $memName?></div>
        <div>信箱：<?php echo $memEmail?></div>
        <button class="btn btnSecondary showChangePsw" id="showChangePsw">更改密碼</button>
        <div class="changePsw hide" id="changeArea">
            請輸入舊密碼：<input type="password" name="oldPsw" id="oldPsw" required minlength="4" autocomplete="off"><br />
            請輸入新密碼：<input type="password" name="newPsw" id="newPsw" required minlength="4" autocomplete="off">
            <button class="btn btnPrimary" id="sendBtn">送出</button>
            <button class="btn btnSecondary" id="cancelBtn">取消</button>
        </div>
    </div>

    <script src="./src/photoPreview.js"></script>
    <script>
    uploadImg.addEventListener("click",function(){
        let sendData = new FormData();
        sendData.append("avatarImg",fileUploader.files[0])

        axios.post('api/updateAvatar.php', sendData)
        .then( (res) => {
            console.log(res)
            removeHandler();
            // window.location.reload();
        })

    },false)

    showChangePsw.addEventListener("click", function() {
        this.classList.toggle("hide");
        changeArea.classList.toggle("hide");
        oldPsw.value = '';
        newPsw.value = '';
    }, false)

    // 取消修改
    cancelBtn.addEventListener("click", function() {
        changeArea.classList.toggle("hide");
        showChangePsw.classList.toggle("hide");
    }, false)

    // 修改密碼
    sendBtn.addEventListener("click", function() {
        if (oldPsw.value.length < 4 || newPsw.value.length < 4) {
            alert("密碼最小長度需四位數");
        } else if (oldPsw.value == newPsw.value) {
            alert("密碼不可與上次相同!");
            oldPsw.value = '';
            newPsw.value = '';
            oldPsw.focus();
        } else {
            var data = new FormData();
            data.append('oldPsw', oldPsw.value);
            data.append('newPsw', newPsw.value);

            axios.post('api/changePassword.php', data)
                .then((response) => {
                    if (!response.data.error) {
                        alert("修改密碼成功!");
                        changeArea.classList.toggle("hide");
                        showChangePsw.classList.toggle("hide");
                    } else {
                        alert("修改密碼失敗!")
                        oldPsw.value = '';
                        newPsw.value = '';
                        oldPsw.focus();
                    }
                })
        }
    }, false)
    </script>
</body>

</html>