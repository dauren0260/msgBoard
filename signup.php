<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css" type="text/css">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <div class="title">會員註冊</div>
        <table>
            <tbody>
                <tr>
                    <td>帳號：<input type="text" name="account"></td>
                    <td>密碼：<input type="password" name="password"></td>
                    <td>名字：<input type="text" name="memberName"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><button type="submit" value="signup" class="btn btn-outline-primary">註冊</button></td>
                </tr>
                <tr>
                    <td>
                        <a href="index.php">
                            <button type="submit" value="login" class="btn btn-outline-secondary" >返回登入</button>
                        </a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</body>
</html>

<?php
// 檢查email帳號規則

function checkEmail(){
    alert("hiiii");
}


?>