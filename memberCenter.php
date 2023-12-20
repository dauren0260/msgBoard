<?php
require_once("connectDB.php");
require_once("memberInfo.php");

?>

<!DOCTYPE html>
<html lang="en">
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
    </div>
</body>
</html>