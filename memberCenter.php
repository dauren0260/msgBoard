<?php
require_once("api/connectDB.php");
require_once("api/memberInfo.php");  //相對路徑
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/d36fc6fed2.js" crossorigin="anonymous"></script>
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
                <span>檔案大小需小於2MB</span>
                <input type="file" name="avatarImg" id="fileTag" />
            </div>
            <div class="uploadArea hide">
                預覽圖片
                <img src="" alt="preview" class="preview hide" />
                <div class="btnArea">
                    <button class="btn btnWarning delPreview">刪除檔案</button>
                    <button class="btn btnPrimary" id="uploadImg">上傳</button>
                </div>
            </div>
        </div>
        <div class="infoArea">
            <div>姓名：<?php echo $memName?></div>
            <div>信箱：<?php echo $memEmail?></div>
            <button class="btn btnSecondary showChangePsw" id="showChangePsw">更改密碼</button>
            <div class="changePsw hide" id="changeArea">
                請輸入舊密碼：<input type="password" name="oldPsw" id="oldPsw" required minlength="8" autocomplete="off"><i class="fa-regular fa-eye"></i>
                <br />
                請輸入新密碼：<input type="password" name="newPsw" id="newPsw" required minlength="8" autocomplete="off"><i class="fa-regular fa-eye"></i>
                <div>
                    <button class="btn btnPrimary" id="sendBtn">送出</button>
                    <button class="btn btnSecondary" id="cancelBtn">取消</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./src/photoPreview.js"></script>
    <script>
    uploadImg.addEventListener("click",function(){
        let sendData = new FormData();
        sendData.append("avatarImg",fileUploader.files[0]);

        axios.post('api/updateAvatar.php', sendData)
        .then( (res) => {
            removeHandler();
            window.location.reload();
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
    }, false);


    sendBtn.addEventListener("click",function(){
            // 密碼8碼，且有英數字
            let strReg =/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/; 
            let val = newPsw.value;

            if(!strReg.test(val)){
                alert("密碼長度至少8碼，包含一個大寫字母，與其他英數字");
                newPsw.value = '';
                newPsw.focus();

            }else if(oldPsw.value == newPsw.value){
                alert("密碼不可與上次相同!");
                oldPsw.value = '';
                newPsw.value = '';
                oldPsw.focus();
            }else{
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

    let eyeIcons = document.querySelectorAll(".fa-regular");
    for (let i = 0; i < eyeIcons.length; i++) {        
        eyeIcons[i].addEventListener("click",function(){
            if(this.previousSibling.type == "password"){
                this.previousSibling.type = "text";
            }else{
                this.previousSibling.type = "password";
            }
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
            
        },false)
    }
    </script>
</body>

</html>