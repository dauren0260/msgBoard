<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/d36fc6fed2.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js" integrity="sha512-b94Z6431JyXY14iSXwgzeZurHHRNkLt9d6bAHt7BZT38eqV+GyngIi/tVye4jBKPYQ2lBdRs0glww4fmpuLRwA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/index.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/signup.css" type="text/css">
    <title>註冊會員</title>
</head>

<body>
    <form action="registerMember.php" method="post" class="signup">
        <div class="title">會員註冊</div>
        <table>
            <tbody>
                <tr>
                    <td class="accountTd">
                        <label>
                            帳號： <input type="text" name="account" required id="accountInput" />
                        </label>
                        <i class="fa-solid fa-check isValid" id="checkIcon"></i>
                    </td>
                    <td>
                        <label>
                            密碼： <input type="password" name="password" required>
                        </label>
                    </td>
                    <td>
                        <label>
                            Email：<input type="email" name="email" required>
                        </label>
                    </td>
                    <td>
                        <label>
                            名字： <input type="text" name="memberName" required>
                        </label>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><button type="submit" value="signup" class="btn btn-outline-primary">註冊</button></td>
                </tr>
                <tr>
                    <td>
                        <a href="index.php">
                            <button type="submit" value="login" class="btn btn-outline-secondary">返回登入</button>
                        </a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>

    <script type="text/javascript">
        accountInput.addEventListener("blur",checkAccount,false);
        let checkIcon = document.getElementById("checkIcon")

        function checkAccount(){
            if(this.value != '' || this.value != ' '){
                axios.get(`checkAccount.php?name=${this.value}`)
                .then( res => {
                    if(res.data>0){
                        alert("此帳號已被使用");
                        this.value = '';
                    }else{
                        checkIcon.className += " show"
                    }
                })
            }else{
                alert("不可為空");

            }
        }

    </script>
</body>

</html>
