<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./src/email-genie.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/index.css" type="text/css">
    <title>留言版</title>
</head>

<body>
    <div class="title">會員登入</div>
    <form action="./api/loginCheck.php" method="post" id="loginForm">
        <table>
            <tbody>
                <tr>
                    <td>信箱：<input type="email" name="email" required autocomplete="off"  class="email"></td>
                    <td>密碼：<input type="password" name="password" required autocomplete="off"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><button type="submit" value="login" class="btn btnPrimary">登入</button></td>
                </tr>
                <tr>
                    <td><a href="signup.php"><button type="button" value="signup" class="btn btnSecondary">註冊</button></a></td>
                </tr>
            </tfoot>
        </table>
    </form>

    <script>

        var field = new EmailGenie('.email',
        {
            domains: ['gmail.com', 'outlook.com', 'hotmail.com', 'msn.com', 'live.com', 'yahoo.com', 'me.com', 'icloud.com'],
            overrideDomains: true,
            insert: 'beforebegin'
        });

        window.onload = function(){
            document.querySelector(".email").focus()
        }
    </script>
</body>

</html>