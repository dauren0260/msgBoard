<?php
require_once("api/connectDB.php");
require_once("api/memberInfo.php");
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js" integrity="sha512-b94Z6431JyXY14iSXwgzeZurHHRNkLt9d6bAHt7BZT38eqV+GyngIi/tVye4jBKPYQ2lBdRs0glww4fmpuLRwA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="./assets/css/index.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/memberCenter.css" type="text/css">
    <title>會員中心</title>
</head>
<body class="memberCenter">
    <?php
        require_once("header.php");
    ?>
    <div class="container">
        <div class="avatar"><img src="./assets/img/member/<?php echo $memAvatar?>" alt="avatar"></div>
        <div>姓名：<?php echo $memName?></div>
        <div>信箱：<?php echo $memEmail?></div>
        <button class="btn btnSecondary showChangePsw" id="showChangePsw">更改密碼</button>
        <div class="changePsw hide" id="changeArea">
            請輸入舊密碼：<input type="password" name="oldPsw" id="oldPsw" required minlength="4" autocomplete="off"><br/>
            請輸入新密碼：<input type="password" name="newPsw" id="newPsw" required minlength="4" autocomplete="off">
            <button class="btn btnPrimary" id="sendBtn">送出</button>
            <button class="btn btnSecondary" id="cancelBtn">取消</button>
        </div>
    </div>

    <script>
        showChangePsw.addEventListener("click",function(){
            this.classList.toggle("hide")
            changeArea.classList.toggle("hide")
        },false)
        cancelBtn.addEventListener("click",function(){
            changeArea.classList.toggle("hide")
            showChangePsw.classList.toggle("hide")
        },false)


        sendBtn.addEventListener("click",function(){

            if(oldPsw.value == newPsw.value){
                alert("密碼不可與上次相同!")
                oldPsw.value = '';
                newPsw.value = '';
                oldPsw.focus();
            }else{
                var data = new FormData();
                data.append('oldPsw', oldPsw.value);
                data.append('newPsw', newPsw.value);

                axios.post('api/changePassword.php', data)
                .then( (response) => {
                    console.log(response)
                    if(!response.error){
                        alert("修改密碼成功!")
                        changeArea.classList.toggle("hide")
                        showChangePsw.classList.toggle("hide")
                    }else{
                        alert("修改密碼失敗!")
                    }
                })
            }
        },false)
    </script>
</body>
</html>