<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/d36fc6fed2.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js" integrity="sha512-b94Z6431JyXY14iSXwgzeZurHHRNkLt9d6bAHt7BZT38eqV+GyngIi/tVye4jBKPYQ2lBdRs0glww4fmpuLRwA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./src/email-genie.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/index.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/signup.css" type="text/css">
    <title>註冊會員</title>
</head>

<body>
    <form action="api/registerMember.php" method="post" class="signup">
        <div class="title">會員註冊</div>
        <table>
            <tbody>
                <tr>
                    <td class="accountTd">
                        <label>
                            帳號：<input type="email" name="email" required id="accountInput" class="email" autocomplete="off" placeholder="請輸入email">
                        </label>
                        <i class="fa-solid fa-check isValid" id="checkIcon"></i>
                    </td>
                    <td>
                        <label>
                            密碼：<input type="password" name="password" required minlength="8" id="password" autocomplete="off">
                        </label>
                        <i class="fa-regular fa-eye" id="eyeIcon"></i>
                    </td>
                    <td>
                        <label>
                            名字：<input type="text" name="memberName" required autocomplete="off">
                        </label>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><button type="submit" value="signup" class="btn btnPrimary" id="signupBtn" onClick="return checkForm()">註冊</button></td>
                </tr>
                <tr>
                    <td>
                        <a href="index.php" class="btn btnSecondary">返回登入</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>

    <script type="text/javascript">
        let checkIcon = document.getElementById("checkIcon");
        // Email正則
        let emailReg = /^\w{3,}(\.\w+)*@[A-z0-9]+(\.[A-z]{2,5}){1,2}$/;

        //自動填入Email
        var field = new EmailGenie('.email',
        {
            domains: ['gmail.com', 'outlook.com', 'hotmail.com', 'msn.com', 'live.com', 'yahoo.com', 'me.com', 'icloud.com'],
            overrideDomains: true,
            insert: 'beforebegin'
        });

        accountInput.addEventListener("change",checkInput,false);
        function checkInput(){
            // 要用trim()
            if((accountInput.value == '') || (accountInput.value == ' ')){
                
                checkIcon.className = "fa-solid fa-check isValid";
                alert(`${accountInput.previousSibling.previousSibling.nodeValue.slice(0,-1)}不可為空`);

            }else if(emailReg.test(accountInput.value)){
                
                // 發送請求確認帳號沒有重複
                axios.get(`api/checkAccount.php?email=${accountInput.value}`)
                .then( res => {
                    if(res.data>0){
                        alert("此帳號已被使用");
                        accountInput.value = '';
                    }else{
                        checkIcon.classList.add('show');
                    }
                })
            }else if(emailReg.test(accountInput.value) == false){
                alert("帳號格式錯誤");
                accountInput.value = '';
                checkInputIcon();
                this.focus();
            }
        }

        signupBtn.addEventListener("submit",checkForm,false);
        function checkForm(){
            if(checkIcon.classList.contains('show')){  //帳號有無重複寫在後端驗證
                // 密碼8碼，且有英數字
                let strReg =/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/; 
                let val = password.value;
                if(!strReg.test(val)){
                    alert("密碼長度至少8碼，包含一個大寫字母，與其他英數字")
                    return false;
                }else{
                    return true;
                }
            }else{
                alert("請檢查帳號可否使用!");
                return false;
            }
        }
        // 修改input的值時也要清除show樣式名
        accountInput.addEventListener("input",checkInputIcon,false);
        function checkInputIcon(){
            checkIcon.className = "fa-solid fa-check isValid";
        }

        eyeIcon.addEventListener("click",function(){
            if(password.type == "password"){
                password.type = "text";
            }else{
                password.type = "password";
            }
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");

        },false);


    </script>
</body>

</html>
